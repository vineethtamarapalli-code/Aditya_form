<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "student_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, studentName, email, course, resume FROM students ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f8fc;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        a.btn {
            padding: 6px 12px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <h2>Registered Students</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Resume</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['studentName']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['course']}</td>
                        <td><a class='btn' href='uploads/{$row['resume']}' target='_blank'>View Resume</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No students registered yet.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>

