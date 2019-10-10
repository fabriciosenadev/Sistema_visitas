<?php
    require_once "db/connect.php";

    session_start();
    if(!$_SESSION['logado']){
        header("Location:index.php");
    }
    //==========================================================================
    //prepara a tela para o usuário
    $id_visitante = $_SESSION['id_usuario'];
    $verifica = "SELECT * FROM usuarios WHERE id = '$id_visitante'";
    $resultado = mysqli_query($conexao, $verifica);

    $dados_visitante = mysqli_fetch_assoc($resultado);    
        
    $id_visitado = $_SESSION['id_visitado'] = isset($_POST['idVisitado']) ? $_POST['idVisitado']: null;
    if(!$_SESSION['id_visitado']){
        header("Location: home.php");
    }else{
        $verifica = "SELECT nome visitado FROM usuarios WHERE id = $id_visitado";
        $resultado = mysqli_query($conexao, $verifica);
        $dados = mysqli_fetch_assoc($resultado);
        extract($dados);
    }

    //===========================================================================
    //salva comentários
    $btnEnviar = isset($_POST['btnEnviar']) ? $_POST['btnEnviar'] : null;
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : null;
    $sucesso = $erros = '';
    if($btnEnviar){
        if(empty($comentario)){
            $erros = 'COmentário deve estar preenchido para ser Registrado';
        }
        if(strlen($comentario) <= 10){
            $erros = 'Comentário deve ser maior que 10 caracteres';
        }
        if(!$erros){
            $salva = "INSERT INTO visitas(mensagem, visitante, visitado, data) 
            VALUES('$comentario',$id_visitante, $id_visitado, NOW())";
            // echo $salva;                
            if(mysqli_query($conexao, $salva)){
                $sucesso = 'Comentário foi registrado';
                $_SESSION['id_usuario'] = $id_visitante;
                $_SESSION['id_visitado'] = $id_visitado;
                $comentario = '';
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
    <div class='container'>
        <br>
        <div class='row justify-content-around'>
            <div>
                <a href="home.php" class='btn btn-primary'>Voltar</a>
            </div>
            <div>                
                <h3>Comentários sobre <?php echo $visitado;?></h3>
            </div>
            <div> 
                <a href="logout.php" class='btn btn-primary'>Deslogar</a>
            </div>
        </div>
        <hr>    
        
        <div class='row'>
            <div class='col-8'>
                <div class="mb-3">
                <h5>Comente algo sobre esta pessoa</h5>
                <form action="visita.php" method="post">
                    <div class='row'>
                        <div class='col-10'>
                            <textarea class="form-control" name='comentario' value='<?php echo $comentario;?>'></textarea>
                        </div>
                        <div class='col-2'>
                            <input type="submit" class='btn btn-primary' name='btnEnviar' value='Registrar'>
                            <input type="hidden" name="idVisitado" value='<?php echo $id_visitado;?>'>       
                        </div>
                    </div>                    
                </form>
                    <?php
                        if($erros){
                            echo "<p class='text-danger'>".$erros."</p>";
                        }
                        if($sucesso){
                            echo "<p class='text-success'>".$sucesso."</p>"; 
                            // sleep(3);
                            // header("Location: ");
                        }
                    ?>
                </div>
                <hr>
                <div class='row'>
                    <div class='col'>
                        <h4>Comentários Registrados</h4>
                        <br>
                        <?php
                            $verifica = "SELECT v.mensagem, v.visitante, v.visitado, v.`data`, u.nome visitante 
                                        FROM visitas v 
                                        LEFT JOIN usuarios u ON u.id = v.visitante
                                        WHERE v.visitado = $id_visitado";
                            $resultado = mysqli_query($conexao, $verifica);

                            if(mysqli_num_rows($resultado) > 0){  
                                while($dados = mysqli_fetch_assoc($resultado)){
                                    extract($dados);
                                ?>
                                <div class='row align-items-right'>
                                <strong>Comentário: </strong>        
                                <span class="border border-primary" style='padding:5px;border-radius:5px;'>
                                    <?php
                                        echo $mensagem;
                                    ?>
                                </span>
                                </div>
                                <div class='row justify-content-around'>
                                    <div>Escrito por: <?php echo $visitante?></div>
                                    <div>Em: <?php echo date('d-m-y', strtotime($data));?></div>
                                </div>
                                <hr>
                                <?php
                                }
                            }else{
                                ?>
                                <br>    
                                <h4 class='text-danger'>Nenhum comentário registrado até o momento.</h4>   
                                <?php
                            }
                        ?>
                    </div>
                </div>            
            </div>
            <div class='col-4'>
                <div class='row'>
                <div class='col-1'></div>
                <div class='col-sm'>                                
                <h5>Visite Alguém</h5> 
                <?php
                    $lista_usuarios = "SELECT id, nome FROM usuarios WHERE id != $id_visitante";        
            
                    $resultado = mysqli_query($conexao, $lista_usuarios);
                    // var_dump(mysqli_num_rows($resultado));
                    echo "<br>";
                    if(mysqli_num_rows($resultado) > 0){
                        while($dados = mysqli_fetch_assoc($resultado)){
                            extract($dados);                                                        
                            ?>
                            <form action="visita.php" method="post">
                                <button type="submit" class='btn btn-outline-primary' style='margin:-10px;'>
                                    <?php echo $nome ;?>
                                </button>
                                <input type="hidden" name="idVisitado" value='<?php echo $id;?>'>
                            </form>
                            <br>
                            <?php
                        }
                    }else{
                        echo "<h3>Não foram encontrados outros usuarios além do seu</h3>";
                    }
                    ?>
                </div>    
                </div>                            
            </div>
        </div>
    </div>    
    <!-- Arquivo do JQuery -->
    <script type='text/javascript' src="assets/js/jquery-3.3.1.min.js"></script>
    <!-- Arquivo do bootstrap 4.3.1-->
    <script type='text/javascript' src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>