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

// Query to fetch recent expenses from the database
$sql = "SELECT id, name, amount, category, subcategory, recurrence, next_occurrence, tags, notes, date FROM expenses ORDER BY date DESC";
$result = $conn->query($sql);

$expenses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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
    <title>Expenses - Personal Finance Tracker</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Recent Expenses</h1>
        <p class="lead">View and manage your expenses</p>
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
        <!-- Add Expense Button -->
        <div class="mb-4">
            <a href="add-expense.php" class="btn btn-success">Add Expense</a>
        </div>

        <!-- Export CSV Button -->
        <div class="mb-4">
            <a href="export-csv.php" class="btn btn-info">Export to CSV</a>
        </div>

        <!-- Expenses Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Your Recent Expenses</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Expense Name</th>
                            <th>Amount (₹)</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Date</th>
                            <th>Recurrence</th>
                            <th>Next Occurrence</th>
                            <th>Tags</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($expenses)): ?>
                            <?php foreach ($expenses as $expense): ?>
                                <tr>
                                    <td><?php echo $expense['name']; ?></td>
                                    <td>₹<?php echo number_format($expense['amount'], 2); ?></td>
                                    <td><?php echo ucfirst($expense['category']); ?></td>
                                    <td><?php echo $expense['subcategory'] ? ucfirst($expense['subcategory']) : 'N/A'; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($expense['date'])); ?></td>
                                    <td><?php echo $expense['recurrence'] ? ucfirst($expense['recurrence']) : 'N/A'; ?></td>
                                    <td><?php echo $expense['next_occurrence'] ? date('d-m-Y', strtotime($expense['next_occurrence'])) : 'N/A'; ?></td>
                                    <td><?php echo $expense['tags'] ? ucfirst($expense['tags']) : 'N/A'; ?></td>
                                    <td><?php echo $expense['notes'] ? $expense['notes'] : 'N/A'; ?></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="edit-expense.php?id=<?php echo $expense['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                        <!-- Delete Button -->
                                        <a href="delete-expense.php?id=<?php echo $expense['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" class="text-center">No recent expenses to display.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
