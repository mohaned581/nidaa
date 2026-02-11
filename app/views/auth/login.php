<!-- app/views/auth/login.php -->
<div class="form-container">
    <h2 style="text-align: center; margin-bottom: 2rem;">Login</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="color: red; margin-bottom: 1rem; text-align: center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
        <div class="alert alert-success" style="color: green; margin-bottom: 1rem; text-align: center;">
            Registration successful! Please login.
        </div>
    <?php endif; ?>

    <form action="index.php?page=login" method="POST">
        <input type="hidden" name="action" value="login">

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>

        <p style="text-align: center; margin-top: 1rem;">
            Don't have an account? <a href="index.php?page=register">Register here</a>
        </p>
    </form>
</div>
