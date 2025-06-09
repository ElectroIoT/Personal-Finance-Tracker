# Personal Finance Tracker 💰📊

A **web-based personal finance tracker** to help users manage their **expenses**, **budget**, **savings goals**, and **taxes**. This project includes several features, including **expense logging**, **budget management**, **tax calculation**, and **savings goal tracking**.

---

### **Features** ✨

- **Track Expenses** 💸  
  - Log and categorize your expenses for daily, weekly, or monthly tracking.
  
- **Set and Manage Budget** 📅  
  - Set a monthly budget and track your spending against it.

- **Savings Goals** 💡  
  - Create savings goals (e.g., vacation, emergency fund) and track your progress.

- **Tax Calculator** 🧾  
  - Calculate your estimated tax based on income and eligible expenses.
  
- **Tax Reports** 📑  
  - Generate and view your tax summary for filing.

- **Expense Categories** 🏷️  
  - Categorize your expenses (food, transportation, entertainment, etc.).

- **Recurring Expenses** 🔁  
  - Set expenses to recur monthly, weekly, or yearly.

- **Export Data** 📥  
  - Export your expenses and goals to **CSV**, **Excel**, or **JSON** format.

---

### **Project Structure** 📂

```bash
/Personal-Finance-Tracker
    /assets
        /css
            - bootstrap.min.css
        /js
            - chart.js
    /index.php            <-- Home page with budget display
    /expenses.php         <-- Expenses page to view and manage expenses
    /budget.php           <-- Budget page
    /set-budget.php       <-- Set budget page
    /add-expense.php      <-- Add expense page
    /tax-calculator.php   <-- Tax calculator page
    /tax-report.php       <-- Tax report page
    /view-goals.php       <-- View savings goals
    /add-goal.php         <-- Add new savings goal page
    /db.php               <-- Database connection file
    /README.md            <-- Project guide and documentation

  -- Users Table (for income and expenses)
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    income DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    expenses DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Expenses Table
CREATE TABLE expenses (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    category VARCHAR(255) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Budgets Table
CREATE TABLE budgets (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10, 2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Savings Goals Table
CREATE TABLE savings_goals (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    goal_name VARCHAR(255) NOT NULL,
    target_amount DECIMAL(10, 2) NOT NULL,
    amount_saved DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    user_id INT(11) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

# Personal Finance Tracker

A **web-based personal finance tracker** to help users manage their **expenses**, **budget**, **savings goals**, and **taxes**. This project includes several features, including **expense logging**, **budget management**, **tax calculation**, and **savings goal tracking**.

---

### How to Use the Personal Finance Tracker 📈

- **Log in to the Application 🔑**

  - After setting up the database and installing the project, visit `index.php`.
  - Create a new user account or log in with your existing credentials.

- **Track Your Expenses 📝**

  - Navigate to `expenses.php` to log and categorize your expenses.
  - View recent expenses and manage them as needed.

- **Set Your Budget 💰**

  - Go to `set-budget.php` to set your monthly budget.
  - Your budget will be displayed on the `index.php` page.

- **Track Savings Goals 🎯**

  - Visit `add-goal.php` to create new savings goals and set target amounts.
  - Track your progress in `view-goals.php`.

- **Calculate and View Your Taxes 🧾**

  - Use the `tax-calculator.php` to calculate your taxes based on your income and eligible expenses.
  - Generate a detailed tax report on `tax-report.php`.

- **Export Data 📊**

  - Export your expenses or savings data in CSV, Excel, or JSON formats for further analysis.

---

### Technologies Used ⚙️

- **Frontend**: HTML, CSS, Bootstrap (for styling and layout), JavaScript
- **Backend**: PHP (for server-side logic)
- **Database**: MySQL (for storing user data, expenses, budgets, and savings goals)
- **Libraries**:
  - **Chart.js** (for visualizing data in charts)
  - **Bootstrap** (for responsive design)

---

### **Installation Guide**

1. **Clone the Repository**

   ```bash
   git clone https://github.com/yourusername/Personal-Finance-Tracker.git
   cd Personal-Finance-Tracker
# Personal-Finance-Tracker
