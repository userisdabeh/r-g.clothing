<div class="details-header">
    <h4>Personal Information</h4>
    <p>Update your personal details and contact information</p>
</div>
<form action="" method="post" class="profile-form personal-form">
    <div class="row g-3 mb-3">
        <div class="col">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $customer['first_name']; ?>" required>
        </div>
        <div class="col">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $customer['last_name']; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $customer['email']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo $customer['phone']; ?>" required>
    </div>
    <div class="w-100">
        <label for="bio" class="form-label">Bio</label>
        <textarea name="bio" id="bio" class="form-control" rows="3" required><?php echo $customer['bio']; ?></textarea>
    </div>
</form>