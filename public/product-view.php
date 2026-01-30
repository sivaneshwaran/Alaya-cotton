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
                    <a href="" class="s-btn " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Wishlist " data-bs-placement="top" >
                        <i class="fa-solid fa-heart"></i>
                    </a>

                <!-- Cart icon -->
                    <a href="" class="s-btn " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="card " data-bs-placement="top">
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
</body>
</html>