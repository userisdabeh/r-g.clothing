<?php
    session_start();
    $activePage = 'users';

    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userID = $_POST['userID'];
        $userRole = $_POST['userRole'];
        $updateUserRole = mysqli_query($dbconn, "CALL update_user_role($userID, '$userRole')");
        if ($updateUserRole) {
            echo "<script>alert('User role updated successfully'); window.location.href = 'users.php';</script>";
        } else {
            echo "<script>alert('Error updating user role'); window.location.href = 'users.php';</script>";
        }
    }

    $getAllUsers = mysqli_query($dbconn, "CALL get_all_users()");
    $getAllUsersResult = [];
    while ($row = mysqli_fetch_assoc($getAllUsers)) {
        $getAllUsersResult[] = $row;
    }
    mysqli_free_result($getAllUsers);
    mysqli_next_result($dbconn);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/employees.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/admin/users.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous" defer></script>
        <script src="../../public/js/users.js" defer></script>
        <title>R+G - Admin Dashboard</title>
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <section class="main-header mb-4">
                <h3 class="main-header-title">Users</h3>
            </section>
            <section class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getAllUsersResult as $user): ?>
                        <tr>
                            <td scope="row"><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['user_role']; ?></td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-bs-user-id="<?php echo $user['user_id']; ?>" data-bs-user-role="<?php echo $user['user_role']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="editUserModalLabel">Edit User</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="editUserForm">
                            <input type="hidden" name="userID" id="userID">
                            <div class="mb-3">
                                <label for="userRole" class="form-label">User Role</label>
                                <select class="form-select" id="userRole" name="userRole">
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="editUserForm">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>