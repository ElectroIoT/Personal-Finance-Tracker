// Fetch Expenses and display in the list
window.onload = function () {
    fetchExpenses();
    displayExpenseGraph();
};

// Fetch the data from get-expenses.php and populate the list
function fetchExpenses() {
    fetch('php/get-expenses.php')
        .then(response => response.json())
        .then(data => {
            let expenseList = document.getElementById("expense-list");
            data.forEach(expense => {
                let expenseItem = document.createElement("div");
                expenseItem.innerText = `${expense.name} - ₹${expense.amount} (${expense.category})`;
                expenseList.appendChild(expenseItem);
            });
        });
}

// Display Expense Graph (using Chart.js)
function displayExpenseGraph() {
    const ctx = document.getElementById('expense-chart').getContext('2d');
    const chartData = {
        labels: ['Food', 'Transport', 'Entertainment'], // Categories
        datasets: [{
            label: 'Expenses',
            data: [150, 120, 90], // Example Data for Food, Transport, Entertainment
            backgroundColor: ['#FF5733', '#33C1FF', '#75FF33']
        }]
    };
    new Chart(ctx, {
        type: 'bar',
        data: chartData,
    });
}
