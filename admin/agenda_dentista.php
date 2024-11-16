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
include "../config.php"; 
$iddentista = $_GET['iddentista'];
$query = sprintf("SELECT * from agenda where iddentista = $iddentista"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 
     
?>
		<script type='text/javascript'>
			$(document).ready(function(){
				$("input[name='title']").change(function(){
					var $valor = $("input[name='idcliente']");
					$.getJSON('retornaIdcliente.php',{ 
						idprocedimento: $( this ).val() 
					},function( json ){
						$valor.val( json.valor );
					});
				});
			});
		</script>
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
  dow: [ 1, 2, 3, 4, 5 ], // Monday - Thursday
  start: '08:00', // a start time (10am in this example)
  end: '18:00', // an end time (6pm in this example)
},
                    defaultView: 'agendaWeek',
					defaultDate: Date(),
                    weekends: false,
                    minTime: "07:00:00",
                    maxTime: "19:00:00",
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
						$('#visualizar #tipo').val(event.tipo);
						$('#visualizar #color').val(event.color);
						$('#visualizar').modal('show');
						return false;

					},
					
					selectable: false,
					selectHelper: false,
					events: [
						<?php
							while($linha=mysqli_fetch_array($dados)){
								?>
								{
								id: '<?php echo $linha['id']; ?>',
								title: '<?php echo $linha['title']; ?>',
								start: '<?php echo $linha['start']; ?>',
								end: '<?php echo $linha['end']; ?>',
								color: '<?php echo $linha['color']; ?>',
								tipo: '<?php echo $linha['tipo']; ?>',
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
<?php 
include "../rodape.php";
?>
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
