<?php
$nome_server = "localhost";
$nome_usuario = "root";
$senha = "";
$base_nome = "visitas";

$conexao = mysqli_connect($nome_server, $nome_usuario, $senha, $base_nome);

if(mysqli_connect_error()){
    echo "Falha na conexao: ".mysqli_connect_error();

    header("Location: erro.php");
}