<div class="container">
    <h2><?php echo !empty($table) ? "Usuń Rekord z: " . htmlspecialchars($table) : "Usuń Rekord"; ?></h2>
    <form method="post" action="index.php?action=deleteRecord">
        <label for="table" style="font-size: 18px;">Wybierz Tabelę:</label>
        <select name="table" id="table" style="padding: 8px; font-size: 16px; margin-right: 10px;" onchange="this.form.submit()">
            <option value="Machines" <?php echo $table == 'Machines' ? 'selected' : ''; ?>>Machines</option>
            <option value="Operators" <?php echo $table == 'Operators' ? 'selected' : ''; ?>>Operators</option>
            <option value="Products" <?php echo $table == 'Products' ? 'selected' : ''; ?>>Products</option>
            <option value="ProductionOrders" <?php echo $table == 'ProductionOrders' ? 'selected' : ''; ?>>Production Orders</option>
            <option value="Operations" <?php echo $table == 'Operations' ? 'selected' : ''; ?>>Operations</option>
        </select>
    </form>

    <?php if (!empty($records)): ?>
        <form method="post" action="index.php?action=deleteRecord">
            <label for="record" style="font-size: 18px;">Wybierz Rekord:</label>
            <select name="record" id="record" style="padding: 8px; font-size: 16px; margin-right: 10px;">
                <?php foreach ($records as $record): ?>
                    <option value="<?php echo $record[$primaryKey]; ?>">
                        <?php echo $record[$primaryKey]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Usuń Rekord</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="error" style="color: red; margin-top: 20px;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <a href="index.php" class="btn-back" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Powrót do Dashboardu</a>
</div>
