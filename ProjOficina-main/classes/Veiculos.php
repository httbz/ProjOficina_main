<?php
class Veiculo
{
    private $conn;
    private $table_name = "veiculos";


    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar($fkCliente, $modelo, $marca, $ano, $placa)
    {
        $query = "INSERT INTO " . $this->table_name . " (fkCliente, modelo, marca, ano, placa) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$fkCliente, $modelo, $marca, $ano, $placa]);
        return $stmt;
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id,$fkCliente, $modelo, $marca, $ano, $placa)
    {
        $query = "UPDATE " . $this->table_name . " SET fkCliente = ?, modelo = ?, marca = ?, ano = ?, placa = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$fkCliente, $modelo, $marca, $ano, $placa, $id]);
        return $stmt;
    }


    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function listarTodos(){
        $sql = "SELECT * FROM veiculos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function pesquisarVeiculos($termo) {
        $query = "SELECT * FROM veiculos WHERE fkCliente OR placa LIKE :termo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':termo', '%' . $termo . '%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>