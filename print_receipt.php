<?php
if (!isset($_SESSION)) session_start();
include "../config.php";
include "../includes/navbar.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];
    $contact = $_POST['contact'];
    $items = $_POST['items'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("INSERT INTO receipts (customer_name, customer_address, contact, items, amount, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssd", $customer_name, $customer_address, $contact, $items, $amount);

    // if ($stmt->execute()) {
    //     $message = "Receipt saved successfully!";
    // } else {
    //     $error = "Error saving receipt.";
    // }
    if ($stmt->execute()) {
        $last_id = $stmt->insert_id;
        header("Location: invoice.php?id=$last_id");
        exit;
    } else {
        $error = "Error saving receipt.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Print Receipt - Applied Computer Technology</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Print Receipt</h2>
        <form method="post">
            <input type="text" name="customer_name" placeholder="Customer Name" required><br>
            <textarea name="customer_address" placeholder="Customer Address" required></textarea><br>
            <input type="number" name="contact" placeholder="Contact Number" required><br>
            <textarea name="items" placeholder="Item Details (e.g., 2x USB Cable, 1x Charger)" required></textarea><br>
            <input type="number" step="0.01" name="amount" placeholder="Total Amount" required><br>
            <button type="submit">Save Receipt</button>
        </form>
        <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
        <?php if (isset($receipt)) : ?>
            <div style="border: 1px solid #ccc; padding: 15px; margin-top: 20px;">
                <h3>Receipt Preview</h3>
                <p><strong>Customer Name:</strong> <?= htmlspecialchars($receipt['customer_name']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($receipt['customer_address']) ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($receipt['contact']) ?></p>
                <p><strong>Items:</strong> <?= nl2br(htmlspecialchars($receipt['items'])) ?></p>
                <p><strong>Amount:</strong> ₹<?= htmlspecialchars($receipt['amount']) ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($receipt['created_at']) ?></p>
            </div>
        <?php endif; ?>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>

</html>