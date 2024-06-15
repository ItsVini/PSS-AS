<?php

require_once realpath(__DIR__ . '/BaseController.php');
require_once realpath(__DIR__ . '/../models/RecordModel.php');

class RecordController extends BaseController {
    public function viewTable() {
        $table = $_POST['table'] ?? 'Machines';
        $stmt = $this->pdo->query("SELECT * FROM {$table}");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->render('view_table', compact('data', 'table'));
    }

    public function addRecord() {
        $table = $_POST['table'] ?? 'Machines';
        $fields = $this->getTableFields($table);
        $this->render('add_record', compact('fields', 'table'));
    }

    public function saveRecord() {
        $table = $_POST['table'];
        $fields = $this->getTableFields($table);

        $values = [];
        foreach ($fields as $field) {
            if ($field != 'id') { // assuming 'id' is auto-increment and should not be set manually
                $values[$field] = $_POST[$field];
            }
        }

        $columns = implode(", ", array_keys($values));
        $placeholders = implode(", ", array_fill(0, count($values), "?"));
        $stmt = $this->pdo->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($values));

        $this->render('add_record', ['success' => true, 'fields' => $fields, 'table' => $table]);
    }

    public function updateRecord() {
        $table = $_POST['table'] ?? 'Machines';
        $fields = $this->getTableFields($table);
        $primaryKey = $this->getPrimaryKey($table);

        $selectedRecord = null;
        if (isset($_POST['record'])) {
            $id = $_POST['record'];
            $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$primaryKey} = ?");
            $stmt->execute([$id]);
            $selectedRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $stmt = $this->pdo->query("SELECT {$primaryKey} FROM {$table}");
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('update_record', compact('fields', 'table', 'records', 'selectedRecord', 'primaryKey'));
    }

    public function saveUpdate() {
        $table = $_POST['table'];
        $id = $_POST['id'];
        $fields = $this->getTableFields($table);
        $primaryKey = $this->getPrimaryKey($table);

        $values = [];
        foreach ($fields as $field) {
            if ($field != 'id') { // assuming 'id' is auto-increment and should not be set manually
                $values[$field] = $_POST[$field];
            }
        }

        $setClause = implode(", ", array_map(fn($field) => "{$field} = ?", array_keys($values)));
        $stmt = $this->pdo->prepare("UPDATE {$table} SET {$setClause} WHERE {$primaryKey} = ?");
        $stmt->execute([...array_values($values), $id]);

        $this->render('update_record', ['success' => true, 'fields' => $fields, 'table' => $table]);
    }

    public function deleteRecord() {
        $table = $_POST['table'] ?? 'Machines';
        $primaryKey = $this->getPrimaryKey($table);

        if (isset($_POST['record'])) {
            $id = $_POST['record'];
            try {
                $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE {$primaryKey} = ?");
                $stmt->execute([$id]);
                $this->render('delete_record', ['success' => true, 'table' => $table]);
            } catch (PDOException $e) {
                $error = "Nie można usunąć rekordu. Powiązane dane w innych tabelach.";
                $stmt = $this->pdo->query("SELECT {$primaryKey} FROM {$table}");
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->render('delete_record', compact('table', 'records', 'primaryKey', 'error'));
            }
        } else {
            $stmt = $this->pdo->query("SELECT {$primaryKey} FROM {$table}");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->render('delete_record', compact('table', 'records', 'primaryKey'));
        }
    }

    private function getTableFields($table) {
        $stmt = $this->pdo->query("DESCRIBE {$table}");
        $fields = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $fields;
    }

    private function getPrimaryKey($table) {
        $stmt = $this->pdo->query("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");
        $primaryKey = $stmt->fetch(PDO::FETCH_ASSOC);
        return $primaryKey['Column_name'];
    }

    public function index() {
        $this->render('dashboard');
    }
}
?>
