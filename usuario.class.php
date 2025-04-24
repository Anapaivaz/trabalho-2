<?php
class Usuario {
    public function login($email, $senha) {
        // Conectar ao banco de dados
        require 'conexao1.php';

        // Consultar o banco de dados para verificar o email e a senha
        $senhaMD5 = md5($senha); // Converte a senha para MD5
        $query = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        
        // Preparar a consulta
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaMD5);
        $stmt->execute();
        
        // Verificar se existe um usuário com esse email e senha
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            // Iniciar a sessão e armazenar as informações do usuário
            $_SESSION['IdUsuario'] = $usuario['IdUsuario'];
            return true;
        } else {
            return false;
        }
    }
}
?>
