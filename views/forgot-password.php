<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="shortcut icon" href="../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/components/forgot-password.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/global/accounts.css?v=<?php echo time(); ?>">
        <title>R+G Clothing | Forgot Password</title>
    </head>
    <body>
        <?php include './includes/header.php'; ?>
        <main>
            <div class="form-container">
                <h3>Forgot Password?</h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email<span class="required">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="password" class="form-label">New Password<span class="required">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="********">
                        </div>
                        <div class="col">
                            <label for="confirm-password" class="form-label">Confirm Password<span class="required">*</span></label>
                            <input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="********">
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </div>
                </form>
                <p>Remember your password? <a href="login.php" class="link-w-line">Login</a></p>
            </div>
        </main>
        <?php include './includes/footer.php'; ?>
    </body>
</html>