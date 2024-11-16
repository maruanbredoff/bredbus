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

    // Consulta para Projeção Financeira (usando a receita passada para projetar)
    $query_projecao_financeira = "SELECT DATE_FORMAT(passagem.data_cadastro, '%Y-%m') AS mes, SUM(passagem.valor) AS total_receita 
                                  FROM passagem 
                                  WHERE passagem.data_cadastro BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND passagem.idcontrato = $idcontrato
                                  GROUP BY mes";
    $result_projecao_financeira = mysqli_query($con, $query_projecao_financeira);

    // Consulta para Ocupação Média dos Ônibus
    $query_ocupacao_media = "SELECT viagem.idviagem, COUNT(passagem.poltrona) AS poltronas_ocupadas, 
                                    bus.lugares AS capacidade, 
                                    (COUNT(passagem.poltrona) / bus.lugares) * 100 AS ocupacao_percentual
                             FROM passagem 
                             INNER JOIN viagem ON passagem.idviagem = viagem.idviagem 
                             INNER JOIN bus ON viagem.idbus = bus.idbus 
                             WHERE viagem.dataviagem BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' and passagem.status_passagem <> 4 AND viagem.idcontrato = $idcontrato
                             GROUP BY viagem.idviagem";
    $result_ocupacao_media = mysqli_query($con, $query_ocupacao_media);

    // Consulta para Desempenho dos Motoristas (número de viagens e receita gerada)
    $query_desempenho_motoristas = "SELECT motorista.nome, 
                                           COUNT(viagem.idviagem) AS total_viagens
                                    FROM motorista
                                    INNER JOIN viagem ON motorista.idmotorista = viagem.motorista1
                                    WHERE viagem.dataviagem BETWEEN '$data_inicial_formatada' AND '$data_final_formatada' AND viagem.idcontrato = $idcontrato 
                                    GROUP BY motorista.nome;
                                    ";
    $result_desempenho_motoristas = mysqli_query($con, $query_desempenho_motoristas);
    ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});

        // Relatório de Projeção Financeira
        function drawProjecaoFinanceira() {
            var data = google.visualization.arrayToDataTable([
                ['Mês', 'Receita (R$)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_projecao_financeira)) {
                    echo "['" . $row['mes'] . "', " . $row['total_receita'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Projeção Financeira (Receita Mensal)',
                hAxis: {title: 'Mês'},
                vAxis: {title: 'Receita (R$)'},
                legend: 'none'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_projecao_financeira'));
            chart.draw(data, options);
        }

        // Relatório de Ocupação Média dos Ônibus
        function drawOcupacaoMedia() {
            var data = google.visualization.arrayToDataTable([
                ['Viagem', 'Ocupação (%)'],
                <?php
                while ($row = mysqli_fetch_assoc($result_ocupacao_media)) {
                    echo "['Viagem " . $row['idviagem'] . "', " . $row['ocupacao_percentual'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Ocupação Média dos Ônibus (%)',
                hAxis: {title: 'Viagem'},
                vAxis: {title: 'Ocupação (%)'},
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_ocupacao_media'));
            chart.draw(data, options);
        }

// Função para desenhar o gráfico de Desempenho dos Motoristas
        function drawDesempenhoMotoristas() {
            var data = google.visualization.arrayToDataTable([
                ['Motorista', 'Viagens Realizadas'],
                <?php
                while ($row = mysqli_fetch_assoc($result_desempenho_motoristas)) {
                    echo "['" . $row['nome'] . "', " . $row['total_viagens'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Desempenho dos Motoristas (Quantidade de Viagens)',
                hAxis: {title: 'Motorista'},
                vAxis: {
                    title: 'Viagens Realizadas',
                    format: '0'  // Garante que os valores no eixo Y sejam inteiros
                },
                legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_desempenho_motoristas'));
            chart.draw(data, options);
        }

        // Função para carregar todos os gráficos
        google.charts.setOnLoadCallback(function() {
            drawProjecaoFinanceira();
            drawOcupacaoMedia();
            drawDesempenhoMotoristas();
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
    <h1>Dashboard Operacional</h1>
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
                    <button type="submit" class="btn btn-primary">Filtrar Relatórios</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Gráficos -->
    <div class="container">
        <div class="row">
            <!-- Gráfico de Projeção Financeira -->
            <div class="col-md-6">
                <div id="chart_projecao_financeira" style="width: 100%; height: 500px;"></div>
            </div>
            <!-- Gráfico de Ocupação Média dos Ônibus -->
            <div class="col-md-6">
                <div id="chart_ocupacao_media" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
        <div class="row">
            <!-- Gráfico de Desempenho dos Motoristas -->
            <div class="col-md-12">
                <div id="chart_desempenho_motoristas" style="width: 100%; height: 500px;"></div>
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
