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
?>

<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>My Aid Requests</h2>
    <a href="index.php?page=submit_request" class="btn btn-primary">New Request</a>
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
