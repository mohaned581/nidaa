<!-- app/views/admin/messages.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

// Fetch all messages sent to admin (receiver_id IS NULL)
$messages = $pdo->query("
    SELECT m.*, u.name as sender_name, u.email as sender_email 
    FROM messages m 
    JOIN users u ON m.sender_id = u.id 
    WHERE m.receiver_id IS NULL 
    ORDER BY m.created_at DESC
")->fetchAll();
?>

<div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h2>Inbox - User Inquiries</h2>
    <a href="index.php?page=admin_dashboard" style="background: #6c757d; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">Back to Dashboard</a>
</div>

<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <?php if (empty($messages)): ?>
        <p>No messages received yet.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($messages as $msg): ?>
                <div style="border: 1px solid #e9ecef; border-radius: 6px; padding: 1.5rem; background: #f8f9fa;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid #dee2e6; padding-bottom: 0.5rem;">
                        <div>
                            <strong style="font-size: 1.1rem; color: #007bff;"><?php echo htmlspecialchars($msg['subject']); ?></strong>
                            <div style="font-size: 0.9em; color: #6c757d; margin-top: 0.2rem;">
                                From: <?php echo htmlspecialchars($msg['sender_name']); ?> (<?php echo htmlspecialchars($msg['sender_email']); ?>)
                            </div>
                        </div>
                        <div style="font-size: 0.85rem; color: #868e96;">
                            <?php echo date('M d, Y h:i A', strtotime($msg['created_at'])); ?>
                        </div>
                    </div>
                    <div style="color: #333; line-height: 1.5;">
                        <?php echo nl2br(htmlspecialchars($msg['body'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
