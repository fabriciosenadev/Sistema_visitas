<?php
    require_once "db/connect.php";

    session_start();
    if(!$_SESSION['logado']){
        header("Location:index.php");
    }

    $id = $_SESSION['id_usuario'];
    $verifica = "SELECT * FROM usuarios WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $verifica);

    $dados = mysqli_fetch_assoc($resultado);    
    extract($dados);
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
                <h3>Olá <?php echo $nome;?></h3>
            </div>
            <div> 
                <a href="logout.php" class='btn btn-primary'>Deslogar</a>
            </div>
        </div>
        <hr>    
        
        <div class='row'>
            <div class='col-8'>
            <div class='row'>
                    <div class='col'>
                        <h4>Comentários sobre mim</h4>
                        <br>
                        <?php
                            $verifica = "SELECT v.mensagem, v.visitante, v.visitado, v.`data`, u.nome visitante 
                                        FROM visitas v 
                                        LEFT JOIN usuarios u ON u.id = v.visitante
                                        WHERE v.visitado = $id";
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
                    $lista_usuarios = "SELECT id, nome FROM usuarios WHERE id != $id";        
            
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
    

    <br>
    <div>
    </div>


    <!-- Arquivo do JQuery -->
    <script type='text/javascript' src="assets/js/jquery-3.3.1.min.js"></script>
    <!-- Arquivo do bootstrap 4.3.1-->
    <script type='text/javascript' src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>