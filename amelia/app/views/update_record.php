<div class="container">
    <h2><?php echo !empty($table) ? "Aktualizuj Rekord w tabeli: " . htmlspecialchars($table) : "Aktualizuj Rekord"; ?></h2>
    <form method="post" action="index.php?action=updateRecord">
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
        <form method="post" action="index.php?action=updateRecord">
            <label for="record" style="font-size: 18px;">Wybierz Rekord:</label>
            <select name="record" id="record" style="padding: 8px; font-size: 16px; margin-right: 10px;" onchange="this.form.submit()">
                <?php foreach ($records as $record): ?>
                    <option value="<?php echo $record[$primaryKey]; ?>" <?php echo isset($selectedRecord) && $selectedRecord[$primaryKey] == $record[$primaryKey] ? 'selected' : ''; ?>>
                        <?php echo $record[$primaryKey]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
        </form>
    <?php endif; ?>

    <?php if (!empty($selectedRecord)): ?>
        <form method="post" action="index.php?action=saveUpdate">
            <?php foreach ($fields as $field): ?>
                <div style="margin-bottom: 15px;">
                    <label for="<?php echo htmlspecialchars($field); ?>" style="display: block;"><?php echo htmlspecialchars($field); ?>:</label>
                    <input type="text" name="<?php echo htmlspecialchars($field); ?>" id="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($selectedRecord[$field]); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>
            <?php endforeach; ?>
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($selectedRecord[$primaryKey]); ?>">
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Zapisz Zmiany</button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="btn-back" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Powrót do Dashboardu</a>
</div>
