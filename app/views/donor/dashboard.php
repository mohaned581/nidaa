<!-- app/views/donor/dashboard.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: index.php?page=login");
    exit;
}

// Fetch donor's donations
$stmt = $pdo->prepare("SELECT * FROM donations WHERE donor_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$donations = $stmt->fetchAll();

// Calculate total
$total = 0;
foreach ($donations as $d) {
    $total += $d['amount'];
}
?>

<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>My Giving Impact</h2>
    <a href="index.php?page=donate" class="btn btn-primary">Make New Donation</a>
</div>

<div class="stat-card" style="max-width: 300px; margin-bottom: 2rem; background: #e3f2fd;">
    <h3>Total Donated</h3>
    <div class="stat-number">$<?php echo number_format($total, 2); ?></div>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] == 'donation_made'): ?>
    <div class="alert alert-success" style="color: green; background: #d4edda; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
        Thank you! Your donation was successful.
    </div>
<?php endif; ?>

<h3>Donation History</h3>
<?php if (empty($donations)): ?>
    <p>You haven't made any donations yet.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donations as $d): ?>
                <tr>
                    <td><?php echo date('M d, Y', strtotime($d['created_at'])); ?></td>
                    <td><?php echo htmlspecialchars($d['category']); ?></td>
                    <td>$<?php echo number_format($d['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($d['message'] ?: '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
