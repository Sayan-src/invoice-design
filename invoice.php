<?php
if (!isset($_SESSION)) session_start();
include "../config.php";

if (!isset($_GET['id'])) {
    die("No invoice ID provided.");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM receipts WHERE id = $id");

if (!$result || $result->num_rows === 0) {
    die("Invoice not found.");
}

$receipt = $result->fetch_assoc();

$company = [
    'name' => 'Applied Computer Technology',
    'address' => '24/4, Feeder Rd, Adarsha Pally, Belghoria, Kolkata, West Bengal 700056',
    'phone' => '082401 20380',
    'email' => 'act2robo@gmail.com',
    'website' => 'actsoft.org'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Invoice #<?= htmlspecialchars($receipt['id']) ?> - <?= htmlspecialchars($company['name']) ?></title>
    <link rel="stylesheet" href="../styles/style.css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            padding: 30px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }

        .logo {
            height: 60px;
            margin-right: 20px;
        }

        .company-title {
            display: flex;
            align-items: center;
        }

        .company-name {
            font-size: 25px;
            font-weight: bold;
            margin-right: 30px;
        }

        .invoice-info {
            text-align: right;
        }

        .section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .box {
            width: 48%;
        }

        h3 {
            margin-bottom: 10px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .total-row {
            font-weight: 700;
            background-color: #f9f9f9;
        }

        .print-button {
            display: inline-block;
            background-color: #1a73e8;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .print-button:hover {
            background-color: #155ab6;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <div class="company-title">
                <img src="../assets/act.jpg" alt="Company Logo" class="logo">
                <div class="company-name">Applied Computer Technology</div>
            </div>
            <div class="invoice-info">
                <div class="invoice-title">INVOICE</div>
                <div>Invoice #: <?= htmlspecialchars($receipt['id']) ?></div>
                <div>Date: <?= date("d M, Y", strtotime($receipt['created_at'])) ?></div>
            </div>
        </div>

        <div class="section">
            <div class="box">
                <h3>Billed To:</h3>
                <p>
                    <strong><?= htmlspecialchars($receipt['customer_name']) ?></strong><br />
                    Address: <?= htmlspecialchars($receipt['customer_address']) ?><br />
                    Contact: <?= htmlspecialchars($receipt['contact']) ?>
                </p>
            </div>

            <div class="box">
                <h3>From:</h3>
                <p>
                    <strong><?= htmlspecialchars($company['name']) ?></strong><br />
                    <?= nl2br(htmlspecialchars($company['address'])) ?><br />
                    Phone: <?= htmlspecialchars($company['phone']) ?><br />
                    Email: <?= htmlspecialchars($company['email']) ?><br />
                    Website: <?= htmlspecialchars($company['website']) ?>
                </p>
            </div>
        </div>

        <div class="items-section">
            <h3>Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price (₹)</th>
                        <th>Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $items_list = explode(',', $receipt['items']);
                    foreach ($items_list as $item_str) {
                        $item_str = trim($item_str);
                        if (preg_match('/(\d+)x\s+(.*)/i', $item_str, $matches)) {
                            $qty = intval($matches[1]);
                            $desc = $matches[2];
                        } else {
                            $qty = 1;
                            $desc = $item_str;
                        }
                        $unit_price = number_format($receipt['amount'] / count($items_list), 2);
                        $line_total = $qty * $unit_price;
                        echo "<tr>
                                <td>" . htmlspecialchars($desc) . "</td>
                                <td>$qty</td>
                                <td>$unit_price</td> 
                                <td>" . number_format($line_total, 2) . "</td>
                            </tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" style="text-align:right;">Grand Total</td>
                        <td>₹<?= number_format($receipt['amount'], 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="notes">
            <strong>Notes:</strong><br />
            Thank you for your business! Please make the payment by the due date.
        </div>

        <button class="print-button" onclick="window.print()">Print Invoice</button>
    </div>
</body>

</html>