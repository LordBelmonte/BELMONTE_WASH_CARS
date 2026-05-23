<?php

require_once __DIR__ . '/../../config/database.php';

class Usuario {

    private $conn;
    private $table = 'usuarios';

    public function __construct(){
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function cadastrar($dados){
        $query = "
            INSERT INTO {$this->table}
            (nome, email, telefone, senha, tipo_usuario)
            VALUES
            (:nome, :email, :telefone, :senha, :tipo_usuario)
        ";

        $stmt = $this->conn->prepare($query);

        $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);
        $tipoUsuario = $dados['tipo_usuario'] ?? 'cliente';

        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':tipo_usuario', $tipoUsuario);

        return $stmt->execute();
    }

    public function buscarPorEmail($email){
        $query = "
            SELECT *
            FROM {$this->table}
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id){
        $query = "
            SELECT *
            FROM {$this->table}
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $dados){
        $query = "
            UPDATE {$this->table}
            SET nome = :nome,
                telefone = :telefone
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function alterarSenha($id, $senha){
        $query = "
            UPDATE {$this->table}
            SET senha = :senha
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function validarSenha($id, $senha){
        $usuario = $this->buscarPorId($id);

        if(!$usuario){
            return false;
        }

        return password_verify($senha, $usuario['senha']);
    }

}