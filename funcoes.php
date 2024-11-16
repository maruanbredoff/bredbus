<!-- ================= Logs de atividades  ======================== -->
<?php 
include "../config.php"; 
function criaLog($con, $MSG, $REL, $idcontrato) {
$login = $_SESSION['UsuarioNome']; // Salva o IP do visitante
$hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
 
$MSGF = mysqli_real_escape_string($con,$MSG); // Limpando String
 
// Monta a query para inserir o log no sistema
$sql = "INSERT INTO logs (hora,login,mensagem,relacionamento, idcontrato) VALUES ('$hora', '$login', '$MSGF', '$REL','$idcontrato')";
 
if (mysqli_query($con,$sql))
return true;
else
return false;
}

function verificaViagemContrato($con, $idviagem) {
    if (!isset($_SESSION['ContratoID']) || !isset($idviagem)) {
        header("Location: ../restrita.php");
        exit;
    }

    $idcontrato = $_SESSION['ContratoID'];
    
    $sql = "SELECT idviagem 
            FROM viagem 
            WHERE idviagem = ? AND idcontrato = ?";

    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $con->error); // Exibe o erro do MySQL se a preparação falhar
    }

    $stmt->bind_param("ii", $idviagem, $idcontrato);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        // Se a viagem não está associada ao contrato do usuário, redireciona para restrita.php
        header("Location: ../restrita.php");
        exit;
    }

    $stmt->close();
}
?>

<style>
    #exportButton {
        border-radius: 0;
    }
</style>



<script language="javascript"> 
// Aparecer campo num Documento ao escolher forma pg -->
    function checkpg(){
        var option = document.getElementById("idformapg").value;
        if(option == "2"){
            document.getElementById("hiddenparcelas").style.visibility ="visible";
              document.getElementById("hiddenemitente").style.visibility ="hidden";
              document.getElementById("hiddenbanco").style.visibility ="hidden";
              document.getElementById("hiddenagencia").style.visibility ="hidden";
        }
        else  {  
              document.getElementById("hiddenparcelas").style.visibility ="hidden";}
    }
</script>

<!-- ================= Adicionar e remover inputs  ======================== -->
<script language="javascript">  
$(document).ready(function() {
        var campos_max          = 10;   //max de 10 campos
        var x = 1; // campos iniciais
        $('#add_field').click (function(e) {
                e.preventDefault();     //prevenir novos clicks
                if (x < campos_max) {
                        $('#listas').append('<div class="row">\
                                                <div class="col-md-6">\
                                                    <div class="form-group">\
                                                    <select class="custom-select form-control" name="idprocedimento[]" id="idprocedimento[]" required>\
                                                    <option value="5">Teste 5</option>\
                                                    <option value="6">Teste 6</option>\
                                                    </select>\
                                <a href="#" class="remover_campo">Remover</a>\
                                </div>\</div>\
                                            <div class="col-md-2">\
                                                <div class="form-group">\
                                                    <label for="valor">Valor</label>\
                                                    <input type="text" class="form-control" id="valor" name="valor">\
                                                </div>\
                                            </div> \    </div>');
                        x++;
                }
        });
        // Remover o div anterior
        $('#listas').on("click",".remover_campo",function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
        });
});
 </script>  
<!-- =================  Formatar Moeda  ======================== -->
<script language="javascript">  

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){  
     var sep = 0;  
     var key = '';  
     var i = j = 0;  
     var len = len2 = 0;  
     var strCheck = '0123456789';  
     var aux = aux2 = '';  
     var whichCode = (window.Event) ? e.which : e.keyCode;  
     if (whichCode == 13 || whichCode == 8) return true;  
     key = String.fromCharCode(whichCode); // Valor para o código da Chave  
     if (strCheck.indexOf(key) == -1) return false; // Chave inválida  
     len = objTextBox.value.length;  
     for(i = 0; i < len; i++)  
         if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;  
     aux = '';  
     for(; i < len; i++)  
         if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);  
     aux += key;  
     len = aux.length;  
     if (len == 0) objTextBox.value = '';  
     if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;  
     if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;  
     if (len > 2) {  
         aux2 = '';  
         for (j = 0, i = len - 3; i >= 0; i--) {  
             if (j == 3) {  
                 aux2 += SeparadorMilesimo;  
                 j = 0;  
             }  
             aux2 += aux.charAt(i);  
             j++;  
         }  
         objTextBox.value = '';  
         len2 = aux2.length;  
         for (i = len2 - 1; i >= 0; i--)  
         objTextBox.value += aux2.charAt(i);  
         objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);  
     }  
     return false;  
 }  
 </script>  
<script language="javascript"> 
// Aparecer campo num Documento ao escolher forma pg -->
    function checkdentista(){
        var option = document.getElementById("sedentista").value;
        if(option == "1") {
            document.getElementById("hiddendt").style.visibility ="visible";
        }
        else
            document.getElementById("hiddendt").style.visibility ="hidden";
    }
</script>
<!-- =================  Formatar Qualquer padrão fixo  ======================== -->
<script>
function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
</script>
<!-- =================  Calcular Valor Parcelado  ======================== -->
<script type="text/javascript">
function calcularparcelas( valparcelado )
{
	var valor = id('valor_total').value;
    var qtd = id('qtdparcelas').value;    
    var entrada = id('entrada').value;
    var parcelado = (valor-entrada)/qtd;
    var arredondado = parseFloat(parcelado.toFixed(2));
	id('valparcelado').value = arredondado
}
</script>

<script type="text/javascript">
function calcularparcelas2( valrestante )
{
    var valor = id('valor_total').value;  
    var entrada = id('entrada').value;
    var entradasemponto = valor.replace(".","");  
    var entradaformatado = valor.replace(",",".");
    var valorsemponto = valor.replace(".","");  
    var valorformatado = valor.replace(",",".");
    var parcelado = (valorsemponto-entradasemponto);
    //var arredondado = parseFloat(valorformatado.toFixed(2));
    id('valrestante').value = parcelado
}
</script>
<!-- =================  Calcular Valor Pagar  ======================== -->
<script type="text/javascript">
function id( imc ){
	return document.getElementById( imc );
}
function calcularparcelaspg( valparcelado )
{
	var valor = id('valor').value;
    var qtd = id('qtdparcelas').value;    
    var parcelado = valor/qtd;
    var arredondado = parseFloat(parcelado.toFixed(2));
	id('valparcelado').value = arredondado
}
</script>
<!-- =================  Calcular IMC  ======================== -->
<script type="text/javascript">
function id( imc ){
	return document.getElementById( imc );
}
function calcularimc( imc )
{
	var altura = id('altura').value;
	var peso = id('peso').value;
    var imc = peso/(altura * altura);
    var arredondado = parseFloat(imc.toFixed(2));
	id('imc').value = arredondado
}
</script>
<!-- =================  Calcular IGC  ======================== -->
<script type="text/javascript">
function id( igc ){
	return document.getElementById( igc );
}

function calcularigc( igc )
{
	var imc = id('imc').value;
	var idade = id('idade').value;
    var sexo = id('sexo').value;
    var igcmasc = ((1.20*imc)+(0.23 * idade)-(10.8*1)-5.4);
    var arredmasc = parseFloat(igcmasc.toFixed(2));
    var igcfem = ((1.20*imc)+(0.23 * idade)-(10.8*0)-5.4);
    var arredfem = parseFloat(igcfem.toFixed(2));
if (sexo == 'Masculino') {
	id('igc').value = arredmasc
        } else {
	id('igc').value = arredfem
        }
}
</script>

     

     