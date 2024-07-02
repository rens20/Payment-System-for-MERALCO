<?php
session_start();
require_once(__DIR__ . '/../config/configuration.php');
require_once(__DIR__ . '/../config/validation.php');
// session_start();

function insertPowerConsumption($userId, $date, $consumption, $totalBill) {
    global $conn;
    $sql = "INSERT INTO power_consumption (user_id, date, consumption_kwh, total_bill) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isdd", $userId, $date, $consumption, $totalBill);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    } else {
        return false;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $userId = 1; // Replace with session user ID in real application
    $date = $_POST['date'];
    $consumption = $_POST['consumption'];
    $ratePerKwh = 12.0545; // Current rate per kWh in the Philippines
    $totalBill = $consumption * $ratePerKwh;

    if (insertPowerConsumption($userId, $date, $consumption, $totalBill)) {
        $message = "Your power consumption for $date: $consumption kWh. Total bill: PHP " . number_format($totalBill, 2);
        
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: '$message',
                      showConfirmButton: true
                    });
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Failed to insert data!',
                      showConfirmButton: true
                    });
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Consumption Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Power Consumption Calculator</h1>
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" id="date" name="date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="consumption" class="block text-gray-700">Consumption (kWh)</label>
                <input type="number" step="0.01" id="consumption" name="consumption" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" name="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Generate</button>
        </form>
    </div>
</body>
</html>