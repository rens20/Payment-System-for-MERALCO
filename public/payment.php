<?php
session_start();
require_once(__DIR__ . '/../config/configuration.php');
require_once(__DIR__ . '/../config/validation.php');
require_once(__DIR__ . '/../vendor/autoload.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay'])) {
    $user_name = $_SESSION['user_name'];
    $totalBill = $_SESSION['totalBill'];
    $amountPaid = $_POST['amount_paid'];
    $creditCard = $_POST['credit_card'];
    
    if ($amountPaid < $totalBill) {
        $message = "Insufficient amount paid. Please pay at least the total bill amount.";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: '$message',
                      showConfirmButton: true
                    });
                });
              </script>";
    } else {
        $change = $amountPaid - $totalBill;

        // Save payment details in session
        $_SESSION['amountPaid'] = $amountPaid;

        // Insert payment details into database
        $sql = "INSERT INTO payments (user_name, totalBill, amountPaid, changeAmount) 
                VALUES ('$user_name', $totalBill, $amountPaid, $change)";
        if ($conn->query($sql) === TRUE) {
            // Success message and redirection to generate receipt
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                          icon: 'success',
                          title: 'Payment Successful!',
                          text: 'Your payment was successful. Your receipt will be downloaded shortly.',
                          showConfirmButton: false,
                          timer: 3000 
                        }).then(() => {
                            window.location.href = 'generate_receipt.php';
                            setTimeout(() => {
                            window.location.href = 'power-consumption.php';
                       },3000);
                        });
                    });
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Payment</h1>
        <form method="POST" class="mb-6">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo $_SESSION['user_name']; ?>" readonly>
            </div>
            <div class="mb-4">
                <label for="total_bill" class="block text-gray-700">Total Bill (PHP)</label>
                <input type="text" id="total_bill" name="total_bill" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="<?php echo number_format($_SESSION['totalBill'], 2); ?>" readonly>
            </div>
            <div class="mb-4">
                <label for="amount_paid" class="block text-gray-700">Amount to Pay (PHP)</label>
                <input type="number" step="0.01" id="amount_paid" name="amount_paid" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="credit_card" class="block text-gray-700">Credit Card Number</label>
                <input type="text" id="credit_card" name="credit_card" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" name="pay" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Pay</button>
        </form>
    </div>
</body>
</html>
