<?php
session_start();

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($conteudo)) {
        
        $quem_postou = $_SESSION['user_nick'] ?? 'Anonimo'; 
        
        $topicos = "Geral";
        $horario = date('Y-m-d'); 

        try {

            $sql = "INSERT INTO posts (titulo, quem_postou, topicos, horario_postagem) 
                    VALUES (:titulo, :quem_postou, :topicos, :horario)";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':titulo', $conteudo);
            $stmt->bindParam(':quem_postou', $quem_postou);
            $stmt->bindParam(':topicos', $topicos);
            $stmt->bindParam(':horario', $horario);
            
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Erro ao salvar a postagem.";
            }

        } catch (PDOException $e) {
            echo "Erro no banco: " . $e->getMessage();
        }
    }
}
?>