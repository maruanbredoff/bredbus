
<head>
<?php include "verifica_sessao.php"; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Bredbus - Seu sistema inteligente de Passagens</title>
    <!-- Bootstrap Core CSS -->
    
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/plugins/dff/dff.js" type="text/javascript"></script>
    <!-- morris CSS -->
    <link href="../assets/plugins/wizard/steps.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <link rel="stylesheet" href="../assets/jquery-ui.css">



        <script src="../js/jquery.js"></script>

        <link rel="stylesheet" href="../css/bootstrap-select.min.css">
        <script src="../js/bootstrap-select.min.js"></script>


      <script src="../assets/jquery-ui.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Calendar JavaScript -->
    <link href="../assets/fullcalendar/fullcalendar.min.css' rel='stylesheet' "/>
    <link href="../assets/fullcalendar/css/fullcalendar.print.min.css' rel='stylesheet' media='print' "/>
    <script src="../assets/fullcalendarr/lib/moment.min.js"></script>
    <script src="../assets/fullcalendar/js/fullcalendar.min.js"></script>
    <script src="../assets/fullcalendar/locale/pt-br.js"></script>
        <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- Chart JS -->
    <script type='text/javascript' src='../assets/cep.js'></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    
    <!-- ============== Datatables ============= -->
    <!-- This is data table -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="../assets/js/dataTables.buttons.min.js"></script>
    <script src="../assets/js/buttons.flash.min.js"></script>
    <script src="../assets/js/jszip.min.js"></script>
    <script src="../assets/js/buttons.html5.min.js"></script>
    <script src="../assets/js/buttons.print.min.js"></script>

    <!-- Formulario winzard -->
    <script src="../assets/plugins/wizard/jquery.steps.min.js"></script>
    
            <script src="../assets/js/jquery.maskMoney.js"></script>

</head>

<body class="fix-header fix-sidebar card-no-border">
<?php

$nivel = $_SESSION['UsuarioNivel'];
$usuarioid = $_SESSION['UsuarioID'];
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
$datebr = date('d-m-Y H:i'); 
// A sessão precisa ser iniciada em cada página diferente

$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: ../restrita.php"); exit;
}
include "../config.php";

?>
<?php
//---------------Lista as despesas vencidas ------------------
// executa a query 
$dados_despesas = mysqli_query($con,"select cpm.data_movimento, cpm.tipopg, cp.valor, cp.parcela, cp.vencimento, cp.idmovipagar, sc.situacao, sc.idsituacao, cp.idcpagar, fp.tipo from contas_pagar_movi cpm 
inner join contas_pagar cp on cpm.idmovipagar = cp.idmovipagar
inner join formapg fp on fp.idformapg = cpm.idformapg
inner join situacao_caixa sc on sc.idsituacao = cp.idsituacao
where sc.idsituacao = 1 and cp.vencimento <= CURRENT_DATE()
order by cp.vencimento") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_despesas = mysqli_fetch_assoc($dados_despesas); 
    
$total_despesas = mysqli_num_rows($dados_despesas);
?>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="../assets/images/logo-icon2.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="../assets/images/logo-light-icon2.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="../assets/images/logo2.png" alt="homepage" width="90" height="60" class="img-rounded" />
                         <!-- Light Logo text -->    
                         <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
                </div>

                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->
                       <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Receitas:
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-cash-multiple"></i>

                       <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Despesas:
                            </a>
                        </li>
<!-------------------------------------Lista de despesas vencidas --------------------------------------  -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-cash-100"></i>
                            <?php
                            if($total_despesas >=1){
                                ?>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox animated slideInUp">
                                <ul>
                                    <li>
                                        <div class="drop-title">Existem <?php echo $total_despesas?> Despesas Vencidas</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <?php 
                                            do{
                                            ?>
                                            <a href="financeiro_pagar_parcelas_ind.php?idmovipagar=<?php echo $linha_despesas['idmovipagar']?>">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-money"></i></div>
                                                <div class="mail-contnet">
                                                    <h5><?php echo $linha_despesas['tipopg'] ?></h5> <span class="mail-desc"><?php echo $linha_despesas['tipo'] ?></span> <span class="time">Valor: <?php echo $linha_despesas['valor'] ?></span> </div>
                                            </a>
                                            <?php } while($linha_parcelas = mysqli_fetch_assoc($dados_parcelas));?>
                                            <!-- Message -->
                                        </div>
                                    </li>
                                </ul>
                            </div> 
                            <?php }
                        else {
                        ?>
                            <div class="dropdown-menu mailbox animated slideInUp">
                                <ul>
                                    <li>
                                        <div class="drop-title"><center>Não existem Despesas Vencidas</center></div>
                                    </li>
                                    <li>

                                            <!-- Message -->
                                            <a href="#">
                                            </a>
                                            <!-- Message -->
                                 
                                    </li>
                                </ul>
                            </div> 
                        </li>
                       <?php }
                        ?>
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> 

                    </div>
                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5><?php echo $_SESSION['UsuarioNome']?></h5>
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                        <a href="../logout.php" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                        <div class="dropdown-menu animated flipInY">
                            <!-- text-->
                            <a href="../alterar_senha.php" class="dropdown-item"><i class="ti-settings"></i>Alterar Senha</a>
                            <!-- text-->
                            <div class="dropdown-divider"></div>
                            <!-- text-->
                            <a href="../logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                            <!-- text-->
                        </div>
                    </div>
                </div>
                <?php switch($nivel){ // começa os casos para cada tipo de usuário...
                    case $nivel >= 9: ?>
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a class="waves-effect waves-dark" href="inicioadm.php" aria-expanded="false"><i class="mdi mdi-home-outline"></i><span class="hide-menu">Inicio </span></a>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Admin</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="usuario_cadastrar.php">Cadastrar Usuario</a></li>
                                <li><a href="logs_listar.php">Listar Atividades</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Clientes</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="cliente_listar.php">Listar Cliente</a></li>
                            </ul>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="agenda.php" aria-expanded="false"><i class="mdi mdi-calendar-today"></i><span class="hide-menu">Agenda </span></a></li>                       
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bus"></i><span class="hide-menu">Viagens</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="linha_cadastrar.php">Cadastrar Linha</a></li>
                                <li><a href="pontos_embarque.php">Cadastrar Embarques</a></li>
                                <li><a href="agencia_cadastrar.php">Cadastrar Agencia</a></li>
                                <li><a href="onibus_cadastrar.php">Cadastrar Onibus</a></li>
                                <li><a href="motorista_cadastrar.php">Cadastrar Motorista</a></li>
                                <li><a href="viagem_pesquisa.php">Cadastrar Viagem</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-package-variant"></i><span class="hide-menu">Encomendas</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="encomenda_cadastrar.php">Cadastrar Encomenda</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-printer"></i><span class="hide-menu">Estatísticas</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="dashboard_financeiro.php">Financeiro</a></li>
                                <li><a href="dashboard_operacional.php">Operacional</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">Fluxo de Caixa</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="financeiro_receber.php">Contas a Receber</a></li>
                                <li><a href="financeiro_pagar.php">Contas a Pagar</a></li>
                                <li><a href="financeiro_fluxo.php">Movimento Geral</a></li>
                            </ul>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="financeiro_encomenda.php" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">Caixa Encomendas </span></a>
                        </li>
                    </ul>
                </nav>
                <?php break;
                case $nivel == 8: ?>
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a class="waves-effect waves-dark" href="inicio.php" aria-expanded="false"><i class="mdi mdi-home-outline"></i><span class="hide-menu">Inicio </span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="agenda.php" aria-expanded="false"><i class="mdi mdi-calendar-today"></i><span class="hide-menu">Agenda </span></a></li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Clientes</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="cliente_listar.php">Listar Cliente</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bus"></i><span class="hide-menu">Viagens</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="linha_cadastrar.php">Cadastrar Linha</a></li>
                                <li><a href="pontos_embarque.php">Cadastrar Embarques</a></li>
                                <li><a href="agencia_cadastrar.php">Cadastrar Agencia</a></li>
                                <li><a href="onibus_cadastrar.php">Cadastrar Onibus</a></li>
                                <li><a href="motorista_cadastrar.php">Cadastrar Motorista</a></li>
                                <li><a href="viagem_pesquisa.php">Cadastrar Viagem</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-package-variant"></i><span class="hide-menu">Encomendas</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="encomenda_cadastrar.php">Cadastrar Encomenda</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-printer"></i><span class="hide-menu">Relatorios</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#">Passagens</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">Fluxo de Caixa</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="financeiro_receber.php">Contas a Receber</a></li>
                                <li><a href="financeiro_pagar.php">Contas a Pagar</a></li>
                                <li><a href="financeiro_fluxo.php">Movimento Geral</a></li>
                            </ul>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="financeiro_encomenda.php" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">Caixa Encomendas </span></a>
                        </li>
                    </ul>
                </nav>
                <?php break;
                case $nivel == 2: ?>
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a class="waves-effect waves-dark" href="inicio.php" aria-expanded="false"><i class="mdi mdi-home-outline"></i><span class="hide-menu">Inicio </span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="agenda.php" aria-expanded="false"><i class="mdi mdi-calendar-today"></i><span class="hide-menu">Agenda </span></a></li> 
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Clientes</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="cliente_listar.php">Listar Cliente</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bus"></i><span class="hide-menu">Viagens</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="viagem_pesquisa.php">Cadastrar Passagem</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-package-variant"></i><span class="hide-menu">Encomendas</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="encomenda_cadastrar.php">Cadastrar Encomenda</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <?php break;
                case $nivel == 1: ?>
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a class="waves-effect waves-dark" href="inicio.php" aria-expanded="false"><i class="mdi mdi-home-outline"></i><span class="hide-menu">Inicio </span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="agenda.php" aria-expanded="false"><i class="mdi mdi-calendar-today"></i><span class="hide-menu">Agenda </span></a></li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Clientes</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="cliente_listar.php">Listar Cliente</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bus"></i><span class="hide-menu">Viagens</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="viagem_pesquisa.php">Cadastrar Viagem</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-package-variant"></i><span class="hide-menu">Encomendas</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="encomenda_cadastrar.php">Cadastrar Encomenda</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-printer"></i><span class="hide-menu">Relatorios</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#">Passagens</a></li>
                            </ul>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="financeiro_encomenda.php" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">Caixa Encomendas </span></a>
                        </li>
                    </ul>
                </nav>
            <?php } ?>

                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            </div>
        </aside>
                        <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
                <!-- Right sidebar -->
                <!-- ============================================================== -->
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
                        </div>
                    </div>
                </div>
<?php 
include "../rodape.php";

//ob_end_flush(); // Libera o conteúdo do buffer de saída

?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->