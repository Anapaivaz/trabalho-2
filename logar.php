<?php
if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])){

    require 'conexao1.php';
    require 'Usuario.class.php';

    $u = new Usuario();

    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    if($u->login($email, $senha) == true){
        if(isset($_SESSION['IdUsuario'])){ 
            header("Location: estoque.php");
        }else{
            header("Location: login.php");
        }
    }else{
        header("Location: login.php");
    }
}
?>
