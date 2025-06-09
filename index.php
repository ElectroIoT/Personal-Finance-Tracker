<?php
// Start the session to manage user authentication
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

// Include the database connection file
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

// Query to fetch recent expenses from the database
$expensesQuery = "SELECT name, amount, category, date FROM expenses ORDER BY date DESC LIMIT 5";
$expensesResult = $conn->query($expensesQuery);

$expenses = [];
if ($expensesResult->num_rows > 0) {
    while ($row = $expensesResult->fetch_assoc()) {
        $expenses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .header-section {
            background-color: #007bff;
            padding: 30px 0;
            color: white;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
        .card {
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header-section text-center">
        <h1 class="display-4">Personal Finance Tracker</h1>
        <p class="lead">Track your expenses and budget effortlessly</p>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="expenses.php">Expenses</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="budget.php">Budget</a></li>
                <li class="nav-item">
                    <!-- View Goals Button -->
                    <a href="view-goals.php" class="btn btn-info nav-link">View Goals</a>
                </li>
                <li class="nav-item">
                    <!-- Logout Button -->
                    <a href="logout.php" class="btn btn-danger nav-link">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <!-- Welcome Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Welcome, <?php echo $_SESSION['username']; ?>!</h5>
                        <p>You're logged in and ready to track your expenses.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Section -->
        <div class="row mt-5">
            <div class="col-md-6">
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
            </div>

            <!-- Expense Entry Form -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Log Your Expense</h5>
                        <form action="add-expense.php" method="POST">
                            <div class="mb-3">
                                <label for="expense_name" class="form-label">Expense Name</label>
                                <input type="text" class="form-control" id="expense_name" name="expense_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="expense_amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="expense_amount" name="expense_amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="expense_category" class="form-label">Category</label>
                                <select class="form-select" id="expense_category" name="expense_category" required>
                                    <option value="food">Food</option>
                                    <option value="transportation">Transportation</option>
                                    <option value="entertainment">Entertainment</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Add Expense</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Section -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Your Recent Expenses</h3>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Expense Name</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($expenses)): ?>
                                    <?php foreach ($expenses as $expense): ?>
                                        <tr>
                                            <td><?php echo $expense['name']; ?></td>
                                            <td>₹<?php echo number_format($expense['amount'], 2); ?></td>
                                            <td><?php echo ucfirst($expense['category']); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($expense['date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">No recent expenses to display.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Personal Finance Tracker</p>
    </footer>

    <!-- Bootstrap and Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
