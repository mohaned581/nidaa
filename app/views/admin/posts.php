<!-- app/views/admin/posts.php -->
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, description, content) VALUES (?, ?, ?)");
        if ($stmt->execute([$title, $description, $content])) {
            $success = "Post created successfully!";
        } else {
            $error = "Failed to create post.";
        }
    } else {
        $error = "Title and Content are required.";
    }
}

// Fetch existing posts
$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
?>

<div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h2>Manage Relief Posts</h2>
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
    <h3>Create New Post</h3>
    <form method="POST">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Title</label>
            <input type="text" name="title" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Short Description</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
        </div>
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Full Content</label>
            <textarea name="content" rows="6" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
        </div>
        <button type="submit" name="create_post" class="btn btn-primary" style="background: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Publish Post</button>
    </form>
</div>

<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <h3>Published Posts</h3>
    <?php if (empty($posts)): ?>
        <p>No posts published yet.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="border-bottom: 2px solid #eee; text-align: left;">
                    <th style="padding: 0.5rem;">Date</th>
                    <th style="padding: 0.5rem;">Title</th>
                    <th style="padding: 0.5rem;">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 0.5rem;"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                        <td style="padding: 0.5rem;"><strong><?php echo htmlspecialchars($post['title']); ?></strong></td>
                        <td style="padding: 0.5rem;"><?php echo htmlspecialchars($post['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
