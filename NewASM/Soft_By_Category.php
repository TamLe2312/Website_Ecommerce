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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
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
    <link rel="stylesheet" href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/plugins/nouislider/nouislider.css">
    <link rel="stylesheet" href="assets/css/demos/demo-11.css">
</head>

<body>
    <div class="page-wrapper">
        <? include('./layout/header.php') ?>
        <main class="main">
            <div class="intro-slider-container mb-4">
                <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "responsive": {
                            "992": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
                    <div class="intro-slide" style="background-image: url(assets/images/demos/demo-11/slider/slide-1.jpg);">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle text-primary">SEASONAL PICKS</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">Get All <br>The Good Stuff</h1><!-- End .intro-title -->

                            <a href="#product-container" class="btn btn-outline-primary-2">
                                <span>FIND MORE</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->

                    <div class="intro-slide" style="background-image: url(assets/images/demos/demo-11/slider/slide-2.jpg);">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle text-primary">all at 50% off</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title text-white">The Most Beautiful <br>Novelties In Our Shop</h1><!-- End .intro-title -->

                            <a href="#product-container" class="btn btn-outline-primary-2 min-width-sm">
                                <span>SHOP NOW</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .intro-content -->
                    </div><!-- End .intro-slide -->
                </div><!-- End .intro-slider owl-carousel owl-simple -->

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->
            <div id="product-container" class="container">
                <div class="toolbox toolbox-filter">
                    <div class="toolbox-right">
                        <?
                        if (isset($_GET['Soft'])) {
                            $Soft = $_GET['Soft'];
                            if ($Soft == 'Lò Vi Sóng') { ?>
                                <ul class="nav-filter product-filter">
                                    <li><a href="./Soft_By_Category.php?Soft=All">All</a></li>
                                    <li class="active"><a href="./Soft_By_Category.php?Soft=Lò Vi Sóng">Microwave</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Tivi">Tivi</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Quạt">Fan</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Sale">Sale</a></li>
                                </ul>
                            <? } elseif ($Soft == 'Tivi') { ?>
                                <ul class="nav-filter product-filter">
                                    <li><a href="./Soft_By_Category.php?Soft=All">All</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Lò Vi Sóng">Microwave</a></li>
                                    <li class="active"><a href="./Soft_By_Category.php?Soft=Tivi">Tivi</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Quạt">Fan</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Sale">Sale</a></li>
                                </ul>
                            <? } elseif ($Soft == 'Quạt') { ?>
                                <ul class="nav-filter product-filter">
                                    <li><a href="./Soft_By_Category.php?Soft=All">All</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Lò Vi Sóng">Microwave</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Tivi">Tivi</a></li>
                                    <li class="active"><a href="./Soft_By_Category.php?Soft=Quạt">Fan</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Sale">Sale</a></li>
                                </ul>
                            <? } elseif ($Soft == 'Sale') { ?>
                                <ul class="nav-filter product-filter">
                                    <li><a href="./Soft_By_Category.php?Soft=All">All</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Lò Vi Sóng">Microwave</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Tivi">Tivi</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Quạt">Fan</a></li>
                                    <li class="active"><a href="./Soft_By_Category.php?Soft=Sale">Sale</a></li>
                                </ul>
                            <? } else { ?>
                                <ul class="nav-filter product-filter">
                                    <li class="active"><a href="./Soft_By_Category.php?Soft=All">All</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Lò Vi Sóng">Microwave</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Tivi">Tivi</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Quạt">Fan</a></li>
                                    <li><a href="./Soft_By_Category.php?Soft=Sale">Sale</a></li>
                                </ul>
                        <?
                            }
                        }
                        ?>
                    </div><!-- End .toolbox-right -->
                </div><!-- End .filter-toolbox -->
                <div class="products-container" data-layout="fitRows">
                    <?
                    if (isset($connection) && isset($_GET['Soft'])) {
                        $Soft = $_GET['Soft'];
                        if ($Soft == "All") {
                            $statement = $connection->prepare("SELECT * FROM products LIMIT 0,12");
                            $statement->execute([]);
                            $statement->setFetchMode(PDO::FETCH_ASSOC);
                            $ProductList = $statement->fetchAll();
                        } elseif ($Soft == "Sale") {
                            $statement = $connection->prepare("SELECT * FROM products WHERE sale > 0 AND status = 1 LIMIT 0,12");
                            $statement->execute([]);
                            $statement->setFetchMode(PDO::FETCH_ASSOC);
                            $ProductList = $statement->fetchAll();
                        } else {
                            $statement = $connection->prepare("SELECT
                            *
                        FROM
                            products AS P
                        INNER JOIN categories AS C
                        ON
                            P.categoryId = C.categoryId
                        WHERE
                            C.categoryName LIKE '%$Soft%' LIMIT 0,12");
                            $statement->execute([]);
                            $statement->setFetchMode(PDO::FETCH_ASSOC);
                            $ProductList = $statement->fetchAll();
                        }
                    }
                    foreach ($ProductList as $Product) { ?>
                        <div class="product-item lighting col-6 col-md-4 col-lg-4">
                            <div class="product product-4">
                                <figure class="product-media">
                                    <span class="product-label"><?
                                                                $Status = 0;
                                                                if ($Product['sale'] > 0) {
                                                                    $Status = 1;
                                                                }
                                                                if ($Product['status'] != 1) {
                                                                    $Status = 2;
                                                                }
                                                                if ($Status == 1) {
                                                                    echo ("Sale");
                                                                } elseif ($Status == 2) {
                                                                    echo ("Out of Stock");
                                                                } else {
                                                                }
                                                                ?></span>
                                    <a href="./Product_Detail.php?productId=<?= $Product['productId'] ?>">
                                        <img src="./uploads/<?= $Product['image'] ?>" alt="Product image" class="product-image">
                                    </a>
                                </figure><!-- End .product-media -->
                                <div class="product-body">
                                    <h3 class="product-title"><a><?= $Product['productName'] ?></a></h3><!-- End .product-title -->
                                    <div class="product-price">
                                        <div class="out-price"><?= currency_format($Product['price']) ?></div><!-- End .out-price -->
                                    </div><!-- End .product-price -->
                                    <div class="product-action">
                                        <?
                                        if ($Product['status'] == 1) { ?>
                                            <a href="./Add_To_Cart.php?productId=<?= $Product['productId'] ?>" class="btn-product btn-cart"><span>add to cart</span><i class="icon-long-arrow-right"></i></a>
                                        <? }
                                        ?>
                                    </div><!-- End .product-action -->
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div><!-- End .product-item -->
                    <? }
                    ?>
                </div><!-- End .products-container -->
            </div><!-- End .container -->

            <div class="more-container text-center mt-0 mb-7">
                <a href="./ShopList.php" class="btn btn-outline-dark-3 btn-more"><span>more products</span><i class="la la-refresh"></i></a>
            </div><!-- End .more-container -->
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

    <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="assets/images/popup/newsletter/logo.png" class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- .End .input-group -->
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>
                            </div><!-- End .custom-checkbox -->
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="assets/images/popup/newsletter/img-1.jpg" class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/wNumb.js"></script>
    <script src="assets/js/nouislider.min.js"></script>
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-11.js"></script>
</body>


<!-- molla/index-11.html  22 Nov 2019 09:58:42 GMT -->

</html>