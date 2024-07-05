<?php
session_start();
require_once(__DIR__ . '/../config/configuration.php');

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

$user_name = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="bg-gray-100 p-8">
    <header class="mb-8">
        <nav class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <img src="./image/images.png" alt="Power Consumption Calculator" class="h-14 w-18 mr-5">
                <div>
                    <a href="power-consumption.php" class="bg text-white px-4 py-2 rounded-lg">Home</a>
                    <form action="logout.php" method="POST" class="inline">
                        <button type="submit" class="bg text-white px-4 py-2 rounded-lg">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Meralco Contact Information</h1>
         <h2 class="text-xl font-semibold mt-8 mb-2">Common Customer Problems:</h2>
        <ul class="list-disc list-inside">
            <li>Billing Issues: Customers may encounter discrepancies in their bills. Meralco provides detailed billing information and assistance through their hotline and customer service centers.</li>
            <li>Power Interruptions: Unexpected power outages can occur. Meralco offers updates and solutions through their website, social media, and customer service.</li>
            <li>New Connections: Setting up a new connection or transferring an existing one can be complex. Meralco assists with step-by-step guidance and required documentation.</li>
            <li>Payment Concerns: Various payment options are available, and customers can seek help regarding payment methods, deadlines, and account balance inquiries.</li>
            <li>Service Requests: Customers can request services like meter relocations, repairs, and maintenance through Meralco's customer service channels.</li>
        </ul>
        
        <h2 class="text-xl font-semibold mt-8 mb-2">How Meralco Addresses These Issues:</h2>
        <ul class="list-disc list-inside">
            <li>24/7 Customer Support: Meralco offers round-the-clock support through their hotline 16211 and online platforms.</li>
            <li>Online Services: Many issues can be resolved through Meralco's online portal and mobile app, providing convenience and efficiency.</li>
            <li>Timely Updates: Meralco keeps customers informed about power interruptions, maintenance schedules, and other important updates through SMS, email, and social media.</li>
            <li>Flexible Payment Options: Multiple payment methods, including online payments, ensure customers can easily settle their bills.</li>
            <li>In-Person Assistance: For more complex issues, customers can visit Meralco branches where trained staff provide personalized assistance.</li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">Branches in Metro Manila:</h2>
        <ul class="list-disc list-inside">
            <li>Pasig - Ortigas Center</li>
            <li>Quezon City - Commonwealth Avenue</li>
            <li>Manila - Ermita</li>
            <li>Makati - Ayala Avenue</li>
            <li>Pasay - EDSA Extension</li>
            <li>Taguig - Bonifacio Global City</li>
            <li>Marikina - Marcos Highway</li>
            <li>Pasig - Kapitolyo</li>
            <li>Quezon City - Timog Avenue</li>
            <li>Manila - Binondo</li>
            <li>Makati - Poblacion</li>
            <li>Pasay - Malibay</li>
            <li>Taguig - FTI Complex</li>
            <li>Marikina - J.P. Rizal</li>
            <li>San Juan - Greenhills</li>
            <li>Parañaque - BF Homes</li>
            <li>Muntinlupa - Alabang</li>
            <li>Las Piñas - Alabang-Zapote Road</li>
            <li>Valenzuela - MacArthur Highway</li>
            <li>Malabon - Longos</li>
            <li>Navotas - C4 Road</li>
            <li>Caloocan - Monumento</li>
            <li>Caloocan - Grace Park</li>
            <li>Manila - Sampaloc</li>
            <li>Quezon City - Novaliches</li>
            <li>Quezon City - Cubao</li>
            <li>Pasig - Rosario</li>
            <li>Quezon City - Eastwood</li>
            <li>Manila - Sta. Cruz</li>
            <li>Makati - Magallanes</li>
            <li>Pasay - Taft Avenue</li>
        </ul>
    </div>

    <footer class="mt-8 text-center">
        <p class="text font-bold">&copy; 2024 Meralco. All rights reserved.</p>
    </footer>
</body>
</html>
