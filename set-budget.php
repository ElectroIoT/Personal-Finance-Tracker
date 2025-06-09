<?php
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $budget_amount = $_POST["budget_amount"];
    $month = $_POST["month"];
    $year = $_POST["year"];

    // Insert the budget for the specific month and year
    $sql = "INSERT INTO budgets (amount, month, year) VALUES ('$budget_amount', '$month', '$year')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-4'>Budget set for $month/$year successfully.</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Error: " . $conn->error . "</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Monthly Budget - Personal Finance Tracker</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Set Monthly Budget</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Enter Your Monthly Budget</h5>
                <form action="set-budget.php" method="POST">
                    <div class="mb-3">
                        <label for="budget_amount" class="form-label">Budget Amount (₹)</label>
                        <input type="number" class="form-control" id="budget_amount" name="budget_amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <select class="form-select" id="month" name="month" required>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year" value="<?php echo date("Y"); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Set Budget</button>
                </form>

                <!-- Back to Home Button -->
                <div class="mt-4">
                    <a href="index.php" class="btn btn-secondary">Back to Home</a>
                </div>
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
