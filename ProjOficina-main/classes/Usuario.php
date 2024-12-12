<?php
class Usuario
{
    private $conn;
    private $table_name = "usuarios";


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrar($nome, $tipo, $senha, $sexo, $dataNasc, $email, $endCidade,$endBairro, $endNum, $endComplemento, $celular, $cpf)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, tipo, senha, sexo, dataNasc, email, endCidade, endBairro, endNum, endComplemento, celular, cpf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $tipo, $hashed_password, $sexo, $dataNasc, $email, $endCidade,$endBairro, $endNum, $endComplemento, $celular, $cpf]);
    
        return $stmt;
    }
    
    public function login($nome, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nome = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
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
        if (!is_numeric($id)) {
            return false; // ID inválido
        }
    
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
    
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: false; // Retorna false se não encontrar
    }


    public function atualizar($id, $nome, $tipo, $sexo, $dataNasc, $celular, $email, $cpf, $endCidade, $endBairro, $endRua, $endNum, $endComplemento, $senha)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, tipo = ?, sexo = ?, dataNasc = ?, celular = ?, email = ?, cpf = ?, endCidade = ?, endBairro = ?, endRua = ?, endNum = ?, endComplemento = ?, senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $tipo, $sexo, $dataNasc, $celular, $email, $cpf, $endCidade, $endBairro, $endRua, $endNum, $endComplemento, $hashed_password, $id]);
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
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
public function pesquisarUsuarios($termo) {
    if (empty($termo)) {
        return []; // Se o termo estiver vazio, retorna um array vazio
    }

    $query = "SELECT * FROM usuarios WHERE nome LIKE :termo";
    $stmt = $this->conn->prepare($query);
    // Utiliza o bindValue para garantir que o valor seja corretamente escapado e evitamos SQL Injection
    $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>