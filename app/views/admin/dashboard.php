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

// Fetch Recent Requests (with Beneficiary Selection Filters)
$where = [];
$params = [];

if (!empty($_GET['filter_category'])) {
    $where[] = "o.category = ?";
    $params[] = $_GET['filter_category'];
}
if (!empty($_GET['filter_city'])) {
    $where[] = "o.city LIKE ?";
    $params[] = "%" . trim($_GET['filter_city']) . "%";
}
if (!empty($_GET['filter_status'])) {
    $where[] = "o.status = ?";
    $params[] = $_GET['filter_status'];
}

$whereClause = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

$stmt = $pdo->prepare("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id $whereClause ORDER BY o.created_at DESC LIMIT 50");
$stmt->execute($params);
$requests = $stmt->fetchAll();

// Fetch Recent Donations
$donations = $pdo->query("SELECT d.*, u.name as donor_name FROM donations d JOIN users u ON d.donor_id = u.id ORDER BY d.created_at DESC LIMIT 10")->fetchAll();

// Handle Status Update (if posted)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $order_id]);
    
    // Create Notification
    if (in_array($new_status, ['approved', 'rejected'])) {
        $userStmt = $pdo->prepare("SELECT user_id FROM orders WHERE id = ?");
        $userStmt->execute([$order_id]);
        $user = $userStmt->fetch();
        if ($user) {
            $msg = "Your aid request has been " . $new_status . ". Please check your dashboard for details.";
            $notifStmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $notifStmt->execute([$user['user_id'], $msg]);
        }
    }
    
    // Refresh
    header("Location: index.php?page=admin_dashboard");
    exit;
}
?>

<div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h2>Admin Dashboard</h2>
    <div>
        <a href="index.php?page=admin_posts" class="btn btn-primary" style="margin-right: 10px;">Manage Posts</a>
        <a href="index.php?page=admin_documents" class="btn btn-primary" style="margin-right: 10px;">Manage Documents</a>
        <a href="index.php?page=admin_reports" class="btn btn-primary">Reports</a>
    </div>
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
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3>Aid Requests (Select Beneficiaries)</h3>
        
        <!-- Filter Form -->
        <form method="GET" style="display: flex; gap: 10px;">
            <input type="hidden" name="page" value="admin_dashboard">
            <select name="filter_status" style="padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">All Statuses</option>
                <option value="pending" <?php echo isset($_GET['filter_status']) && $_GET['filter_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="approved" <?php echo isset($_GET['filter_status']) && $_GET['filter_status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                <option value="rejected" <?php echo isset($_GET['filter_status']) && $_GET['filter_status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
            </select>
            <input type="text" name="filter_category" placeholder="Category" value="<?php echo isset($_GET['filter_category']) ? htmlspecialchars($_GET['filter_category']) : ''; ?>" style="padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
            <input type="text" name="filter_city" placeholder="City" value="<?php echo isset($_GET['filter_city']) ? htmlspecialchars($_GET['filter_city']) : ''; ?>" style="padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            <a href="index.php?page=admin_dashboard" style="padding: 0.5rem 1rem; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Clear</a>
        </form>
    </div>
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
