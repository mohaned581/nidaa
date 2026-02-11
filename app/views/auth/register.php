<!-- app/views/auth/register.php -->
<div class="form-container">
    <h2 style="text-align: center; margin-bottom: 2rem;">Create an Account</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="color: red; margin-bottom: 1rem; text-align: center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=register" method="POST">
        <input type="hidden" name="action" value="register">
        
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="role">I am a...</label>
            <select id="role" name="role" required>
                <option value="user">Individual (Seeking Aid)</option>
                <option value="donor">Donor (Want to Help)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        
        <p style="text-align: center; margin-top: 1rem;">
            Already have an account? <a href="index.php?page=login">Login here</a>
        </p>
    </form>
</div>
