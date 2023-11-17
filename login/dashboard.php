<?php
session_start();
ob_start();
include_once 'conexao.php';

if((!isset($_SESSION['id'])) AND (!isset($_SESSION['nome']))){
    $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Necessário realizar o login para acessar a página!</p>";
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="" href="" type="">
    <title>Login</title>
</head>

<body>
    <h1>Bem vindo <?php echo $_SESSION['nome']; ?>!</h1>

    <a href="sair.php">Sair</a>

</body>

</html>