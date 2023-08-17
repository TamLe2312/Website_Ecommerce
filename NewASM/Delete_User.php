<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('./provider.php');
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $statement1 = $connection->prepare("DELETE FROM users where username = :username");
    if ($statement1->execute([
        ':username' => $username
    ])) {
        header('location: ./Account_List.php');
        exit;
    }
}
