<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R+G Clothing</title>
        <link rel="stylesheet" href="public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="public/css/components/landing.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    </head>
    <body>
        <header>
            <h2>R+G Clothing</h2>
            <nav>
                <button type="button" class="dark-light-toggle">
                    <i class="bi bi-moon-fill"></i>
                </button>
                <ul>
                    <li>
                        <a href="views/signup.php" class="btn btn-secondary">Sign Up</a>
                    </li>
                    <li>
                        <a href="views/login.php" class="btn btn-primary">Login</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <section class="hero main-wrapper">
                <div class="hero-content">
                    <h1 class="hero-title">Refined Style for the<br>Modern Man.</h1>
                    <p class="hero-description">Discover a curated collection of premium apparel designed for strength, sophistication, and everyday comfort.</p>
                    <a href="views/signup.php" class="btn btn-primary">Get Started</a>
                </div>
                <div class="hero-image">
                    <img src="https://res.cloudinary.com/davgly7hd/image/upload/v1752311718/samples/man-on-a-street.jpg" alt="Hero Image">
                </div>
            </section>
            <section class="about main-wrapper">
                <div class="about-content">
                    <h2 class="about-title">About Us</h2>
                    <p class="about-description">At R+G Clothing, we believe that style is a reflection of who you are — and that looking good shouldn't mean emptying your wallet or sweating through your day just to keep up appearances. Our mission is to empower Filipino men with high-quality apparel that blends timeless design, modern functionality, and all-day comfort. Whether you're heading to the office, a night out, or just running errands, our pieces are made to move with you — breathable, durable, and always on point. Because confidence shouldn't come with compromise — and at R+G, you don’t have to choose between looking sharp and feeling good.</p>
                </div>
            </section>
            <section class="promotion main-wrapper">
                <div class="promotion-content">
                    <h2 class="promotion-title">Why Choose R+G Clothing?</h2>
                    <div class="promotion-items">
                        <div class="promotion-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="promotion-item-icon"><path d="M720-120H320v-520l280-280 50 50q7 7 11.5 19t4.5 23v14l-44 174h218q32 0 56 24t24 56v80q0 7-1.5 15t-4.5 15L794-168q-9 20-30 34t-44 14ZM240-640v520H80v-520h160Z"/></svg>
                            <div class="promotion-item-content">
                                <h4 class="promotion-item-title">Quality Materials</h4>
                                <p class="promotion-item-description">We use only the finest fabrics and materials to ensure that our products are not only stylish but also durable and comfortable to wear.</p>
                            </div>
                        </div>
                        <div class="promotion-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-stopwatch promotion-item-icon" viewBox="0 0 16 16">
                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z"/>
                                <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3"/>
                            </svg>
                            <div class="promotion-item-content">
                                <h4 class="promotion-item-title">Timeless Design</h4>
                                <p class="promotion-item-description">Our collections blend classic aesthetics with modern trends, ensuring your style remains relevant for years.</p>
                            </div>
                        </div>
                        <div class="promotion-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="promotion-item-icon"><path d="M471.69-131.54q-14.69 0-25.81-9.96-11.11-9.96-11.11-26.19 0-7.77 3.38-17.19 3.39-9.43 10.16-16.2l147.31-147.3-22.08-22.08-147.08 147.31q-6.77 6.77-15.31 10.15-8.53 3.38-17.3 3.38-15.47 0-26.2-10.73-10.73-10.73-10.73-26.19 0-9.23 3.77-18.04 3.77-8.8 9.54-14.57l147.31-147.31-21.85-21.85-147.31 147.08q-6 6-14.92 9.77-8.92 3.77-17.92 3.77-15.23 0-26.08-10.85-10.84-10.84-10.84-26.08 0-8.76 3.38-17.3 3.38-8.54 10.15-15.31l138.08-138.08-22.08-21.84-137.84 138.07q-5.77 5.77-14.69 9.54-8.93 3.77-18.16 3.77-16.23 0-26.58-10.35-10.34-10.34-10.34-26.57 0-8.77 3.38-17.31 3.39-8.54 10.16-15.31l197.61-197.61 86.16 86.38q11 11 24.84 15.58 13.85 4.58 28.08 4.58 28.92 0 48.31-19.04 19.38-19.04 19.38-48.66 0-14-5.38-28.23-5.39-14.23-16.85-25.69L490.31-753.92l39.23-39.23q13.15-12.93 31.84-20.27 18.7-7.35 37.39-7.35 19.85 0 38.77 7.35 18.92 7.34 32.31 20.73l171.3 171.54q12.62 12.61 19.97 30.77 7.34 18.15 7.34 40.23 0 20-7.46 37.8-7.46 17.81-19.85 30.2L504.31-145.08q-6.46 6.46-15.16 10-8.69 3.54-17.46 3.54ZM167.92-433.08l-41.38-41.38q-17-16.77-25.62-40.31-8.61-23.54-8.61-46 0-23.69 7.69-43T119.62-635l157.46-157.69q12.92-12.93 28.77-20.5 15.84-7.58 34.53-7.58 20.08 0 36.85 7.12 16.77 7.11 30.62 20.96l166.54 166.54q6 6 9.76 14.92 3.77 8.92 3.77 16.92 0 16-10.46 26.85Q567-556.62 551-556.62q-9 0-17.31-3.26-8.3-3.27-15.3-10.27L411.46-676.62 167.92-433.08Z"/></svg>
                            <div class="promotion-item-content">
                                <h4 class="promotion-item-title">Customer Satisfaction</h4>
                                <p class="promotion-item-description">We prioritize customer satisfaction, ensuring that you're happy with every purchase.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="partnerships main-wrapper">
                <div class="partnerships-content">
                    <h2 class="partnerships-title">Our Partners</h2>
                    <p class="partnerships-description">R+G Clothing is more than just a brand; it's a vision for the future of men's fashion. We are actively seeking strategic partnerships and investment opportunities to expand our reach and innovate our offerings.</p>
                    <button type="button" class="btn btn-primary">Contact Us</button>
                </div>
            </section>
        </main>
        <?php include 'views/includes/footer.php'; ?>
    </body>
</html>