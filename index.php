<?php
    require_once "db/connect.php";

    session_start();    
    $btn_conectar = isset($_POST['btnConectar']) ? $_POST['btnConectar'] : null;
    $login = isset($_POST['email']) ? $_POST['email'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;
    $erros = [];

    if($btn_conectar){
        
        if(empty($login) or empty($senha)){
            $erros[] = "<li class='text-danger'>O campo e-mail/senha precisa ser preenchido</li>";
        }else{
            $verificar = "SELECT id FROM usuarios WHERE login = '$login' and senha = '$senha'";
            $resultado = mysqli_query($conexao, $verificar);
            
            if(mysqli_num_rows($resultado) > 0){
                $verificar = "SELECT * FROM usuarios WHERE login = '$login' and senha = '$senha'";
                $resultado = mysqli_query($conexao, $verificar);
                if(mysqli_num_rows($resultado) == 1){
                    $dados = mysqli_fetch_array($resultado);
                    mysqli_close($conexao);
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $dados['id'];
                    header("Location: home.php");
                }
            }else{
                $erros[] = "<li class='text-danger'>Usuario inexistente</li>";
            }
        }
    }    
?>

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
        <div class='row justify-content-between'>
            <div>
                <h3>Painel de Login</h3>
            </div>
            <div>
                <a href="cadastro/" class='btn btn-primary'>Cadastrar</a>
            </div>
        </div>
        <?php
            if($btn_conectar and $erros){
                foreach($erros as $erro){
                    echo $erro;
                }
            }
        ?>
        <hr>        
        <div class='col-sm'>
            <form method='post' action='<?php $_SERVER['PHP_SELF'];?>'>
                <div class="form-group row">
                    <label for="inputLogin" class="col-sm-3 col-form-label">E-mail</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="inputLogin" name='email'>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputSenha" class="col-sm-3 col-form-label">Senha</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="inputSenha" name='senha'>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary"name='btnConectar' value='Entrar'>
                            Entrar
                        </button>
                    </div>
                </div>
            </form>        
        </div>        
    </div>
    <!-- Arquivo do JQuery -->
    <script type='text/javascript' src="assets/js/jquery-3.3.1.min.js"></script>
    <!-- Arquivo do bootstrap 4.3.1-->
    <script type='text/javascript' src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>