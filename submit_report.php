<?php
include 'connection.php';
// Get form data
$crimeType = $_POST['crimeType'];
$location = $_POST['location'];
$city = $_POST['city'];
$description = $_POST['description'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];

// Insert into database
$sql = "INSERT INTO `crime_reports`(`crime_type`, `location`, `city`, `description`, `mobile`, `email`, `created_at`, `updated_at`)
 VALUES (?,?,?,?,?,?,NOW(),NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $crimeType, $location, $city, $description, $mobile, $email);

if ($stmt->execute()) {
    echo "<script>alert('Crime report submitted successfully!'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
