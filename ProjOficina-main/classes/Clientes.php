<?php
class Cliente
{
    private $conn;
    private $table_name = "clientes";


    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar( $nome, $sexo, $celular, $email, $dataNasc, $cpf, $endCidade, $endBairro, $endNum, $endComplemento, $endRua )    {
        $query = "INSERT INTO " . $this->table_name . " (nome, sexo, celular, email, dataNasc, cpf, endCidade, endBairro, endNum, endComplemento, endRua) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $sexo, $celular, $email, $dataNasc, $cpf, $endCidade, $endBairro, $endNum, $endComplemento, $endRua]);
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


    public function atualizar($id, $nome, $sexo, $dataNasc, $celular, $email, $cpf, $endCidade, $endBairro, $endComplemento, $endRua, $endNum)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, dataNasc = ?, celular = ?, email = ?, cpf = ?, endCidade = ?, endBairro = ?, endComplemento = ?, endRUa = ?, endNum = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id, $nome, $sexo, $dataNasc, $celular, $email, $cpf, $endCidade, $endBairro, $endComplemento, $endRua, $endNum]);
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
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>