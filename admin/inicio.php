<!DOCTYPE html>
<html lang="en">

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
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
?>
<body class="card-no-border">
<?php
include "../config.php"; 
//include_once "../verificanivel.php"; 
include_once "../menu.php";
    
// executa a query 
$dados = mysqli_query($con,"select crm.idmovimento,crm.idcliente,pa.idpassagem, pa.embarque, pa.desembarque,c.nome as nomecliente, crm.valor_total, crm.qtdparcelas, fr.tipo, crm.data_movimento, pa.status_passagem, sum(cr.valor) as contaspagas, fr.tipo, crm.desconto as desconto, c.nome
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
left join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join passagem pa on pa.idpassagem = crm.idpassagem 
inner join formapg fr on fr.idformapg = crm.idformapg
where DATE_FORMAT(cr.data_pg, '%Y-%m-%d') = CURRENT_DATE()
group by crm.idmovimento,crm.idcliente,pa.idpassagem, pa.embarque, pa.desembarque,c.nome, crm.valor_total, crm.qtdparcelas, fr.tipo, pa.status_passagem, crm.data_movimento, fr.tipo, crm.desconto
ORDER BY crm.idmovimento limit 5") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);
@$valor = $linha['valor'];
$valor_formatado = number_format($valor,2, ',', '.');

//------------------------Lista de Pagamentos -----------------------------------
// executa a query 
$dados_pg = mysqli_query($con,"select cpm.idmovipagar, cpm.data_movimento, cpm.tipopg, cpm.valor, cpm.qtdparcelas, fp.tipo, cpm.idsituacao, cpm.descricao 
from contas_pagar_movi cpm 
inner join formapg fp on fp.idformapg = cpm.idformapg
inner join situacao_caixa sc on sc.idsituacao = cpm.idsituacao
where DATE_FORMAT(cpm.data_movimento, '%Y-%m-%d') = CURRENT_DATE() and cpm.idsituacao = 2
group by cpm.idmovipagar, cpm.data_movimento, cpm.tipopg, cpm.valor, cpm.qtdparcelas, fp.tipo, cpm.idsituacao, cpm.descricao limit 5") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapg = mysqli_fetch_assoc($dados_pg); 
    
$total_pg = mysqli_num_rows($dados_pg);
@$valor_pg = round($linhapg['valor']*100/100);
$valor_formatado_pg = number_format($valor_pg,2, ',', '.');
//------------------------------ Agenda -----------------------------------
$dados_agenda = mysqli_query($con,"select id,title,start,end,resp_agenda,color,tipo from agenda where DATE_FORMAT(start, '%Y-%m-%d') = CURRENT_DATE()") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhaagenda = mysqli_fetch_assoc($dados_agenda);
    
//------------------------------Soma o valor de receitas pagos ------------------------------
// executa a query 
$dados_receb_pago = mysqli_query($con,"select sum(cr.valor) as contaspagas
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
left join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join passagem pa on pa.idpassagem = crm.idpassagem 
inner join formapg fr on fr.idformapg = cr.idformapg
where DATE_FORMAT(cr.data_pg, '%Y-%m-%d') = CURRENT_DATE()") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linharecebpago = mysqli_fetch_assoc($dados_receb_pago);   
$valorrecebpago = round($linharecebpago['contaspagas']*100/100);
$valorrecebpago_format = number_format($valorrecebpago,2, ',', '.');

//------------------------------Soma o valor de pagamentos pagos ----------------------------
// executa a query 
$dados_soma_pago = mysqli_query($con,"select sum(cpm.valor) as total_pago 
from contas_pagar_movi cpm 
inner join formapg fp on fp.idformapg = cpm.idformapg
inner join tipopg tp on tp.idtipopg = cpm.tipopg
where DATE_FORMAT(cpm.data_pg, '%Y-%m-%d') = CURRENT_DATE()") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapago = mysqli_fetch_assoc($dados_soma_pago);   
$valorpago = round($linhapago['total_pago']*100/100);
$valorpago_format = number_format($valorpago,2, ',', '.');
// ----------------------- Usuario ----------------------------    
// executa a query 
$usuarios = mysqli_query($con,"SELECT nivel FROM usuario where id_usuario=$usuarioid") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhausuario = mysqli_fetch_assoc($usuarios); 

// Residual do caixa
$residual = round(($valorrecebpago - $valorpago)*100/100);
$residual_format = number_format($residual,2, ',', '.');
?>
?>
        <!-- ============================================================== -->
        <div class="page-wrapper">
<br>
            <div class="container-fluid">
            <div class="card">
                <div class="row">
                    
                    <div class="col-12">
                <div class="alert alert-warning">
                    <center><h4><i class="fa fa-tasks"></i> Estatísticas Gerais do dia</h4></center>
                </div>

                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-success"></i></h2>
                                    <h3 class="">R$ <?php echo $valorrecebpago_format ?></h3>
                                    <h6 class="card-subtitle">Receitas</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-alert-circle text-warning"></i></h2>
                                    <h3 class="">R$ <?php echo $valorpago_format?></h3>
                                    <h6 class="card-subtitle">Despesas</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-wallet text-info"></i></h2>
                                    <h3 class="">R$ <?php echo $residual_format ?></h3>
                                    <h6 class="card-subtitle">Residual</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h4 class="card-title">Ultimas Receitas<br/></h4>
                                    <table class="table table-hover earning-box">
                                        <thead>
                                            <tr>
                                                <th>Paciente</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                            $valor = $linha['contaspagas'];
                                            $valor_formatado = number_format($valor,2, ',', '.');
                                            ?>
                                            <tr>
                                                <td><a href="cliente_cadastro_ver.php?idcliente=<?php echo $linha['idcliente']?>"><?php echo $linha['nomecliente']?></a></td>
                                                <td><?php echo $valor_formatado ?></td>
                                            </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha = mysqli_fetch_assoc($dados)); 
                                                    // fim do if 
                                                            } 
                                            ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h4 class="card-title">Ultimas Despesas<br/></h4>
                                    <table class="table table-hover earning-box">
                                        <thead>
                                            <tr>
                                                <th>Titulo</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total_pg > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                            $valorpagamento = $linhapg['valor'];
                                            $valorpg_formatado = number_format($valorpagamento,2, ',', '.');
                                            ?>
                                            <tr>
                                                <td><a href="financeiro_pagar.php?idmovipagar=<?php echo $linhapg['idmovipagar']?>"><?php echo $linhapg['descricao']?></a></td>
                                                <td><a href="financeiro_pagar_parcelas_ind.php?idmovipagar=<?php echo $linhapg['idmovipagar']?>&idcliente=<?php echo $linhapg['idcliente']?>">R$ <?php echo $valorpg_formatado?></a></td>
                                            </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linhapg = mysqli_fetch_assoc($dados)); 
                                                    // fim do if 
                                                            } 
                                            ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div></div>
                <!-- Row -->
               
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
        </div>
                </div>
            </div>
    </div>
        <!-- ============================================================== -->

</body>

</html>