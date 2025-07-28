<?php
session_start();
include '../config/dbconn.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($dbconn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                    if ($user['user_role'] === 'admin') {
                        $_SESSION['user_id'] = $user['user_id'];
                        
                        header("Location: ./admin/dashboard.php");
                        exit;
                    } else if ($user['user_role'] === 'staff') {
                        $_SESSION['user_id'] = $user['user_id'];

                        header("Location: ./staff/dashboard.php");
                        exit;
                    } else {
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

                        header("Location: ./customer/catalog.php");
                        exit;
                    }
                
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/css/components/login.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/global/accounts.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/global/base.css?v=<?php echo time(); ?>">
        <title>R+G Clothing | Login</title>
    </head>
    <body>
        <?php include './includes/header.php'; ?>
        <main>
            <div class="form-container">
                <h3>Login to your R+G Account</h3>
                <form action="login.php" method="post">
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