<?
session_start();
require('./provider.php');
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_GET['productId'])) {
    $ProductId = $_GET['productId'];
    if (isset($connection)) {
        $statement1 = $connection->prepare("SELECT * FROM products WHERE productId = :productId");
        $statement1->execute([
            ':productId' => $ProductId
        ]);
        $statement1->setFetchMode(PDO::FETCH_ASSOC);
        $Product = $statement1->fetchAll();
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $value) {
                if ($_SESSION['cart'][$id]['ProductId'] == $ProductId) {
                    $_SESSION['cart'][$id]['Quantity'] = $_SESSION['cart'][$id]['Quantity'] + 1;
                    header("Location: ./index.php");
                    die;
                }
            }
            foreach ($_SESSION['cart'] as $id => $value) {
                if ($_SESSION['cart'][$id]['ProductId'] != $ProductId) {
                    $NewArray = array(
                        'ProductId' => $Product[0]['productId'],
                        'Name' => $Product[0]['productName'],
                        'Price' => $Product[0]['price'],
                        'Quantity' => 1,
                        'Image' => $Product[0]['image'],
                        'Sale' => $Product[0]['sale'],
                        'Status' => $Product[0]['status']
                    );
                    $_SESSION['cart'][$ProductId] = $NewArray;
                    header("Location: ./index.php");
                    die;
                }
            }
        } else {
            $NewArray = array(
                'ProductId' => $Product[0]['productId'],
                'Name' => $Product[0]['productName'],
                'Price' => $Product[0]['price'],
                'Quantity' => 1,
                'Image' => $Product[0]['image'],
                'Sale' => $Product[0]['sale'],
                'Status' => $Product[0]['status']
            );
            $_SESSION['cart'][$ProductId] = $NewArray;
            header("Location: ./index.php");
            die;
        }
    }
}
/* if (isset($_GET['productId'])) {
    $ProductId = $_GET['productId'];
    if (isset($connection)) {
        $statement1 = $connection->prepare("SELECT * FROM products WHERE productId = :productId");
        $statement1->execute([
            ':productId' => $ProductId
        ]);
        $statement1->setFetchMode(PDO::FETCH_ASSOC);
        $Product = $statement1->fetchAll();
        if (isset($_SESSION['cart'])) {
            if (count($_SESSION['cart']) < 1) {
                $NewArray = array(
                    'ProductId' => $Product[0]['productId'],
                    'Name' => $Product[0]['productName'],
                    'Price' => $Product[0]['price'],
                    'Quantity' => 1,
                    'Image' => $Product[0]['image'],
                    'Sale' => $Product[0]['sale'],
                    'Status' => $Product[0]['status']
                );
                $_SESSION['cart'][] = $NewArray;
                header("Location: ./index.php");
                die;
            } else {
                for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                    if ($_SESSION['cart'][$i]['ProductId'] == $ProductId) {

                        $NewQuantity = $_SESSION['cart'][$i]['Quantity'] + 1;
                        $_SESSION['cart'][$i]['Quantity'] = $NewQuantity;
                        header("Location: ./index.php");
                        die;
                    }
                }
                for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                    if ($_SESSION['cart'][$i]['cart'] != $ProductId) {
                        $NewArray = array(
                            'ProductId' => $Product[0]['productId'],
                            'Name' => $Product[0]['productName'],
                            'Price' => $Product[0]['price'],
                            'Quantity' => 1,
                            'Image' => $Product[0]['image'],
                            'Sale' => $Product[0]['sale'],
                            'Status' => $Product[0]['status'],
                        );
                        $_SESSION['cart'][] = $NewArray;
                        header("Location: ./index.php");
                        die;
                    }
                }
            }
        }
    }
}
if (isset($_POST['productDetailId']) && isset($_POST['QuantityProductAdd'])) {
    $productDetailId = $_POST['productDetailId'];
    $QuantityProductAdd = $_POST['QuantityProductAdd'];
    $statement3 = $connection->prepare("SELECT * FROM products WHERE productId = :productId");
    $statement3->execute([
        ':productId' => $productDetailId
    ]);
    $statement3->setFetchMode(PDO::FETCH_ASSOC);
    $Cart = $statement3->fetchAll();
    if (isset($_SESSION['cart'])) {
        if (count($_SESSION['cart']) < 1) {
            $NewArray = array(
                'ProductId' => $Cart[0]['productId'],
                'Name' => $Cart[0]['productName'],
                'Price' => $Cart[0]['price'],
                'Quantity' => $QuantityProductAdd,
                'Image' => $Cart[0]['image'],
                'Sale' => $Cart[0]['sale'],
                'Status' => $Cart[0]['status'],
            );
            $_SESSION['cart'][] = $NewArray;
            header("Location: ./index.php");
            die;
        } else {
            for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                if ($_SESSION['cart'][$i]['ProductId'] == $productDetailId) {
                    $NewQuantity = $_SESSION['cart'][$i]['Quantity'] + $QuantityProductAdd;
                    $_SESSION['cart'][$i]['Quantity'] = $NewQuantity;
                    header("Location: ./index.php");
                    die;
                }
            }
            for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                if ($_SESSION['cart'][$i]['ProductId'] != $productDetailId) {
                    $NewArray = array(
                        'ProductId' => $Cart[0]['productId'],
                        'Name' => $Cart[0]['productName'],
                        'Price' => $Cart[0]['price'],
                        'Quantity' => $Quantity,
                        'Image' => $Cart[0]['image'],
                        'Sale' => $Cart[0]['sale'],
                        'Status' => $Cart[0]['status'],
                    );
                    $_SESSION['cart'][] = $NewArray;
                    header("Location: ./index.php");
                    die;
                }
            }
        }
    }
} */
/* if (!isset($_SESSION['cartTotal'])) {
    $_SESSION['cartTotal'] = [];
}
if (isset($_GET['action']) && isset($_GET['productId'])) {
    function Update_Cart_Total()
    {
        foreach ($_POST['Quantity'] as $id => $quantity) {
            $_SESSION['cartTotal'][$id] = $quantity;
        }
    }
    switch ($_GET['action']) {
        case "add":
            foreach ($_SESSION['cartTotal'] as $id => $value) {
                if ($id == $_GET['productId']) {
                    $_SESSION['cartTotal'][$id] = $_SESSION['cartTotal'][$id]++;
                } else {
                    Update_Cart_Total();
                }
            }
            header("Location: index.php");
            break;
    }
} */
