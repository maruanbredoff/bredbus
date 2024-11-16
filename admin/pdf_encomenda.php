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
$idviagem = $_GET['idviagem'];                   
$dados2 = mysqli_query($con,"select ve.idencomenda, ve.idviagem, ve.etiqueta, ve.descricao, ve.remetente, ve.destinatario,ve.descricao, ve.localhorigem, ve.localdestino, ve.telremetente, ve.teldestinatario, ve.valor, ve.idsituacao, ve.obs, ve.docremetente, ve.docdestinatario, sc.situacao, ce.valorpg, ce.id as idmovimento, ve.tipo, ve.qtd, ve.valdeclarado
from viagem_encomenda ve
inner join viagem v on v.idviagem = ve.idviagem
inner join situacao_caixa sc on sc.idsituacao = ve.idsituacao
left join contas_encomendas ce on ce.idencomenda = ve.idencomenda
where v.idviagem = $idviagem and sc.idsituacao <> 3
order by ve.idencomenda") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha2 = mysqli_fetch_assoc($dados2); 

// calcula quantos dados retornaram 
$total2 = mysqli_num_rows($dados2);

@$idpassagem = $linha2['idpassagem'];


//Soma o valor total das encomendas
$dados_soma = mysqli_query($con,"select SUM(ve.valor) as totalencomenda, SUM(ve.qtd) as totalvolume
from viagem_encomenda ve
inner join viagem v on v.idviagem = ve.idviagem
inner join situacao_caixa sc on sc.idsituacao = ve.idsituacao
left join contas_encomendas ce on ce.idencomenda = ve.idencomenda
where v.idviagem = $idviagem and sc.idsituacao <> 3
order by ve.idencomenda") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_soma = mysqli_fetch_assoc($dados_soma); 

// calcula quantos dados retornaram 
$total_soma = mysqli_num_rows($dados_soma);

//--------------------Seleciona a rota antes da passagem--------                 
$dados_rota = mysqli_query($con,"select v.idviagem, v.dataviagem, v.horaviagem, r.corigem, r.cdestino, v.motorista1, v.motorista2, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
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
@$total_rota = mysqli_num_rows($linha_rota);
?>

             <table border="1" align="center">
                <tr>
                <td rowspan="3"><img src=../assets/images/logo2.png width="80" class="img-circle"></td>
                    <td colspan="2"><b>ORIGEM: </b> <i> <?php echo $linha_rota['corigem'] ?> </i> - <?php echo $linha_rota['uforigem'] ?> <b>DESTINO: </b> <i><?php echo $linha_rota['cdestino'] ?></i> - <?php echo $linha_rota['ufdestino'] ?> <b>DATA PARTIDA: </b> <i> <?php echo date('d/m/Y', strtotime($linha_rota['dataviagem'])); ?> - <?php echo $linha_rota['horaviagem'] ?> </i> </td>
                </tr>
                <tr>
                    <td><b>MOTORISTA: </b> <i> <?php echo $linha_rota['motorista1'] ?> </i></td>
                    <td><b>MOTORISTA: </b> <i> <?php echo $linha_rota['motorista2'] ?> </i></td>
                </tr>
             </table>
             <br>

<p style="text-align:justify; margin: 10px 10px 10px 3px; line-height: 1.3;">

        <table border='0' align="center">
            <tr>
                <td><h3 align='center'>LISTA DE ENCOMENDAS</h3></td>
            </tr>
</table>

                                        <table align="center" border="1">
                                            <thead>
                                                <tr>       
                                                    <th align="center">REMETENTE</th>
                                                    <th align="center">TELEFONE</th>
                                                    <th align="center">DESTINATARIO</th>
                                                    <th align="center">TIPO</th>
                                                    <th align="center">VOL</th>
                                                    <th align="center">ORIGEM</th>
                                                    <th align="center">DESTINO</th>
                                                    <th align="center">VALOR</th>
                                                    <th align="center">PG?</th>
                                                    <th align="center">COD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 

                                                do { 
                                                $qtdlinha = 1;
                                                $valor = $linha2['valor'];
                                                $valor_formatadoo = number_format($valor,2, ',', '.');
                                                $valorliquido = $linha2['valor'] -$linha2['valorpg'];
                                                $valor_liq_formatado = number_format($valorliquido,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td width="120" align="center"><?php echo strtoupper($linha2['remetente']); ?>
                                                    </td>
                                                    <td width="80" align="center"><?php echo strtoupper($linha2['telremetente']); ?>
                                                    </td>
                                                    <td width="120" align="center"><?php echo strtoupper($linha2['destinatario']); ?>
                                                    </td>
                                                    <td width="70" align="center"><?php echo strtoupper($linha2['tipo']);?></td>
                                                    <td width="30" align="center"><?php echo strtoupper($linha2['qtd']);?></td>
                                                    <td width="50" align="center"><?php echo strtoupper($linha2['localhorigem']);?></td>
                                                    <td width="50" align="center"><?php echo strtoupper($linha2['localdestino']);?></td>
                                                    <td width="60" align="center"><?php echo strtoupper($valor_formatadoo); ?></td>
                                                    <?php if($valorliquido>0) {?>
                                                    <td width="20" align="center">NÃO</td>
                                                    <?php } else { ?>
                                                    <td width="20" align="center">SIM</td> <?php } ?>
                                                    <td width="40" align="center"><?php echo strtoupper($linha2['etiqueta']);?></td>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha2 = mysqli_fetch_assoc($dados2)); 
                                                    // fim do if 

                                            ?> 
                                            </tbody>
                                        </table>
                                        <br>
                                        <table border="0" width="200" align="right">
                                                <tr>
                                                    <th>QTD VOLUMES:</th> 
                                                    <td width="50"><?php echo $linha_soma['totalvolume']?></td>   
                                                    <th>VALOR TOTAL:</th> 
                                                    <td width="50"><?php echo $linha_soma['totalencomenda']?></td>    
                                                </tr>
                                        </table>
</p>

<br><br><br><br>
<h4><?php echo " $data_extenso" ?></h4>
<br>
<br>

	