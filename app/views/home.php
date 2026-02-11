<!-- app/views/home.php -->
<section class="hero" style="text-align: center; padding: 4rem 0;">
    <h1>Welcome to AidConnect</h1>
    <p style="font-size: 1.2rem; color: #666; max-width: 600px; margin: 1rem auto;">
        Connecting war-affected individuals with relief organizations and generous donors. 
        Together, we can make a difference.
    </p>
    
    <div style="margin-top: 2rem;">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="index.php?page=register" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">Get Started</a>
        <?php else: ?>
            <a href="index.php?page=<?php echo $_SESSION['role']; ?>_dashboard" class="btn btn-primary">Go to Dashboard</a>
        <?php endif; ?>
    </div>
</section>

<section class="features" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 4rem;">
    <div class="feature-card" style="text-align: center; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>For Individuals</h3>
        <p>Request aid easily and connect with organizations ready to help.</p>
    </div>
    <div class="feature-card" style="text-align: center; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>For Donors</h3>
        <p>Make secure donations and track the impact of your contributions.</p>
    </div>
    <div class="feature-card" style="text-align: center; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Transparency</h3>
        <p>Full monitoring and reporting to ensure help reaches those in need.</p>
    </div>
</section>
