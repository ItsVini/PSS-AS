<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderNumber = $_POST['orderNumber'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $orderDate = $_POST['orderDate'];
    $dueDate = $_POST['dueDate'];

    $stmt = $pdo->prepare('INSERT INTO ProductionOrders (OrderNumber, ProductID, Quantity, OrderDate, DueDate) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$orderNumber, $productID, $quantity, $orderDate, $dueDate]);

    $success = "Order created successfully.";
}

$products = $pdo->query('SELECT * FROM Products')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Production Order</title>
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
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: auto;
        }
        label, input, select {
            margin: 10px 0;
        }
        input, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
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
    <h2>Create Production Order</h2>
    <?php if (isset($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="orderNumber">Order Number:</label>
        <input type="text" name="orderNumber" id="orderNumber" required>
        
        <label for="productID">Product:</label>
        <select name="productID" id="productID" required>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo htmlspecialchars($product['ProductID']); ?>">
                    <?php echo htmlspecialchars($product['ProductName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required>
        
        <label for="orderDate">Order Date:</label>
        <input type="date" name="orderDate" id="orderDate" required>
        
        <label for="dueDate">Due Date:</label>
        <input type="date" name="dueDate" id="dueDate" required>
        
        <button type="submit">Create Order</button>
    </form>
    <p><a class="btn-back" href="index.php">Back to Dashboard</a></p>
</body>
</html>
