<?php
// Database connection
$host = "localhost";
$user = "root"; // default in XAMPP
$pass = "";     // leave empty unless you set password
$db   = "student_db";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['studentName'];
    $sucCode = $_POST['sucCode'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $section = $_POST['section'];
    $course = $_POST['course'];
    $major = $_POST['major'];
    $minor = !empty($_POST['minor']) ? $_POST['minor'] : NULL;
    $collegeLocation = $_POST['collegeLocation'];

    // File upload handling
    $resume = $_FILES['resume']['name'];
    $resume_tmp = $_FILES['resume']['tmp_name'];
    $resume_folder = "uploads/" . basename($resume);

    // Validate file upload
    $allowed_ext = ['pdf', 'doc', 'docx'];
    $file_ext = strtolower(pathinfo($resume, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        die("❌ Invalid file type. Only PDF, DOC, DOCX allowed.");
    }

    if ($_FILES['resume']['size'] > 5 * 1024 * 1024) {
        die("❌ File size too large. Max 5MB allowed.");
    }

    // Move uploaded file
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }
    move_uploaded_file($resume_tmp, $resume_folder);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO students 
        (studentName, sucCode, email, phone, section, course, major, minor, collegeLocation, resume) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $studentName, $sucCode, $email, $phone, $section, $course, $major, $minor, $collegeLocation, $resume);

    if ($stmt->execute()) {
        echo "<h3>✅ Registration Successful!</h3>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
