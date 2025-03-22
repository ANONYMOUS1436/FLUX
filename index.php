
<?php
include 'connection.php';
// Get form data


if(isset($_POST['submit'])){
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
    echo "<script>alert('Crime report submitted successfully!'); window.location.href='index.php?id=';</script>";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            background-image: url('https://www.ppic.org/wp-content/uploads/crime-scene-tape-and-police-car-at-night.jpg');
        }

        header {
            color: rgb(241, 236, 236);
            background-color: rgb(42, 10, 10);
        }
    </style>
</head>

<body class="bg-gray-900 text-white font-sans">
    <header class="bg-gradient-to-r from-red-600 to-red-900 py-8 text-center shadow-lg">
        <h1 class="text-4xl font-bold">Crime Report</h1>
        <p class="mt-2 text-lg">Help keep your community safe by reporting crimes.</p>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-2xl">
        <h2 class="text-2xl font-semibold mb-6">Report a Crime</h2>
        <form id="crimeReportForm" class="space-y-4" method="POST">
            <div>
                <label for="crimeType" class="block text-sm font-medium mb-1">Crime Type:</label>
                <select id="crimeType" name="crimeType" class="w-full p-2 rounded bg-gray-800 border border-gray-700" required>
                    <option value="theft">Theft</option>
                    <option value="burglary">Burglary</option>
                    <option value="vandalism">Vandalism</option>
                    <option value="assault">Assault</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium mb-1">Location:</label>
                <input type="text" id="location" name="location" readonly class="w-full p-2 rounded bg-gray-800 border border-gray-700">
            </div>

            <div>
                <label for="city" class="block text-sm font-medium mb-1">City:</label>
                <input type="text" id="city" name="city" readonly class="w-full p-2 rounded bg-gray-800 border border-gray-700">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium mb-1">Description:</label>
                <textarea id="description" name="description" required class="w-full p-2 rounded bg-gray-800 border border-gray-700" rows="4"></textarea>
            </div>

            <div>
                <label for="mobile" class="block text-sm font-medium mb-1">Mobile Number (Required):</label>
                <input type="tel" id="mobile" name="mobile" required class="w-full p-2 rounded bg-gray-800 border border-gray-700">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email ID (Optional):</label>
                <input type="email" id="email" name="email" class="w-full p-2 rounded bg-gray-800 border border-gray-700">
            </div>

            <button type="submit" name="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded transition duration-300">
                Report Crimes
            </button>
        </form>

        <div class="mt-6 flex space-x-4">
            <button onclick="window.location.href='view_reports.php'" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded transition duration-300">View Reports</button>
        </div>

        <div id="map" class="mt-6 h-64 rounded-lg shadow-lg"></div>
    </main>

    <script>
        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async position => {
                    const userLocation = [position.coords.latitude, position.coords.longitude];
                    document.getElementById("location").value = userLocation.join(", ");

                    let map = L.map('map').setView(userLocation, 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    L.marker(userLocation).addTo(map).bindPopup("Your Location").openPopup();

                    try {
                        const response = await axios.get(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLocation[0]}&lon=${userLocation[1]}`);
                        const address = response.data.address;
                        const city = address.city || address.town || address.village || address.county || "Unknown";
                        document.getElementById("city").value = city;




                    } catch (error) {
                        console.error("Error fetching city:", error);
                        document.getElementById("city").value = "Unknown";
                    }
                }, error => {
                    console.error("Error fetching location:", error);
                    alert("Unable to fetch your location. Please enable location access.");
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }

        initMap();
        

        // function submitReport(){
        //     const crime_type=document.getElementById("crimeType").value;
        //     console.log(crime_type);
        // }
    </script>
</body>
</html>
