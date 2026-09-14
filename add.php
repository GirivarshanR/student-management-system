<?php
include "db.php";

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $date_of_birth = $_POST["date_of_birth"];
    $course = $_POST["course"];
    $department = $_POST["department"];
    $address = $_POST["address"];

    if (
        empty($name) ||
        empty($email) ||
        empty($phone) ||
        empty($date_of_birth) ||
        empty($course) ||
        empty($department) ||
        empty($address)
    ) {
        echo "Please fill in all fields.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please enter a valid email address.";
    }
    elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        echo "Please enter a valid phone number.";
    }
    else {
        $checkEmail = "SELECT * FROM students WHERE email = ?";
        $stmt = $conn->prepare($checkEmail);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $emailResult = $stmt->get_result();

        if ($emailResult->num_rows > 0) {
            echo "This email is already registered.";
        }
        else {
            $sql = "INSERT INTO students
                    (name, email, phone, date_of_birth, course, department, address)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssssss",
                $name,
                $email,
                $phone,
                $date_of_birth,
                $course,
                $department,
                $address
            );

            if ($stmt->execute()) {
                echo "Student added successfully!";
            }
            else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body>
<div class="container mt-5">
    <h1>Add Student</h1>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input
                type="text"
                name="phone"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input
                type="date"
                name="date_of_birth"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Course</label>
            <input
                type="text"
                name="course"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Department</label>
            <input
                type="text"
                name="department"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea
                name="address"
                class="form-control"
            ></textarea>
        </div>
        <button
            type="submit"
            name="submit"
            class="btn btn-primary"
        >
            Add Student
        </button>
        <a
            href="index.php"
            class="btn btn-secondary"
        >
            Back
        </a>
    </form>
</div>
</body>
</html>