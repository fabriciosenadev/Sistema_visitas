<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <!-- determina a largunra do site -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS do Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">    
    <title>sistema de visitas</title>
</head>
<body>
    
    <div class='container col-sm-6'>
        <br>
        <div class='row justify-content-center'>        
        <h3>Bem vindo ao sistema</h3>
        </div>
        <hr>        
        <div class='col-sm'>
            <p>
                Se voce está acessando o sistema pela primeira vez, siga as instruções abaixo.
            </p>
            
            <p>
                Acesse o diretorio: <strong>visitas/bd</strong> e execute o script 
                <a href="db/visitas.sql">visitas.sql</a> 
            </p>
            <p>
                Após execução do script, será necessário acessar novamente o diretorio 
                <strong>visitas/db</strong> e alterar o conteúdo das variáveis: <br>
                <strong>$nome_server</strong> de "localhost" para o nome ou IP do seu servidor de banco de dados. <br>
                <strong>$nome_usuario</strong> de "root" para o usuário do seu banco de dados. <br>
                <strong>$senha</strong> de "" para a senha do usuário informado anteriormente.
            </p>
            <p>
                <h4><strong class='text-danger'>ATENÇAO !</strong></h4> 
                <strong>Não altere o nome do banco de dados!</strong> <br>
                Isto ocasionará o não funcionamento do sistema.
            </p>
        </div>        
    </div>
    <!-- Arquivo do JQuery -->
    <script type='text/javascript' src="assets/js/jquery-3.3.1.min.js"></script>
    <!-- Arquivo do bootstrap 4.3.1-->
    <script type='text/javascript' src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>