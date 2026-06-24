<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    $conteudo = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $autor = $_SESSION['user_nick'] ?? 'Anonimo';

    if ($post_id && !empty($conteudo)) {
        try {
            $sql = "INSERT INTO comentarios (post_id, autor, conteudo) VALUES (:post_id, :autor, :conteudo)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'post_id'  => $post_id,
                'autor'    => $autor,
                'conteudo' => $conteudo
            ]);
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao comentar: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}

header("Location: index.php");
exit();