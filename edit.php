<?php
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch();

if (!$employee) {
    die("Employee not found.");
}

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
            "UPDATE employees
             SET name = ?, email = ?, phone = ?, department = ?, salary = ?, joining_date = ?
             WHERE id = ?"
        );
        $stmt->execute([$name, $email, $phone, $department, $salary, $joining_date, $id]);

        header("Location: index.php?msg=updated");
        exit;
    }

    $employee = array_merge($employee, [
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "department" => $department,
        "salary" => $salary,
        "joining_date" => $joining_date
    ]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small-container">
    <div class="form-card">
        <h1>Edit Employee</h1>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Employee Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($employee['email']) ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($employee['phone']) ?>" required>

            <label>Department</label>
            <select name="department" required>
                <?php
                $departments = ["HR", "IT", "Finance", "Sales", "Marketing", "Operations"];
                foreach ($departments as $dept):
                ?>
                    <option value="<?= $dept ?>" <?= ($employee['department'] === $dept) ? 'selected' : '' ?>>
                        <?= $dept ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Salary</label>
            <input type="number" name="salary" step="0.01" min="0"
                   value="<?= htmlspecialchars($employee['salary']) ?>" required>

            <label>Joining Date</label>
            <input type="date" name="joining_date"
                   value="<?= htmlspecialchars($employee['joining_date']) ?>" required>

            <div class="form-actions">
                <button class="btn" type="submit">Update Employee</button>
                <a class="btn secondary" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
