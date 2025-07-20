<?php
    $currentTab = $_GET['tab'] ?? 'personal';

    function isActive($tab, $currentTab) {
        return $tab === $currentTab ? 'active' : '';
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
        <title>R+G Clothing | Profile</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <div class="profile-summary">
                <div class="summary-header">
                    <div class="summary-header-details">
                        <h3 class="summary-header-text summary-header-name">John Doe</h3>
                        <p class="summary-header-text">
                            <i class="bi bi-geo-alt"></i>
                            Manila, Philippines
                        </p>
                    </div>
                    <button class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i>    
                        Edit Profile
                    </button>
                </div>
                <p class="summary-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a nisi id lectus pulvinar semper. Ut mollis mollis arcu, et accumsan sem suscipit id.</p>
            </div>
            <div class="tabs">
                <a href="?tab=personal" class="tab <?php echo isActive('personal', $currentTab); ?>">Personal Information</a>
                <a href="?tab=address" class="tab <?php echo isActive('address', $currentTab); ?>">Address</a>
            </div>
        </main>
    </body>
</html>