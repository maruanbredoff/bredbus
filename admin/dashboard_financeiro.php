<!DOCTYPE html>
<html lang="en">

<head>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date2 = date('Y-m-d H:i');
//$datebr = date('d-m-Y H:i', strtotime('+1 months', strtotime(date('d-m-Y'))));
$datebr2 = date('d-m-Y H:i');
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: ../restrita.php"); exit;
}
include "../config.php"; 
$idcontrato = $_SESSION['ContratoID'];
    // Captura as datas e o período do formulário
    $data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : '2024-01-01';
    $data_final = isset($_POST['data_final']) ? $_POST['data_final'] : '2024-12-31';
    $periodo = isset($_POST['periodo']) ? $_POST['periodo'] : 'diario'; // Padrão diário

    // Converte as datas para o formato adequado (yyyy-mm-dd)
    $data_inicial_formatada = date('Y-m-d', strtotime($data_inicial));
    $data_final_formatada = date('Y-m-d', strtotime($data_final));

    // Consulta para Receita Total por Período (dia, semana, mês ou ano)
    if ($periodo == 'mensal') {
        $query_receita_periodo = "SELECT DATE_FORMAT(passagem.data_cadastro, '%Y-%m') AS periodo_venda, SUM(passagem.valor) AS total_receita 
                                  FROM passagem 
                                  WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato
                                  GROUP BY periodo_venda";
    } else if ($periodo == 'anual') {
        $query_receita_periodo = "SELECT DATE_FORMAT(passagem.data_cadastro, '%Y') AS periodo_venda, SUM(passagem.valor) AS total_receita 
                                  FROM passagem 
                                  WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato  
                                  GROUP BY periodo_venda";
    } else if ($periodo == 'semanal') {
        $query_receita_periodo = "SELECT YEARWEEK(passagem.data_cadastro) AS periodo_venda, SUM(passagem.valor) AS total_receita 
                                  FROM passagem 
                                  WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato
                                  GROUP BY periodo_venda";
    } else {
        // Diário por padrão
        $query_receita_periodo = "SELECT DATE(passagem.data_cadastro) AS periodo_venda, SUM(passagem.valor) AS total_receita 
                                  FROM passagem 
                                  WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato
                                  GROUP BY periodo_venda";
    }

    // Consulta para Receita por Rota
    $query_receita_rota = "SELECT c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino, SUM(passagem.valor) AS total_receita 
                           FROM passagem 
                           INNER JOIN viagem ON passagem.idviagem = viagem.idviagem 
                           INNER JOIN rota r ON viagem.idrota = r.idrota 
                            INNER JOIN cidades c1 ON c1.id = r.corigem
                            INNER JOIN cidades c2 on c2.id = r.cdestino
                            INNER JOIN estados e1 on e1.id = r.uforigem
                            INNER JOIN estados e2 on e2.id = r.ufdestino
                           WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND viagem.idcontrato = $idcontrato
                           GROUP BY r.corigem, r.cdestino";

    // Consulta para Receita por Tipo de Serviço (passagens e encomendas)
    $query_receita_servico = "SELECT 'Passagens' AS tipo_servico, SUM(passagem.valor) AS total_receita 
                              FROM passagem 
                              WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato
                              UNION ALL
                              SELECT 'Encomendas' AS tipo_servico, SUM(viagem_encomenda.valor) AS total_receita 
                              FROM viagem_encomenda 
                              WHERE viagem_encomenda.data_cadastro BETWEEN '$data_inicial_formatada' AND viagem_encomenda.idcontrato = $idcontrato AND '$data_final_formatada'";

    // Consulta para obter a receita por forma de pagamento
    $query_receita_forma_pagamento = "SELECT formapg.tipo, SUM(contas_receb_movi.valor_total) AS total_receita 
                                        FROM formapg 
                                        INNER JOIN contas_receb_movi ON formapg.idformapg = contas_receb_movi.idformapg 
                                        INNER JOIN situacao_caixa on situacao_caixa.idsituacao = contas_receb_movi.idsituacao
                                        WHERE contas_receb_movi.data_movimento BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND contas_receb_movi.idsituacao <> 3 AND contas_receb_movi.idcontrato = $idcontrato
                                        GROUP BY formapg.tipo";

   // Consulta para despesas por categoria (vinculando `tipopg` com `contas_pagar_movi`)
    $query_despesas_categoria = "SELECT tipopg.descricao AS categoria, SUM(contas_pagar_movi.valor) AS total_despesas 
                                 FROM contas_pagar_movi 
                                 LEFT JOIN tipopg ON contas_pagar_movi.tipopg = tipopg.idtipopg 
                                 WHERE contas_pagar_movi.data_movimento BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND contas_pagar_movi.idsituacao <> 3 AND contas_pagar_movi.idcontrato = $idcontrato
                                 GROUP BY tipopg.descricao";
    $result_despesas_categoria = mysqli_query($con, $query_despesas_categoria);

    // Consulta para despesas por período
    $query_despesas_periodo = "SELECT DATE_FORMAT(data_movimento, '%Y-%m') AS periodo, SUM(valor) AS total_despesas 
                               FROM contas_pagar_movi 
                               WHERE data_movimento BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND contas_pagar_movi.idsituacao <> 3 AND contas_pagar_movi.idcontrato = $idcontrato
                               GROUP BY periodo";
    $result_despesas_periodo = mysqli_query($con, $query_despesas_periodo);

    // Comparação entre despesas e receitas
    $query_comparacao_despesas_receitas = "SELECT 'Despesas' AS tipo, SUM(valor) AS total FROM contas_pagar_movi WHERE data_movimento BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND contas_pagar_movi.idcontrato = $idcontrato
                                           UNION ALL
                                           SELECT 'Receitas' AS tipo, SUM(valor) AS total FROM passagem WHERE data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato";
    $result_comparacao_despesas_receitas = mysqli_query($con, $query_comparacao_despesas_receitas);

    // Número de passagens vendidas por viagem
    $query_passagens_viagem = "SELECT viagem.idviagem, COUNT(passagem.idpassagem) AS total_passagens 
                               FROM passagem 
                               LEFT JOIN viagem ON passagem.idviagem = viagem.idviagem 
                               WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND viagem.idcontrato = $idcontrato
                               GROUP BY viagem.idviagem";
    $result_passagens_viagem = mysqli_query($con, $query_passagens_viagem);

    // Poltronas ocupadas e disponíveis
    $query_poltronas_ocupadas = "SELECT viagem.idviagem, 
                                        COUNT(passagem.poltrona) AS ocupadas, 
                                        (bus.lugares - COUNT(passagem.poltrona)) AS disponiveis 
                                 FROM passagem
                                 LEFT JOIN viagem ON passagem.idviagem = viagem.idviagem
                                 LEFT JOIN bus ON viagem.idbus = bus.idbus
                                 WHERE viagem.dataviagem BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato
                                 GROUP BY viagem.idviagem";
    $result_poltronas_ocupadas = mysqli_query($con, $query_poltronas_ocupadas);

    // Receita gerada por viagem
    $query_receita_viagem = "SELECT viagem.idviagem, SUM(passagem.valor) AS total_receita 
                             FROM passagem 
                             LEFT JOIN viagem ON passagem.idviagem = viagem.idviagem 
                             WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND passagem.idcontrato = $idcontrato
                             GROUP BY viagem.idviagem";
    $result_receita_viagem = mysqli_query($con, $query_receita_viagem);

    // Número de passagens vendidas por agência
    $query_passagens_agencia = "SELECT agencia.nome, COUNT(passagem.idpassagem) AS total_passagens 
                                FROM passagem 
                                LEFT JOIN agencia ON passagem.idagencia = agencia.idagencia 
                                WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND agencia.idcontrato = $idcontrato
                                GROUP BY agencia.nome";
    $result_passagens_agencia = mysqli_query($con, $query_passagens_agencia);

    // Receita total gerada por agência
    $query_receita_agencia = "SELECT agencia.nome, SUM(passagem.valor) AS total_receita 
                              FROM passagem 
                              LEFT JOIN agencia ON passagem.idagencia = agencia.idagencia 
                              WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND agencia.idcontrato = $idcontrato
                              GROUP BY agencia.nome";
    $result_receita_agencia = mysqli_query($con, $query_receita_agencia);

    // Comparação entre as agências
    $query_comparacao_agencias = "SELECT agencia.nome, SUM(passagem.valor) AS total_receita 
                                  FROM passagem 
                                  LEFT JOIN agencia ON passagem.idagencia = agencia.idagencia 
                                  WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.status_passagem <> 4 AND agencia.idcontrato = $idcontrato
                                  GROUP BY agencia.nome";
    $result_comparacao_agencias = mysqli_query($con, $query_comparacao_agencias);

    // Executando as consultas
    $result_receita_periodo = mysqli_query($con, $query_receita_periodo);
    $result_receita_rota = mysqli_query($con, $query_receita_rota);
    $result_receita_servico = mysqli_query($con, $query_receita_servico);
    $result_receita_forma_pagamento = mysqli_query($con, $query_receita_forma_pagamento);
    ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});

        // Função para desenhar o gráfico de Receita por Período
        function drawReceitaPorPeriodo() {
            var data = google.visualization.arrayToDataTable([
                ['Período', 'Receita Total (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_receita_periodo)) {
                    if (isset($row['total_receita']) && !is_null($row['total_receita'])) {
                        echo "['" . $row['periodo_venda'] . "', " . $row['total_receita'] . "],";
                    }
                }
                ?>
            ]);

            var options = {
                title: 'Receita Total por Período',
                hAxis: {title: 'Período', slantedText: true, slantedTextAngle: 45},
                vAxis: {title: 'Receita Total (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_receita_por_periodo'));
            chart.draw(data, options);
        }

        // Função para desenhar o gráfico de Receita por Rota
        function drawReceitaPorRota() {
            var data = google.visualization.arrayToDataTable([
                ['Origem-Destino', 'Receita Total (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_receita_rota)) {
                    if (isset($row['total_receita']) && !is_null($row['total_receita'])) {
                        echo "['" . $row['corigem'] . " - " . $row['cdestino'] . "', " . $row['total_receita'] . "],";
                    }
                }
                ?>
            ]);

            var options = {
                title: 'Receita por Rota',
                hAxis: {title: 'Origem-Destino'},
                vAxis: {title: 'Receita Total (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_receita_por_rota'));
            chart.draw(data, options);
        }

        // Função para desenhar o gráfico de Receita por Tipo de Serviço
        function drawReceitaPorTipoServico() {
            var data = google.visualization.arrayToDataTable([
                ['Tipo de Serviço', 'Receita Total (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_receita_servico)) {
                    if (isset($row['total_receita']) && !is_null($row['total_receita'])) {
                        echo "['" . $row['tipo_servico'] . "', " . $row['total_receita'] . "],";
                    }
                }
                ?>
            ]);

            var options = {
                title: 'Receita por Tipo de Serviço',
                hAxis: {title: 'Tipo de Serviço'},
                vAxis: {title: 'Receita Total (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_receita_por_tipo_servico'));
            chart.draw(data, options);
        }

        // Função para desenhar o gráfico de Receita Total por Forma de Pagamento
        function drawReceitaPorFormaPagamento() {
            var data = google.visualization.arrayToDataTable([
                ['Forma de Pagamento', 'Receita Total (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_receita_forma_pagamento)) {
                    if (isset($row['total_receita']) && !is_null($row['total_receita'])) {
                        echo "['" . $row['tipo'] . "', " . $row['total_receita'] . "],";
                    }
                }
                ?>
            ]);

            var options = {
                title: 'Total de Receita por Forma de Pagamento',
                hAxis: {title: 'Forma de Pagamento'},
                vAxis: {title: 'Receita Total (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_receita_por_forma_pagamento'));
            chart.draw(data, options);
        }

        // Função para desenhar o gráfico de Percentual de Cada Forma de Pagamento no Total da Receita
        function drawPercentualFormaPagamento() {
            var data = google.visualization.arrayToDataTable([
                ['Forma de Pagamento', 'Percentual (%)'],
                <?php
                // Executa novamente a consulta para obter os dados
                mysqli_data_seek($result_receita_forma_pagamento, 0); // Volta ao início dos resultados
                while ($row = mysqli_fetch_assoc($result_receita_forma_pagamento)) {
                    if (isset($row['total_receita']) && !is_null($row['total_receita'])) {
                        echo "['" . $row['tipo'] . "', " . $row['total_receita'] . "],";
                    }
                }
                ?>
            ]);

            var options = {
                title: 'Percentual de Cada Forma de Pagamento no Total da Receita',
                pieHole: 0.4,  // Gráfico de pizza em formato de rosca
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_percentual_forma_pagamento'));
            chart.draw(data, options);
        }

        // Gráficos de Despesas e Receitas
        function drawDespesasPorCategoria() {
            var data = google.visualization.arrayToDataTable([
                ['Categoria', 'Despesas (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_despesas_categoria)) {
                    echo "['" . $row['categoria'] . "', " . $row['total_despesas'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Despesas por Categoria',
                hAxis: {title: 'Categoria'},
                vAxis: {title: 'Despesas (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_despesas_categoria'));
            chart.draw(data, options);
        }

        function drawDespesasPorPeriodo() {
            var data = google.visualization.arrayToDataTable([
                ['Período', 'Despesas (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_despesas_periodo)) {
                    echo "['" . $row['periodo'] . "', " . $row['total_despesas'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Despesas por Período',
                hAxis: {title: 'Período'},
                vAxis: {title: 'Despesas (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_despesas_periodo'));
            chart.draw(data, options);
        }

        function drawComparacaoDespesasReceitas() {
            var data = google.visualization.arrayToDataTable([
                ['Tipo', 'Total (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_comparacao_despesas_receitas)) {
                    echo "['" . $row['tipo'] . "', " . $row['total'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Comparação entre Despesas e Receitas',
                hAxis: {title: 'Tipo'},
                vAxis: {title: 'Total (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_comparacao_despesas_receitas'));
            chart.draw(data, options);
        }

function drawPassagensPorViagem() {
            var data = google.visualization.arrayToDataTable([
                ['Viagem', 'Passagens Vendidas'],
                <?php
                while ($row = mysqli_fetch_assoc($result_passagens_viagem)) {
                    echo "['Viagem " . $row['idviagem'] . "', " . $row['total_passagens'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Número de Passagens Vendidas por Viagem',
                hAxis: {title: 'Viagem'},
                vAxis: {title: 'Passagens Vendidas'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_passagens_viagem'));
            chart.draw(data, options);
        }

 function drawPoltronasOcupadasDisponiveis() {
            var data = google.visualization.arrayToDataTable([
                ['Viagem', 'Ocupadas', 'Disponíveis'],
                <?php
                while ($row = mysqli_fetch_assoc($result_poltronas_ocupadas)) {
                    echo "['Viagem " . $row['idviagem'] . "', " . $row['ocupadas'] . ", " . $row['disponiveis'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Poltronas Ocupadas vs Disponíveis',
                hAxis: {title: 'Viagem'},
                vAxis: {title: 'Poltronas'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_poltronas_ocupadas_disponiveis'));
            chart.draw(data, options);
        }

        function drawReceitaPorViagem() {
            var data = google.visualization.arrayToDataTable([
                ['Viagem', 'Receita (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_receita_viagem)) {
                    echo "['Viagem " . $row['idviagem'] . "', " . $row['total_receita'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Receita Gerada por Viagem',
                hAxis: {title: 'Viagem'},
                vAxis: {title: 'Receita (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_receita_viagem'));
            chart.draw(data, options);
        }

        function drawPassagensPorAgencia() {
            var data = google.visualization.arrayToDataTable([
                ['Agência', 'Passagens Vendidas'],
                <?php
                while ($row = mysqli_fetch_assoc($result_passagens_agencia)) {
                    echo "['" . $row['nome'] . "', " . $row['total_passagens'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Número de Passagens Vendidas por Agência',
                hAxis: {title: 'Agência'},
                vAxis: {title: 'Passagens Vendidas'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_passagens_agencia'));
            chart.draw(data, options);
        }

        function drawReceitaPorAgencia() {
            var data = google.visualization.arrayToDataTable([
                ['Agência', 'Receita (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_receita_agencia)) {
                    echo "['" . $row['nome'] . "', " . $row['total_receita'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Receita Total Gerada por Agência',
                hAxis: {title: 'Agência'},
                vAxis: {title: 'Receita (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_receita_agencia'));
            chart.draw(data, options);
        }

        function drawComparacaoAgencias() {
            var data = google.visualization.arrayToDataTable([
                ['Agência', 'Receita (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_comparacao_agencias)) {
                    echo "['" . $row['nome'] . "', " . $row['total_receita'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Comparação entre Agências',
                hAxis: {title: 'Agência'},
                vAxis: {title: 'Receita (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_comparacao_agencias'));
            chart.draw(data, options);
        }

        // Carrega todos os gráficos quando a página é carregada
        google.charts.setOnLoadCallback(function() {
            drawReceitaPorPeriodo();
            drawReceitaPorRota();
            drawReceitaPorTipoServico();
            drawReceitaPorFormaPagamento();
            drawPercentualFormaPagamento();
            drawDespesasPorCategoria();
            drawDespesasPorPeriodo();
            drawComparacaoDespesasReceitas();
            drawPassagensPorViagem();
            drawPoltronasOcupadasDisponiveis();
            drawReceitaPorViagem();
            drawPassagensPorAgencia();
            drawReceitaPorAgencia();
            drawComparacaoAgencias();
        });
    </script>
</head>

<body class="fix-header card-no-border">
<?php 
include "../verificanivel.php"; 

// ----------------------- Usuario ----------------------------    
// executa a query 
$usuarios = mysqli_query($con,"SELECT nivel FROM usuario where id_usuario=$usuarioid") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhausuario = mysqli_fetch_assoc($usuarios);  
?>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Estatísticas</li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>

            <div class="container-fluid"> 
<?php
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
?>

                <div class="row">
                    <div class="col-12">
                    <div class="card">
                        <div class="card-group">
                            <div class="card-body wizard-content">
    <h1>Dashboard Financeiro</h1>
    <!-- Formulário de Filtro de Data e Período -->
    <form method="POST" action="" class="mb-6">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_inicial">Data Inicial:</label>
                    <input type="date" id="data_inicial" name="data_inicial" class="form-control" value="<?php echo $data_inicial; ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_final">Data Final:</label>
                    <input type="date" id="data_final" name="data_final" class="form-control" value="<?php echo $data_final; ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="periodo">Período:</label>
                    <select id="periodo" name="periodo" class="form-control">
                        <option value="diario" <?php if($periodo == 'diario') echo 'selected'; ?>>Diário</option>
                        <option value="semanal" <?php if($periodo == 'semanal') echo 'selected'; ?>>Semanal</option>
                        <option value="mensal" <?php if($periodo == 'mensal') echo 'selected'; ?>>Mensal</option>
                        <option value="anual" <?php if($periodo == 'anual') echo 'selected'; ?>>Anual</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Filtrar Relatórios</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Gráficos -->
    <div class="container">
        <div class="row">
            <!-- Gráfico 1: Receita por Período -->
            <div class="col-md-6">
                <div id="chart_receita_por_periodo" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico 2: Receita por Rota -->
            <div class="col-md-6">
                <div id="chart_receita_por_rota" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico 3: Receita por Tipo de Serviço -->
            <div class="col-md-6">
                <div id="chart_receita_por_tipo_servico" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico de Receita por Forma de Pagamento -->
            <div class="col-md-6">
                 <div id="chart_receita_por_forma_pagamento" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
        <div class="row">
            <!-- Gráfico de Percentual de Cada Forma de Pagamento -->
            <div class="col-md-6">
                <div id="chart_percentual_forma_pagamento" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico 9: Comparação entre Agências -->
            <div class="col-md-6">
                <div id="chart_comparacao_agencias" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico 1: Despesas por Categoria -->
            <div class="col-md-6">
                <div id="chart_despesas_categoria" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico 2: Despesas por Período -->
            <div class="col-md-6">
                <div id="chart_despesas_periodo" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico 3: Comparação entre Despesas e Receitas -->
            <div class="col-md-6">
                <div id="chart_comparacao_despesas_receitas" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico 4: Número de Passagens Vendidas por Viagem -->
            <div class="col-md-6">
                <div id="chart_passagens_viagem" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico 5: Poltronas Ocupadas vs Disponíveis -->
            <div class="col-md-6">
                <div id="chart_poltronas_ocupadas_disponiveis" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico 6: Receita por Viagem -->
            <div class="col-md-6">
                <div id="chart_receita_viagem" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico 7: Número de Passagens Vendidas por Agência -->
            <div class="col-md-6">
                <div id="chart_passagens_agencia" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico 8: Receita Total Gerada por Agência -->
            <div class="col-md-6">
                <div id="chart_receita_agencia" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
                            </div>
                        </div>
                    </div>
                    

        <style type="text/css">
.escondida {
    display:none;
}
</style>


<script>
    $("#estadoorigem").on("change",function(){
        var id = $("estadoorigem").val();

        $.ajax({
            url: 'pega_cidade_origem.php?id='+id,
            type: 'POST',
            dataType: "text",
            beforeSend: function(){
            $("#cidadeorigem").css({display:'block'});
            $("#cidadeorigem").html("Carregando...");
            },
            success: function(res)
            {
            //$('.cidadeori').slideToggle(); // aparece o div
            //$('.cidadeori').show(); // aparece o div
            $("#cidadeorigem").css({display:'block'});
            $("#cidadeorigem").html(res); 
            $("#cidadeorigem").append(res); 
            }

        })
    })
    </script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ]

    });
    </script>
    <!-- ============================================================== -->

</body>

</html>
