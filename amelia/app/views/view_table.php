<div class="container">
    <h2><?php echo !empty($table) ? htmlspecialchars($table) : "Wyświetl Tabelę"; ?></h2>
    <form method="post" action="index.php?action=viewTable">
        <label for="table" style="font-size: 18px;">Wybierz tabelę:</label>
        <select name="table" id="table" style="padding: 8px; font-size: 16px; margin-right: 10px;">
            <option value="Machines" <?php echo $table == 'Machines' ? 'selected' : ''; ?>>Machines</option>
            <option value="Operators" <?php echo $table == 'Operators' ? 'selected' : ''; ?>>Operators</option>
            <option value="Products" <?php echo $table == 'Products' ? 'selected' : ''; ?>>Products</option>
            <option value="ProductionOrders" <?php echo $table == 'ProductionOrders' ? 'selected' : ''; ?>>Production Orders</option>
            <option value="Operations" <?php echo $table == 'Operations' ? 'selected' : ''; ?>>Operations</option>
        </select>
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Wyświetl</button>
    </form>

    <?php if (!empty($data)): ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <?php foreach (array_keys($data[0]) as $column): ?>
                        <th style="background-color: #4CAF50; color: white; padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($cell); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="btn-back" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Powrót do Dashboardu</a>
</div>
