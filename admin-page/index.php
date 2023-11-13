<?php
ini_set('default_charset', 'UTF-8');
include "conexao.php";

if(isset($_POST['email']) || isset($_POST['senha'])){

    if(strlen($_POST['email']) == 0){
        echo "Preencha seu email!";
    } elseif (strlen($_POST['senha']) == 0){
        echo "Preencha sua senha!";
    } else {
        $email = $db->real_escape_string($_POST['email']);
        $senha = $db->real_escape_string($_POST['senha']);

        $query = "SELECT * FROM login WHERE email = '$email' AND senha = '$senha'";
        $executa_query = $db->query($query) or die("Falha na execução do código SQL: " . $db->error);

        $quantidade = $executa_query->num_rows;

        if($quantidade == 1){
            $usuario = $executa_query->fetch_assoc();

            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['user'] = $usuario['usuario'];

            header("Location: dashboard.php");

        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="style.css">
  <title>HASH TECHIE OFFICIAL</title>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="index.php" method="post">
                    <h2>Login ADM</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name="email" class="tira_fundo" required>
                        <label for="">E-mail</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="senha" class="tira_fundo" required>
                        <label for="">Senha</label>
                    </div>
                    <button type="submit" name="envia_form">Entrar</button>
                </form>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>