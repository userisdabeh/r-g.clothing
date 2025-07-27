<nav>
    <ul class="dashboard-links">
        <li>
            <a href="dashboard.php" class="dashboard-link <?php echo $activePage === 'dashboard' ? 'active-link' : ''; ?>">
                <i class="bi bi-house-fill dashboard-icon"></i>
                <span class="dashboard-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="products.php" class="dashboard-link <?php echo $activePage === 'products' ? 'active-link' : ''; ?>">
                <i class="bi bi-shop-window dashboard-icon"></i>
                <span class="dashboard-text">Products</span>
            </a>
        </li>   
        <li>
            <a href="orders.php" class="dashboard-link <?php echo $activePage === 'orders' ? 'active-link' : '' ?> ">
                <i class="bi bi-cart-check-fill dashboard-icon"></i>
                <span class="dashboard-text">Orders</span>
            </a>
        </li>
        <li>
            <a href="users.php" class="dashboard-link <?php echo $activePage === 'users' ? 'active-link' : ''; ?>">
                <i class="bi bi-people-fill dashboard-icon"></i>
                <span class="dashboard-text">Users</span>
            </a>
        </li>
        <li>
            <a href="reports.php" class="dashboard-link <?php echo $activePage === 'reports' ? 'active-link' : ''; ?>">
                <i class="bi bi-file-earmark-bar-graph-fill dashboard-icon"></i>
                <span class="dashboard-text">Reports</span>
            </a>
        </li>
    </ul>
    <div class="logout-container">
        <a href="../logout.php" class="dashboard-link">
            <i class="bi bi-box-arrow-right dashboard-icon"></i>
            <span class="dashboard-text">Logout</span>
        </a>
    </div>
</nav>