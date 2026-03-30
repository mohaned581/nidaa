<!-- app/views/user/request_aid.php -->
<?php require_once APP_ROOT . '/controllers/RequestController.php'; ?>

<div class="form-container">
    <h2 style="text-align: center; margin-bottom: 2rem;">Request Aid</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="color: red; margin-bottom: 1rem; text-align: center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=submit_request" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="category">Type of Aid Needed</label>
            <select id="category" name="category" required>
                <option value="Food">Food / Water</option>
                <option value="Health">Medical / Health</option>
                <option value="Shelter">Shelter / Housing</option>
                <option value="Children">Children / Baby Supplies</option>
                <option value="Financial">Financial Support</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="age">Age of Applicant</label>
            <input type="number" id="age" name="age" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number (Optional)</label>
            <input type="text" id="phone" name="phone">
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" id="country" name="country" required>
        </div>

        <div class="form-group">
            <label for="city">City / Location</label>
            <input type="text" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label for="message">Detailed Situation / Message</label>
            <textarea id="message" name="message" rows="5" required placeholder="Please describe your situation and what you specifically need..."></textarea>
        </div>

        <div class="form-group">
            <label for="document">Supporting Document (Optional)</label>
            <input type="file" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Request</button>
        <a href="index.php?page=user_dashboard" class="btn btn-secondary" style="width: 100%; margin-top: 10px; text-align: center; display: block; box-sizing: border-box;">Cancel</a>
    </form>
</div>
