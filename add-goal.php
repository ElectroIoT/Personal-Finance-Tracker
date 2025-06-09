<?php
include('db.php');

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission to create a savings goal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $goal_name = $_POST['goal_name'];
    $target_amount = $_POST['target_amount'];
    $user_id = $_SESSION['user_id']; // User ID from session

    // Insert the new goal into the database
    $sql = "INSERT INTO savings_goals (goal_name, target_amount, amount_saved, user_id) 
            VALUES ('$goal_name', '$target_amount', 0, '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-4'>Savings Goal created successfully!</div>";
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
    <title>Create Savings Goal</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Create Savings Goal</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Set Your Savings Goal</h5>
                <form action="add-goal.php" method="POST">
                    <div class="mb-3">
                        <label for="goal_name" class="form-label">Goal Name</label>
                        <input type="text" class="form-control" id="goal_name" name="goal_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="target_amount" class="form-label">Target Amount (₹)</label>
                        <input type="number" class="form-control" id="target_amount" name="target_amount" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Goal</button>
                </form>

                <!-- Navigation Buttons -->
                <div class="mt-4">
                    <a href="index.php" class="btn btn-secondary">Back to Home</a>
                    <a href="view-goals.php" class="btn btn-primary">View Goals</a>
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
