<div class="container">
    <h2>Register</h2>
    <?php if (!empty($success)): ?>
        <p style="color: green; text-align: center;"><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="register.php" onsubmit="return validateForm()">
        <div style="margin-bottom: 15px;">
            <label for="username" style="display: block;">Username:</label>
            <input type="text" name="username" id="username" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block;">Password:</label>
            <input type="password" name="password" id="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block;">Email:</label>
            <input type="email" name="email" id="email" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="confirm_email" style="display: block;">Confirm Email:</label>
            <input type="email" name="confirm_email" id="confirm_email" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; width: 100%;">Register</button>
    </form>
    <p style="text-align: center; margin-top: 15px; font-size: 14px;">
        Already have an account? <a href="login.php" style="color: #4CAF50;">Login here</a>
    </p>
</div>

<script>
function validateForm() {
    var email = document.getElementById('email').value;
    var confirmEmail = document.getElementById('confirm_email').value;
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (email !== confirmEmail) {
        alert('Email addresses do not match.');
        return false;
    }

    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    return true;
}
</script>
