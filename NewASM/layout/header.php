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
                                    <a href="./Order_List.php" class="sf-with-ul">Account</a>
                                    <ul>
                                        <li><a href="./Account_List.php">Account List</a></li>
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

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                    </a>
                    <form action="./Cart.php?action=add" method="POST">
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                <?
                                $Total_Product = 0;
                                $Product_Price = 0;
                                if (!empty($_SESSION['cart_Total'])) {
                                    $_words = '"' . implode('","', array_keys($_SESSION['cart_Total'])) . '"';
                                    $statement = $connection->prepare("SELECT * FROM `products` WHERE `productId` IN ($_words)");
                                    $statement->execute([]);
                                    $statement->setFetchMode(PDO::FETCH_ASSOC);
                                    $ProductList = $statement->fetchAll();
                                }
                                /* SELECT * FROM `products` WHERE `productId` IN ('PD01','PD02','PD06','PD05') */

                                if (!empty($_SESSION['cart_Total'])) {
                                    foreach ($ProductList as $product) {
                                ?>
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a><?= $product['productName'] ?></a>
                                                </h4>
                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty"><?= $_SESSION['cart_Total'][$product['productId']] ?></span>
                                                    x <?= currency_format($product['price']) ?>
                                                </span>
                                            </div><!-- End .product-cart-details -->
                                            <figure class="product-image-container">
                                                <a class="product-image">
                                                    <img src="./uploads/<?= $product['image'] ?>" alt="product">
                                                </a>
                                            </figure>
                                            <a href="./Delete_Cart.php?productId=<?= $product['productId'] ?>" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                        </div><!-- End .product -->
                                        <input type="hidden" value="<?= $_SESSION['cart_Total'][$product['productId']] ?>" name="Quantity[<?= $product['productId'] ?>]">
                                <?
                                        $Product_Price =  $_SESSION['cart_Total'][$product['productId']] * $product['price'];
                                        $Total_Product += $Product_Price;
                                    }
                                }
                                ?>
                            </div><!-- End .cart-product -->
                            <div class="dropdown-cart-total">
                                <span>Total</span>
                                <span class="cart-total-price"><?= currency_format($Total_Product) ?></span>
                            </div><!-- End .dropdown-cart-total -->
                            <button class="btn btn-primary">View Cart</button>
                        </div><!-- End .dropdown-menu -->
                    </form>
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->