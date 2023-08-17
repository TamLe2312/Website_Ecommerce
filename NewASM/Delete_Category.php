<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('./provider.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $statement1 = $connection->prepare("DELETE FROM categories where categoryId = :id");
    if ($statement1->execute([
        ':id' => $id
    ])) {
        header('location: ./Categories.php');
        exit;
    }
}
