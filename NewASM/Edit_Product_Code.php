<?
session_start();
if (!isset($_SESSION['errorsEdit'])) {
    $_SESSION['errorsEdit'] = [];
}
require('./provider.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['productName']) &&
        isset($_POST['productDescription']) &&
        isset($_POST['price']) &&
        isset($_POST['status']) &&
        isset($_POST['category'])
    ) {
        $productId = trim(htmlspecialchars($_POST['productId']));
        $productName = trim(htmlspecialchars($_POST['productName']));
        $productDescription = trim(htmlspecialchars($_POST['productDescription']));
        $price = trim(htmlspecialchars($_POST['price']));
        $sale = trim(htmlspecialchars($_POST['sale']));
        $status = trim(htmlspecialchars($_POST['status']));
        $category_id = trim(htmlspecialchars($_POST['category']));
        $imageDelete = trim(htmlspecialchars($_POST['imageDelete']));
        $image = "";
        if (!isset($productId) || !isset($productName) || !isset($productDescription) || !isset($price) || !isset($sale) || !isset($status) || !isset($category_id)) {
            $_SESSION['errorsEdit'][] = "All fields must be filled";
            header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
            exit;
        }
        if (!is_numeric($price)) {
            $_SESSION['errorsEdit'][] = "Price must be number";
            header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
            exit;
        }
        if (intval($sale) < 0 || intval($sale) > 100) {
            $_SESSION['errorsEdit'][] = "Sale must be from 0 - 100 %";
            header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
            exit;
        }
        if (isset($_FILES['image'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check == false) {
                $_SESSION['errorsEdit'][] = "File is not an image.";
                $uploadOk = 0;
                header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
                exit;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $dir = "uploads";
                $dirHandle = opendir($dir);
                while ($file = readdir($dirHandle)) {
                    if ($file == $_FILES["image"]["name"]) {
                        unlink($dir . "/" . $file);
                    }
                }
            }
            // Check file size
            if ($_FILES["image"]["size"] > 500000) {
                $_SESSION['errorsEdit'][] = "Size too large";
                $uploadOk = 0;
                header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
                exit;
            }
            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $_SESSION['errorsEdit'][] = "Type image not supported";
                $uploadOk = 0;
                header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
                exit;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['errorsEdit'][] = "Image Invalid";
                header("location : ./Edit_Product.php?productId=$productId&image=$imageDelete&productName=$productName&description=$productDescription&price=$price&sale=$sale&status=$status&categoryId=$category_id");
                exit;
            }
        }
        if (isset($connection) && count($_SESSION['errorsEdit']) < 1) {
            try {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = htmlspecialchars(basename($_FILES["image"]["name"]));
                    $dir = "uploads";
                    $dirHandle = opendir($dir);
                    while ($file = readdir($dirHandle)) {
                        if ($file == $imageDelete) {
                            unlink($dir . "/" . $file);
                        }
                    }
                    $sql1 = "UPDATE products SET productName = :name,description = :description,price = :price,image = :image,sale = :sale,status = :status,categoryId = :categoryId where productId = :id";
                    $statement1 = $connection->prepare($sql1);
                    if ($statement1->execute([
                        ':id' => $productId,
                        ':name' => $productName,
                        ':description' => $productDescription,
                        ':price' => $price,
                        ':image' => $image,
                        ':sale' => $sale,
                        ':status' => $status,
                        ':categoryId' => $category_id,
                    ])) {
                        $_SESSION['EditSuccess'] = "Update Succes";
                        header("location: ./Products.php");
                    }
                }
            } catch (Exception $err) {
                echo $err->getMessage();
            }
        }
    }
}
