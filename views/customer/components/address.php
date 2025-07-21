<div class="details-header">
    <h4>Address</h4>
    <p>Update your addresses</p>
</div>
<form action="" method="post" class="profile-form address-form">
    <div class="row g-3 mb-3">
        <div class="col">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="<?php echo $customer['address']; ?>" required>
        </div>
    </div>
</form>