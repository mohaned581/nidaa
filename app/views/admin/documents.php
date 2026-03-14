<!-- app/views/admin/documents.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

$upload_dir = __DIR__ . '/../../../public/uploads/';
// Create folder if not exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $title = $_POST['title'];
    $uploader_id = $_SESSION['user_id'];
    
    $file = $_FILES['document'];
    $filename = time() . '_' . basename($file['name']);
    $target_path = $upload_dir . $filename;
    
    // Relative path for storing in DB
    $db_path = 'uploads/' . $filename;

    if (!empty($title) && $file['error'] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            $stmt = $pdo->prepare("INSERT INTO documents (uploader_id, title, file_path) VALUES (?, ?, ?)");
            if ($stmt->execute([$uploader_id, $title, $db_path])) {
                $success = "Document uploaded successfully!";
            } else {
                $error = "Failed to save document record to database.";
            }
        } else {
            $error = "Failed to move uploaded file.";
        }
    } else {
        $error = "Title and File are required.";
    }
}

// Fetch existing documents
$documents = $pdo->query("
    SELECT d.*, u.name as uploader_name 
    FROM documents d 
    JOIN users u ON d.uploader_id = u.id 
    ORDER BY d.uploaded_at DESC
")->fetchAll();
?>

<div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h2>Manage Documents</h2>
    <a href="index.php?page=admin_dashboard" style="background: #6c757d; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">Back to Dashboard</a>
</div>

<?php if (isset($success)): ?>
    <div style="color: green; background: #d4edda; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
        <?php echo $success; ?>
    </div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div style="color: red; background: #f8d7da; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <h3>Upload New Document</h3>
    <form method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Document Title</label>
            <input type="text" name="title" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Select File (PDF, DOCX, etc.)</label>
            <input type="file" name="document" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <button type="submit" class="btn btn-primary" style="background: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Upload Document</button>
    </form>
</div>

<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <h3>Uploaded Documents</h3>
    <?php if (empty($documents)): ?>
        <p>No documents uploaded yet.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="border-bottom: 2px solid #eee; text-align: left;">
                    <th style="padding: 0.5rem;">Date</th>
                    <th style="padding: 0.5rem;">Title</th>
                    <th style="padding: 0.5rem;">Uploader</th>
                    <th style="padding: 0.5rem;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $doc): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 0.5rem;"><?php echo date('M d, Y', strtotime($doc['uploaded_at'])); ?></td>
                        <td style="padding: 0.5rem;"><strong><?php echo htmlspecialchars($doc['title']); ?></strong></td>
                        <td style="padding: 0.5rem;"><?php echo htmlspecialchars($doc['uploader_name']); ?></td>
                        <td style="padding: 0.5rem;">
                            <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" style="color: #007bff; text-decoration: none;">View / Download</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
