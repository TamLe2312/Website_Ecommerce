<?
session_start();
require('./provider.php');
require_once("./User.php");
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
?>

<!DOCTYPE html>
<html lang="en">


<!-- molla/wishlist.html  22 Nov 2019 09:55:05 GMT -->

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

<style>
    .imageProduct {
        width: 75px;
    }
</style>

<body>
    <div class="page-wrapper">
        <? include('./layout/header.php') ?>
        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">Product</h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <div class="page-content">
                <div class="container-fluid">
                    <?
                    if (isset($errors) && count($errors) > 0) { ?>
                        <br />
                        <div class="alert alert-danger" role="alert">
                            <?php echo join("<br/>", $errors) . ""; ?>
                        </div>
                    <? }
                    ?>
                    <?
                    if (isset($message) && $message !== "") {
                        echo " <br/>
                    <div class='alert alert-success' role='alert'>
                        $message
                    </div>";
                    }
                    ?>
                    <table class="table table-wishlist table-mobile">
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th style="padding-left: 10px;">Product ID</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th style="padding-left: 15px;">Description</th>
                                <th>Price</th>
                                <th>Sale</th>
                                <th>Status</th>
                                <th>Category</th>
                                <?
                                if ($user['role'] == 1) { ?>
                                    <th style="padding-left: 15px;">Action</th>
                                <? }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            if (isset($connection)) {
                                $start = 0;
                                $rows_per_page = 5;
                                $statement4 = $connection->prepare("SELECT * FROM products");
                                $statement4->execute([]);
                                $nr_of_rows = $statement4->rowCount();
                                $pages = ceil($nr_of_rows / $rows_per_page);
                                if (isset($_GET['page-nr'])) {
                                    $page = $_GET['page-nr'] - 1;
                                    $start = $page * $rows_per_page;
                                }
                                $statement = $connection->prepare("SELECT * FROM products LIMIT $start,$rows_per_page");
                                $statement->execute([]);
                                $result2 = $statement->setFetchMode(PDO::FETCH_ASSOC);
                                $Products = $statement->fetchAll();
                                $pages = ceil($nr_of_rows / $rows_per_page);
                            }
                            if (isset($connection)) {
                                $statement3 = $connection->prepare("SELECT * FROM products as P
                                inner join categories as C on P.categoryId = C.categoryId LIMIT $start,$rows_per_page");
                                $statement3->execute([]);
                                $result2 = $statement3->setFetchMode(PDO::FETCH_ASSOC);
                                $ProductList = $statement3->fetchAll();
                            }
                            $count = 1;
                            foreach ($ProductList as $Product) { ?>
                                <tr>
                                    <td scope="price-col"><?= $count ?></td>
                                    <td class="price-col"><?= $Product['productId'] ?></td>
                                    <td class="product-col">
                                        <div class="product">
                                            <h4 class="product-title" style="font-size: 1.4rem;">
                                                <?= $Product['productName'] ?>
                                            </h4><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td><img class="imageProduct" src="./uploads/<?= $Product['image'] ?>"></td>
                                    <td class="product-col">
                                        <div class="product" style="padding-left: 2rem;">
                                            <p style="font-size: 1.3rem;">
                                                <?= $Product['description'] ?>
                                            </p><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class=" price-col"><?= currency_format($Product['price']) ?>
                                    </td>
                                    <td class="price-col"><?= $Product['sale'] ?> %</td>
                                    <td class="product-col">
                                        <div class="product">
                                            <h3 class="product-title">
                                                <?
                                                if ($Product['status'] == 1) {
                                                    echo "Còn hàng";
                                                } elseif ($Product['status'] == 2) {
                                                    echo "Hết hàng";
                                                } elseif ($Product['status'] == 3) {
                                                    echo "Ngừng bán";
                                                }
                                                ?>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="product-col">
                                        <div class="product">
                                            <h3 class="product-title">
                                                <?= $Product['categoryName'] ?>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <?
                                    if ($user['role'] == 1) { ?>
                                        <td class="action-col">
                                            <div class="dropdown">
                                                <button class="btn btn-block btn-outline-primary-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-list-alt"></i>Select Options
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="./Edit_Product.php?productId=<?= $Product['productId'] ?>&image=<?= $Product['image'] ?>&productName=<?= $Product['productName'] ?>&description=<?= $Product['description'] ?>&price=<?= $Product['price'] ?>&sale=<?= $Product['sale'] ?>&status=<?= $Product['status'] ?>&categoryId=<?= $Product['categoryId'] ?>">Edit</a>
                                                    <a class=" dropdown-item" href="./Delete_Product.php?id=<?= $Product['productId'] ?>&image=<?= $Product['image'] ?>">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    <? }
                                    ?>
                                </tr>
                            <? $count++;
                            }
                            ?>
                        </tbody>
                    </table><!-- End .table table-wishlist -->
                    <?
                    if (!isset($_GET['page-nr'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page-nr'];
                    }
                    ?>
                    <div>Page <? echo $page ?> of <? echo $pages ?> pages</div>
                    <nav aria-label="Page navigation example">
                        <form action="./Category.php" method="get">
                            <ul class="pagination justify-content-center">
                                <?
                                if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) { ?>
                                    <li class="page-item"><a class="page-link" href="?page-nr=<? echo $_GET['page-nr'] - 1 ?>">Previous</a></li>
                                <? } else { ?>
                                    <li class="page-item disabled"><a class="page-link">Previous</a></li>
                                <? }
                                ?>
                                <?
                                for ($count = 1; $count <= $pages; $count++) { ?>
                                    <li class="page-item"><a class="page-link" href="?page-nr=<? echo $count ?>"><? echo $count ?></a></li>
                                <? }
                                ?>
                                <?
                                if (!isset($_GET['page-nr'])) {
                                    if ($nr_of_rows >= $rows_per_page) { ?>
                                        <li class="page-item"><a class="page-link" href="?page-nr=2">Next</a></li>
                                    <? } else { ?>
                                        <li class="page-item disabled"><a class="page-link">Next</a></li>
                                    <? }
                                } else {
                                    if ($_GET['page-nr'] >= $pages) { ?>
                                        <li class="page-item disabled"><a class="page-link">Next</a></li>
                                    <? } else { ?>
                                        <li class="page-item"><a class="page-link" href="?page-nr=<? echo $_GET['page-nr'] + 1 ?>">Next</a></li>
                                <? }
                                }
                                ?>
                            </ul>
                        </form>

                    </nav>
                </div>
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <footer class="footer">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="widget widget-about">
                                <img src="assets/images/logo.png" class="footer-logo" alt="Footer Logo" width="105" height="25">
                                <p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. </p>

                                <div class="social-icons">
                                    <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Pinterest"><i class="icon-pinterest"></i></a>
                                </div><!-- End .soial-icons -->
                            </div><!-- End .widget about-widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="about.html">About Molla</a></li>
                                    <li><a href="#">How to shop on Molla</a></li>
                                    <li><a href="#">FAQ</a></li>
                                    <li><a href="contact.html">Contact us</a></li>
                                    <li><a href="login.html">Log in</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="#">Payment Methods</a></li>
                                    <li><a href="#">Money-back guarantee!</a></li>
                                    <li><a href="#">Returns</a></li>
                                    <li><a href="#">Shipping</a></li>
                                    <li><a href="#">Terms and conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="#">Sign In</a></li>
                                    <li><a href="cart.html">View Cart</a></li>
                                    <li><a href="#">My Wishlist</a></li>
                                    <li><a href="#">Track My Order</a></li>
                                    <li><a href="#">Help</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    <p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p><!-- End .footer-copyright -->
                    <figure class="footer-payments">
                        <img src="assets/images/payments.png" alt="Payment methods" width="272" height="20">
                    </figure><!-- End .footer-payments -->
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
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
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->
    <script>
        updateCategory = (categoryId, name) => {
            document.getElementById("id").value = categoryId;
            document.getElementById("CID").readOnly = true;
            elmCategoryId = document.getElementById("CID");
            elmName = document.getElementById("CN");
            elmSubmit = document.getElementById("submit");
            elmCategoryId.value = categoryId;
            elmName.value = name;
            elmSubmit.textContent = "Save";
        };
    </script>

    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>


<!-- molla/wishlist.html  22 Nov 2019 09:55:06 GMT -->

</html>