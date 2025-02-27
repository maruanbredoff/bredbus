<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
     <script src="../assets/jquery-1.10.2.js"></script>
	<script type="text/javascript">	
		
		$(document).ready(function () {
		
			$.getJSON('estados_cidades.json', function (data) {

				var items = [];
				var options = '<option value="">escolha um estado</option>';	

				$.each(data, function (key, val) {
					options += '<option value="' + val.nome + '">' + val.nome + '</option>';
				});					
				$("#estados").html(options);				
				
				$("#estados").change(function () {				
				
					var options_cidades = '';
					var str = "";					
					
					$("#estados option:selected").each(function () {
						str += $(this).text();
					});
					
					$.each(data, function (key, val) {
						if(val.nome == str) {							
							$.each(val.cidades, function (key_city, val_city) {
								options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
							});							
						}
					});

					$("#cidades").html(options_cidades);
					
				}).change();		
			
			});
		
		});
		
	</script>		
</head>

<body>

<form>
		
		<!-- Estado -->
		<select id="estados">
			<option value=""></option>
		</select>
		<select id="cidades">
		</select>
	
</form>

</body>

</html>