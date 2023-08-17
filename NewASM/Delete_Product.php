<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('./provider.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $image = $_GET['image'];
    $sql = "DELETE FROM products where productId = :id";
    $statement1 = $connection->prepare($sql);
    $dir = "uploads";
    $dirHandle = opendir($dir);
    while ($file = readdir($dirHandle)) {
        if ($file == $image) {
            unlink($dir . "/" . $file); //give correct path,
        }
    }
    closedir($dirHandle);
    if ($statement1->execute([
        ':id' => $id
    ])) {
        header('location: ./Products.php');
        exit;
    }
}
