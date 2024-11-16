<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d');
$datebr = date('d-m-Y H:i'); 
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

?>
<meta charset='utf-8' />
<link href='fullcalendar/css/fullcalendar.min.css' rel='stylesheet' />
<link href='fullcalendar/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<link href='fullcalendar/css/personalizado.css' rel='stylesheet' />
<script src='fullcalendar/js/jquery.min.js'></script>
<script src='fullcalendar/js/moment.min.js'></script>
<script src='fullcalendar/js/fullcalendar.min.js'></script>
<script src='fullcalendar/locale/pt-br.js'></script>
<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../config.php"; 
$idcontrato = $_SESSION['ContratoID'];


$sql = "SELECT * FROM agenda WHERE idcontrato = ?";
$stmt = $con->prepare($sql);
if (!$stmt) {
    // Mostra a mensagem de erro se a preparação da consulta falhar
    die("Erro ao preparar a consulta SQL: " . $con->error);
}
// Se a preparação for bem-sucedida, continue com o bind e execução
$stmt->bind_param("i", $idcontrato);
$stmt->execute();
$result = $stmt->get_result();

     
?>
<!-- Fim Completar nome cliente --> 
		<script>
			$(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay,listMonth'
					},
businessHours: {
  // days of week. an array of zero-based day of week integers (0=Sunday)
  dow: [ 0, 1, 2, 3, 4, 5, 6 ], // Monday - Thursday
  start: '08:00', // a start time (10am in this example)
  end: '22:00', // an end time (6pm in this example)
},
                    defaultView: 'agendaWeek',
					defaultDate: Date(),
                    weekends: false,
                    minTime: "08:00:00",
                    maxTime: "22:00:00",
					navLinks: true, // can click day/week names to navigate views
					editable: true,
                    allday: true,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event) {
						$('#visualizar #id').text(event.id);
						$('#visualizar #id').val(event.id);
						$('#visualizar #title').text(event.title);
						$('#visualizar #title').val(event.title);
						$('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #color').val(event.color);
						$('#visualizar').modal('show');
						return false;

					},
					
					selectable: true,
					selectHelper: true,
					select: function(start, end){
						$('#cadastrar #start').val(moment(start).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar #end').val(moment(end).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar').modal('show');						
					},
					events: [
						<?php
							while ($linha = $result->fetch_assoc()) {
								?>
								{
								id: '<?php echo $linha['id']; ?>',
								title: '<?php echo $linha['title']; ?>',
								start: '<?php echo $linha['start']; ?>',
								end: '<?php echo $linha['end']; ?>',
								color: '<?php echo $linha['color']; ?>',
								},<?php
							}
						?>
					]
				});
			});
			
			//Mascara para o campo data e hora
			function DataHora(evento, objeto){
				var keypress=(window.event)?event.keyCode:evento.which;
				campo = eval (objeto);
				if (campo.value == '00/00/0000 00:00:00'){
					campo.value=""
				}
			 
				caracteres = '0123456789';
				separacao1 = '/';
				separacao2 = ' ';
				separacao3 = ':';
				conjunto1 = 2;
				conjunto2 = 5;
				conjunto3 = 10;
				conjunto4 = 13;
				conjunto5 = 16;
				if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19)){
					if (campo.value.length == conjunto1 )
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto2)
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto3)
					campo.value = campo.value + separacao2;
					else if (campo.value.length == conjunto4)
					campo.value = campo.value + separacao3;
					else if (campo.value.length == conjunto5)
					campo.value = campo.value + separacao3;
				}else{
					event.returnValue = false;
				}
			}
		</script>

</head>
<body class="fix-header card-no-border mini-sidebar">
<?php 
ini_set('display_errors',0);
include_once "../verificanivel.php"; 

?>
        <div class="page-wrapper">
            
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
<?php
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
?>
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                            <div id="calendar"></div>
		<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                     <h4 class="modal-title text-center">Dados do Evento</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						
							<form class="form-horizontal" method="POST" action="agenda_cad_evento.php">
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Titulo</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="title" id="title" required>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Status</label>
									<div class="col-sm-10">
										<select name="color" class="form-control" id="color" required>
											<option value="">Status</option>			
											<option style="color:#FFD700;" value="#FFD700">Cancelado</option>
											<option style="color:#0071c5;" value="#0071c5">Agendado</option>
											<option style="color:#BB9999;" value="#BB9999">Finalizado</option>									<option style="color:#228B22;" value="#228B22">Confirmada</option>
											<option style="color:#F90000;" value="#F90000">Faltou</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Data Inicial</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Data Final</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
									</div>
								</div>
								<input type="hidden" class="form-control" name="id" id="id">
                                <input type="hidden" class="form-control" id="resp_agenda" name="resp_agenda" value="<?php echo $_SESSION['UsuarioNome']?>">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
										<button type="submit" class="btn btn-warning">Salvar Alterações</button>
									</div>
								</div>
							</form>
					
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                     <h4 class="modal-title text-center">Dados do Evento</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="visualizar">
							<dl class="dl-horizontal">
								<dt>Titulo</dt>
								<dd id="title"></dd>
								<dd id="tipo"></dd>
								<dt>Data Inicio</dt>
								<dd id="start"></dd>
								<dt>Data do fim</dt>
								<dd id="end"></dd>
							</dl>
							<button class="btn btn-canc-vis btn-warning">Editar</button>
						</div>
						<div class="form">
							<form class="form-horizontal" method="POST" action="agenda_edit_evento.php">
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Titulo</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="title" id="title">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Status</label>
									<div class="col-sm-10">
										<select name="color" class="form-control" id="color">
											<option value="">Status</option>			
											<option style="color:#FFD700;" value="#FFD700">Cancelado</option>
											<option style="color:#0071c5;" value="#0071c5">Agendado</option>
											<option style="color:#BB9999;" value="#BB9999">Finalizado</option>									<option style="color:#228B22;" value="#228B22">Confirmada</option>
											<option style="color:#F90000;" value="#F90000">Faltou</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Data Inicial</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="control-label">Data Final</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
									</div>
								</div>
								<input type="hidden" class="form-control" name="id" id="id">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
										<button type="submit" class="btn btn-warning">Salvar Alterações</button>
									</div>
								</div>
							</form>
							
						
						</div>
					</div>
				</div>
			</div>
		</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
		<script>
			$('.btn-canc-vis').on("click", function() {
				$('.form').slideToggle();
				$('.visualizar').slideToggle();
			});
			$('.btn-canc-edit').on("click", function() {
				$('.visualizar').slideToggle();
				$('.form').slideToggle();
			});
		</script>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2017 Admin Press Admin by themedesigner.in
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>

</body>
<!--<script type="text/javascript">
$(document).ready(function() {
// Captura o retorno do retornaCliente.php
    $.getJSON('completar.php', function(data){
    var dados = [];
    // Armazena na array capturando somente o nome do EC
    $(data).each(function(key, value) {
        dados.push(value.nome);
    });
    // Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
    $('#title').autocomplete({ 
                source: function (request, response) {
                    var results = $.ui.autocomplete.filter(dados, request.term);
                    response(results.slice(0, 10));
                },
                minLength: 3,
                appendTo: "#cadastrar"
            });
    });
});
</script>-->
</html>
