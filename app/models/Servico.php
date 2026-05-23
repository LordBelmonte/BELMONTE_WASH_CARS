<?php

require_once __DIR__ . '/../../config/database.php';

class Servico {

    private $conn;
    private $table = 'servicos';

    public function __construct(){
        $database = new Database();
        $this->conn = $database->conectar();
    }

    private function obterColunaValor(){
        $query = "SHOW COLUMNS FROM {$this->table} LIKE 'valor'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return 'valor';
        }

        return 'preco';
    }

    public function listar(){
        $valorColuna = $this->obterColunaValor();

        $query = "
            SELECT id, nome, descricao, {$valorColuna} AS valor
            FROM {$this->table}
            ORDER BY nome
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id){
        $valorColuna = $this->obterColunaValor();

        $query = "
            SELECT id, nome, descricao, {$valorColuna} AS valor
            FROM {$this->table}
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}