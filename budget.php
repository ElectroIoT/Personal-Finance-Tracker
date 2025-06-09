<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

// Include database connection
include('db.php');

// Query to fetch the most recent budget from the database
$sql = "SELECT amount FROM budgets ORDER BY date DESC LIMIT 1";
$result = $conn->query($sql);

// Initialize variable to store the budget amount
$budgetAmount = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $budgetAmount = $row['amount'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Budget - Personal Finance Tracker</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Budget</h1>
        <p class="lead">Track and manage your monthly budget</p>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="expenses.php">Expenses</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="budget.php">Budget</a></li>
                <li class="nav-item"><a href="logout.php" class="btn btn-danger nav-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <!-- Budget Section -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Your Monthly Budget</h5>
                <?php if ($budgetAmount !== null): ?>
                    <p class="card-text">Your current set budget is: <strong>₹<?php echo number_format($budgetAmount, 2); ?></strong></p>
                <?php else: ?>
                    <p class="card-text">No budget has been set yet. Please set your budget on the <a href="set-budget.php">Set Budget</a> page.</p>
                <?php endif; ?>
                <a href="set-budget.php" class="btn btn-primary">Set Budget</a>
            </div>
        </div>

        <!-- Budget History Section -->
        <div class="card shadow-sm mt-5">
            <div class="card-body">
                <h5 class="card-title">View Budget History</h5>
                <a href="budget-history.php" class="btn btn-info">View History</a>
            </div>
        </div>

        <!-- Back to Home Section -->
        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p>&copy; 2025 Personal Finance Tracker</p>
    </footer>

    <!-- Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
