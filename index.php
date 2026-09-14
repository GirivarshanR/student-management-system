<?php
include "db.php";
$sql = "SELECT COUNT(*) AS total FROM students";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
$totalStudents = $data["total"];
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Management System</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                Student Management System
            </a>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <p>Welcome to the Student Management System.</p>
        <div class="card mb-4">
            <div class="card-body">
                <h5>Total Students</h5>
                <h2>
                    <?php echo $totalStudents; ?>
                </h2>
            </div>
        </div>
        <a href="add.php" class="btn btn-primary mb-4">
            Add Student
        </a>
        <h2>Student List</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date of Birth</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $number = 1;
                    while ($student = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $number; ?>
                            </td>
                            <td>
                                <?php echo $student["name"]; ?>
                            </td>

                            <td>
                                <?php echo $student["email"]; ?>
                            </td>

                            <td>
                                <?php echo $student["phone"]; ?>
                            </td>

                            <td>
                                <?php echo $student["date_of_birth"]; ?>
                            </td>

                            <td>
                                <?php echo $student["course"]; ?>
                            </td>

                            <td>
                                <?php echo $student["department"]; ?>
                            </td>

                            <td>
                                <?php echo $student["address"]; ?>
                            </td>
                            <td>
                                <a
                                    href="edit.php?id=<?php echo $student["id"]; ?>"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>
                                <a
                                    href="delete.php?id=<?php echo $student["id"]; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this student?');"
                                >
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php
$number++;
}

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>