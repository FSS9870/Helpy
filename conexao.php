<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "helpy-banco";
$charset = 'utf8mb4';

try {
    // 1. Conecta ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Define o caminho do arquivo SQL (ex: pasta 'db' no projeto)
    $caminhoArquivo = __DIR__ . '/db/banco.sql';

    // 3. Verifica se o arquivo realmente existe
    if (!file_exists($caminhoArquivo)) {
        die("Erro: O arquivo SQL não foi encontrado no caminho: " . $caminhoArquivo);
    }

    // 4. Lê todo o conteúdo do arquivo SQL
    $sql = file_get_contents($caminhoArquivo);

    // 5. Executa as instruções SQL no banco
    $pdo->exec($sql);

    echo "Arquivo SQL importado com sucesso!";

} catch (PDOException $e) {
    die("Erro na conexão ou execução: " . $e->getMessage());
}