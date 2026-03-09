<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Link for Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

<!-- Script for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<!-- Font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<!-- Stylesheet link -->
    <link rel="stylesheet" href="CSS/style.css">

<!-- Fontawsome link for icons -->
    <script src="https://kit.fontawesome.com/2a292e456c.js" crossorigin="anonymous"></script>


<!-- Link for Icon -->
    <link rel="icon" href="Images/Raw images/fevicon.ico" type="image">

<!-- TITLE for website -->
    <title>Alaya cotton</title>

</head>
<body>
<?php
    require_once __DIR__."\config\bootstrap.php";
    require_once __DIR__."\database\db_connection.php";
    require_once __DIR__."\database\wishlist_db.php";
    require_once __DIR__.'\database\session_management.php';
    
//Sesseion check 
    $db_conn = new db_connection();
    $pdo = $db_conn -> get_connection();
    $session = new session_management($pdo); 


    

    $client_name = "";
    $client_id = "";
    if($session->checkSession()){
        $client_name = $_SESSION['user_name'];
        $client_id = $_SESSION['user_id'];
        $wishlist = new wishlist($pdo, $client_id, $client_name);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST["logout"])){
            $session->logout();
        }
    }

?>




<!-- Top bar for offers -->
    <div class="top-bar container-fluid text-center py-2 bg-warning align-middle">
        Free delivery on orders above ₹599 | Cash on Delivery Available
    </div>

<!-- Header for Header section  -->
    <header class="container-fluid px-0 sticky-top">
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
                    <a href="index.php">
                        <img src="Images/Raw images/Alaya-Logo---English_01.jpg" alt="Alaya logo image" title="Alaya logo image"  width="150px" class="logo-icon">
                    </a>
                </div>

            <!-- Column 3 for icons of three  -->
                <div class="icon-array col-lg-2 col-md-2 col-sm-2 col-4 d-flex align-items-center justify-content-around">
                <!-- Account icon -->
                 <div class="account">
                    <button class="s-btn" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Account " data-bs-placement="top" id="account-icon">
                        <i class="fa-solid fa-user"></i>
                        
                    </button>
                    
                    <div class=" account-menu p-3">
                        <?php
                            if($session->checkSession()){
                                
                                echo '<ul class="w-100 acount-list text-center">
                                        <li class="my-2">
                                            <img src="Images/Raw images/profile-svgrepo-com (2).svg" width="70px" height="70px">
                                        </li>
                                        <li class="my-2">
                                            <p class="m-0 fw-bold text-success">'.$client_name.'</p>
                                        </li>
                                        <li class="my-2"> <a href="public/profile.php" class="btn py-0 px-4 border border-2 border-secondary">View Profile</a> </li>
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
                                            <a href="public/login-mail.php" class="btn fw-bold py-1" style="background-color:#faee00;">Login</a>
                                        </li>
                                        <li class=" list-group-item" >
                                            <p class="mt-0 mb-1">Don\'t Have an Account?</p>
                                            <a href="public/Register.php" class="fw-bold py-1 ">Register now</a>
                                        </li>
                                    </ul>';
                            }
                        ?>
                        </div>
                 </div>

                    

                <!-- Wishlist icon -->
                    <a href="/public/wishlist.php" class="s-btn wishlist position-relative" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Wishlist " data-bs-placement="top" >
                        <i class="fa-solid fa-heart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded text-dark border border-1 border-dark" style="background-color: #faee00; padding: 3px 3px!important;">
                            <?php
                                if(isset($wishlist)){
                                    $count = $wishlist -> count_product();
                                    if($count < 100 & $count >= 0){
                                        echo $count;
                                    }else{
                                        echo "99+";
                                    }
                                }else{
                                    echo "0";
                                }
                            ?>
                        
                        </span>
                    </a>

                <!-- Cart icon -->
                    <a href="public/cart.php" class="s-btn card" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="cart" data-bs-placement="top">
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

<!--Section 1  Carousal  -->
    <section class="carousal">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="Images/Raw images/carousal 1.jpeg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="Images/Raw images/carousal 2.jpeg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="Images/Raw images/carousal 3.jpeg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        </div>
    </section>

<!-- Section 2 for Shirts of Number 3 -->
    <section class="container-fluid m-0 p-0" style="width:100%!important;">
    <!-- Div for Heading  -->
        <div class="container-fluid fs-1 fw-3 py-5 text-center">
            Shop This Look
        </div>

    <!-- div for Photos -->
     <div class=" row p-0 m-0">
        <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-2">
            <div class="img-div">
                <img src="Images/Raw images/55.webp" alt="Alaya shirt image" title="Alaya shirt image" class="img-fluid m-0 p-0" >
                
            <!-- Cart Hover box -->
                <div class="cart-outer">
                    <div class="cart-hover">  
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Shop this look</span>
                    </div>
                </div>
            </div>
            
            <p class="w-100 text-center">Majesty Combo</p> 
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-2">
            <div class="img-div">
                <img src="Images/Raw images/02.webp" alt="Alaya shirt image" title="Alaya shirt image" class="img-fluid" >
            <!-- Cart Hover box -->
                <div class="cart-outer">
                    <div class="cart-hover">  
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Shop this look</span>
                    </div>
                </div>
            </div>
            <p class="w-100 text-center">Mc Neo</p> 
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-2 ">
            <div class="img-div">
                <img src="Images/Raw images/03.webp" alt="Alaya shirt image" title="Alaya shirt image" class="img-fluid" >
            
            <!-- Cart Hover box -->
                <div class="cart-outer">
                    <div class="cart-hover">  
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Shop this look</span>
                    </div>
                </div>
            </div>
            <p class="w-100 text-center" >White combo</p> 
        </div>
     </div>

    </section><!-- Section for shirts ends here -->

<!-- Section 3 for 3 image -->
    <section class="container-fluid p-5 my-5 border-bottom ">
        <div class="row ">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-2">
            <img src="Images/Raw images/Section 3 image 1.webp" alt="Alaya shirt images" title="Alaya shirt images" class="img-fluid">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4  col-12 p-2">
            <img src="Images/Raw images/Section 3 image 2.webp" alt="Alaya shirt images" title="Alaya shirt images" class="img-fluid">

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-2">
            <img src="Images/Raw images/Section 3 image 3.webp" alt="Alaya shirt images" title="Alaya shirt images" class="img-fluid"> 
            
        </div>
        </div>
        
    </section><!--Section for 3 ends here  -->

<!-- Section 4 for offers -->
    <section class="offers container pb-5">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-6 d-flex ">
                <div class=" w-25">
                    <img src="Images/Raw images/Payment.png" alt="Payment option image for alayas" title="Payment option image for alayas" class="img-fluid" width="35px">
                </div>
                <div >
                    <h4>
                    Flexible Payment
                    </h4>
                    <p>Pay with Credit Cards, Debit Cards & UPI</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-6 d-flex ">
                <div class=" w-25">
                    <img src="Images/Raw images/Box .png" alt="Shipping image for alayas" title="Shipping image for alayas" class="img-fluid" width="35px">
                </div>
                <div >
                    <h4>
                    Free Shipping
                    </h4>
                    <p>Free shipping on order value above Rs.599/-</p>
                </div>
            </div><div class="col-lg-3 col-md-3 col-sm-3 col-6 d-flex ">
                <div class=" w-25">
                    <img src="Images/Raw images/Exchange.png" alt="Exchange image for alayas" title="Exchange image for alayas" class="img-fluid" width="35px">
                </div>
                <div >
                    <h4>
                    Exchange
                    </h4>
                    <p>Within 10 days for an exchange.</p>
                </div>
            </div><div class="col-lg-3 col-md-3 col-sm-3 col-6 d-flex ">
                <div class=" w-25">
                    <img src="Images/Raw images/Oline chat.png" alt="Online Chat Support image for alayas" title="Online Chat Support image for alayas" class="img-fluid" width="35px">
                </div>
                <div >
                    <h4>
                    Online Chat Support
                    </h4>
                    <p>Hours : 9AM to 7PM (Mon-Sat)</p>
                </div>
            </div>
        </div>
    </section><!-- Section 4 for Offer option ends here-->
    
<!-- Section 5 for Image Gallary and Shirt and Dhoti section  -->
    <section class="container py-5 border-5 border-bottom border-warning mb-5">
        <h2 class="text-center pb-3">Wedding Celebration</h2>
        <div class="row">
        <!-- Single image column -->
            <div class="single-img col-lg-6 col-md-12 col-sm-12 col-xs-12 ">
                <img src="Images/Raw images/101.jpg" alt="Alaya shirt image" title="Alaya shirt image" class="img-fluid">
            </div>

        <!-- Four image column -->
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ">

            <!-- Row 1 for first 2 shirts images -->
                <div class="row d-flex justify-content-around p-3">
                <!-- column 1 -->
                    <div class="col-6 img-col d-flex flex-column align-items-center">
                    <!-- Image 1 -->
                        <div class="images d-flex flex-column align-items-center">
                            <img src="Images/product-images/copper shirt/copper shirt 1.png" alt="Alaya cotton shirt" class="img-top img-fluid">
                            <img src="Images/product-images/copper shirt/copper shirt 2.png" alt="Alaya cotton shirt" class="img-under img-fluid">

                        <!-- Icon set div -->
                            <div class="icon-set ">  
                                <span class="icon-1">
                                    <i class="fa-solid fa-heart "></i>
                                </span>
                                <span class="icon-2">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </span>
                                <span class="icon-3">
                                    <a href="public\product-view.php?id=1"><i class="fa-solid fa-eye"></i></a>
                                </span>
                                
                            </div><!-- Icon set div is ends here -->
                        </div>
                    

                    <!-- Div for information -->
                        <div class="info">
                            <p><b>Kondattam Copper Tissue Shirt & Gold Jari Border Dhoti Set</b></p>
                            <p>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                            </p>
                            <p>Rs. 1,500.00</p>
                        </div>
                    </div><!-- Image Column 1 div ends here -->
                    

                <!-- column 2 -->
                    <div class="col-6 img-col d-flex flex-column align-items-center">
                    <!-- Image 2 -->
                        <div class="images d-flex flex-column align-items-center">
                            <img src="Images/product-images/gold border shirt/gold shirt 1.png" alt="Alaya cotton gold shirt" class="img-top img-fluid">
                            <img src="Images/product-images/gold border shirt/gold shirt 2.png" alt="Alaya cotton gold shirt" class="img-under img-fluid">

                        <!-- Icon set div -->
                            <div class="icon-set ">  
                                <span class="icon-1">
                                    <i class="fa-solid fa-heart "></i>
                                </span>
                                <span class="icon-2">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </span>
                                <span class="icon-3">
                                    <a href="public\product-view.php?id=2"><i class="fa-solid fa-eye"></i></a>                                    
                                </span>
                                
                            </div><!-- Icon set div is ends here -->
                        </div>
                    

                    <!-- Div for information -->
                        <div class="info">
                            <p><b>Kondattam Tissue Shirt & Dhoti Set- Copper</b></p>
                            <!-- <p>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                            </p> -->
                            <p>Rs. 1,500.00</p>
                        </div>
                    </div><!-- Image Column 2 div ends here -->
                </div><!-- Row div ends here -->

            <!-- Row 2 for another 2 shirts -->
                <div class="row d-flex justify-content-around p-3">
                <!-- column 3 -->
                    <div class="col-6 img-col d-flex flex-column align-items-center">
                    <!-- Image 3 -->
                        <div class="images d-flex flex-column align-items-center">
                            <img src="Images/product-images/silver shirt/silver shirt 1.png" alt="Alaya cotton silver shirt" class="img-top img-fluid">
                            <img src="Images/product-images/silver shirt/silver shirt 2.png" alt="Alaya cotton silver shirt" class="img-under img-fluid">

                        <!-- Icon set div -->
                            <div class="icon-set ">  
                                <span class="icon-1">
                                    <i class="fa-solid fa-heart "></i>
                                </span>
                                <span class="icon-2">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </span>
                                <span class="icon-3">
                                    <a href="public\product-view.php?id=3"><i class="fa-solid fa-eye"></i></a>
                                </span>
                                
                            </div><!-- Icon set div is ends here -->
                        </div>
                    
                    
                    <!-- Div for information -->
                        <div class="info">
                            <p><b>Kondattam Silver Tissue Shirt & Gold Jari Border Dhoti Set</b></p>
                            <!-- <p>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                            </p> -->
                            <p>Rs. 1,575.00</p>
                        </div>
                    </div><!-- Image Column 3 div ends here -->
                    

                <!-- column 4 -->
                    <div class="col-6 img-col d-flex flex-column align-items-center">
                    <!-- Image 4 -->
                        <div class="images d-flex flex-column align-items-center">
                            <img src="Images/product-images/blue shirt/blue shirt 1.png" alt="Alaya cotton blue shirt" class="img-top img-fluid">
                            <img src="Images/product-images/blue shirt/blue shirt 2.png" alt="Alaya cotton blue shirt" class="img-under img-fluid">

                        <!-- Icon set div -->
                            <div class="icon-set ">  
                                <span class="icon-1">
                                    <i class="fa-solid fa-heart "></i>
                                </span>
                                <span class="icon-2">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </span>
                                <span class="icon-3">
                                    <a href="public/product-view.php?id=4"><i class="fa-solid fa-eye"></i></a>
                                    
                                </span>
                                
                            </div><!-- Icon set div is ends here -->
                        </div>
                    
                    
                    <!-- Div for information -->
                        <div class="info">
                            <p><b>Kondattam Grand Tissue Shirt & Dhoti Combo - Blue Hosta</b></p>
                            <p>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-solid fa-star text-warning"></i>
                                <i class="fa-regular fa-star text-warning"></i>
                                <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                            </p>
                            <p>Rs. 1,575.00</p>
                        </div>
                    </div><!-- Image Column 4 div ends here -->
                </div>
                <!-- Row div for another 2 shirts ends here -->

            </div>
        </div>
    </section><!-- Section 5 ends here  -->

<!-- Section 6 for row of images cart  -->
    <section class="container-fluid ">
    <!-- Overall row -->
     <div class="row d-flex justify-content-center">

    <!-- Item 1 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6  ">
        <!-- Image 1 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="Images/Raw images/Kgf1-top.webp" alt="" class="img-top img-fluid">
                <img src="Images/Raw images/Kgf1-under.webp" alt="" class="img-under img-fluid">
            
            <!-- Icon set div -->
                <div class="icon-set ">  
                    <span class="icon-1">
                        <i class="fa-solid fa-heart "></i>
                    </span>
                    <span class="icon-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span class="icon-3">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    
                </div><!-- Icon set div is ends here -->
            </div>
                    

            <!-- Div for information -->
                <div class="info">
                    <p><b>Kondattam Tissue Shirt & Dhoti Set- Gold</b></p>
                    <!-- <p>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                    </p> -->
                    <p>Rs. 1,500.00</p>
                </div>
        </div><!-- Item 1 ends here -->
    <!-- Item 2 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6 ">
        <!-- Image 2 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="Images/Raw images/Kgf2-top.webp" alt="" class="img-top img-fluid">
                <img src="Images/Raw images/Kgf2-under.webp" alt="" class="img-under img-fluid">

            <!-- Icon set div -->
                <div class="icon-set ">  
                    <span class="icon-1">
                        <i class="fa-solid fa-heart "></i>
                    </span>
                    <span class="icon-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span class="icon-3">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    
                </div><!-- Icon set div is ends here -->
            </div>
        

        <!-- Div for information -->
            <div class="info">
                <p><b>Kondattam Tissue Shirt & Dhoti Set- Copper</b></p>
                <!-- <p>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                </p> -->
                <p>Rs. 1,500.00</p>
            </div>
        </div><!-- Item 2 ends here -->
    <!-- Item 3 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-xs-6 d-none d-md-block ">
        <!-- Image 4 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="Images/Raw images/Kgf4-top.webp" alt="" class="img-top img-fluid">
                <img src="Images/Raw images/Kgf4-under.webp" alt="" class="img-under img-fluid">

            <!-- Icon set div -->
                <div class="icon-set ">  
                    <span class="icon-1">
                        <i class="fa-solid fa-heart "></i>
                    </span>
                    <span class="icon-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span class="icon-3">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    
                </div><!-- Icon set div is ends here -->
            </div>
        
        
        <!-- Div for information -->
            <div class="info">
                <p><b>Kondattam Tissue Shirt & Dhoti Set- Green</b></p>
                <!-- <p>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-regular fa-star text-warning"></i>
                    <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                </p> -->
                <p>Rs. 1,575.00</p>
            </div>
        </div><!-- Item 3 ends here -->
    <!-- Item 4 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-xs-6 d-none d-md-block ">
         <!-- Image 3 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="Images/Raw images/Kgf3-top.webp" alt="" class="img-top img-fluid">
                <img src="Images/Raw images/Kgf3-under.webp" alt="" class="img-under img-fluid">

            <!-- Icon set div -->
                <div class="icon-set ">  
                    <span class="icon-1">
                        <i class="fa-solid fa-heart "></i>
                    </span>
                    <span class="icon-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span class="icon-3">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    
                </div><!-- Icon set div is ends here -->
            </div>
        
        
        <!-- Div for information -->
            <div class="info">
                <p><b>Kondattam Tissue Shirt & Dhoti Set- Blue</b></p>
                <!-- <p>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                </p> -->
                <p>Rs. 1,575.00</p>
            </div>   
        </div><!-- Item 4 ends here -->
    <!-- Item 5 -->
        <div class="col-xl-2 col-lg-2  d-none d-md-none d-xl-block d-lg-block">
        <!-- Image 5 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="Images/Raw images/dothi 1 top.webp" alt="" class="img-top img-fluid">
                <img src="Images/Raw images/dothi 1.jpg" alt="" class="img-under img-fluid">

            <!-- Icon set div -->
                <div class="icon-set ">  
                    <span class="icon-1">
                        <i class="fa-solid fa-heart "></i>
                    </span>
                    <span class="icon-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span class="icon-3">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    
                </div><!-- Icon set div is ends here -->
            </div>
        
        
        <!-- Div for information -->
            <div class="info">
                <p><b>Cotton Dhoti Set - Wide Gold</b></p>
                <!-- <p>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-regular fa-star text-warning"></i>
                    <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                </p> -->
                <p>Rs. 1,575.00</p>
            </div>
        </div><!-- Item 5 ends here -->
    <!-- Item 6 --> 
        <div class="col-xl-2 col-lg-2  d-none d-md-none d-xl-block d-lg-block">
        <!-- Image 6 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="Images/Raw images/dothi 2 top.webp" alt="" class="img-top img-fluid">
                <img src="Images/Raw images/dothi 2.jpg" alt="" class="img-under img-fluid">

            <!-- Icon set div -->
                <div class="icon-set ">  
                    <span class="icon-1">
                        <i class="fa-solid fa-heart "></i>
                    </span>
                    <span class="icon-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span class="icon-3">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                    
                </div><!-- Icon set div is ends here -->
            </div>
        
        
        <!-- Div for information -->
            <div class="info">
                <p><b>Cotton Dhoti Set -Line Gold</b></p>
                <!-- <p>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-regular fa-star text-warning"></i>
                    <span>1 review  | <span><i class="fa-solid fa-comments"></i> 1 question</span></span>
                </p> -->
                <p>Rs. 1,575.00</p>
            </div>
        </div><!-- Item 6 ends here -->
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


<!-- Whatsapp floating icon -->
    

    <section class="Whatsapp">
    <!-- Whatsapp chat box  -->
        <div class="whatsapp-chat">
            <div class="contact">
                <p><b>WhatsApp</b></p>
                <button class="close-btn" id="close-btn" onclick="whatsapp_close(event)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="msg-body">
                <div></div>
                <p><b>Alaya cottons</b></p>
            </div>
            <div class="text-box">
                <a href="https://wa.me/+916385483215"  target="_blank" rel="noopener" class="chat">Chat on Whatsapp</a>
            </div>
        </div>


    <!-- Whatsapp floating Icon -->
        <button class="whatsapp-float " id="whatsapp-float " onclick="whatsapp_open(event)">
            <img src="https://img.icons8.com/color/48/000000/whatsapp.png" alt="WhatsApp Chat" />
        </button>
        
    </section>


    
 

<!-- Script for custom script file -->
    <script src="JS/script.js"></script>
    
</body>
</html>