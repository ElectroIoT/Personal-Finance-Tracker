<?php
// Start session to handle user login
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection file
include('db.php');

// Initialize variables for user data
$income = 0;
$expenses = 0;
$taxable_income = 0;
$tax = 0;

// Debugging: Check if session user_id is set
echo "User ID from session: " . $_SESSION['user_id'] . "<br>"; // Debugging line

// Query to fetch user income and expenses based on user id
$sql = "SELECT income, expenses FROM users WHERE id = '".$_SESSION['user_id']."'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Check if the user data exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $income = $user['income'];
        $expenses = $user['expenses'];
        
        // Calculate taxable income
        $taxable_income = $income - $expenses;
        
        // Simple tax calculation logic based on income and expenses
        if ($taxable_income <= 250000) {
            $tax = 0;
        } elseif ($taxable_income <= 500000) {
            $tax = $taxable_income * 0.05;
        } elseif ($taxable_income <= 1000000) {
            $tax = 250000 * 0.05 + ($taxable_income - 250000) * 0.2;
        } else {
            $tax = 250000 * 0.05 + 500000 * 0.2 + ($taxable_income - 1000000) * 0.3;
        }
    } else {
        echo "<div class='alert alert-danger'>No data found for your user. Please check your data.</div>";
    }
} else {
    // Output query error if the query fails
    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Report - Personal Finance Tracker</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Tax Report</h1>
        <p class="lead">Your Tax Summary for Filing</p>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Tax Filing Report</h5>
                <p>Annual Income: ₹<?php echo number_format($income, 2); ?></p>
                <p>Eligible Expenses: ₹<?php echo number_format($expenses, 2); ?></p>
                <p>Taxable Income: ₹<?php echo number_format($taxable_income, 2); ?></p>
                <p>Calculated Tax: ₹<?php echo number_format($tax, 2); ?></p>
            </div>
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
