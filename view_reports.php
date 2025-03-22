<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crime_reports";

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reports from the database
$sql = "SELECT * FROM crime_reports ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Crime Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-6">Crime Reports</h1>
        <table class="min-w-full bg-gray-800 border border-gray-700">
            <thead>
                <tr>
                    <th class="py-2 px-4 border border-gray-700">ID</th>
                    <th class="py-2 px-4 border border-gray-700">Crime Type</th>
                    <th class="py-2 px-4 border border-gray-700">Location</th>
                    <th class="py-2 px-4 border border-gray-700">City</th>
                    <th class="py-2 px-4 border border-gray-700">Description</th>
                    <th class="py-2 px-4 border border-gray-700">Mobile</th>
                    <th class="py-2 px-4 border border-gray-700">Email</th>
                    <th class="py-2 px-4 border border-gray-700">Time Reported</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['id']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['crime_type']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['location']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['city']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['description']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['mobile']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['email']; ?></td>
                        <td class="py-2 px-4 border border-gray-700"><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
