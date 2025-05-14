<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

// Fetch stats
$products = $pdo->query("SELECT COUNT(*) FROM tblProducts")->fetchColumn();
$orders = $pdo->query("SELECT COUNT(*) FROM tblOrders")->fetchColumn();
$users = $pdo->query("SELECT COUNT(*) FROM tblUsers")->fetchColumn();

// Calculate total for percentage
$total = $products + $orders + $users;

include 'admin_header.php';
?>
<div class="dashboard">
    <h1>Admin Dashboard</h1>
    <div class="stats">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?= htmlspecialchars($products) ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?= htmlspecialchars($orders) ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Users</h3>
            <p><?= htmlspecialchars($users) ?></p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-container" style="display: flex; justify-content: space-around; margin: 50px auto;">
        <div style="width: 30%;">
            <h3>Products, Orders, and Users</h3>
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for the pie chart
    const data = {
        labels: [
            `Products (${((<?= $products ?> / <?= $total ?>) * 100).toFixed(2)}%)`,
            `Orders (${((<?= $orders ?> / <?= $total ?>) * 100).toFixed(2)}%)`,
            `Users (${((<?= $users ?> / <?= $total ?>) * 100).toFixed(2)}%)`
        ],
        datasets: [{
            label: 'Dashboard Statistics',
            data: [<?= $products ?>, <?= $orders ?>, <?= $users ?>],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)', // Products
                'rgba(255, 99, 132, 0.2)', // Orders
                'rgba(54, 162, 235, 0.2)'  // Users
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)', // Products
                'rgba(255, 99, 132, 1)', // Orders
                'rgba(54, 162, 235, 1)'  // Users
            ],
            borderWidth: 1
        }]
    };

    // Configuration for the pie chart
    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percentage = ((value / <?= $total ?>) * 100).toFixed(2);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    };

    // Render the chart
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, config);
</script>
<?php include '../includes/footer.php'; ?>