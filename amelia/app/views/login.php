<div class="container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <div style="margin-bottom: 15px;">
            <label for="username" style="display: block;">Username:</label>
            <input type="text" name="username" id="username" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block;">Password:</label>
            <input type="password" name="password" id="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Login</button>
    </form>
    <p style="text-align: center; margin-top: 15px; font-size: 14px;">
        Don't have an account? <a href="register.php" style="color: #4CAF50;">Register here</a>
    </p>
</div>
