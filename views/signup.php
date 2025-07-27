<?php
include '../config/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first-name"] ?? '');
    $last_name = trim($_POST["last-name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $phone = trim($_POST["phone"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm-password"] ?? '';
    $terms_accepted = isset($_POST["terms-and-conditions"]);

    $province = trim($_POST["province"] ?? '');
    $city = trim($_POST["city"] ?? '');
    $barangay = trim($_POST["barangay"] ?? '');
    $street_address = trim($_POST["street"] ?? '');
    $zip_code = trim($_POST["zip-code"] ?? '');

    $errors = [];
    $success = false;
 
    if (!$first_name || !$last_name || !$email || !$phone || !$password || !$confirm_password || !$terms_accepted || !$province || !$city || !$barangay || !$street_address || !$zip_code) {
        $errors[] = "All fields are required and Terms must be accepted.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $dbconn->begin_transaction();

        try {
            $stmt_user = $dbconn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
            $stmt_user->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashed_password);
            $stmt_user->execute();

            $user_id = $dbconn->insert_id;

            $stmt_address = $dbconn->prepare("INSERT INTO user_address(user_id, province, city, barangay, street_address, postal_code) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_address->bind_param("isssss", $user_id, $province, $city, $barangay, $street_address, $zip_code);
            $stmt_address->execute();

            $dbconn->commit();
            $success = true;
            header('Location: login.php');

        } catch (mysqli_sql_exception $e) { 
            $dbconn->rollback();

            if (str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'email')) {
                $errors[] = "An account with this email already exists.";
            } else {
                $errors[] = "Database error: " . $e->getMessage();
            }
            echo $e->getMessage();
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
        <link rel="stylesheet" href="../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/components/signup.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../public/css/global/accounts.css?v=<?php echo time(); ?>">
        <title>R+G Clothing | Signup</title>
    </head>
    <body>
        <?php include './includes/header.php'; ?>
        <main>
            <div class="form-container">
                <h3>Create an R+G Account</h3>
                <form action="" method="post">
                    <fieldset class="mb-3">
                        <legend>Personal Information</legend>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="first-name" class="form-label">First Name<span class="required">*</span></label>
                                <input type="text" name="first-name" id="first-name" class="form-control" placeholder="John" required>
                            </div>
                            <div class="col">
                                <label for="last-name" class="form-label">Last Name<span class="required">*</span></label>
                                <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Doe" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="required">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number<span class="required">*</span></label>
                            <input type="tel" name="phone" id="phone" class="form-control" placeholder="09123456789" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="password" class="form-label">Password<span class="required">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                            </div>
                            <div class="col">
                                <label for="confirm-password" class="form-label">Confirm Password<span class="required">*</span></label>
                                <input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="********" required>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend>Address Details</legend>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="province" class="form-label">Province<span class="required">*</span></label>
                                <input type="text" name="province" id="province" class="form-control" placeholder="Province" required>
                            </div>
                            <div class="col">
                                <label for="city" class="form-label">City<span class="required">*</span></label>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="barangay" class="form-label">Barangay<span class="required">*</span></label>
                                <input type="text" name="barangay" id="barangay" class="form-control" placeholder="Barangay" required>
                            </div>
                            <div class="col">
                                <label for="street" class="form-label">Street<span class="required">*</span></label>
                                <input type="text" name="street" id="street" class="form-control" placeholder="Street" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="zip-code" class="form-label">Zip Code<span class="required">*</span></label>
                            <input type="number" name="zip-code" id="zip-code" class="form-control" placeholder="12345" min="0" required>
                        </div>
                    </fieldset>
                    <div class="mb-3">
                        <label for="terms-and-conditions" class="form-check-label">
                            <input type="checkbox" name="terms-and-conditions" id="terms-and-conditions" class="form-check-input" required>
                            I agree to the <a href="terms-and-conditions.php" class="link-w-line">Terms and Conditions</a>
                        </label>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary w-100">Create Account</button>
                    </div>
                </form>
                <p>Already have an account? <a href="login.php" class="link-w-line">Login</a></p>
            </div>
        </main>
        <?php include './includes/footer.php'; ?>
    </body>
</html>