<?php
// Start session at the beginning of the file
session_start();

include('db.php');

// Check if the ID is passed in the URL for editing the goal
if (isset($_GET['id'])) {
    $goal_id = $_GET['id'];
    
    // Fetch the current goal data
    $sql = "SELECT * FROM savings_goals WHERE id = '$goal_id' AND user_id = '".$_SESSION['user_id']."'"; // Make sure the goal belongs to the logged-in user
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $goal = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger mt-4'>Goal not found or you do not have permission to edit this goal.</div>";
        exit;
    }
}

// Handle form submission to update the savings goal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $goal_name = $_POST['goal_name'];
    $target_amount = $_POST['target_amount'];
    $amount_saved = $_POST['amount_saved']; // The user can update the amount saved so far

    // Update the goal in the database
    $sql = "UPDATE savings_goals SET goal_name = '$goal_name', target_amount = '$target_amount', amount_saved = '$amount_saved' WHERE id = '$goal_id' AND user_id = '".$_SESSION['user_id']."'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-4'>Savings Goal updated successfully!</div>";
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
    <title>Edit Savings Goal</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Edit Savings Goal</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Edit Your Savings Goal</h5>
                <form action="edit-goal.php?id=<?php echo $goal_id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="goal_name" class="form-label">Goal Name</label>
                        <input type="text" class="form-control" id="goal_name" name="goal_name" value="<?php echo $goal['goal_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="target_amount" class="form-label">Target Amount (₹)</label>
                        <input type="number" class="form-control" id="target_amount" name="target_amount" value="<?php echo $goal['target_amount']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount_saved" class="form-label">Amount Saved So Far (₹)</label>
                        <input type="number" class="form-control" id="amount_saved" name="amount_saved" value="<?php echo $goal['amount_saved']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Goal</button>
                </form>

                <!-- Navigation Buttons -->
                <div class="mt-4">
                    <a href="index.php" class="btn btn-secondary">Back to Home</a>
                    <a href="view-goals.php" class="btn btn-primary">Back to View Goals</a>
                    <a href="expenses.php" class="btn btn-info">Back to Expenses</a>
                    <a href="budget.php" class="btn btn-warning">Back to Budget</a>
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
