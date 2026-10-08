CREATE DATABASE IF NOT EXISTS employee_management;
USE employee_management;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    department VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    joining_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO employees (name, email, phone, department, salary, joining_date)
VALUES
('Rahul Kumar', 'rahul@example.com', '9876543210', 'IT', 45000.00, '2025-06-10'),
('Priya Sharma', 'priya@example.com', '9876501234', 'HR', 40000.00, '2025-07-15'),
('Arun Kumar', 'arun@example.com', '9876512345', 'Finance', 50000.00, '2025-08-01');
