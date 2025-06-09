<?php
// Email function to send notifications
function sendEmail($subject, $message, $to) {
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($to, $subject, $message, $headers);
}

// Check for upcoming recurring expenses and send email
function checkRecurringExpensesEmail() {
    include('db.php');

    // Fetch recurring expenses
    $sql = "SELECT name, amount, next_occurrence, user_email FROM expenses JOIN users ON expenses.user_id = users.id WHERE recurrence IS NOT NULL AND next_occurrence <= CURDATE() + INTERVAL 1 DAY";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subject = "Reminder: Recurring Expense Due";
            $message = "Dear User,<br><br>Your recurring expense for '{$row['name']}' (₹{$row['amount']}) is due on {$row['next_occurrence']}. Please ensure you are prepared.<br><br>Regards,<br>Personal Finance Tracker";
            sendEmail($subject, $message, $row['user_email']);
        }
    }

    $conn->close();
}

// Check budget status and send email alerts
function checkBudgetStatusEmail() {
    include('db.php');

    // Fetch the budget and expenses
    $sql = "SELECT category, SUM(amount) as total_spent, budget_amount, user_email FROM expenses JOIN budgets ON expenses.category = budgets.category JOIN users ON expenses.user_id = users.id GROUP BY category";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['total_spent'] > $row['budget_amount']) {
                $subject = "Alert: Budget Exceeded";
                $message = "Dear User,<br><br>You have exceeded your budget for the category '{$row['category']}' by ₹" . ($row['total_spent'] - $row['budget_amount']) . ". Please review your spending.<br><br>Regards,<br>Personal Finance Tracker";
                sendEmail($subject, $message, $row['user_email']);
            } elseif ($row['total_spent'] >= $row['budget_amount'] * 0.9) {
                $subject = "Reminder: Nearing Budget Limit";
                $message = "Dear User,<br><br>You are nearing your budget for '{$row['category']}' with ₹" . ($row['total_spent']) . " spent out of ₹" . ($row['budget_amount']) . ".<br><br>Regards,<br>Personal Finance Tracker";
                sendEmail($subject, $message, $row['user_email']);
            }
        }
    }

    $conn->close();
}

// Call functions to send email notifications
checkRecurringExpensesEmail();
checkBudgetStatusEmail();
?>
