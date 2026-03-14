<!-- app/views/programs.php -->
<?php
// Fetch existing posts
$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
?>

<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Relief Programs & Initiatives</h2>

    <?php if (empty($posts)): ?>
        <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #666; font-size: 1.1rem;">There are currently no active relief programs or posts available.</p>
            <p style="color: #666;">Please check back later.</p>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 2rem;">
            <?php foreach ($posts as $post): ?>
                <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <div style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">
                        Published: <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                    </div>
                    <h3 style="color: #007bff; margin-top: 0; margin-bottom: 1rem;"><?php echo htmlspecialchars($post['title']); ?></h3>
                    
                    <?php if (!empty($post['description'])): ?>
                        <p style="font-weight: 500; font-size: 1.1rem; margin-bottom: 1rem; color: #333;">
                            <?php echo nl2br(htmlspecialchars($post['description'])); ?>
                        </p>
                    <?php endif; ?>

                    <div style="color: #555; line-height: 1.6;">
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
