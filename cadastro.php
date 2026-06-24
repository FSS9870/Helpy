<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro</title>
</head>
<body>
    <div id="cadastro">
        <h1>Cadastro</h1>
        <form action="cadastro.php" method="POST">
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="text" name="nick" placeholder="Nome de usuário" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
        </form>
        <button onclick="window.location.href='login.php'">Já tenho conta</button>
        <button onclick="window.location.href='index.php'">Voltar</button>
    </div>
</body>
</html>

<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $nick = filter_input(INPUT_POST, 'nick', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if ($nome && $nick && $email && !empty($senha)) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, nick, senha, email) VALUES (:nome, :nick, :senha, :email)");
            $stmt->execute(['nome' => $nome, 'nick' => $nick, 'senha' => $hash, 'email' => $email]);
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_nick'] = $nick; 
            
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao cadastrar no banco: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos do formulário corretamente.');</script>";
    }
}
?>