<?php
require_once "./connecta_db.php";

$nombre = $_POST['username'];
$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pass = $_POST['password'];
$pass2 = $_POST['vpassword'];
if($pass===$pass2){ #Si las passwords son iguales
    $sqlUsuariMail = "SELECT * FROM users WHERE username='$nombre'  or mail='$email' ";
    $validarUsuari = $db->query($sqlUsuariMail);

    if($validarUsuari->rowCount()>0){ #Si hay algun registro, signifia que ya esta en uso el nombre o mail
        echo "<script>
             alert('El nombre de usuario o correo electronico ya existe');
             window.location.href='./register';
            </script>";
    }else{

        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $consulta = $db->prepare("INSERT INTO users (username,mail,userFirstName,userLastName,passHash,creationDate,active) VALUES (:username,:email,:fname,:lname,:password,NOW(),'1')");
        $consulta->bindParam(':username',$nombre);
        $consulta->bindParam(':email',$email);
        $consulta->bindParam(':fname',$fname);
        $consulta->bindParam(':lname',$lname);
        $consulta->bindParam(':password',$pass);

        if($consulta->execute()){
            echo "<script>
                alert('Usuario registrado correctamente');
                window.location.href='./index';
            </script>";
        }
    }
}else{
    echo "<script>
        alert('Las contraseñas no coinciden');
        window.location.href='./register';
    </script>";
}
?>