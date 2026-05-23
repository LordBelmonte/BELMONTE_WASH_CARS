<?php

require_once __DIR__ . '/../../config/database.php';

class Agendamento {

    private $conn;
    private $table = 'agendamentos';

    public function __construct(){
        $database = new Database();
        $this->conn = $database->conectar();
    }

    private function obterColunaValorServico(){
        $query = "SHOW COLUMNS FROM servicos LIKE 'valor'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return 'valor';
        }

        return 'preco';
    }

    public function criar($dados){
        $query = "
            INSERT INTO {$this->table}
            (
                usuario_id,
                servico_id,
                data_agendamento,
                status_agendamento,
                observacoes
            )
            VALUES
            (
                :usuario_id,
                :servico_id,
                :data_agendamento,
                :status_agendamento,
                :observacoes
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $dados['usuario_id']);
        $stmt->bindParam(':servico_id', $dados['servico_id']);
        $stmt->bindParam(':data_agendamento', $dados['data_agendamento']);
        $stmt->bindValue(':status_agendamento', 'pendente');
        $stmt->bindParam(':observacoes', $dados['observacoes']);

        return $stmt->execute();
    }

    public function listarPorUsuario($usuarioId){
        $colunaValor = $this->obterColunaValorServico();

        $query = "
            SELECT
                a.*, 
                s.nome AS servico,
                s.descricao AS servico_descricao,
                s.{$colunaValor} AS servico_valor
            FROM agendamentos a
            INNER JOIN servicos s
                ON a.servico_id = s.id
            WHERE a.usuario_id = :usuario_id
            ORDER BY a.data_agendamento DESC, a.id DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos(){
        $colunaValor = $this->obterColunaValorServico();

        $query = "
            SELECT
                a.*,
                u.nome AS usuario,
                u.telefone AS telefone,
                s.nome AS servico,
                s.descricao AS servico_descricao,
                s.{$colunaValor} AS servico_valor
            FROM agendamentos a
            INNER JOIN usuarios u
                ON a.usuario_id = u.id
            INNER JOIN servicos s
                ON a.servico_id = s.id
            ORDER BY a.data_agendamento DESC, a.id DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pertenceAoUsuario($id, $usuarioId){
        $query = "
            SELECT 1
            FROM {$this->table}
            WHERE id = :id
              AND usuario_id = :usuario_id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function alterarStatus($id, $status){
        $allowedStatuses = [
            'pendente',
            'aprovado',
            'concluido',
            'cancelado'
        ];

        if(!in_array($status, $allowedStatuses, true)){
            return false;
        }

        $query = "
            UPDATE {$this->table}
            SET status_agendamento = :status_agendamento
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status_agendamento', $status);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function totalAgendamentos($usuarioId){
        return $this->totalPorUsuarioEStatus($usuarioId, null);
    }

    public function totalPendentes($usuarioId){
        return $this->totalPorUsuarioEStatus($usuarioId, 'pendente');
    }

    public function totalAprovados($usuarioId){
        return $this->totalPorUsuarioEStatus($usuarioId, 'aprovado');
    }

    public function totalConcluidos($usuarioId){
        return $this->totalPorUsuarioEStatus($usuarioId, 'concluido');
    }

    public function totalCancelados($usuarioId){
        return $this->totalPorUsuarioEStatus($usuarioId, 'cancelado');
    }

    public function totalAgendamentosTodos(){
        return $this->totalTodosPorStatus(null);
    }

    public function totalPendentesTodos(){
        return $this->totalTodosPorStatus('pendente');
    }

    public function totalAprovadosTodos(){
        return $this->totalTodosPorStatus('aprovado');
    }

    public function totalConcluidosTodos(){
        return $this->totalTodosPorStatus('concluido');
    }

    public function totalCanceladosTodos(){
        return $this->totalTodosPorStatus('cancelado');
    }

    private function totalPorUsuarioEStatus($usuarioId, $status){
        $query = "
            SELECT COUNT(*) as total
            FROM {$this->table}
            WHERE usuario_id = :usuario_id
        ";

        if($status !== null){
            $query .= "\n            AND status_agendamento = :status_agendamento";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId);

        if($status !== null){
            $stmt->bindParam(':status_agendamento', $status);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function totalTodosPorStatus($status){
        $query = "
            SELECT COUNT(*) as total
            FROM {$this->table}
        ";

        if($status !== null){
            $query .= "\n            WHERE status_agendamento = :status_agendamento";
        }

        $stmt = $this->conn->prepare($query);

        if($status !== null){
            $stmt->bindParam(':status_agendamento', $status);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}