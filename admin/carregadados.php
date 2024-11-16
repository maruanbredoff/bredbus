<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Select Dinâmico com AJAX + PHP + MySQL</title>
        <script src="js/jquery.js"></script>

        <link rel="stylesheet" href="css/bootstrap-select.min.css">
        <script src="js/bootstrap-select.min.js"></script>

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date2 = date('Y-m-d H:i');
//$datebr = date('d-m-Y H:i', strtotime('+1 months', strtotime(date('d-m-Y'))));
$datebr2 = date('d-m-Y H:i');
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
include "../config.php";
include "../verificanivel.php"; 
include "../funcoes.php"; 
?>
        <script>
            $(document).ready(function () {

                $('select').selectpicker();

                //$('#cidades').selectpicker();

                carrega_dados('estados');

                function carrega_dados(tipo, nome = ''){
                    $.ajax({
                        url: "carrega_dados.php",
                        method: "POST",
                        data: {tipo: tipo, nome: nome},
                        dataType: "json",
                        success: function (data)
                        {
                            var html = '';
                            for (var count = 0; count < data.length; count++){
                                html += '<option value="' + data[count].nome + '">' + data[count].nome + '</option>';
                            }
                            if (tipo == 'estados'){
                                $('#estados').html(html);
                                $('#estados').selectpicker('refresh');
                            } else {
                                $('#cidades').html(html);
                                $('#cidades').selectpicker('refresh');
                            }
                        }
                    })
                }

                $(document).on('change', '#estados', function () {
                    var nome = $('#estados').val();
                    carrega_dados('cidades', nome);
                });

            });
        </script>
    </head>
    <body>
<?php 


$query = sprintf("select * from rota"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);
// ----------------------- Usuario ----------------------------    
// executa a query 
$usuarios = mysqli_query($con,"SELECT nivel FROM usuario where id_usuario=$usuarioid") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhausuario = mysqli_fetch_assoc($usuarios);  
?>
        <br />
        <div class="container">
            <h1>WEB VÍDEO AULAS</h1>
            <h3>Select Dinâmico com AJAX + PHP + MySQL</h3>
            <br />
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>SELECIONE UM ESTADO:</label>
                        <select name="estados" id="estados" class="form-control input-lg" data-live-search="true" title="Selecione o Estado"></select>
                    </div>
                    <div class="form-group">
                        <label>SELECIONE UMA CIDADE:</label>
                        <select name="cidades" id="cidades" class="form-control input-lg" data-live-search="true" title="Selecione a Cidade"></select>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

