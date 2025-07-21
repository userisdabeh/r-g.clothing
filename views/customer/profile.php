<?php
    session_start(); // Needed for $_SESSION

    // Initialize default data if session is empty
    if (!isset($_SESSION['customer'])) {
        $_SESSION['customer'] = [
            'id' => 1,
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'email' => 'juan.delacruz@example.com',
            'phone' => '+639123456789',
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a nisi id lectus pulvinar semper.',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Muntinlupa',
            'barangay' => 'Ayala Alabang',
            'street' => 'University Ave.',
            'zip_code' => '1700',
        ];
    }

    // Always work with the session data
    $customer = $_SESSION['customer'];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Grab POST data
        $customer['first_name'] = $_POST['first_name'] ?? '';
        $customer['last_name']  = $_POST['last_name'] ?? '';
        $customer['email']      = $_POST['email'] ?? '';
        $customer['phone']      = $_POST['phone'] ?? '';
        $customer['bio']        = $_POST['bio'] ?? '';
        $customer['region']     = $_POST['region'] ?? '';
        $customer['province']   = $_POST['province'] ?? '';
        $customer['city']       = $_POST['city'] ?? '';
        $customer['barangay']   = $_POST['barangay'] ?? '';
        $customer['zip_code']   = $_POST['zip_code'] ?? '';

        // Save changes back to session
        $_SESSION['customer'] = $customer;

        // Redirect to avoid form resubmission on refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/customer.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/profile.css?v=<?php echo time(); ?>">
        <script src="../../public/js/profile.js?v=<?php echo time(); ?>" defer></script>
        <title>R+G Clothing | Profile</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <div class="profile-summary">
                <div class="summary-header">
                    <div class="summary-header-details">
                        <h3 class="summary-header-text summary-header-name"><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></h3>
                        <p class="summary-header-text">
                            <i class="bi bi-geo-alt"></i>
                            <?php echo $customer['street'] . ', ' . $customer['barangay'] . ', ' . $customer['city'] . ', ' . $customer['province'] . ', ' . $customer['region'] . ', ' . $customer['zip_code']; ?>
                        </p>
                    </div>
                    <button class="btn btn-primary" id="edit-personal-button">
                        <i class="bi bi-pencil-square"></i>    
                        Edit Profile
                    </button>
                </div>
                <p class="summary-description"><?php echo $customer['bio']; ?></p>
            </div>
            <div class="details">
                <div class="details-header">
                    <h4>Personal Information</h4>
                    <p>Update your personal details and contact information</p>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="profile-form personal-form">
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $customer['first_name']; ?>" required disabled>
                        </div>
                        <div class="col">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $customer['last_name']; ?>" required disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $customer['email']; ?>" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo $customer['phone']; ?>" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea name="bio" id="bio" class="form-control" rows="3" required disabled><?php echo $customer['bio']; ?></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="region" class="form-label">Region</label>
                            <select name="region" id="region" class="form-select" required disabled>
                                <option value="NCR" <?php echo $customer['region'] === 'NCR' ? 'selected' : ''; ?>>NCR</option>
                                <option value="Region 1" <?php echo $customer['region'] === 'Region 1' ? 'selected' : ''; ?>>Region 1</option>
                                <option value="Region 2" <?php echo $customer['region'] === 'Region 2' ? 'selected' : ''; ?>>Region 2</option>
                                <option value="Region 3" <?php echo $customer['region'] === 'Region 3' ? 'selected' : ''; ?>>Region 3</option>
                                <option value="Region 4" <?php echo $customer['region'] === 'Region 4' ? 'selected' : ''; ?>>Region 4</option>
                                <option value="Region 5" <?php echo $customer['region'] === 'Region 5' ? 'selected' : ''; ?>>Region 5</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="province" class="form-label">Province</label>
                            <select name="province" id="province" class="form-select" required disabled>
                                <option value="Metro Manila" <?php echo $customer['province'] === 'Metro Manila' ? 'selected' : ''; ?>>Metro Manila</option>
                                <option value="Bulacan" <?php echo $customer['province'] === 'Bulacan' ? 'selected' : ''; ?>>Bulacan</option>
                                <option value="Pampanga" <?php echo $customer['province'] === 'Pampanga' ? 'selected' : ''; ?>>Pampanga</option>
                                <option value="Tarlac" <?php echo $customer['province'] === 'Tarlac' ? 'selected' : ''; ?>>Tarlac</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city" class="form-control" value="<?php echo $customer['city']; ?>" required disabled>
                        </div>
                        <div class="col">
                            <label for="barangay" class="form-label">Barangay</label>
                            <input type="text" name="barangay" id="barangay" class="form-control" value="<?php echo $customer['barangay']; ?>" required disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="number" name="zip_code" id="zip_code" class="form-control" value="<?php echo $customer['zip_code']; ?>" required minlength="4" maxlength="4" disabled>
                    </div>
                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary d-none" id="save-changes">Save Changes</button>
                        <button type="button" class="btn btn-secondary d-none" id="cancel-changes">Cancel</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>