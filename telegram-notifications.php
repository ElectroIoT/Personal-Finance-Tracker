<?php
// Telegram Bot Token and Chat ID
define('BOT_TOKEN', 'YOUR_BOT_API_TOKEN');  // Replace with your bot's API token
define('CHAT_ID', 'YOUR_CHAT_ID');  // Replace with your chat ID

// Function to send a message via Telegram Bot
function sendTelegramMessage($message) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage?chat_id=" . CHAT_ID . "&text=" . urlencode($message);
    file_get_contents($url);
}

// Check for upcoming recurring expenses
function checkRecurringExpenses() {
    include('db.php');

    // Get recurring expenses whose next occurrence is today or tomorrow
    $sql = "SELECT name, amount, next_occurrence FROM expenses WHERE recurrence IS NOT NULL AND next_occurrence <= CURDATE() + INTERVAL 1 DAY";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $message = "Reminder: Your recurring expense for '{$row['name']}' (₹{$row['amount']}) is due on {$row['next_occurrence']}.";
            sendTelegramMessage($message);
        }
    }

    $conn->close();
}

// Function to check budget status (budget alerts)
function checkBudgetStatus() {
    include('db.php');

    // Check if user is exceeding the budget
    $sql = "SELECT category, SUM(amount) as total_spent, budget_amount FROM expenses JOIN budgets ON expenses.category = budgets.category GROUP BY category";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['total_spent'] > $row['budget_amount']) {
                $message = "Alert: You have exceeded your budget for the category '{$row['category']}' by ₹" . ($row['total_spent'] - $row['budget_amount']);
                sendTelegramMessage($message);
            } elseif ($row['total_spent'] >= $row['budget_amount'] * 0.9) {
                $message = "Reminder: You are nearing your budget for '{$row['category']}' with ₹" . ($row['total_spent']) . " spent out of ₹" . ($row['budget_amount']);
                sendTelegramMessage($message);
            }
        }
    }

    $conn->close();
}

// Call functions to send reminders
checkRecurringExpenses();
checkBudgetStatus();
?>
