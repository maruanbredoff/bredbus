<?php 
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$data_extenso = strftime('%d de %B de %Y', strtotime('today'));
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
// A sessão precisa ser iniciada em cada página diferente
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
  ob_start();
//include "../verificanivel.php";
include "../config.php"; 

$data_extenso = strftime('%d de %B de %Y', strtotime('today'));
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
// A sessão precisa ser iniciada em cada página diferente
//include "../verificanivel.php";
$idcliente = $_GET['idcliente'];
$idpassagem = $_GET['idpassagem'];
$query = sprintf("SELECT * from clientes where idcliente = $idcliente");

// executa a query 
$dados = mysqli_query($con,$query) or die(mysql_error()); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados); 

?>
        <table border='0' align="center">
            <tr>
                <td align="center"><img src=../assets/images/logo.png width="150"></td>
            </tr>
            <tr>
                <td><h3 align='center'>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE TURISMO</h3></td>
            </tr>
</table>
<p style="text-align:justify; margin: 25px 25px 10px 25px; line-height: 1.3;">
<h4>1. DAS PARTES</h4>
<h4>1.1 CONTRATADAS</h4>
PORTO TURISMO VIAGENS S.A., inscrita no CNPJ/MF sob o nº 11.111.111/0001-11, com sede na Rua Belo Horizonte,  88,  2º  andar,  Centro,  Cidade  de  Padre Paraíso,  Estado  de  Minas Gerais, CEP 39818-000, neste ato sendo a Agência de Viagens..
<br>

<h4>1.2.CONTRATANTE:</h4>
CLIENTE: <?php echo $linha['nome']; ?>, Portador do Passaporte: <?php echo $linha['passaporte']; ?> e CPF: <?php echo $linha['cpf']; ?>, residente em <?php echo $linha['endereco']; ?>, <?php echo $linha['numero']; ?>, <?php echo $linha['bairro']; ?>, <?php echo $linha['cidade']; ?>.
<br>
<h4>2.  DO  OBJETO </h4>
O  presente  contrato  tem  por  objeto  a  contratação de serviços  de  turismo prestados  PORTO TURISMO VIAGENS  contratados  para  execução  dos  serviços descritos  e  especificados  no  item 2.1. a seguir. 
<br>
<h4>2.1. DOS SERVIÇOS INTERMEDIADOS</h4>
        <table border='1' align="center" width="800">
            <tr>
                <th colspan="3" align="center">DADOS DA VIAGEM</th>
            </tr>
            <tr>
                <td><strong>ORIGEM:</strong><?php echo strtoupper($linha_passagem['origem'])?></td> 
                <td width="300" align="center"><strong>DESTINO:</strong><?php echo strtoupper($linha_passagem[destino]) ?></td> 
                <td width="200"><strong>DATA PASSAGEM:</strong> <?php echo strtoupper($databr2) ?></td>
            </tr>  
            <tr>
                <th colspan="3" align="center">SERVIÇOS INCLUSOS</th>
            </tr> 
            <tr>
                <td colspan="3" height="40"></td>
            </tr> 
            <tr>
                <th colspan="3" align="center">NOME DOS PASSAGEIROS</th>
            </tr> 
            <tr>
                <th align="center">NOME</th>
                <th align="center" width="100">DOCUMENTO</th>
                <th align="center" width="100">NASCIMENTO</th>
            </tr> 
            <tr>
                <td height="20" align="center"><?php echo strtoupper($linha['nome']) ?></td>
                <td height="20" align="center"><?php echo strtoupper($linha_passagem['passaporte']) ?></td>
                <td height="20" align="center"><?php echo strtoupper($nascimento) ?></td>
            </tr>
            <tr>
                <td height="20"></td>
                <td height="20"></td>
                <td height="20"></td>
            </tr>
            <tr>
                <td height="20"></td>
                <td height="20"></td>
                <td height="20"></td>
            </tr>
            <tr>
                <td height="20"></td>
                <td height="20"></td>
                <td height="20"></td>
            </tr>
            <tr>
                <td height="20"></td>
                <td height="20"></td>
                <td height="20"></td>
            </tr>
        </table>

<h4>3. DO PREÇO</h4>
Os serviços contratados totalizam o valor de R$ (<?php echo $valor_pa_formatado; ?>), já incluídas as taxas de embarque e taxas de outros serviços como hotel, comidas, etc.

<h4>4. DAS RESPONSABILIDADES DO CONTRATANTE</h4>
O Contratante, acima qualificado, assina este contrato como responsável por si e pelas as demais pessoas, para quem as reservas são feitas. <br><br><br><br>
<h4>4.1. ALTERAÇÕES DA PROGRAMAÇÃO</h4>
Havendo alterações na programação, afetando parcial ou totalmente qualquer item da viagem, a Contratada
comunicará por escrito o Contratante, quando da entrega dos documentos da viagem e respectivas passagens. 
<br><br>
<br><br><br>
E para que conste assino o presente documento.
<br> <br>  
Assinatura por extenso (Cliente) ___________________________________________data ___/________/______
<br><br><br><br><br>
</p>

<br><br><br><br>
<h4>Padre Paraíso, <?php echo " $data_extenso" ?></h4>
<br>
<br>

	