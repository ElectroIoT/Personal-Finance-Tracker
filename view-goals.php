<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include('db.php');

// Fetch the savings goals for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM savings_goals WHERE user_id = '$user_id' ORDER BY date_created DESC";
$result = $conn->query($sql);

$savings_goals = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $savings_goals[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Savings Goals</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white p-4 text-center">
        <h1>Your Savings Goals</h1>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <!-- Add New Goal Button -->
        <div class="mb-4">
            <a href="add-goal.php" class="btn btn-success">Create New Goal</a>
        </div>

        <!-- Navigation Buttons -->
        <div class="mb-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
            <a href="expenses.php" class="btn btn-primary">Back to Expenses</a>
            <a href="budget.php" class="btn btn-warning">Back to Budget</a>
        </div>

        <!-- Savings Goals Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Your Progress</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Goal Name</th>
                            <th>Target Amount (₹)</th>
                            <th>Amount Saved (₹)</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($savings_goals)): ?>
                            <?php foreach ($savings_goals as $goal): ?>
                                <?php 
                                    $progress = ($goal['amount_saved'] / $goal['target_amount']) * 100;
                                    $progress = round($progress, 2);
                                ?>
                                <tr>
                                    <td><?php echo $goal['goal_name']; ?></td>
                                    <td>₹<?php echo number_format($goal['target_amount'], 2); ?></td>
                                    <td>₹<?php echo number_format($goal['amount_saved'], 2); ?></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $progress; ?>%" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $progress; ?>%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Edit Goal Button (Not implemented here) -->
                                        <a href="edit-goal.php?id=<?php echo $goal['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No savings goals found. Create one now!</td></tr>
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
