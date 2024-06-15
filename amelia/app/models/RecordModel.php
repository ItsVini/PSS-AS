<?php

class RecordModel {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getTables() {
        return ['Machines', 'Operators', 'Products', 'ProductionOrders', 'Operations'];
    }

    public function getColumns($table) {
        $stmt = $this->pdo->query("SHOW COLUMNS FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRecords($table) {
        $stmt = $this->pdo->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecord($table, $record) {
        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE " . key($record) . " = ?");
        $stmt->execute([current($record)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addRecord($table, $fields) {
        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO $table (" . implode(',', array_keys($fields)) . ") VALUES ($placeholders)");
        $stmt->execute(array_values($fields));
    }

    public function updateRecord($table, $record, $fields) {
        $setClause = [];
        foreach ($fields as $field => $value) {
            $setClause[] = "$field = ?";
        }
        $setClause = implode(', ', $setClause);
        $values = array_values($fields);
        $values[] = current($record);

        $stmt = $this->pdo->prepare("UPDATE $table SET $setClause WHERE " . key($record) . " = ?");
        $stmt->execute($values);
    }

    public function deleteRecord($table, $record) {
        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE " . key($record) . " = ?");
        $stmt->execute([current($record)]);
    }
}
?>
