<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div id="login">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <input type="text" name="nick" placeholder="Nome de usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            
            <button type="submit">Entrar</button>
            <button type="button" onclick="window.location.href='cadastro.php'">Criar conta</button>
            <button type="button" onclick="window.location.href='index.php'">Voltar</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = filter_input(INPUT_POST, 'nick', FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = $_POST['senha'];

    if (!empty($nick) && !empty($senha)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nick = :nick");
            $stmt->execute(['nick' => $nick]);
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['user_nick'] = $usuario['nick'];
                
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Usuário ou senha incorretos.');</script>";
            }
        } catch (PDOException $e) {
            echo "Erro no sistema: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Preencha todos os campos.');</script>";
    }
}
?>