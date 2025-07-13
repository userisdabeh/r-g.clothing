<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/components/login.css?v=<?php echo time(); ?>">
        <title>R+G Clothing | Login</title>
    </head>
    <body>
        <main>
            <div class="form-container">
                <h3>Login to your R+G Account</h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="********">
                        <div class="form-text">
                            Your password must be at least 8 characters long, contain letters and numbers, and must not contain spaces, or special characters.
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
                <div class="form-links">
                    <div class="form-link">
                        <p>Don't have an account? <br><a href="signup.php" class="link-w-line">Sign up</a></p>
                    </div>
                    <div class="form-link text-end">
                        <p>Forgot your password? <br><a href="forgot-password.php" class="link-w-line">Reset password</a></p>
                    </div>
                </div>
            </div>
        </main>
        <?php include './includes/footer.php'; ?>
    </body>
</html>