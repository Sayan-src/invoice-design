<?php
if (!isset($_SESSION)) session_start();
include "../config.php";
include "../includes/navbar.php";

// Fetch all receipts
$result = $conn->query("SELECT * FROM receipts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Receipts - Applied Computer Technology</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="receipt-container">
        <h2>All Receipts</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Items</th>
                <th>Amount (₹)</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= htmlspecialchars($row['contact']) ?></td>
                <td><?= htmlspecialchars($row['items']) ?></td>
                <td><?= number_format($row['amount'], 2) ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
