<?
session_start();
if (isset($_GET['productId'])) {
    $ProductId = $_GET['productId'];
    unset($_SESSION['cart_Total'][$ProductId]);
    header("Location: index.php");
    exit;
}
