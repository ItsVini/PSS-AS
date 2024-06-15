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
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedTable = $_POST['table'];
    if (isset($_POST['submit_table'])) {
        $stmt = $pdo->query("SHOW COLUMNS FROM $selectedTable");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif (isset($_POST['submit_record'])) {
        $selectedTable = $_POST['selectedTable'];
        $fields = $_POST['fields'];
        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $values = array_values($fields);
        $stmt = $pdo->prepare("INSERT INTO $selectedTable (" . implode(',', array_keys($fields)) . ") VALUES ($placeholders)");
        $stmt->execute($values);
        $success = "Record added successfully.";
        $columns = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Record</title>
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
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
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
    </style>
</head>
<body>
    <h2>Add New Record</h2>
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

    <?php if (!empty($columns)): ?>
        <form method="post" action="">
            <input type="hidden" name="selectedTable" value="<?php echo $selectedTable; ?>">
            <?php foreach ($columns as $column): ?>
                <?php if ($column['Field'] != 'id'): // assuming 'id' is auto-increment ?>
                    <label for="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?>:</label>
                    <input type="text" name="fields[<?php echo $column['Field']; ?>]" id="<?php echo $column['Field']; ?>" required>
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit" name="submit_record">Add Record</button>
        </form>
    <?php endif; ?>

    <p><a class="btn-back" href="index.php">Back to Dashboard</a></p>
</body>
</html>
