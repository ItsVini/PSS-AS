<div class="container">
    <h2><?php echo !empty($table) ? "Dodaj Nowy Rekord do: " . htmlspecialchars($table) : "Dodaj Nowy Rekord"; ?></h2>
    <form method="post" action="index.php?action=addRecord">
        <label for="table" style="font-size: 18px;">Wybierz Tabelę:</label>
        <select name="table" id="table" style="padding: 8px; font-size: 16px; margin-right: 10px;" onchange="this.form.submit()">
            <option value="Machines" <?php echo $table == 'Machines' ? 'selected' : ''; ?>>Machines</option>
            <option value="Operators" <?php echo $table == 'Operators' ? 'selected' : ''; ?>>Operators</option>
            <option value="Products" <?php echo $table == 'Products' ? 'selected' : ''; ?>>Products</option>
            <option value="ProductionOrders" <?php echo $table == 'ProductionOrders' ? 'selected' : ''; ?>>Production Orders</option>
            <option value="Operations" <?php echo $table == 'Operations' ? 'selected' : ''; ?>>Operations</option>
        </select>
    </form>

    <?php if (!empty($fields)): ?>
        <form method="post" action="index.php?action=saveRecord">
            <?php foreach ($fields as $field): ?>
                <div style="margin-bottom: 15px;">
                    <label for="<?php echo htmlspecialchars($field); ?>" style="display: block;"><?php echo htmlspecialchars($field); ?>:</label>
                    <input type="text" name="<?php echo htmlspecialchars($field); ?>" id="<?php echo htmlspecialchars($field); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>
            <?php endforeach; ?>
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Dodaj Rekord</button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="btn-back" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Powrót do Dashboardu</a>
</div>
