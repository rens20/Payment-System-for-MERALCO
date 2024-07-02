<?php
session_start();
require_once(__DIR__ . '/../config/configuration.php');
require_once __DIR__ . '/../config/configuration.php';


function insertPowerConsumption($userId, $date, $consumption) {
    global $conn;
    $sql = "INSERT INTO power_consumption (user_id, date, consumption_kwh) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isd", $userId, $date, $consumption);
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

function getMonthlyConsumption($userId, $month, $year) {
    global $conn;
    $sql = "SELECT SUM(consumption_kwh) AS total_consumption FROM power_consumption WHERE user_id = ? AND MONTH(date) = ? AND YEAR(date) = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iii", $userId, $month, $year);
        $stmt->execute();
        $stmt->bind_result($totalConsumption);
        $stmt->fetch();
        $stmt->close();
        return $totalConsumption;
    } else {
        return null;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => ''];

    if (isset($_POST['type']) && $_POST['type'] === 'insert') {
        $date = $_POST['date'];
        $consumption = $_POST['consumption'];
        $userId = 1; // Example user ID, replace with session user ID in real application

        if (insertPowerConsumption($userId, $date, $consumption)) {
            $response['success'] = true;
            $response['message'] = 'Data inserted successfully.';
        } else {
            $response['message'] = 'Failed to insert data.';
        }
    }

    if (isset($_POST['type']) && $_POST['type'] === 'retrieve') {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $userId = 1; // Example user ID, replace with session user ID in real application

        $totalConsumption = getMonthlyConsumption($userId, $month, $year);
        if ($totalConsumption !== null) {
            $response['success'] = true;
            $response['message'] = "Total consumption for $month/$year: " . $totalConsumption . " kWh";
        } else {
            $response['message'] = 'Failed to retrieve data.';
        }
    }

    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Consumption Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Power Consumption Calculator</h1>
        <form id="consumptionForm" class="mb-6">
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" id="date" name="date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="consumption" class="block text-gray-700">Consumption (kWh)</label>
                <input type="number" step="0.01" id="consumption" name="consumption" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
        </form>

        <form id="monthlyConsumptionForm">
            <div class="mb-4">
                <label for="month" class="block text-gray-700">Month</label>
                <input type="number" id="month" name="month" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" min="1" max="12">
            </div>
            <div class="mb-4">
                <label for="year" class="block text-gray-700">Year</label>
                <input type="number" id="year" name="year" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" min="2000" max="2100">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Get Monthly Consumption</button>
        </form>
        <div id="monthlyConsumptionResult" class="mt-4 text-center"></div>
    </div>

    <script>
        document.getElementById('consumptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const date = document.getElementById('date').value;
            const consumption = document.getElementById('consumption').value;

            fetch('power-consumption.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `type=insert&date=${date}&consumption=${consumption}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('monthlyConsumptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;

            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `type=retrieve&month=${month}&year=${year}`
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('monthlyConsumptionResult').textContent = data.message;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
