<!-- app/views/user/dashboard.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php?page=login");
    exit;
}

// Fetch user's requests
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$requests = $stmt->fetchAll();

// Fetch Notifications
$notifStmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$notifStmt->execute([$_SESSION['user_id']]);
$notifications = $notifStmt->fetchAll();

// Mark notifications as read once viewed here
if (!empty($notifications)) {
    $pdo->prepare("UPDATE notifications SET is_read = TRUE WHERE user_id = ?")->execute([$_SESSION['user_id']]);
}
?>

<?php if (!empty($notifications)): ?>
<div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 2rem; border-left: 4px solid #007bff;">
    <h3 style="margin-top: 0; margin-bottom: 1rem; color: #333;">Recent Notifications</h3>
    <ul style="list-style-type: none; padding-left: 0; margin-bottom: 0;">
        <?php foreach ($notifications as $n): ?>
            <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between;">
                <span style="<?php echo !$n['is_read'] ? 'font-weight: bold; color: #000;' : 'color: #555;'; ?>">
                    <?php echo htmlspecialchars($n['message']); ?>
                    <?php if (!$n['is_read']) echo ' <span style="background: red; color: white; padding: 2px 6px; border-radius: 10px; font-size: 0.75rem; margin-left: 5px;">New</span>'; ?>
                </span>
                <span style="color: #999; font-size: 0.85rem;"><?php echo date('M d, Y g:i A', strtotime($n['created_at'])); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>My Aid Requests</h2>
    <div>
        <a href="index.php?page=contact_admin" class="btn btn-secondary" style="margin-right: 10px; background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">Contact Admin</a>
        <a href="index.php?page=submit_request" class="btn btn-primary" style="background: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">New Request</a>
    </div>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] == 'request_submitted'): ?>
    <div class="alert alert-success" style="color: green; background: #d4edda; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
        Your aid request has been submitted successfully.
    </div>
<?php endif; ?>

<?php if (empty($requests)): ?>
    <p>You haven't submitted any requests yet.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Location</th>
                <th>Message</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $req): ?>
                <tr>
                    <td><?php echo date('M d, Y', strtotime($req['created_at'])); ?></td>
                    <td><?php echo htmlspecialchars($req['category']); ?></td>
                    <td><?php echo htmlspecialchars($req['city'] . ', ' . $req['country']); ?></td>
                    <td><?php echo htmlspecialchars(substr($req['message'], 0, 50)) . '...'; ?></td>
                    <td>
                        <span style="padding: 4px 8px; border-radius: 4px; background: 
                            <?php 
                                echo $req['status'] == 'pending' ? '#ffc107' : 
                                    ($req['status'] == 'approved' ? '#28a745' : '#dc3545'); 
                            ?>; color: white; font-size: 0.9em;">
                            <?php echo ucfirst($req['status']); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
