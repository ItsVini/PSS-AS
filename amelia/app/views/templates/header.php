<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to the CSS file -->
</head>
<body class="<?php echo basename($_SERVER['PHP_SELF'], '.php'); ?>">
    <?php
    $currentFile = basename($_SERVER['PHP_SELF']);
    if (isset($_SESSION['user_id']) && $currentFile != 'login.php' && $currentFile != 'register.php'): ?>
        <div class="nav">
            <a href="index.php?action=addRecord"><i class="fas fa-plus-square"></i>Dodaj Nowy Rekord</a>
            <a href="index.php?action=viewTable"><i class="fas fa-table"></i>Wyświetl Tabelę</a>
            <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): // Admin ?>
                <a href="index.php?action=updateRecord"><i class="fas fa-edit"></i>Aktualizuj Rekord</a>
                <a href="index.php?action=deleteRecord"><i class="fas fa-trash-alt"></i>Usuń Rekord</a>
                <a href="index.php?action=manageRoles"><i class="fas fa-user-cog"></i>Zarządzaj Rolami</a>
            <?php endif; ?>
            <a class="btn-logout" href="logout.php"><i class="fas fa-sign-out-alt"></i>Wyloguj</a>
        </div>
        <!-- <div class="welcome-message">Witamy na Dashbordzie! Wybierz opcję z menu.</div> -->
    <?php endif; ?>
</body>
</html>
