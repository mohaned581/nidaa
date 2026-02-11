<!-- app/views/donor/donate.php -->
<?php require_once APP_ROOT . '/controllers/DonationController.php'; ?>

<div class="form-container">
    <h2 style="text-align: center; margin-bottom: 2rem;">Make a Donation</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="color: red; margin-bottom: 1rem; text-align: center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=donate" method="POST">
        
        <div class="form-group">
            <label for="category">I want to support:</label>
            <select id="category" name="category" required>
                <option value="General">General Relief Fund</option>
                <option value="Food">Food / Water Security</option>
                <option value="Health">Medical Supplies</option>
                <option value="Shelter">Shelter & Housing</option>
                <option value="Children">Child Welfare</option>
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Donation Amount ($)</label>
            <input type="number" id="amount" name="amount" min="1" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="message">Message of Hope (Optional)</label>
            <textarea id="message" name="message" rows="3" placeholder="Leave a message for the recipients..."></textarea>
        </div>

        <hr style="margin: 20px 0;">
        <h4>Payment Details (Mock)</h4>
        
        <div class="form-group">
            <label>Card Number</label>
            <input type="text" placeholder="**** **** **** 1234" disabled style="background-color: #e9ecef;">
        </div>
        
        <div style="display: flex; gap: 1rem;">
             <div class="form-group" style="flex: 1;">
                <label>Expiry</label>
                <input type="text" placeholder="MM/YY" disabled style="background-color: #e9ecef;">
            </div>
             <div class="form-group" style="flex: 1;">
                <label>CVV</label>
                <input type="text" placeholder="123" disabled style="background-color: #e9ecef;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Process Donation</button>
        <a href="index.php?page=donor_dashboard" class="btn btn-secondary" style="width: 100%; margin-top: 10px; text-align: center; display: block; box-sizing: border-box;">Cancel</a>

    </form>
</div>
