<nav>
    <ul class="dashboard-links">
        <li>
            <a href="dashboard.php" class="dashboard-link <?php echo $activePage === 'dashboard' ? 'active-link' : ''; ?>">
                <i class="bi bi-house-fill dashboard-icon"></i>
                <span class="dashboard-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="stocks.php" class="dashboard-link <?php echo $activePage === 'stocks' ? 'active-link' : ''; ?>">
                <i class="bi bi-shop-window dashboard-icon"></i>
                <span class="dashboard-text">Stocks</span>
            </a>
        </li>
        <li>
            <a href="orders.php" class="dashboard-link <?php echo $activePage === 'orders' ? 'active-link' : ''; ?>">
                <i class="bi bi-cart-check-fill dashboard-icon"></i>
                <span class="dashboard-text">Orders</span>
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