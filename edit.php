<?php
include "db.php";

$id = $_GET["id"];

$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$message = "";
$messageType = "";

$name = $student["name"];
$email = $student["email"];
$phone = $student["phone"];
$date_of_birth = $student["date_of_birth"];
$course = $student["course"];
$department = $student["department"];
$address = $student["address"];

if (isset($_POST["update"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $date_of_birth = $_POST["date_of_birth"];
    $course = trim($_POST["course"]);
    $department = trim($_POST["department"]);
    $address = trim($_POST["address"]);

    if (
        empty($name) ||
        empty($email) ||
        empty($phone) ||
        empty($date_of_birth) ||
        empty($course) ||
        empty($department) ||
        empty($address)
    ) {
        $message = "Please fill in all fields.";
        $messageType = "danger";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "danger";
    }
    elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $message = "Please enter a valid phone number.";
        $messageType = "danger";
    }
    else {
        $checkEmail = "SELECT * FROM students WHERE email = ? AND id != ?";
        $stmt = $conn->prepare($checkEmail);
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $emailResult = $stmt->get_result();

        if ($emailResult->num_rows > 0) {
            $message = "This email is already registered.";
            $messageType = "danger";
        }
        else {
            $sql = "UPDATE students SET
                    name = ?,
                    email = ?,
                    phone = ?,
                    date_of_birth = ?,
                    course = ?,
                    department = ?,
                    address = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssssssi",
                $name,
                $email,
                $phone,
                $date_of_birth,
                $course,
                $department,
                $address,
                $id
            );

            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            }
            else {
                $message = "Error: " . $stmt->error;
                $messageType = "danger";
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
    <title>Edit Student</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <div class="dashboard-card">
        <h1 class="mb-4">Edit Student</h1>
        <?php
        if (!empty($message)) {
            echo '<div class="alert alert-' . $messageType . '">' . htmlspecialchars($message) . '</div>';
        }
        ?>

        <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="<?php echo htmlspecialchars($name); ?>"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="text"
                name="email"
                class="form-control"
                value="<?php echo htmlspecialchars($email); ?>"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input
                type="text"
                name="phone"
                class="form-control"
                value="<?php echo htmlspecialchars($phone); ?>"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input
                type="date"
                name="date_of_birth"
                class="form-control"
                value="<?php echo htmlspecialchars($date_of_birth); ?>"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Course</label>
            <input
                type="text"
                name="course"
                class="form-control"
                value="<?php echo htmlspecialchars($course); ?>"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Department</label>
            <input
                type="text"
                name="department"
                class="form-control"
                value="<?php echo htmlspecialchars($department); ?>"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea
                name="address"
                class="form-control"
            ><?php echo htmlspecialchars($address); ?></textarea>
        </div>
        <button
            type="submit"
            name="update"
            class="btn btn-success"
        >
            Update Student
        </button>
        <a
            href="index.php"
            class="btn btn-secondary"
        >
            Back
        </a>
    </form>
    </div>
</div>
</body>
</html>