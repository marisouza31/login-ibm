<?php
session_start();
ob_start();
include_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Importa o arquivo CSS do Bootstrap para estilização -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- Importa os arquivos JavaScript do Bootstrap para funcionalidades interativas -->
    <link rel="stylesheet" href="style.css">
    <!-- Importa um arquivo de estilo personalizado (style.css) -->
    <title>Cadastro</title>
    <!-- Define o título da página como "Cadastro" -->
</head>

<body>
    <?php
    //Exemplo criptografar a senha
    // echo password_hash(123456, PASSWORD_DEFAULT);

    ?>

    <div class="container-login">
        <!-- Container principal -->
        <!-- Caixa de imagem -->
        <div class="img-box">
            <img src="img/logo.jpeg">
        </div>
        <!-- Caixa de conteúdo -->
        <div class="content-box">
            <!-- Caixa de formulário -->
            <div class="form-box">
                <h2>Login</h2>

                <?php
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($dados['SendLogin'])) {
                    $senhaFormatada = md5($dados['senha']);
                    var_dump($senhaFormatada);
                    $query_clientes = "SELECT id, nome, email, senha
                        FROM clientes
                        WHERE email =:email &&
                        senha ='$senhaFormatada'";
                    $result_clientes = $conexao->prepare($query_clientes);
                    $result_clientes->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                    $result_clientes->execute();

                    if (($result_clientes) and ($result_clientes->rowCount() != 0)) {
                        $row_email = $result_clientes->fetch(PDO::FETCH_ASSOC);
                        //var_dump($row_usuario);

                        $_SESSION['id'] = $row_email['id'];
                        $_SESSION['nome'] = $row_email['nome'];
                        header("Location: dashboard.php");
                    } else {
                        $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Usuário ou senha inválida!</p>";
                    }
                }

                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>


                <form method="POST" action="">
                    <!-- Campo de entrada de email -->
                    <div class="input-box">
                        <span>Email</span>
                        <input type="text" name="email" placeholder="Digite o usuário" value="<?php if (isset($dados['email'])) {
                                                                                                    echo $dados['email'];
                                                                                                } ?>"><br><br>

                        <span>Senha</span>
                        <input type="password" name="senha" placeholder="Digite a senha" value="<?php if (isset($dados['senha'])) {
                                                                                                            echo $dados['senha'];
                                                                                                        } ?>"><br><br>
                        <!-- Opção de "Remember me" -->
                    </div>
                    <div class="remember">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                        <!-- Link "Esqueceu a Senha?" -->
                        <a href="#">Esqueceu a Senha?</a>
                    </div>
                    <div class="input-box">
                        <input type="submit" value="Entrar" name="SendLogin">
                    </div>
                </form>

</body>

</html>