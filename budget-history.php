<?php
include('db.php');

// Clear history logic (only if the clear history button is pressed)
if (isset($_POST['clear_history'])) {
    // Delete all records in the budgets table
    $delete_sql = "DELETE FROM budgets";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "<div class='alert alert-success mt-4'>Budget history cleared successfully.</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Error: " . $conn->error . "</div>";
    }
}

// Query to fetch all budgets from the database
$sql = "SELECT * FROM budgets ORDER BY year DESC, month DESC";
$result = $conn->query($sql);

$budgets = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $budgets[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget History - Personal Finance Tracker</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Budget History</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <h3>Your Budget History</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Budget Amount (₹)</th>
                            <th>Amount Spent (₹)</th>
                            <th>Remaining Budget (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($budgets)): ?>
                            <?php foreach ($budgets as $budget): ?>
                                <tr>
                                    <td><?php echo date("F", mktime(0, 0, 0, $budget['month'], 10)); ?></td>
                                    <td><?php echo $budget['year']; ?></td>
                                    <td>₹<?php echo number_format($budget['amount'], 2); ?></td>
                                    <td>₹<?php echo number_format($budget['spent'], 2); ?></td>
                                    <td>₹<?php echo number_format($budget['amount'] - $budget['spent'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No budgets set yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Buttons Section: Back to Home, Back to Budget, Clear History -->
        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
            <a href="budget.php" class="btn btn-primary">Back to Budget</a>

            <!-- Clear Budget History Button -->
            <form action="budget-history.php" method="POST" class="d-inline">
                <button type="submit" name="clear_history" class="btn btn-danger" onclick="return confirmClear()">Clear History</button>
            </form>
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
