<?php
include('db.php');

// Check if the expense ID is passed
if (isset($_GET['id'])) {
    $expense_id = $_GET['id'];

    // Query to delete the expense from the database
    $sql = "DELETE FROM expenses WHERE id = $expense_id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-4'>Expense deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Error: " . $conn->error . "</div>";
    }

    $conn->close();

    // Redirect to the expenses page after deletion
    header("Location: expenses.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Expense - Personal Finance Tracker</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Delete Expense</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="alert alert-warning">
            <h4 class="alert-heading">Are you sure you want to delete this expense?</h4>
            <p>This action cannot be undone.</p>
            <a href="expenses.php" class="btn btn-secondary">Cancel</a>
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
