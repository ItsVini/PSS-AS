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
$rows = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedTable = $_POST['table'];
    $stmt = $pdo->query("SELECT * FROM $selectedTable");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($rows)) {
        $columns = array_keys($rows[0]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Widok tabel</title>
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
        select {
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
    <h2>Widok Tabel</h2>
    <form method="post" action="">
        <label for="table">Select Table:</label>
        <select name="table" id="table" required>
            <?php foreach ($tables as $table): ?>
                <option value="<?php echo $table; ?>" <?php if ($table === $selectedTable) echo 'selected'; ?>>
                    <?php echo $table; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">View</button>
    </form>

    <?php if (!empty($rows)): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th><?php echo htmlspecialchars($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo htmlspecialchars($cell); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No data found for the selected table.</p>
    <?php endif; ?>

    <p><a class="btn-back" href="index.php">Back to Dashboard</a></p>
</body>
</html>
