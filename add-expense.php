<?php
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_name = $_POST['expense_name'];
    $expense_amount = $_POST['expense_amount'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $recurrence = $_POST['recurrence'];
    $tags = $_POST['tags'];                  // Tags (comma-separated)
    $notes = $_POST['notes'];                // Notes section
    $next_occurrence = null;

    // Calculate next occurrence date based on recurrence type
    if ($recurrence == 'weekly') {
        $next_occurrence = date('Y-m-d', strtotime('+1 week'));
    } elseif ($recurrence == 'monthly') {
        $next_occurrence = date('Y-m-d', strtotime('+1 month'));
    } elseif ($recurrence == 'yearly') {
        $next_occurrence = date('Y-m-d', strtotime('+1 year'));
    }

    // Insert the expense data into the database
    $sql = "INSERT INTO expenses (name, amount, category, subcategory, recurrence, next_occurrence, tags, notes) 
            VALUES ('$expense_name', '$expense_amount', '$category', '$subcategory', '$recurrence', '$next_occurrence', '$tags', '$notes')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-4'>Expense added successfully!</div>";
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
    <title>Add Expense - Personal Finance Tracker</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Add Expense</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
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
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="food">Food</option>
                            <option value="transportation">Transportation</option>
                            <option value="entertainment">Entertainment</option>
                            <option value="utilities">Utilities</option>
                            <option value="health">Health</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subcategory" class="form-label">Subcategory (Optional)</label>
                        <input type="text" class="form-control" id="subcategory" name="subcategory">
                    </div>
                    <div class="mb-3">
                        <label for="recurrence" class="form-label">Recurring Expense</label>
                        <select class="form-select" id="recurrence" name="recurrence" required>
                            <option value="">Select Recurrence</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label">Expense Tags (Optional)</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="e.g., urgent, business, tax">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Add any notes or description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Add Expense</button>
                </form>

                <!-- Navigation Buttons -->
                <div class="mt-4">
                    <a href="index.php" class="btn btn-secondary">Back to Home</a>
                    <a href="expenses.php" class="btn btn-primary">Back to Expenses</a>
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
