<?php
require_once "db.php";

$stmt = $pdo->query("SELECT * FROM employees ORDER BY id DESC");
$employees = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Employee Management System</h1>
            <p>Manage employee records easily</p>
        </div>
        <a class="btn" href="add.php">+ Add Employee</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="message">
            <?php
            $messages = [
                'added' => 'Employee added successfully.',
                'updated' => 'Employee updated successfully.',
                'deleted' => 'Employee deleted successfully.'
            ];
            echo htmlspecialchars($messages[$_GET['msg']] ?? 'Operation completed.');
            ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Salary</th>
                        <th>Joining Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($employees) > 0): ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?= htmlspecialchars($employee['id']) ?></td>
                            <td><?= htmlspecialchars($employee['name']) ?></td>
                            <td><?= htmlspecialchars($employee['email']) ?></td>
                            <td><?= htmlspecialchars($employee['phone']) ?></td>
                            <td><?= htmlspecialchars($employee['department']) ?></td>
                            <td>₹<?= number_format((float)$employee['salary'], 2) ?></td>
                            <td><?= htmlspecialchars($employee['joining_date']) ?></td>
                            <td class="actions">
                                <a class="edit" href="edit.php?id=<?= $employee['id'] ?>">Edit</a>
                                <a class="delete" href="delete.php?id=<?= $employee['id'] ?>"
                                   onclick="return confirm('Are you sure you want to delete this employee?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="empty">No employee records found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
