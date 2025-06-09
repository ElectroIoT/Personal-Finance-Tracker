<?php
// Include the database connection file
include('db.php');

// SQL query to fetch all expenses
$sql = "SELECT * FROM expenses";
$result = $conn->query($sql);

// Initialize an empty array to store expenses
$expenses = [];

// Check if there are results and store them in the array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $expenses[] = $row; // Add each row to the array
    }
} 

// Return the expenses as a JSON response
echo json_encode($expenses);

// Close the database connection
$conn->close();
?>
