<?php
session_start();
require_once(__DIR__ . '/../config/configuration.php');

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

$user_name = $_SESSION['user_name'];

// Fetch user transactions
$sql = "SELECT totalBill, amountPaid,paymentDate, changeAmount FROM payments WHERE user_name = '$user_name' ORDER BY paymentDate DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <header class="mb-8">
        <nav class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg">
            <div class="text-lg font-bold">Power Consumption</div>
            <div>
                <a href="power-consumption.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Home</a>
                <form action="logout.php" method="POST" class="inline">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</button>
                </form>
            </div>
        </nav>
    </header>
    
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Your Transactions</h1>
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Total Bill (PHP)</th>
                    <th class="border px-4 py-2">Amount Paid (PHP)</th>
                    <th class="border px-4 py-2">Change (PHP)</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . number_format($row['totalBill'], 2) . "</td>";
                        echo "<td class='border px-4 py-2'>" . number_format($row['amountPaid'], 2) . "</td>";
                        echo "<td class='border px-4 py-2'>" . number_format($row['changeAmount'], 2) . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row['paymentDate'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td class='border px-4 py-2' colspan='4'>No transactions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
