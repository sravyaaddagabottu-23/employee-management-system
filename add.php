<?php
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $department = trim($_POST["department"] ?? "");
    $salary = trim($_POST["salary"] ?? "");
    $joining_date = $_POST["joining_date"] ?? "";

    if ($name === "" || $email === "" || $phone === "" || $department === "" || $salary === "" || $joining_date === "") {
        $error = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!is_numeric($salary) || $salary < 0) {
        $error = "Please enter a valid salary.";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO employees (name, email, phone, department, salary, joining_date)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $email, $phone, $department, $salary, $joining_date]);

        header("Location: index.php?msg=added");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small-container">
    <div class="form-card">
        <h1>Add Employee</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Employee Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>

            <label>Department</label>
            <select name="department" required>
                <option value="">Select Department</option>
                <?php
                $departments = ["HR", "IT", "Finance", "Sales", "Marketing", "Operations"];
                foreach ($departments as $dept):
                ?>
                    <option value="<?= $dept ?>" <?= (($_POST['department'] ?? '') === $dept) ? 'selected' : '' ?>>
                        <?= $dept ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Salary</label>
            <input type="number" name="salary" step="0.01" min="0"
                   value="<?= htmlspecialchars($_POST['salary'] ?? '') ?>" required>

            <label>Joining Date</label>
            <input type="date" name="joining_date"
                   value="<?= htmlspecialchars($_POST['joining_date'] ?? '') ?>" required>

            <div class="form-actions">
                <button class="btn" type="submit">Save Employee</button>
                <a class="btn secondary" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
