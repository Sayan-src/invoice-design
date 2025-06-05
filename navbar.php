<?php
if (!isset($_SESSION)) session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<style>
.navbar {
    background-color: #2c3e50;
    padding: 10px;
}
.navbar a {
    color: white;
    margin-right: 15px;
    text-decoration: none;
    font-weight: bold;
}
.navbar a:hover {
    text-decoration: underline;
}
</style>

<div class="navbar">
    <a href="/bill/dashboard.php">Dashboard</a>
<a href="/bill/pages/print_receipt.php">Print Receipt</a>
<a href="/bill/pages/invoice.php">Invoice</a>
<?php if ($role === 'admin'): ?>
    <a href="/bill/pages/accounts.php">Accounts</a>
<?php endif; ?>
<a href="/bill/logout.php">Logout</a>

</div>