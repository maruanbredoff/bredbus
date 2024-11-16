<?php 
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$stylesheet =file_get_contents(K_PATH_MAIN.'/bootstrap.min.css');

$data_extenso = strftime('%d de %B de %Y %H:%i', strtotime('today'));
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

// Buscar dados do ônibus e a quantidade de poltronas
$sql = "
    SELECT b.idbus, b.lugares 
    FROM bus b 
    JOIN viagem v ON b.idbus = v.idbus 
    WHERE v.idviagem = $idviagem";
$result = mysqli_query($con, $sql);
$bus = mysqli_fetch_assoc($result);

// Buscar passagens para a viagem específica usando a consulta SQL fornecida
$sql = "
    SELECT 
        p.poltrona, 
        p.embarque, 
        p.desembarque, 
        v.idviagem, 
        v.dataviagem, 
        v.horaviagem, 
        substring_index(c.nome, ' ', 1) as primeironome, 
        substring_index(c.nome, ' ', -2) as segundonome, 
        c.sexo, 
        c.nascimento, 
        c.documento, 
        c.celular, 
        a.nome as agencia, 
        c.idcliente, 
        cr.valor, 
        p.hembarque, 
        c1.nome as corigem, 
        e1.uf as uforigem, 
        c2.nome as cdestino, 
        e2.uf as ufdestino, 
        fr.tipo, 
        c.mae, 
        cr.obs
    FROM passagem p
    INNER JOIN clientes c ON c.idcliente = p.idcliente
    INNER JOIN viagem v ON p.idviagem = v.idviagem
    INNER JOIN agencia a ON a.idagencia = p.idagencia
    INNER JOIN rota r ON r.idrota = v.idrota
    INNER JOIN contas_receb_movi crm ON crm.idpassagem = p.idpassagem
    INNER JOIN formapg fr ON fr.idformapg = crm.idformapg
    INNER JOIN cidades c1 ON c1.id = r.corigem
    INNER JOIN cidades c2 ON c2.id = r.cdestino
    INNER JOIN estados e1 ON e1.id = r.uforigem
    INNER JOIN estados e2 ON e2.id = r.ufdestino
    LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
    WHERE v.idviagem = $idviagem AND p.status_passagem <> 4
    ORDER BY p.poltrona";
$result = mysqli_query($con, $sql);

// Inicializar array para todas as poltronas
$poltronas = array_fill(1, $bus['lugares'], [
    'primeironome' => '', 
    'segundonome' => '', 
    'mae' => '', 
    'documento' => '', 
    'embarque' => '', 
    'desembarque' => '', 
    'celular' => '', 
    'valor' => '', 
    'tipo' => '', 
    'obs' => ''
]);

// Preencher o array com as passagens ocupadas
while ($row = mysqli_fetch_assoc($result)) {
    $poltronas[$row['poltrona']] = [
        'primeironome' => $row['primeironome'],
        'segundonome' => $row['segundonome'],
        'mae' => $row['mae'],
        'documento' => $row['documento'],
        'embarque' => $row['embarque'],
        'desembarque' => $row['desembarque'],
        'celular' => $row['celular'],
        'valor' => $row['valor'],
        'tipo' => $row['tipo'],
        'obs' => $row['obs']
    ];
}

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
@$total_rota = mysqli_num_rows($linha_rota);


//-------------------------------Total de Passagens -------------------------
$query_viagem = sprintf("select count(*) as qtdpassagem from viagem v, passagem p
where p.idviagem = v.idviagem
and v.idviagem = $idviagem
and p.status_passagem <> 4");

// executa a query 
$dados_viagem = mysqli_query($con,$query_viagem) or die(mysql_error()); 

// transforma os dados em um array 
$linha_viagem = mysqli_fetch_assoc($dados_viagem); 
?>

             <table border="1" align="center">
                <tr>
                <td rowspan="3"><img src=../assets/images/logo2.png width="80" class="img-circle"></td>
                    <td colspan="2"><b>ORIGEM: </b> <i> <?php echo $linha_rota['corigem'] ?> </i> - <b>DESTINO: </b> <i><?php echo $linha_rota['cdestino'] ?></i> - <b>DATA PARTIDA: </b> <i> <?php echo date('d/m/Y', strtotime($linha_rota['dataviagem'])); ?> - <?php echo $linha_rota['horaviagem'] ?> </i> </td>
                </tr>
                <tr>
                    <td><b>MOTORISTA: </b> <i> <?php echo $linha_rota['motorista1'] ?> </i></td>
                    <td><b>MOTORISTA: </b> <i> <?php echo $linha_rota['motorista2'] ?> </i></td>
                </tr>
             </table>
             <br><br>
<p style="text-align:justify; margin: 25px 25px 10px 25px; line-height: 1.3;">

        <table border='0' align="center">
            <tr>
                <td><h3 align='center'>MAPA DAS POLTRONAS</h3></td>
            </tr>
        </table>
        <table border='0' align="center">
            <tr>
                <td>
                    <h4 align='center'>Passagens Vendidas = <?php echo $linha_viagem['qtdpassagem'] ?></h4></td>
            </tr>
        </table>

    <table class="table table-bordered" border="1">
        <thead>
            <tr>
                <th align="center">POLT.</th>          
                <th align="center">CLIENTE</th>
                <th align="center">MAE</th>
                <th align="center">DOC.</th>
                <th align="center">EMBARQUE.</th>
                <th align="center">DESEMBARQUE</th>
                <th align="center">TELEFONE</th>
                <th align="center">VAL.PG</th>
                <th align="center">TIPO PG</th>
                <th align="center">OBS</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= $bus['lugares']; $i++): ?>
                <tr>
                    <td width="40" align="center"><?php echo $i; ?></td>
                    <td width="180"><?php echo htmlspecialchars($poltronas[$i]['primeironome'] . ' ' . $poltronas[$i]['segundonome']); ?></td>
                    <td width="130"><?php echo htmlspecialchars($poltronas[$i]['mae']); ?></td>
                    <td width="80"><?php echo htmlspecialchars($poltronas[$i]['documento']); ?></td>
                    <td width="90"><?php echo htmlspecialchars($poltronas[$i]['embarque']); ?></td>
                    <td width="110"><?php echo htmlspecialchars($poltronas[$i]['desembarque']); ?></td>
                    <td width="90"><?php echo htmlspecialchars($poltronas[$i]['celular']); ?></td>
                    <td><?php echo htmlspecialchars($poltronas[$i]['valor']); ?></td>
                    <td width="80"><?php echo htmlspecialchars($poltronas[$i]['tipo']); ?></td>
                    <td width="100"><?php echo htmlspecialchars($poltronas[$i]['obs']); ?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>

</p>

<br><br><br><br>
<h4><?php echo " $date" ?></h4>
<br>
<br>

    