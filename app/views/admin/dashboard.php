<!-- app/views/admin/dashboard.php -->
<?php
// app/controllers/AdminController logic included here for simplicity or can be separated
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

// Stats
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_requests = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$total_donations_count = $pdo->query("SELECT COUNT(*) FROM donations")->fetchColumn();
$total_donations_amount = $pdo->query("SELECT SUM(amount) FROM donations")->fetchColumn();

// Fetch Recent Requests
$requests = $pdo->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 10")->fetchAll();

// Fetch Recent Donations
$donations = $pdo->query("SELECT d.*, u.name as donor_name FROM donations d JOIN users u ON d.donor_id = u.id ORDER BY d.created_at DESC LIMIT 10")->fetchAll();

// Handle Status Update (if posted)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $order_id]);
    // Refresh
    header("Location: index.php?page=admin_dashboard");
    exit;
}
?>

<div class="dashboard-header" style="margin-bottom: 2rem;">
    <h2>Admin Dashboard</h2>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <div class="stat-number"><?php echo $total_users; ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Requests</h3>
        <div class="stat-number"><?php echo $total_requests; ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Donations</h3>
        <div class="stat-number">$<?php echo number_format($total_donations_amount, 2); ?></div>
        <small><?php echo $total_donations_count; ?> contributions</small>
    </div>
</div>

<!-- Recent Requests -->
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <h3>Recent Aid Requests</h3>
    <?php if (empty($requests)): ?>
        <p>No requests found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $req): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($req['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($req['category']); ?></td>
                        <td><?php echo htmlspecialchars($req['city'] . ', ' . $req['country']); ?></td>
                        <td><?php echo htmlspecialchars(substr($req['message'], 0, 30)) . '...'; ?></td>
                        <td>
                            <span style="padding: 4px 8px; border-radius: 4px; background: 
                                <?php 
                                    echo $req['status'] == 'pending' ? '#ffc107' : 
                                        ($req['status'] == 'approved' ? '#28a745' : '#dc3545'); 
                                ?>; color: white; font-size: 0.9em;">
                                <?php echo ucfirst($req['status']); ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="update_status" value="1">
                                <input type="hidden" name="order_id" value="<?php echo $req['id']; ?>">
                                <select name="status" onchange="this.form.submit()" style="padding: 4px;">
                                    <option value="pending" <?php echo $req['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo $req['status'] == 'approved' ? 'selected' : ''; ?>>Approve</option>
                                    <option value="rejected" <?php echo $req['status'] == 'rejected' ? 'selected' : ''; ?>>Reject</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Recent Donations -->
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <h3>Recent Donations</h3>
    <?php if (empty($donations)): ?>
        <p>No donations found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Donor</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $d): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($d['donor_name']); ?></td>
                        <td>$<?php echo number_format($d['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($d['category']); ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($d['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
