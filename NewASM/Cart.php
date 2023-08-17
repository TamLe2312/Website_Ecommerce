<?
session_start();
require('./provider.php');
require('./User.php');
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (!function_exists('currency_format')) {
    function currency_format($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}
if (!empty($_SESSION['currentUser'])) {
    $user = unserialize($_SESSION['currentUser']);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include library files 
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function send_order_notification($get_username, $get_email, $products, $total, $discount)
{
    // Create an instance; Pass `true` to enable exceptions 
    $mail = new PHPMailer;

    // Server settings 
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output 
    $mail->isSMTP();                            // Set mailer to use SMTP 
    $mail->Host = 'smtp.gmail.com';           // Specify main and backup SMTP servers 
    $mail->SMTPAuth = true;                     // Enable SMTP authentication 
    $mail->Username = 'tamledeptraiso1@gmail.com';       // SMTP username 
    $mail->Password = 'bfntpgblbsoswvjx';         // SMTP password 
    $mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted 
    $mail->Port = 465;                          // TCP port to connect to 

    // Sender info 
    $mail->setFrom('tamledeptraiso1@gmail.com', 'Mister Uri');
    /* $mail->addReplyTo('reply@example.com', 'SenderName'); */

    // Add a recipient 
    $mail->addAddress($get_email);

    //$mail->addCC('cc@example.com'); 
    //$mail->addBCC('bcc@example.com'); 

    // Set email format to HTML 
    $mail->isHTML(true);

    // Mail subject 
    $mail->Subject = 'Order Notification';

    $Count = 1;
    // Mail body content 
    $bodyContent = "<h1 style='text-align: center;'>Hello,$get_username</h1>";
    $bodyContent .= "<h1 style='text-align: center;'>Thank You For Order</h1>";
    $bodyContent .= "<div style='text-align: center;'>
        <p>This is your order bill</p>
        <table class='table' style='margin-left: auto; margin-right: auto;'>
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Product</th>
                    <th scope='col'>Price</th>
                    <th scope='col'>Quantity</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($products as $product) {
        $bodyContent .= "
                <tr>
                    <th scope='row'>$Count</th>
                    <td>" . $product['productName'] . "</td>
                    <td> " . currency_format($product['price']) . "</td>
                    <td>" . $_POST['Quantity'][$product['productId']] . "</td>
                </tr>";
        $Count++;
    }
    if ($discount == 0) {
        $bodyContent .= "</tbody>
    </table>
    <h3>Total :" . currency_format($total) . "</h3>
    </div>";
    } else {
        $bodyContent .= "</tbody>
    </table>
    <h3>Total(Before Discount) :" . currency_format($total + $discount) . "</h3>
    <h3>Discount :" . currency_format($discount) . "</h3>
    <h3>Total(After Discount) :" . currency_format($total) . "</h3>
</div>";
    }
    $mail->Body = $bodyContent;
    if (!$mail->send()) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    } else {
        unset($_SESSION['InfoProduct']);
        echo 'Message has been sent.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- molla/cart.html  22 Nov 2019 09:55:06 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Molla - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<?
if (!isset($_SESSION['cart_Total'])) {
    $_SESSION['cart_Total'] = [];
}
if (isset($_GET['action'])) {
    $errors = [];
    $success = false;
    function Update_Cart_Total($add = false)
    {
        if (isset($_POST['Quantity'])) {
            foreach ($_POST['Quantity'] as $id => $quantity) {
                if ($add) {
                    if (isset($_GET['productIdGet'])) {
                        if ($id == $_GET['productIdGet']) {
                            $_SESSION['cart_Total'][$id] += $quantity;
                        } else {
                            $_SESSION['cart_Total'][$id] = $quantity;
                        }
                    }
                } else {
                    $_SESSION['cart_Total'][$id] = $quantity;
                }
            }
        }
    }
    switch ($_GET['action']) {
        case "add":
            if (isset($_GET['index'])) {
                if ($_GET['index'] == 1) {
                    Update_Cart_Total(true);
                    header("Location: index.php");
                    break;
                } else {
                    Update_Cart_Total(true);
                    header("Location: Product_Detail.php?productId=" . $_GET['productIdGet'] . "");
                    break;
                }
            } else {
                Update_Cart_Total(true);
                break;
            }
        case "delete":
            if (isset($_GET['id'])) {
                unset($_SESSION['cart_Total'][$_GET['id']]);
            }
            header("Location: ./Cart.php");
            break;
        case "submit":
            if (isset($_POST['Update_Click'])) {
                Update_Cart_Total();
                header("Location: ./Cart.php");
            } elseif (isset($_POST['Order_Click'])) {
                if (empty($_SESSION['currentUser'])) {
                    header("Location: login.php");
                    exit;
                } else {
                    if (empty($_POST['Name'])) {
                        $errors[] = "Name not empty";
                    } elseif (empty($_POST['Address'])) {
                        $errors[] = "Address not empty";
                    } elseif (empty($_POST['Email'])) {
                        $errors[] = "Email not empty";
                    } elseif (empty($_POST['Quantity'])) {
                        $errors[] = "Cart not empty";
                    }

                    if (count($errors) < 1 && !empty($_POST['Quantity'])) {
                        $_words = '"' . implode('","', array_keys($_SESSION['cart_Total'])) . '"';
                        $statement1 = $connection->prepare("SELECT * FROM `products` WHERE `productId` IN ($_words)");
                        $statement1->execute([]);
                        $statement1->setFetchMode(PDO::FETCH_ASSOC);
                        $ProductCheckOut = $statement1->fetchAll();
                        $Total = 0;
                        $orderProducts = [];
                        foreach ($ProductCheckOut as $Product) {
                            $orderProducts[] = $Product;
                            $Total += $Product['price'] * $_POST['Quantity'][$Product['productId']];
                        }
                        if (isset($_POST['Discount'])) {
                            $Discount = $_POST['Discount'];
                            $Total = ($Total - $Discount);
                        }
                        if (!empty($_SESSION['currentUser'])) {
                            $user = unserialize($_SESSION['currentUser']);
                        }
                        $insertOrder = "INSERT INTO orderrs (userId, email, address, total, nameUserr)
                        VALUES (:userId, :email, :address, :total, :nameUserr);";
                        $statement = $connection->prepare($insertOrder);
                        if ($statement->execute([
                            ':userId' => $user['id'],
                            ':email' => trim($_POST['Email']),
                            ':address' => trim($_POST['Address']),
                            ':total' => $Total,
                            ':nameUserr' => trim($_POST['Name']),
                        ])) {
                            $OrderId = ($connection->lastInsertId());
                            $insertString = '';
                            foreach ($orderProducts as $key => $Product) {
                                $insertString .= "('" . $OrderId . "', '" . $Product['productId'] . "', '" . $_POST['Quantity'][$Product['productId']] . "', '" . $Product['price'] . "')";
                                if ($key != count($orderProducts) - 1) {
                                    $insertString .= ",";
                                }
                            }
                            $insert_Order_Detail = "INSERT INTO 
                            order_detail (order_id, productId, quantity, price) 
                            VALUES " . $insertString . "";
                            $statement2 = $connection->prepare($insert_Order_Detail);
                            $statement2->execute([]);
                            $success = "Success";
                            if (isset($_POST['Discount'])) {
                                send_order_notification($_POST['Name'], $_POST['Email'], $orderProducts, $Total, $_POST['Discount']);
                            } else {
                                send_order_notification($_POST['Name'], $_POST['Email'], $orderProducts, $Total, 0);
                            }
                            unset($_SESSION['cart_Total']);
                            break;
                        }
                        exit;
                    }
                    break;
                }
            } elseif (isset($_POST['Coupon'])) {
                if ($_POST['Coupon'] == "GIAM20") {
                    header("Location: Cart.php?Coupon=20");
                    exit;
                } elseif ($_POST['Coupon'] == "GIAM50") {
                    header("Location: Cart.php?Coupon=50");
                    exit;
                } elseif ($_POST['Coupon'] == "GIAM70") {
                    header("Location: Cart.php?Coupon=70");
                    exit;
                }
                header("Location: ./Cart.php");
            }
            break;
    }
}
if (!empty($_SESSION['cart_Total'])) {
    $_words = '"' . implode('","', array_keys($_SESSION['cart_Total'])) . '"';
    /* SELECT * FROM `products` WHERE `productId` IN ('PD01','PD02','PD06','PD05') */
    $statement = $connection->prepare("SELECT * FROM `products` WHERE `productId` IN ($_words)");
    $statement->execute([]);
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $ProductList = $statement->fetchAll();
}
?>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        <a href="index.php" class="logo">
                            <img src="./images/LogoMisterURi2.png" alt="Molla Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container active">
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="./Products.php" class="sf-with-ul">Product</a>
                                    <ul>
                                        <?
                                        if ((!empty($_SESSION['currentUser']))) {
                                            if ($user['role'] != 1) { ?>
                                                <li><a href="./Products.php">Product List</a></li>
                                            <? } else { ?>
                                                <li><a href="./Products.php">Product List</a></li>
                                                <li><a href="./Add_Product.php">Add Products</a></li>
                                            <? }
                                        } else { ?>
                                            <li><a href="./Products.php">Product List</a></li>
                                        <? } ?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="./Categories.php">Categories</a>
                                </li>
                                <li>
                                    <?
                                    if (!empty($_SESSION['currentUser'])) {
                                        if ($user['role'] != 1) { ?>
                                            <a href="./Order_List.php" class="sf-with-ul">Account</a>
                                            <ul>
                                                <li><a href="./Order_List.php">Carts</a></li>
                                            </ul>
                                        <? } else { ?>
                                            <a href="./Products.php" class="sf-with-ul">Account</a>
                                            <ul>
                                                <li><a href="./Account_List.php">Account List</a></li>
                                                <li><a href="./Add_Product.php">Add Products</a></li>
                                                <li><a href="./Order_List.php">Carts</a></li>
                                            </ul>
                                        <? }
                                        ?>
                                    <? }
                                    ?>
                                </li>
                                <li>
                                    <?
                                    if (empty($_SESSION['currentUser'])) { ?>
                                        <a href="./login.php">Login/SignUp</a>
                                    <? } else { ?>
                                        <a href="./logout.php">Logout</a>
                                    <? }
                                    ?>
                                </li>
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search">
                            <a href="Search.php" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                            <form action="Search.php" method="get">
                                <div class="header-search-wrapper">
                                    <label for="Search" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="Search" id="Search" placeholder="Search in..." required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->
        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">View Cart</h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <div class="page-content">
                <div class="cart">
                    <div class="container">
                        <?
                        if (isset($errors) && count($errors) > 0) { ?>
                            <br />
                            <div class="alert alert-danger" role="alert">
                                <?php echo join("<br/>", $errors) . ""; ?>
                            </div>
                        <? }
                        ?>
                        <?
                        if (!empty($success)) {
                            echo " <br/>
                    <div class='alert alert-success' role='alert'>
                        $success
                    </div><br/>
                    <a href=`./index.php`>Continue Shopping</a>
                    ";
                        }
                        ?>
                        <br />
                        <form action="./Cart.php?action=submit" method="POST">
                            <div class="row">
                                <div class="col-lg-9">
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <?
                                        $Total_Product = 0;
                                        if (!empty($ProductList)) {

                                            foreach ($ProductList as $Product) {
                                                $Product_Price = 0;
                                        ?>
                                                <tbody>
                                                    <tr>
                                                        <td class="product-col">
                                                            <div class="product">
                                                                <figure class="product-media">
                                                                    <a>
                                                                        <img src="./uploads/<?= $Product['image'] ?>" alt="Product image">
                                                                    </a>
                                                                </figure>

                                                                <h3 class="product-title">
                                                                    <a><?= $Product['productName'] ?></a>
                                                                </h3><!-- End .product-title -->
                                                            </div><!-- End .product -->
                                                        </td>
                                                        <td class="price-col"><?= currency_format($Product['price']) ?></td>
                                                        <td class="quantity-col">
                                                            <div class="cart-product-quantity">
                                                                <input name="Quantity[<?= $Product['productId'] ?>]" type="number" class="form-control" value="<?= $_SESSION['cart_Total'][$Product['productId']] ?>" min="1" max="10" step="1" data-decimals="0" required>
                                                            </div><!-- End .cart-product-quantity -->
                                                        </td>
                                                        <td class="total-col"><?= currency_format($Product['price'] * $_SESSION['cart_Total'][$Product['productId']]) ?></td>
                                                        <td class="remove-col"><a href="./Cart.php?action=delete&id=<?= $Product['productId'] ?>" class="btn-remove"><i class="icon-close"></i></a></td>
                                                    </tr>
                                                </tbody>
                                        <?
                                                $Product_Price = $_SESSION['cart_Total'][$Product['productId']] * $Product['price'];
                                                $Total_Product += $Product_Price;
                                            }
                                        }
                                        ?>
                                    </table><!-- End .table table-wishlist -->
                                    <div class="cart-bottom">
                                        <div class="cart-discount">
                                            <form action="./Cart.html" method="POST">
                                                <div class="input-group">
                                                    <input name="Coupon" type="text" class="form-control" placeholder="coupon code">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                                    </div><!-- .End .input-group-append -->
                                                </div><!-- End .input-group -->
                                            </form>
                                        </div><!-- End .cart-discount -->
                                        <button type="submit" name="Update_Click" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></button>
                                    </div><!-- End .cart-bottom -->
                                </div><!-- End .col-lg-9 -->
                                <aside class="col-lg-3">
                                    <div class="summary summary-cart">
                                        <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->
                                        <table class="table table-summary">
                                            <tbody>
                                                <tr class="summary-subtotal">
                                                    <?
                                                    $Discount = 0;
                                                    if (isset($_GET['Coupon'])) {
                                                        $Coupon = $_GET['Coupon'];
                                                        if ($Coupon == 20) {
                                                            $Discount = $Total_Product * $Coupon / 100;
                                                        } elseif ($Coupon == 50) {
                                                            $Discount = $Total_Product * $Coupon / 100;
                                                        } elseif ($Coupon == 70) {
                                                            $Discount = $Total_Product * $Coupon / 100;
                                                        }
                                                    ?>
                                                        <td>Discount:</td>
                                                        <input type="hidden" name="Discount" value="<?= $Discount ?>">
                                                        <td><?= currency_format($Discount) ?></td>
                                                    <? } else { ?>
                                                        <td>Discount:</td>
                                                        <input type="hidden" name="Discount" value="<?= $Discount ?>">
                                                        <td><?= $Discount ?></td>
                                                    <?
                                                    }
                                                    ?>
                                                </tr><!-- End .summary-subtotal -->
                                                <tr class="summary-total">
                                                    <td>Total(Included VAT):</td>
                                                    <td><?
                                                        if (isset($_GET['Coupon'])) {
                                                            echo currency_format($Total_Product - $Discount);
                                                        } else {
                                                            echo currency_format($Total_Product);
                                                        }
                                                        ?></td>
                                                </tr><!-- End .summary-total -->
                                            </tbody>
                                        </table><!-- End .table table-summary -->
                                    </div><!-- End .summary -->
                                    <button name="Order_Click" type="submit" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</button>
                                    <a href="./index.php" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                                </aside><!-- End .col-lg-3 -->
                                <div class="col-lg-9">
                                    <h2 class="checkout-title">Checkout</h2><!-- End .checkout-title -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Name *</label>
                                            <input name="Name" type="text" class="form-control">
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->
                                    <label>Street address *</label>
                                    <input name="Address" type="text" class="form-control" placeholder="House number and Street name">
                                    <label>Email address *</label>
                                    <input name="Email" type="email" class="form-control">
                                </div><!-- End .col-lg-9 -->
                            </div><!-- End .row -->
                        </form>
                    </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <? include('./layout/footer.php') ?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>

            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active">
                        <a href="index.html">Home</a>

                        <ul>
                            <li><a href="index-1.html">01 - furniture store</a></li>
                            <li><a href="index-2.html">02 - furniture store</a></li>
                            <li><a href="index-3.html">03 - electronic store</a></li>
                            <li><a href="index-4.html">04 - electronic store</a></li>
                            <li><a href="index-5.html">05 - fashion store</a></li>
                            <li><a href="index-6.html">06 - fashion store</a></li>
                            <li><a href="index-7.html">07 - fashion store</a></li>
                            <li><a href="index-8.html">08 - fashion store</a></li>
                            <li><a href="index-9.html">09 - fashion store</a></li>
                            <li><a href="index-10.html">10 - shoes store</a></li>
                            <li><a href="index-11.html">11 - furniture simple store</a></li>
                            <li><a href="index-12.html">12 - fashion simple store</a></li>
                            <li><a href="index-13.html">13 - market</a></li>
                            <li><a href="index-14.html">14 - market fullwidth</a></li>
                            <li><a href="index-15.html">15 - lookbook 1</a></li>
                            <li><a href="index-16.html">16 - lookbook 2</a></li>
                            <li><a href="index-17.html">17 - fashion store</a></li>
                            <li><a href="index-18.html">18 - fashion store (with sidebar)</a></li>
                            <li><a href="index-19.html">19 - games store</a></li>
                            <li><a href="index-20.html">20 - book store</a></li>
                            <li><a href="index-21.html">21 - sport store</a></li>
                            <li><a href="index-22.html">22 - tools store</a></li>
                            <li><a href="index-23.html">23 - fashion left navigation store</a></li>
                            <li><a href="index-24.html">24 - extreme sport store</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="category.html">Shop</a>
                        <ul>
                            <li><a href="category-list.html">Shop List</a></li>
                            <li><a href="category-2cols.html">Shop Grid 2 Columns</a></li>
                            <li><a href="category.html">Shop Grid 3 Columns</a></li>
                            <li><a href="category-4cols.html">Shop Grid 4 Columns</a></li>
                            <li><a href="category-boxed.html"><span>Shop Boxed No Sidebar<span class="tip tip-hot">Hot</span></span></a></li>
                            <li><a href="category-fullwidth.html">Shop Fullwidth No Sidebar</a></li>
                            <li><a href="product-category-boxed.html">Product Category Boxed</a></li>
                            <li><a href="product-category-fullwidth.html"><span>Product Category Fullwidth<span class="tip tip-new">New</span></span></a></li>
                            <li><a href="cart.html">Cart</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                            <li><a href="wishlist.html">Wishlist</a></li>
                            <li><a href="#">Lookbook</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="product.html" class="sf-with-ul">Product</a>
                        <ul>
                            <li><a href="product.html">Default</a></li>
                            <li><a href="product-centered.html">Centered</a></li>
                            <li><a href="product-extended.html"><span>Extended Info<span class="tip tip-new">New</span></span></a></li>
                            <li><a href="product-gallery.html">Gallery</a></li>
                            <li><a href="product-sticky.html">Sticky Info</a></li>
                            <li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
                            <li><a href="product-fullwidth.html">Full Width</a></li>
                            <li><a href="product-masonry.html">Masonry Sticky Info</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Pages</a>
                        <ul>
                            <li>
                                <a href="about.html">About</a>

                                <ul>
                                    <li><a href="about.html">About 01</a></li>
                                    <li><a href="about-2.html">About 02</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="contact.html">Contact</a>

                                <ul>
                                    <li><a href="contact.html">Contact 01</a></li>
                                    <li><a href="contact-2.html">Contact 02</a></li>
                                </ul>
                            </li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="faq.html">FAQs</a></li>
                            <li><a href="404.html">Error 404</a></li>
                            <li><a href="coming-soon.html">Coming Soon</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="blog.html">Blog</a>

                        <ul>
                            <li><a href="blog.html">Classic</a></li>
                            <li><a href="blog-listing.html">Listing</a></li>
                            <li>
                                <a href="#">Grid</a>
                                <ul>
                                    <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                    <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                    <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                    <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Masonry</a>
                                <ul>
                                    <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                    <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                    <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                    <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Mask</a>
                                <ul>
                                    <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                    <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Single Post</a>
                                <ul>
                                    <li><a href="single.html">Default with sidebar</a></li>
                                    <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                    <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="elements-list.html">Elements</a>
                        <ul>
                            <li><a href="elements-products.html">Products</a></li>
                            <li><a href="elements-typography.html">Typography</a></li>
                            <li><a href="elements-titles.html">Titles</a></li>
                            <li><a href="elements-banners.html">Banners</a></li>
                            <li><a href="elements-product-category.html">Product Category</a></li>
                            <li><a href="elements-video-banners.html">Video Banners</a></li>
                            <li><a href="elements-buttons.html">Buttons</a></li>
                            <li><a href="elements-accordions.html">Accordions</a></li>
                            <li><a href="elements-tabs.html">Tabs</a></li>
                            <li><a href="elements-testimonials.html">Testimonials</a></li>
                            <li><a href="elements-blog-posts.html">Blog Posts</a></li>
                            <li><a href="elements-portfolio.html">Portfolio</a></li>
                            <li><a href="elements-cta.html">Call to Action</a></li>
                            <li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="singin-email">Username or email address *</label>
                                            <input type="text" class="form-control" id="singin-email" name="singin-email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password" name="singin-password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="register-email">Your email address *</label>
                                            <input type="email" class="form-control" id="register-email" name="register-email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Password *</label>
                                            <input type="password" class="form-control" id="register-password" name="register-password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login  btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>


<!-- molla/cart.html  22 Nov 2019 09:55:06 GMT -->

</html>