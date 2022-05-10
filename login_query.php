<?php
session_start(); 
include "./connecta_db.php";

if (isset($_SESSION['user_id'])) {
    header('Location: ./home');
}

if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $records = $db->prepare('SELECT iduser, username, mail, passHash FROM users WHERE ((username = :username  OR mail = :mail) AND active = 1)');
    $records->bindParam(':username', $_POST['login']);
    $records->bindParam(':mail', $_POST['login']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC); // asd - 123 (si existe email con el principio sale error) //login con alexeg13@gmail.com deja en blanco query // sql injection deja blanco query
    $total = $records->rowCount();

    if (($total > 0) && password_verify($_POST['password'], $results['passHash'])) {
      $_SESSION['user_id'] = $results['iduser'];
      $_SESSION['username'] = $results['username'];
      $update = $db->prepare('UPDATE users SET lastSignIn = now() WHERE username = :username or mail = :mail');
      $update->bindParam(':username', $_POST['login']);
      $update->bindParam(':mail', $_POST['login']);
      $update->execute();
      header("Location: ./home");
    } else {
        echo "<script>
        alert('No es possible fer login amb les dades facilitades');
        window.location.href='./index';
    </script>";
    }
  }

?>