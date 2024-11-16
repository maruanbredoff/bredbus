<style>
div.a {
  font-size: large;
}

</style>
<?php 
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$data_extenso = strftime('%d de %B de %Y', strtotime('today'));
date_default_timezone_set('America/Sao_Paulo');
$date = date('H:i');
// A sessão precisa ser iniciada em cada página diferente
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
  ob_start();
//include "../verificanivel.php";
include "../config.php"; 
$idcliente = $_GET['idcliente'];
$idatestado = $_GET['idatestado'];
$query = sprintf("select a.idcliente, a.finalidade,a.dataatestado,a.idatestado,a.qtddias,a.respatestado,a.cid,c.nome,c.cpf,c.rg from atestado a, clientes c
where a.idcliente = c.idcliente and a.idatestado = $idatestado");

// executa a query 
$dados = mysqli_query($con,$query) or die(mysql_error()); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados); 

//@$databr = date('d-m-Y', strtotime($linha['data']));
@$databr2 = date('d/m/Y H:i:s', strtotime($linha['dataatestado']));
?>
<div style="width:900px;height:100%;background:url(../assets/images/background_receitas.jpeg);background-size:700px;
    background-repeat:no-repeat;">
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="padding-left:-90px;">
<p style="font-size:30px; text-align:center;">Atesto pra fins <?php echo $linha['finalidade'] ?>, que o(a) Sr(a) <br><strong><?php echo $linha['nome']?></strong> <br> portador do RG: <strong><?php echo $linha['rg']?></strong>
<br> esteve sob meus cuidados no dia <?php echo date('d/m/Y', strtotime($linha['dataatestado']));?>. <br>
Necessitando o(a) mesmo(a) de <strong><?php echo $linha['qtddias']?></strong> dias de repouso. <br></p>
</div>
<p style="font-size:30px;">CID: <strong><?php echo $linha['cid']?></strong></p>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<h3>Teófilo Otoni, <?php echo " $data_extenso"." - ".$date?></h3>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div style="padding-left:190px;">
        <table border="0">
			<tr>
				<td width='350'>___________________________________________________</td>
			</tr><tr><td></td></tr>
			<tr>
				<td width='350' align="center"><h4>Dra. Michella Murta Martins</h4></td>	
			</tr>
			<tr><td></td></tr><tr><td></td></tr>
        </table>
    </div> 
</div>

	