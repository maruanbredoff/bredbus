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
include "../cssboostrap.php";

$data_extenso = strftime('%d de %B de %Y', strtotime('today'));
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
// A sessão precisa ser iniciada em cada página diferente
//include "../verificanivel.php";
$idpassagem = $_GET['idpassagem'];
$idviagem = $_GET['idviagem'];
//Listagem das Passagens
$query_passagem = sprintf("select p.idpassagem, p.embarque, p.desembarque, v.idviagem, v.dataviagem, v.horaviagem, r.corigem, r.cdestino, substring_index(c.nome, ' ', 1)  as primeironome, substring_index(c.nome, ' ', -2)  as segundonome, c.sexo, c.nascimento, c.documento, c.celular, p.poltrona, a.nome as agencia, c.idcliente, cr.valor, p.valor as valpassagem, p.hembarque, sc.situacao
from passagem p
inner join clientes c on c.idcliente = p.idcliente
inner join viagem v on p.idviagem = v.idviagem
inner join agencia a on a.idagencia = p.idagencia
inner join rota r on r.idrota = v.idrota
inner join contas_receb_movi crm on crm.idpassagem = p.idpassagem
inner join situacao_caixa sc on sc.idsituacao = crm.idsituacao
left join contas_receber cr on cr.idmovimento = crm.idmovimento
where p.idpassagem = $idpassagem and p.status_passagem <> 4
order by p.poltrona");

// executa a query 
$dados_passagem = mysqli_query($con,$query_passagem) or die(mysql_error()); 

// transforma os dados em um array 
$linha_passagem = mysqli_fetch_assoc($dados_passagem); 

//@$total_passagem = mysqli_num_rows($linha_passagem);

//--------------------Seleciona a rota antes da passagem--------                 
$dados_rota = mysqli_query($con,"select v.idviagem, v.dataviagem, v.horaviagem, v.motorista1, v.motorista2, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
from viagem v
inner join rota r on r.idrota = v.idrota
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_rota = mysqli_fetch_assoc($dados_rota); 

// calcula quantos dados retornaram 
//@$total_rota = mysqli_num_rows($linha_rota);

?>

        <table border='0' align="center">
            <tr>
                <td><h4 align='center'>RESERVA DE PASSAGEM</h4></td>
            </tr>
        </table>

             <table border="1" align="center">
                <tr>
                <td><img src=../assets/images/logo2.png width="70" class="img-circle"></td>
                <td><b>ORIGEM: </b> <i> <?php echo $linha_rota['corigem'] ?> </i> <br> <b>DESTINO: </b> <i><?php echo $linha_rota['cdestino'] ?></i> <br> <b>DATA PARTIDA: </b> <i> <?php echo date('d/m/Y', strtotime($linha_rota['dataviagem'])); ?> - <?php echo $linha_rota['horaviagem'] ?> </i> </td>
                </tr>
             </table>
             <br>
<p style="text-align:justify; margin: 20px 20px 10px 20px; line-height: 1.3;">


                                        <table border="0">
                                            <thead>
                                                <tr>
                                                    <th>POLT.</th>          
                                                    <th>CLIENTE</th>
                                                    <th>DOC.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="50"><?php echo $linha_passagem['poltrona']?></td>
                                                    <td width="140"><?php echo $linha_passagem['primeironome']?> <?php echo $linha_passagem['segundonome']?></td>
                                                    <td width="120"><?php echo $linha_passagem['documento']?></td>
                                                </tr>
                                            </tbody>
                                        </table>

<br>

                                        <table border="0">
                                            <thead>
                                                <tr>
                                                    <th>EMBARQUE.</th>
                                                    <th>HORA EMBARQUE</th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                               <tr>
                                                    <td width="160"><?php echo $linha_passagem['embarque']?></td>
                                                    <?php if($linha_passagem['hembarque'] == null) { ?>
                                                    <td></td> <?php } 
                                                    else {?> 
                                                    <td><?php echo date('H:i', strtotime($linha_passagem['hembarque'])); ?></td>
                                                <?php } ?>
                                               </tr>
                                           </tbody>
                                        </table>

<br>
                                        <table border="0">
                                            <thead>
                                                <tr>
                                                    <th>DESEMBARQUE</th>
                                                    <th>VALOR</th>
                                                    <th>PAGAMENTO</th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                               <tr>
                                                    <td width="120"><?php echo $linha_passagem['desembarque']?></td>
                                                    <td width="100">R$ <?php echo $linha_passagem['valpassagem']?></td>
                                                    <td width="100"><?php echo $linha_passagem['situacao'] ?></td>
                                               </tr>
                                           </tbody>
                                        </table>

</p>

<p align="center"><h5>Favor chegar no mínimo com 10 minutos de antecedência no embarque!</h5></p>
<p align="center"> <u> Obs: Todo passageiro tem direito a 2 malas ou bolsas em baixo e 1 de mão em cima! </u></p>
<h5><?php echo " $data_extenso" ?></h5>

	