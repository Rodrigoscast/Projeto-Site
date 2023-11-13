<?php
ini_set('default_charset', 'UTF-8');
include "guardiao2.php";
include "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && isset($_POST["novo_nome"])) {
    $id = $_POST["id"];
    $novoNome = $_POST["novo_nome"];
    
    // Prepare e execute a atualização no banco de dados
    $query = "UPDATE filtros SET nome_filtro = ? WHERE id_filtro = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "si", $novoNome, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // A atualização foi bem-sucedida
        echo "Sucesso";
    } else {
        // Houve um erro na atualização
        echo "Erro: " . mysqli_error($db);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"]) && isset($_POST["action"])) {
        $id = $_POST["id"];
        $action = $_POST["action"];

        if ($action === "excluir") {
            // Prepare e execute a exclusão no banco de dados
            $query = "DELETE FROM filtros WHERE id_filtro = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                // A exclusão foi bem-sucedida
                echo "Sucesso";
            } else {
                // Houve um erro na exclusão
                echo "Erro: " . mysqli_error($db);
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>
