<!-- app/views/admin/reports.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

// Get Overview counts
$total_donors = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'donor'")->fetchColumn();
$total_beneficiaries = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
$total_donations = $pdo->query("SELECT SUM(amount) FROM donations")->fetchColumn();
$donations_by_category = $pdo->query("SELECT category, SUM(amount) as total, COUNT(*) as count FROM donations GROUP BY category")->fetchAll();
$requests_by_status = $pdo->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status")->fetchAll();

?>

<div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h2>System Reports</h2>
    <a href="index.php?page=admin_dashboard" style="background: #6c757d; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;" class="hide-print">Back to Dashboard</a>
</div>

<style>
    @media print {
        .hide-print { display: none !important; }
        body { background: white; }
    }
</style>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <!-- Overview Metrics -->
    <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>User Demographics</h3>
        <p><strong>Total Donors:</strong> <?php echo $total_donors; ?></p>
        <p><strong>Total Beneficiaries:</strong> <?php echo $total_beneficiaries; ?></p>
    </div>

    <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Financial Overview</h3>
        <p><strong>Total Funds Raised:</strong> $<?php echo number_format($total_donations, 2); ?></p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Donations By Category -->
    <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Donations by Category</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <tr style="border-bottom: 1px solid #ccc; text-align: left;">
                <th style="padding: 0.5rem;">Category</th>
                <th style="padding: 0.5rem;">Count</th>
                <th style="padding: 0.5rem;">Total Amount</th>
            </tr>
            <?php foreach ($donations_by_category as $cat): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;"><?php echo htmlspecialchars($cat['category']); ?></td>
                <td style="padding: 0.5rem;"><?php echo $cat['count']; ?></td>
                <td style="padding: 0.5rem;">$<?php echo number_format($cat['total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Requests By Status -->
    <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Requests by Status</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <tr style="border-bottom: 1px solid #ccc; text-align: left;">
                <th style="padding: 0.5rem;">Status</th>
                <th style="padding: 0.5rem;">Count</th>
            </tr>
            <?php foreach ($requests_by_status as $req): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem; text-transform: capitalize;"><?php echo htmlspecialchars($req['status']); ?></td>
                <td style="padding: 0.5rem;"><?php echo $req['count']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div style="margin-top: 2rem; text-align: right;" class="hide-print">
    <button onclick="window.print()" class="btn btn-primary" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Print Report</button>
</div>
