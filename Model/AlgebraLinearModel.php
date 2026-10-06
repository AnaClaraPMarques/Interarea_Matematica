<?php

namespace Model;

use PDO;
use PDOException;

class SistemaLinear
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    
    public function createSistema(array $matriz, array $termos, array $resultado): bool
{
    try {
        $sql = "INSERT INTO SistemaLinear (matriz, termos, resultado)
                VALUES (:matriz, :termos, :resultado)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":matriz", json_encode($matriz), PDO::PARAM_STR);
        $stmt->bindValue(":termos", json_encode($termos), PDO::PARAM_STR);
        $stmt->bindValue(":resultado", json_encode($resultado), PDO::PARAM_STR);

        return $stmt->execute();
    } catch (PDOException $error) {
        error_log("Erro ao salvar sistema: " . $error->getMessage());
        return false;
    }
}

}