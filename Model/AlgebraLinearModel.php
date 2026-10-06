<?php

namespace Model;

use PDO;
use PDOException;

class AlgebraLinearModel
{
    private ?PDO $db = null;

    private function getDb(): PDO
    {
        if ($this->db === null) {
            $this->db = Connection::getInstance();
        }

        return $this->db;
    }

    public function createSistema(array $matriz, array $termos, array $resultado): bool
    {
        try {
            $sql = "INSERT INTO SistemaLinear (matriz, termos, resultado)
                    VALUES (:matriz, :termos, :resultado)";

            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindValue(':matriz', json_encode($matriz, JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(':termos', json_encode($termos, JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(':resultado', json_encode($resultado, JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $error) {
            error_log('Erro ao salvar sistema: ' . $error->getMessage());
            return false;
        }
    }
}