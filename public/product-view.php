<?php
    require_once __DIR__.'\..\config\bootstrap.php';
    require_once __DIR__.'\..\database\product-database.php';
    require_once __DIR__.'\..\database\db_connection.php';
// DB connection to Product Table
    $db_conn = new db_connection();
    $pdo = $db_conn->get_connection();
    $product_db = new product_db($pdo);

    $product_id = htmlspecialchars($_GET['id']);
    $product = $product_db->getProduct($product_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product["product_name"]?></title>
<!-- Link for Icon -->
    <link rel="icon" href="/./Images/Raw images/fevicon.ico" type="image">

<!-- Link for Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

<!-- Script for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<!-- Font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<!-- Stylesheet link -->
    <link rel="stylesheet" href="/./CSS/style.css">
    <link rel="stylesheet" href="/./CSS/style-register.css">
    <link rel="stylesheet" href="/./CSS/style-product-view.css">
    

<!-- Fontawsome link for icons -->
    <script src="https://kit.fontawesome.com/2a292e456c.js" crossorigin="anonymous"></script>


<!-- GSAP Link -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

</head>
<body>
<?php

    require_once __DIR__.'\..\database\session_management.php';
    
//Sesseion check 
    $session = new session_management(); 

    $client_name = "";
    $client_id = "";
    if($session->checkSession()){
        $client_name = $_SESSION['user_name'];
        $client_id = $_SESSION['id'];
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST["logout"])){
            $session->logout();
            header("location: index.php");
            exit;
        }
    }

?>
<!-- Header for Header section  -->
    <header class=" container-fluid bg-white border border-2 border-top-0 border-start-0 border-end-0 border-warning px-0 sticky-top">
    <!-- Main bar Icons and Logo -->
        <div class="container-fluid ">
            <div class="main-bar row ">
            <!-- Column 1 for Search icon -->
                <div class="col-lg-2 col-md-2 col-sm-2 col-3 d-flex align-items-center justify-content-center">
                    <a href="" class="s-btn nav-link " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Search " data-bs-placement="bottom">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </div>

            <!-- column 2 for logo -->
                <div class="col-lg-8 col-md-8 col-sm-8 col-5 d-flex align-middle justify-content-center py-3 ">
                    <a href="/index.php">
                        <img src="/Images/Raw images/Alaya-Logo---English_01.jpg" alt="Alaya logo image" title="Alaya logo image"  width="150px" class="logo-icon">
                    </a>
                </div>

            <!-- Column 3 for icons of three  -->
                <div class="icon-array col-lg-2 col-md-2 col-sm-2 col-4 d-flex align-items-center justify-content-around">
                <!-- Account icon -->
                 <div class="account">
                    <button class="s-btn" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Account" data-bs-placement="top" id="account-icon">
                        <i class="fa-solid fa-user"></i>
                        
                    </button>
                    <div class="account-menu">
                        <?php
                            if($session->checkSession()){
                                
                                echo '<ul class="w-100 acount-list text-center">
                                        <li class="my-2">
                                            <img src="/Images/Raw images/profile-svgrepo-com (2).svg" width="70px" height="70px">
                                        </li>
                                        <li class="my-2">
                                            <p class="m-0 fw-bold text-success">'.$client_name.'</p>
                                        </li>
                                        <li class="my-2"> <a href="" class="btn py-0 px-4 border border-2 border-secondary">View Profile</a> </li>
                                        <li class="mt-2 border border-1 border-secondary border-start-0 border-end-0 border-bottom-0 pt-2" >
                                            <form action="" method="POST"> 
                                                <button class="btn btn-warning fw-bold" name="logout" >Logout</button>
                                            </form>
                                        </li>
                                    </ul>';

                            }else{
                                echo '<ul class="w-100 list-group list-group-flush text-center">
                                        <li class="list-group-item">
                                            <p class="mt-0 mb-1">Login to order</p>
                                            <a href="login-mail.php" class="btn fw-bold py-1" style="background-color:#faee00;">Login</a>
                                        </li>
                                        <li class=" list-group-item" >
                                            <p class="mt-0 mb-1">Don\'t Have an Account?</p>
                                            <a href="Register.php" class="fw-bold py-1 ">Register now</a>
                                        </li>
                                    </ul>';
                            }
                        ?>
                        </div>
                 </div>
                    

                <!-- Wishlist icon -->
                    <a href="wishlist.php" class="s-btn " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Wishlist" data-bs-placement="top" >
                        <i class="fa-solid fa-heart"></i>
                    </a>

                <!-- Cart icon -->
                    <a href="cart.php" class="s-btn " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="cart" data-bs-placement="top">
                       <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                   
                </div>

            <!-- column for empty space -->
                <div class="col-lg-1 col-md-1 col-sm-1 col-1 d-none d-lg-block ">

                </div>
            </div>
        </div>

   <!-- Bottom bar for Main menu -->
        <div class="main-menu container-fluid sticky-top bg-white px-5 d-flex align-items-center justify-content-evenly">
        <!-- Dropdown list 1 -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>DHOTI</b>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Cotton Dhotis</a></li>
                    <li><a class="dropdown-item" href="#">Tissu Dhotis</a></li>
                    <li><a class="dropdown-item" href="#">Prayer Dhoti</a></li>
                </ul>
            </div>

        <!-- Dropdown list 2 -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>SHIRTS</b>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><b>Color Shirts</b></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">MC Neo ( Printed )</a></li>
                    <li><a class="dropdown-item" href="#">Majesty ( Plain )</a></li>
                    <li><a class="dropdown-item" href="#">Winners Club</a></li>
                    <li><a class="dropdown-item" href="#">Carnival</a></li>
                    <li><a class="dropdown-item" href="#">Karna</a></li>
                </ul>
                
            </div>

        <!-- Dropdown list 3 -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>DHOTHI & SHIRTS</b>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><b>Colour Shirt & Dhoti Combo</b></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">MC Neo Combo</a></li>
                    <li><a class="dropdown-item" href="#">Arima Combo</a></li>
                    <li><a class="dropdown-item" href="#">Majesty Combo</a></li>
                    <li><a class="dropdown-item" href="#">Rolex Tissue Combo</a></li>
                    <li><a class="dropdown-item" href="#">Winners Club Combo</a></li>
                    <li><a class="dropdown-item" href="#">Carnival Black Combo</a></li>
                    <li><a class="dropdown-item" href="#">Karna combo</a></li>

                </ul>
            </div>

        <!-- Dropdown list 4 -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>KIDS</b>
                </button>
                <ul class="dropdown-menu ">
                    <li><a class="dropdown-item" href="#"><b>Dhoti & Shirt</b></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">BTS Tissue Dhoti Combo</a></li>
                    <li><a class="dropdown-item" href="#">Kids Kondattam Set</a></li>
                    <li><a class="dropdown-item" href="#">Veera Soora</a></li>
                    <li><a class="dropdown-item" href="#">Match & Catch Junior</a></li>
                    <li><a class="dropdown-item" href="#">Go Trendy ( Kurtha Set ) Cream</a></li>
                </ul>
            </div>

        <!-- Dropdown list 5 -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>WEDDING COLLECTION</b>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Readymade</a></li>
                </ul>
            </div>

        <!-- Dropdown list 6 -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>ACCESSORIES</b>
                </button>
                <ul class="dropdown-menu ">
                    <li><a class="dropdown-item" href="#">Dhoti Belt</a></li>
                    <li><a class="dropdown-item" href="#">Hand Kerchief</a></li>
                    <li><a class="dropdown-item" href="#">Cradle Dhoti For Born Baby Kids</a></li>
                    <li><a class="dropdown-item" href="#">Towel</a></li>
                </ul>
            </div>

        </div>
    </header>
<!-- Section for Product -->
    <section class="product">
        <div class="container-fluid">
            <div class="row">
            <!-- Product Image Column -->
                <div class="product-img col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="row px-2">
                    <!-- Images thumbnails -->
                        <div class="thumbnails col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2  ">
                            <div class="img-tile d-flex justify-content-center align-items-center">
                                <button class="img-btn">
                                    <img src="/./product-images/<?php echo $product["img1_uniqname"]; ?>" alt="Alaya cotton shirt">
                                </button>
                            </div>
                            <div class="img-tile d-flex justify-content-center align-items-center">
                                <button class="img-btn">
                                    <img src="/./product-images/<?php echo $product["img2_uniqname"]; ?>" alt="Alaya cotton shirt">
                                </button>
                            </div>
                            <div class="img-tile d-flex justify-content-center align-items-center">
                                <button class="img-btn">
                                    <img src="/./product-images/<?php echo $product["img3_uniqname"]; ?>" alt="Alaya cotton shirt">
                                </button>
                            </div>
                            <div class="img-tile d-flex justify-content-center align-items-center">
                                <button class="img-btn">
                                    <img src="/./product-images/<?php echo $product["img4_uniqname"]; ?>" alt="Alaya cotton shirt">
                                </button>
                            </div>
                            <div class="img-tile d-flex justify-content-center align-items-center">
                                <button class="img-btn">
                                    <img src="/./product-images/<?php echo $product["img5_uniqname"]; ?>" alt="Alaya cotton shirt">
                                </button>
                            </div>                                                                                    
                        </div>
                    <!-- Main Image -->
                        <div class="img-box col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 d-flex justify-content-center align-items-center ">
                            <img class="main-img" src="/./product-images/<?php echo $product["img1_uniqname"]; ?>" alt="Alaya cotton shirts">
                        </div>
                    </div>

                </div>

            <!-- Product Details column -->
                <div class="product-details col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 py-4">
                <!-- Product Name -->
                    <h3 class="my-3">
                        <?php echo $product["product_name"];?>
                    </h3>

                    <p class="fw-bold fs-4 text-danger my-3">
                        Rs. <?php echo $product["sell_price"];?>/-
                    </p>

                    <hr>
                <!-- Product description -->
                    <p class="my-3 ">
                        <?php echo $product["product_description"];?>
                    </p>

                <!-- Size Guide button -->
                    <div class="container px-0 py-3">
                        <button class="btn btn-warning focus-ring focus-ring-warning fw-semibold">Size Guide</button>
                    </div>

                <!-- Product size -->
                    <h5 class="mt-3">size</h5>
                    <div class="container gap-3 d-flex justify-content-start align-items-center py-2 px-0">
                    <!-- Check Box for "S" -->
                        <input type="radio" id="s-check" class="btn-check" value="s" name="size" checked>
                        <label for="s-check" class="btn btn-outline-dark">S</label>
                    <!-- Check Box for "M" -->
                        <input type="radio" id="m-check" class="btn-check" value="m" name="size">
                        <label for="m-check" class="btn btn-outline-dark">M</label>
                    <!-- Check Box for "L" -->
                        <input type="radio" id="l-check" class="btn-check" value="l" name="size">
                        <label for="l-check" class="btn btn-outline-dark">L</label>
                    <!-- Check Box for "XL" -->
                        <input type="radio" id="xl-check" class="btn-check" value="xl" name="size">
                        <label for="xl-check" class="btn btn-outline-dark">XL</label>
                    <!-- Check Box for "XXL" -->
                        <input type="radio" id="xxl-check" class="btn-check" value="xxl" name="size">
                        <label for="xxl-check" class="btn btn-outline-dark">XXL</label>                           
                    </div>

                <!-- Product sleeve type -->
                    <h5 class="mt-3">Sleeve</h5>
                    <div class="container gap-3 d-flex justify-content-start align-items-center py-2 px-0">
                    <!-- Check Box for "Full Sleeve" -->
                        <input type="radio" id="fullsleeve" class="btn-check" value="fullsleeve" name="sleeve" checked>
                        <label for="fullsleeve" class="btn btn-outline-dark">Full Sleeve</label>
                    <!-- Check Box for "Half Sleeve" -->
                        <input type="radio" id="halfsleeve" class="btn-check" value="halfsleeve" name="sleeve">
                        <label for="halfsleeve" class="btn btn-outline-dark">Half Sleeve</label>
                    </div>

                <!-- Product Add to cart and Buy button -->
                    <div class="container p-3 my-3 d-flex align-items-center justify-content-center gap-4 border border-2 border-start-0 border-end-0 ">
                        <button class="addcart btn btn-danger focus-ring focus-ring-danger w-50">Add to Cart</button>
                        <button class="buy btn btn-success focus-ring focus-ring-success w-50">Buy Now</button>
                    </div>

                </div>
            </div>
        </div>
    </section>

<!-- Footer for footer section  -->
    <footer class="footer container-fluid">

    <!-- First row for  list of service and  -->
        <div class="row p-5">

        <!-- Subscribe -->
            <div class="col-lg-3 col-md-6 ">
                <ul class="f-list">
                    <li class="topic">
                        Subscibe
                    </li>
                    <li class="li-items">
                        Enter your email below to be the first to know about new collections and product launches.
                    </li>
                    <li class="input">
                        <div class=""><i class="fa-regular fa-envelope"></i></div>
                        <input type="email" placeholder="Enter your email id" class="">
                        <i class="fa-solid fa-arrow-right"></i>
                    </li>

                    <li class="icons">
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-instagram"></i>
                        <i class="fa-brands fa-x-twitter"></i>
                        <i class="fa-brands fa-youtube"></i>
                    </li>
                </ul>

                
            </div>

        <!-- Policy -->
            <div class="col-lg-3 col-md-6 d-none d-md-block d-lg-block d-xl-block d-xxl-block">
                <ul class="f-list">
                    <li class="topic">Policy</li>
                    <li class="li-items">
                        Shipping & Delivery Policy
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items ">
                        Exchange Policy
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Cancel & Refund Policy
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Privacy Policy
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Terms of Service
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                </ul>
            </div> <!-- Policy div ends here -->

        <!-- Policy for mobile screen -->
            <p class="footer-dorpdown-xl d-inline-flex gap-1 d-block d-md-none d-lg-none d-xl-none d-xxl-none ">
              <a class="btn" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Policy
              </a>
            </p>
            <div class="collapse" id="collapseExample">
              <div class="card card-body">
                <ul class="f-list">
                    
                    <li class="li-items">
                        Shipping & Delivery Policy
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items ">
                        Exchange Policy
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Cancel & Refund Policy
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Privacy Policy
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Terms of Service
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                </ul>
              </div>
            </div><!-- Policy for mobile screen div ends here -->

        <!-- Quick links -->
            <div class="col-lg-3 col-md-6 d-none d-md-block d-lg-block d-xl-block d-xxl-block">
                <ul class="f-list">
                    <li class="topic">Quick links</li>
                    <li class="li-items">
                        Dhoti
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        White Shirts
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Colour Shirts
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Dhoti & Shirts
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Wedding Collection
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Kids Dhoti & Shirts
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                </ul>
            </div><!-- Quick links div ends here -->

        <!-- Quick links for mobile screen -->
            <p class="footer-dorpdown-xl d-inline-flex gap-1 d-block d-md-none d-lg-none d-xl-none d-xxl-none ">
              <a class="btn" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Quick links
              </a>
            </p>
            <div class="collapse" id="collapseExample">
              <div class="card card-body">
                <ul class="f-list">
                    
                    <li class="li-items">
                        Dhoti
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items ">
                        White Shirts
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Colour Shirts
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Dhoti & Shirts
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Wedding Collection
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Kids Dhoti & Shirts
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                </ul>
              </div>
            </div><!-- Quick links for mobile screen div ends here -->

        <!-- Service -->
            <div class="col-lg-3 col-md-6 d-none d-md-block d-lg-block d-xl-block d-xxl-block">
                <ul class="f-list">
                    <li class="topic">
                        Service
                        
                    </li>
                    <li class="li-items">
                        About us
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Blog
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Track Your Order
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Contact us
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    
                </ul>
            </div>

        <!-- Service for mobile screen -->
            <p class="footer-dorpdown-xl d-inline-flex gap-1 d-block d-md-none d-lg-none d-xl-none d-xxl-none ">
              <a class="btn" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Service
              </a>
            </p>
            <div class="collapse" id="collapseExample">
              <div class="card card-body">
                <ul class="f-list">
                    
                    <li class="li-items">
                        About us
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items ">
                         Blog
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Track Your Order
                        <div class="underline-out-1">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                    <li class="li-items">
                        Contact us
                        <div class="underline-out-2">
                            <div class="inner-box"></div>
                        </div>
                    </li>
                </ul>
              </div>
            </div><!-- Service for mobile screen div ends here -->
        </div><!-- Service div ends here -->

    <!-- Second Row for footer -->
        <div class="row">
        </div><!-- Second row for footer ends here-->   
    </footer>

<!-- Script for custom script file -->
    <script src="\..\JS\script.js"></script>
    <script>
        const img_btn = document.querySelector(".img-btn");
        const main_img = document.querySelector(".main-img");
        function getSrc(event){
            var child = event.firstElementChild;
            var source = child.getAttribute("src");
            main_img.setAttribute("src", source);
            console.log("click");
        }

        img_btn.addEventListener("click", getSrc);
    </script>
</body>
</html>