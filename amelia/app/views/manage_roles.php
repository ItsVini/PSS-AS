<div class="container">
    <h2>Zarządzaj rolami użytkowników</h2>
    <?php if (!empty($users) && !empty($roles)): ?>
        <form method="post" action="index.php?action=updateRole">
            <table class="role-table">
                <thead>
                    <tr>
                        <th>ID Użytkownika</th>
                        <th>Nazwa Użytkownika</th>
                        <th>Rola</th>
                        <th>Nowa Rola</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <select name="role_id" class="role-select">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo htmlspecialchars($role['role_id']); ?>" <?php echo $user['role'] == $role['role_name'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($role['role_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                <button type="submit" class="btn-update-role">Aktualizuj Rolę</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php else: ?>
        <p>Brak użytkowników lub ról do wyświetlenia.</p>
    <?php endif; ?>

    <a href="index.php" class="btn-back">Powrót do Dashboardu</a>
</div>
