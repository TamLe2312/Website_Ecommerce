<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('./provider.php');
if (isset($_GET['username']) && isset($_GET['statementBan'])) {
    $username = $_GET['username'];
    $statementBan = $_GET['statementBan'];
    $sql = "UPDATE users SET ban_status = :statementBan WHERE username = :username";
    $statement1 = $connection->prepare($sql);
    if ($statement1->execute([
        ':statementBan' => $statementBan,
        ':username' => $username
    ])) {
        header('location: ./Account_List.php');
        exit;
    } else {
        header('location: ./404.php');
        exit;
    }
}
