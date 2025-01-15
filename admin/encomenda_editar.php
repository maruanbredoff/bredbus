<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
  // Destrói a sessão por segurança
  session_destroy();
  // Redireciona o visitante de volta pro login
  header("Location: ../restrita.php"); exit;
}
$date2 = date('Y-m-d H:i'); 
include "../verificanivel.php";
include "../config.php"; 
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
                <div class="col-md-5 align-self-center">
                    <br>
                </div>
            <div class="container-fluid">
<?php
include "../funcoes.php";
        $idcontrato = $_SESSION['ContratoID'];
      $idencomenda = mysqli_real_escape_string($con,$_POST['idencomenda']);
      $idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
      $etiqueta = mysqli_real_escape_string($con,$_POST['etiqueta']);
      $descricao = mysqli_real_escape_string($con,$_POST['descricao']);
      $remetente = mysqli_real_escape_string($con,$_POST['remetente']);
      $destinatario = mysqli_real_escape_string($con,$_POST['destinatario']);
      $localhorigem = mysqli_real_escape_string($con,$_POST['localhorigem']);
      $localdestino = mysqli_real_escape_string($con,$_POST['localdestino']);
      $telremetente = mysqli_real_escape_string($con,$_POST['telremetente']);
      $teldestinatario = mysqli_real_escape_string($con,$_POST['teldestinatario']);
      $docremetente = mysqli_real_escape_string($con,$_POST['docremetente']);
      $docdestinatario = mysqli_real_escape_string($con,$_POST['docdestinatario']);
      $idsituacao = mysqli_real_escape_string($con,$_POST['idsituacao']);
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $editado_por = $_SESSION['UsuarioNome'];
      $atendente = $_SESSION['UsuarioNome'];

      $tipo = mysqli_real_escape_string($con,$_POST['tipo']);
      $qtd = mysqli_real_escape_string($con,$_POST['qtd']);

      $valdeclarado = mysqli_real_escape_string($con,$_POST['valdeclarado']);
      $valord_ponto = str_replace(".","",$valdeclarado);  
      $valordformatado = str_replace(",",".",$valord_ponto);

      //Campos formatados
      $valor = mysqli_real_escape_string($con,$_POST['valor']);
      $valor_ponto = str_replace(".","",$valor);  
      $valorformatado = str_replace(",",".",$valor_ponto);

      @$formapg = mysqli_real_escape_string($con,$_POST['formapg']);
     
          $cad = mysqli_query ($con,"UPDATE viagem_encomenda set idviagem = '$idviagem', descricao = '$descricao', remetente = '$remetente', destinatario = '$destinatario', localhorigem = '$localhorigem',localdestino = '$localdestino',telremetente = '$telremetente',teldestinatario = '$teldestinatario',docremetente = '$docremetente',docdestinatario = '$docdestinatario', valor = '$valorformatado', idviagem = '$idviagem',idsituacao = '$idsituacao',editado_por = '$editado_por', data_edicao = '$date2', tipo = '$tipo', qtd = '$qtd', valdeclarado = '$valordformatado', etiqueta = '$etiqueta' where idencomenda=$idencomenda")  or die(mysqli_error($con));

if($cad){

          $updatecontas = mysqli_query ($con,"UPDATE contas_encomendas set valorpg = '$valorformatado', idsituacao = '$idsituacao' where idencomenda=$idencomenda")  or die(mysqli_error($con)); 

//criaLog($con,"Encomenda Editada", "viagem numero $idencomenda"); ?>   
                    <?php
    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Encomenda Editada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: cliente_imagens.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=encomenda_ver.php?idviagem=$idviagem'>";  
                          
            }
          else{ ?>
                
        <?php  
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar viagem <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=encomenda_ver.php?idviagem=$idviagem'>";  }

?>
        </div>

    </div>