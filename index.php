<?php
session_start();
require_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Helpy</title>
</head>
<body>
    <div id="titulo">
        <h1>Helpy</h1>
        <strong>O lugar para buscar ajuda ou achar gente para bater papo</strong>
        
        <?php if (isset($_SESSION['user_nick'])): ?>
            <p>Olá, <strong><?= htmlspecialchars($_SESSION['user_nick']) ?></strong>! <a href="logout.php" style="color: red;">Sair</a></p>
        <?php else: ?>
            <div onclick="window.location.href='cadastro.php'" class="botao" style="display: inline-block; cursor: pointer; margin-right: 10px;">Cadastrar</div>
            <div onclick="window.location.href='login.php'" class="botao" style="display: inline-block; cursor: pointer;">Login</div>
        <?php endif; ?>
    </div>

    <div id="centro">
        <?php
        try {
            // Busca todos os posts do mais recente para o mais antigo
            $stmt = $pdo->query("SELECT * FROM posts ORDER BY ID_postagem DESC");
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                echo "<div class='card-post' style='border: 1px solid #ccc; margin: 15px; padding: 10px;'>";
                echo "<h3>" . htmlspecialchars($post['titulo']) . "</h3>";
                echo "<p>Por: <strong>" . htmlspecialchars($post['quem_postou']) . "</strong> em " . htmlspecialchars($post['horario_postagem']) . "</p>";
                
                echo "<div class='secao-comentarios' style='margin-left: 20px; background: #f9f9f9; padding: 5px;'>";
                echo "<h4>Comentários:</h4>";

                $stmt_coment = $pdo->prepare("SELECT * FROM comentarios WHERE post_id = :post_id ORDER BY id ASC");
                $stmt_coment->execute(['post_id' => $post['ID_postagem']]);
                $comentarios = $stmt_coment->fetchAll();

                if (count($comentarios) > 0) {
                    foreach ($comentarios as $coment) {
                        echo "<p style='margin: 5px 0;'><strong>" . htmlspecialchars($coment['autor']) . ":</strong> " . htmlspecialchars($coment['conteudo']) . "</p>";
                    }
                } else {
                    echo "<p style='color: gray; font-size: 0.9em;'>Nenhum comentário ainda. Seja o primeiro!</p>";
                }

                echo "<form action='comentar.php' method='POST' style='margin-top: 10px;'>";
                echo "<input type='hidden' name='post_id' value='" . $post['ID_postagem'] . "'>";
                echo "<input type='text' name='comentario' placeholder='Escreva um comentário...' required style='width: 70%; padding: 5px;'>";
                echo "<button type='submit' style='padding: 5px 10px; margin-left: 5px;'>Comentar</button>";
                echo "</form>";

                echo "</div>"; 
                echo "</div>"; 
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao carregar posts: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div id="post" style="margin: 15px;">
        <form action="postar.php" method="POST">
            <textarea name="conteudo" placeholder="O que você precisa..." required style="width: 100%; height: 60px; display: block; margin-bottom: 5px;"></textarea>
            <button type="submit" style="padding: 5px 15px;">Postar</button>
        </form>
    </div>
</body>
</html>