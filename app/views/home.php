<style>
/* Base Styles for Blogs & Articles Section */
.blogs-section {
    padding: 5rem 0;
    text-align: center;
    background-color: #fcfcfc;
    margin-top: 4rem;
}

.blogs-section h2 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.blogs-section p.subtitle {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 3rem;
}

.blogs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2.5rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.blog-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: left;
    display: flex;
    flex-direction: column;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.blog-card-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-card-img {
    transform: scale(1.05);
}

.blog-card-img-wrapper {
    overflow: hidden;
}

.blog-card-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.blog-card-category {
    font-size: 0.85rem;
    color: #007bff;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: inline-block;
}

.blog-card-title {
    font-size: 1.35rem;
    color: #222;
    margin-bottom: 1rem;
    line-height: 1.4;
    font-weight: 700;
}

.blog-card-excerpt {
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex-grow: 1;
}

.blog-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.btn-read-more {
    color: #007bff;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    transition: color 0.2s ease;
}

.btn-read-more:hover {
    color: #0056b3;
}

.btn-read-more i {
    margin-left: 5px;
    transition: transform 0.2s ease;
}

.btn-read-more:hover i {
    transform: translateX(4px);
}

/* Beautiful Hero Section Styles */
.hero {
    position: relative;
    text-align: center;
    padding: 8rem 1rem;
    background: url('assets/images/blue_bg.png') center/cover no-repeat;
    color: white;
    margin-bottom: 2rem;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 48, 107, 0.7); /* Deep blue semi-transparent overlay */
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.hero p {
    font-size: 1.3rem;
    color: #e0eaff;
    max-width: 650px;
    margin: 0 auto 2rem auto;
    line-height: 1.6;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.hero .btn-primary {
    padding: 1rem 2.5rem;
    font-size: 1.15rem;
    font-weight: 600;
    border-radius: 50px;
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    transition: all 0.3s ease;
}

.hero .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.6);
}

/* Update Features Margin to overlap the background nicely */
.features {
    position: relative;
    z-index: 3;
    margin-top: -6rem !important; /* Pull up into the hero */
}
</style>

<!-- app/views/home.php -->
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to Nidaa org</h1>
        <p>
            Connecting war-affected individuals with relief organizations and generous donors. 
            Together, we can make a difference.
        </p>
        
        <div>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=register" class="btn btn-primary">Get Started</a>
            <?php else: ?>
                <a href="index.php?page=<?php echo $_SESSION['role']; ?>_dashboard" class="btn btn-primary">Go to Dashboard</a>
            <?php endif; ?>
        </div>
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

<!-- Blogs & Articles Section -->
<section class="blogs-section">
    <h2>Latest News & Articles</h2>
    <p class="subtitle">Stay updated with the latest from our campaigns and how your contributions make an impact.</p>
    
    <div class="blogs-grid">
        <!-- Article 1 -->
        <article class="blog-card">
            <div class="blog-card-img-wrapper">
                <img src="assets/images/humanitarian-development-aid.jpg" alt="Distribution of Aid" class="blog-card-img">
            </div>
            <div class="blog-card-content">
                <span class="blog-card-category">Relief Effort</span>
                <h3 class="blog-card-title">Bringing Hope to Affected Communities</h3>
                <p class="blog-card-excerpt">See how your generous donations are directly translating into life-saving aid for displaced families worldwide.</p>
                <div class="blog-card-footer">
                    <a href="index.php?page=programs" class="btn-read-more">Read More <i style="font-style: normal; font-family: sans-serif;">&rarr;</i></a>
                </div>
            </div>
        </article>
        
        <!-- Article 2 -->
        <article class="blog-card">
            <div class="blog-card-img-wrapper">
                <img src="assets/images/pexels-lagosfoodbank-9823013.jpg" alt="Food Delivery" class="blog-card-img">
            </div>
            <div class="blog-card-content">
                <span class="blog-card-category">Food Security</span>
                <h3 class="blog-card-title">Securing Food for the Future</h3>
                <p class="blog-card-excerpt">Learn about the on-ground initiatives distributing essential food supplies to those hardest hit by conflict and crisis.</p>
                <div class="blog-card-footer">
                    <a href="index.php?page=programs" class="btn-read-more">Read More <i style="font-style: normal; font-family: sans-serif;">&rarr;</i></a>
                </div>
            </div>
        </article>
        
        <!-- Article 3 -->
        <article class="blog-card">
            <div class="blog-card-img-wrapper">
                <img src="assets/images/somali-women-1024x708.jpg" alt="Community Support" class="blog-card-img">
            </div>
            <div class="blog-card-content">
                <span class="blog-card-category">Community</span>
                <h3 class="blog-card-title">Empowering Local Women and Children</h3>
                <p class="blog-card-excerpt">Discover stories of resilience from local communities as they rebuild and support their families.</p>
                <div class="blog-card-footer">
                    <a href="index.php?page=programs" class="btn-read-more">Read More <i style="font-style: normal; font-family: sans-serif;">&rarr;</i></a>
                </div>
            </div>
        </article>
    </div>
</section>
