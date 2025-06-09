<?php
// Start session to handle user login
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize tax result
$tax = 0;
$taxable_income = 0;
$income = 0;
$expenses = 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $income = $_POST['income'];
    $expenses = $_POST['expenses'];
    
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Calculator - Personal Finance Tracker</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Tax Calculator</h1>
        <p class="lead">Calculate your estimated tax based on your income and eligible expenses</p>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <form action="tax-calculator.php" method="POST">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Enter Your Details</h5>
                    
                    <!-- Income -->
                    <div class="mb-3">
                        <label for="income" class="form-label">Annual Income (₹)</label>
                        <input type="number" class="form-control" id="income" name="income" value="<?php echo isset($income) ? $income : ''; ?>" required>
                    </div>
                    
                    <!-- Expenses -->
                    <div class="mb-3">
                        <label for="expenses" class="form-label">Eligible Expenses (₹)</label>
                        <input type="number" class="form-control" id="expenses" name="expenses" value="<?php echo isset($expenses) ? $expenses : ''; ?>" required>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Calculate Tax</button>
                </div>
            </div>
        </form>

        <!-- Tax Result Section -->
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="mt-5 card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tax Calculation Result</h5>
                    <p>Your taxable income: ₹<?php echo number_format($taxable_income, 2); ?></p>
                    <p>Your estimated tax: ₹<?php echo number_format($tax, 2); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p>&copy; 2025 Personal Finance Tracker</p>
    </footer>

    <!-- Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
