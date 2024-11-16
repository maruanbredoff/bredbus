<!DOCTYPE html>
<html>
    <head>
        <title>Consulta de CEP - por rafaelWendel.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="../assets/plugins/jquery/jquery.min.js"></script>
        <script type='text/javascript' src='cep.js'></script>
 
    </head>
    <body>
        <form id="form1" class="form1" method="post">
            <label>CEP (Somente números):</label><br />
            <input type="text" name="cep" id="cep" maxlength="8" />
 
            <br /><br />
 
            <label>Rua:</label><br />
            <input type="text" name="endereco" id="endereco" size="45" />
 
            <br /><br />
 
            <label>Número:</label><br />
            <input type="text" name="numero" id="numero" size="5" />
 
            <br /><br />
 
            <label>Bairro:</label><br />
            <input type="text" name="bairro" id="bairro" size="25" />
 
            <br /><br />
 
            <label>Cidade:</label><br />
            <input type="text" name="cidade" id="cidade" size="25" />
 
            <br /><br />
 
            <label>Estado:</label><br />
            <input type="text" name="estado" id="estado" size="2" />
 
            <br /><br />
 
            <input type="submit" value="Salvar Dados" />
 
        </form>
    </body>
</html>