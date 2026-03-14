<!-- app/views/user/contact.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $subject = trim($_POST['subject']);
    $body = trim($_POST['body']);
    $sender_id = $_SESSION['user_id'];
    
    // receiver_id is NULL for general admin inbox

    if (!empty($subject) && !empty($body)) {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, subject, body) VALUES (?, ?, ?)");
        if ($stmt->execute([$sender_id, $subject, $body])) {
            $success = "Your message has been sent to the administration.";
        } else {
            $error = "Failed to send message.";
        }
    } else {
        $error = "Subject and Message body are required.";
    }
}
?>

<div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h2>Contact Administration</h2>
    <a href="index.php?page=user_dashboard" class="btn btn-secondary" style="background: #6c757d; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">Back to Dashboard</a>
</div>

<?php if (isset($success)): ?>
    <div style="color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
        <?php echo $success; ?>
    </div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div style="color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <p style="margin-bottom: 1.5rem; color: #555;">Use this form to send inquiries, feedback, or follow-up questions regarding your aid requests directly to the NIDAA Organization administrators.</p>
    
    <form method="POST">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Subject</label>
            <input type="text" name="subject" required style="width: 100%; padding: 0.75rem; border: 1px solid #ced4da; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Message</label>
            <textarea name="body" rows="6" required style="width: 100%; padding: 0.75rem; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
        </div>
        <button type="submit" name="send_message" class="btn btn-primary" style="background: #007bff; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; cursor: pointer; font-size: 1rem;">Send Message</button>
    </form>
</div>
