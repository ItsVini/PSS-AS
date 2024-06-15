<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
    exit();
}

$tables = ['Machines', 'Operators', 'Products', 'ProductionOrders', 'Operations'];
$selectedTable = null;
$columns = [];
$records = [];
$selectedRecord = null;
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_table'])) {
        $selectedTable = $_POST['table'];
        $stmt = $pdo->query("SHOW COLUMNS FROM $selectedTable");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->query("SELECT * FROM $selectedTable");
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif (isset($_POST['select_record'])) {
        $selectedTable = $_POST['selectedTable'];
        $selectedRecord = $_POST['record'];
        $stmt = $pdo->query("SHOW COLUMNS FROM $selectedTable");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM $selectedTable WHERE " . key($selectedRecord) . " = ?");
        $stmt->execute([current($selectedRecord)]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif (isset($_POST['update_record'])) {
        $selectedTable = $_POST['selectedTable'];
        $record = $_POST['record'];
        $fields = $_POST['fields'];

        $setClause = [];
        foreach ($fields as $field => $value) {
            $setClause[] = "$field = ?";
        }
        $setClause = implode(', ', $setClause);
        $values = array_values($fields);
        $values[] = current($record);

        $stmt = $pdo->prepare("UPDATE $selectedTable SET $setClause WHERE " . key($record) . " = ?");
        $stmt->execute($values);
        $success = "Record updated successfully.";

        // Reload records
        $stmt = $pdo->query("SHOW COLUMNS FROM $selectedTable");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->query("SELECT * FROM $selectedTable");
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $selectedRecord = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        h2 {
            color: #4CAF50;
        }
        form {
            margin-bottom: 20px;
        }
        select, input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        button, .btn-edit {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        button:hover, .btn-edit:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .success {
            color: green;
            margin-top: 20px;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background-color: #45a049;
        }
        .btn-edit:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
    <script>
        function enableEditButton() {
            document.getElementById('edit-button').disabled = false;
        }
    </script>
</head>
<body>
    <h2>Update Record</h2>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="table">Select Table:</label>
        <select name="table" id="table" required>
            <?php foreach ($tables as $table): ?>
                <option value="<?php echo $table; ?>" <?php if ($table === $selectedTable) echo 'selected'; ?>>
                    <?php echo $table; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="submit_table">Select Table</button>
    </form>

    <?php if (!empty($columns) && !empty($records) && empty($selectedRecord)): ?>
        <form method="post" action="">
            <input type="hidden" name="selectedTable" value="<?php echo $selectedTable; ?>">
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <?php foreach ($columns as $column): ?>
                            <th><?php echo htmlspecialchars($column['Field']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $rec): ?>
                        <tr>
                            <td><input type="radio" name="record[<?php echo $columns[0]['Field']; ?>]" value="<?php echo $rec[$columns[0]['Field']]; ?>" onclick="enableEditButton()"></td>
                            <?php foreach ($columns as $column): ?>
                                <td><?php echo htmlspecialchars($rec[$column['Field']]); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="select_record" class="btn-edit" id="edit-button" disabled>Edit Selected Record</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($selectedRecord)): ?>
        <form method="post" action="">
            <input type="hidden" name="selectedTable" value="<?php echo $selectedTable; ?>">
            <input type="hidden" name="record[<?php echo $columns[0]['Field']; ?>]" value="<?php echo $record[$columns[0]['Field']]; ?>">
            <?php foreach ($columns as $column): ?>
                <?php if ($column['Field'] != $columns[0]['Field']): ?>
                    <label for="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?>:</label>
                    <input type="text" name="fields[<?php echo $column['Field']; ?>]" id="<?php echo $column['Field']; ?>" value="<?php echo htmlspecialchars($record[$column['Field']]); ?>" required>
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit" name="update_record">Update Record</button>
        </form>
    <?php endif; ?>

    <p><a class="btn-back" href="index.php">Back to Dashboard</a></p>
</body>
</html>
