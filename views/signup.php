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
                                <input type="text" name="first-name" id="first-name" class="form-control" placeholder="John">
                            </div>
                            <div class="col">
                                <label for="last-name" class="form-label">Last Name<span class="required">*</span></label>
                                <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Doe">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="required">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number<span class="required">*</span></label>
                            <input type="tel" name="phone" id="phone" class="form-control" placeholder="09123456789">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="password" class="form-label">Password<span class="required">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="********">
                            </div>
                            <div class="col">
                                <label for="confirm-password" class="form-label">Confirm Password<span class="required">*</span></label>
                                <input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="********">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend>Address Details</legend>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="province" class="form-label">Province<span class="required">*</span></label>
                                <input type="text" name="province" id="province" class="form-control" placeholder="Province">
                            </div>
                            <div class="col">
                                <label for="city" class="form-label">City<span class="required">*</span></label>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="barangay" class="form-label">Barangay<span class="required">*</span></label>
                                <input type="text" name="barangay" id="barangay" class="form-control" placeholder="Barangay">
                            </div>
                            <div class="col">
                                <label for="street" class="form-label">Street<span class="required">*</span></label>
                                <input type="text" name="street" id="street" class="form-control" placeholder="Street">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="zip-code" class="form-label">Zip Code<span class="required">*</span></label>
                            <input type="number" name="zip-code" id="zip-code" class="form-control" placeholder="12345" min="0">
                        </div>
                    </fieldset>
                    <div class="mb-3">
                        <label for="terms-and-conditions" class="form-check-label">
                            <input type="checkbox" name="terms-and-conditions" id="terms-and-conditions" class="form-check-input">
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