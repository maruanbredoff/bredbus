<?php   
include "../config.php"; 
 
   //recebe os parâmetros
    $idprocedimento = $_REQUEST['idprocedimento'];
    $idcliente = $_REQUEST['idcliente'];
    $dente = $_REQUEST['dente'];
    $face = $_REQUEST['face'];
    $iddentista = $_REQUEST['iddentista'];
    $datainicio = $_REQUEST['datainicio'];
    $atendente = $_REQUEST['atendente'];
    $datacadastro = $_REQUEST['datacadastro'];
    try
    {
        //insere na BD
$cad = mysqli_query($con,"INSERT INTO tratamento (idtratamento,idcliente,idprocedimento, dente, face, iddentista, datainicio, status_tratamento, datacadastro, atendente) values(NULL,'$idcliente','$idprocedimento','$dente','$face','$iddentista','$datainicio','Tratando','$datacadastro','$atendente') ") or die(mysqli_error($con));  
        //retorna 1 para no sucesso do ajax saber que foi com inserido sucesso
        echo "1";
    } 
    catch (Exception $ex)
    {
        //retorna 0 para no sucesso do ajax saber que foi um erro
        echo "0";
    }
?>