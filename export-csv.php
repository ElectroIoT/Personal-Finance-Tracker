<?php
include('db.php');

// Fetch all expenses from the database
$sql = "SELECT id, name, amount, category, subcategory, recurrence, next_occurrence, tags, notes, date FROM expenses";
$result = $conn->query($sql);

// Check if any data exists
if ($result->num_rows > 0) {
    // Set headers to force file download as CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="expenses.csv"');

    // Open PHP output stream
    $output = fopen('php://output', 'w');

    // Add column headers to CSV
    fputcsv($output, ['ID', 'Expense Name', 'Amount (₹)', 'Category', 'Subcategory', 'Recurrence', 'Next Occurrence', 'Tags', 'Notes', 'Date']);

    // Loop through rows and write them to the CSV file
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close the file pointer
    fclose($output);
} else {
    echo "<div class='alert alert-warning'>No data found for export.</div>";
}

$conn->close();
?>
