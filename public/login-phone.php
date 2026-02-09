<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alaya cotton registeration</title>
<!-- Link for Icon -->
    <link rel="icon" href="/Images/Raw images/fevicon.ico" type="image">

<!-- Link for Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

<!-- Script for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<!-- Font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<!-- Stylesheet link -->
    <link rel="stylesheet" href="/CSS/style.css">
    <link rel="stylesheet" href="/CSS/style-register.css">
    

<!-- Fontawsome link for icons -->
    <script src="https://kit.fontawesome.com/2a292e456c.js" crossorigin="anonymous"></script>


<!-- GSAP Link -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

</head>
<body>
    <?php
        require_once __DIR__.'\..\config\bootstrap.php';
        require_once __DIR__.'\..\database\db_connection.php';
        require_once __DIR__.'\..\database\user_database.php';
        require_once __DIR__.'\..\database\session_management.php';

        $session = new session_management(); 
    
        $client_name = "";
        $client_id = "";
        if($session->checkSession()){
            $client_name = $_SESSION['user_name'];
            $client_id = $_SESSION['id'];
            header("location: \index.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST["logout"])){
                $session->logout();
                header("location: index.php");
                exit;
            }
        }

    // Variables for store data
        $phone_number = $password = "";

    // Variables for store Error msg
        $err_msg = $success_msg = "";

    // Login status
        $login_status = false;

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $db_conn = new db_connection();
        $pdo = $db_conn->get_connection();
        $user_db = new user_database($pdo);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(empty($_POST['phone-number']) && empty($_POST['password'])){
                $err_msg = "All fields required";
            }else{
                $phone_number = test_input($_POST['phone-number']);

                if(!preg_match("/^[6-9]\d{9}$/", $phone_number)){
                    $err_msg = "Invalid Phone Number";
                }elseif($user_db->checkPhone($phone_number)){
                    $password = test_input($_POST['password']);
                    if(empty($password)){
                        $err_msg = "Enter password";
                    }elseif($user_db->verifyPasswordPhone($phone_number, $password)){
                        $success_msg = "Login Success....";
                        $user_data = $user_db->fetchSessionDetails($phone_number);
                        $session->login($user_data);
                        unset($_POST);
                        $login_status = true;

                    }else{
                        $err_msg = "Invalid User Credentials";
                    }
                }else{
                    $err_msg = "Invalid User Credentials";
                }
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
                    <button class="s-btn" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Account " data-bs-placement="top" id="account-icon">
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


    </header>
<!-- Login section  -->
    <section class="login container-fluid overflow-hidden p-0 d-flex justify-content-evely align-items-center flex-column">
                
                <div class="msg mb-3 d-flex justify-content-center align-items-center ">
                    <?php echo empty($err_msg)? "":'<span class="err_msg">' .$err_msg .'</span>' ?><!-- Error Msg-->
                    <?php echo empty($success_msg)? "":'<span class="success_msg">'. $success_msg.'</span>' ?><!-- success Msg-->
                </div>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login-form p-0 border border-2 border-secondary rounded-4 d-flex justify-content-center align-items-center " id='login-form'>

                <!-- Phone number Login -->
                    <div class="phone-login container-fluid h-100">
                        <h2 class="w-100 text-center ">Login</h2>

                        <div class="phone-input w-100 mb-2 ">
                            <label for="phone-number" class="fw-bold">Phone Number</label>
                            <input type="text" class="form-control  border border-1 border-secondary" id="phone-number" placeholder="Enter your Phone Number" name="phone-number" value=<?php echo isset($_POST["phone-number"])? htmlspecialchars($_POST["phone-number"]):"";?>>
                        </div>
                        <div class="pass-input w-100 mb-2 ">
                            <label for="password"  class="fw-bold">Password</label>
                            <div class="form-control border border-1 border-primary d-flex justify-content-center align-items-center">
                                <input type="password" class="" autocomplete="off" name="password" id="password_input" placeholder="Enter password"  value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']):"";?>">
                                <button class="show_pass" type="button"><i class="fa-solid fa-eye"></i></button>
                            </div>                                
                        </div>

                        <button class="btn btn-secondary w-100 my-1 "> Login </button>

                        <p class="my-0 w-100 text-center fw-bold">(or)</p>

                        <p class="my-1 w-100 text-center  border border-1 border-secondary border-top-0 border-start-0 border-end-0 pb-2"> Don't have an account <a class="fw-bold" href="register.php">Register here</a></p>

                        <a href="login-mail.php" class="btn w-100 btn-success mt-3 email-btn" id="email-btn">Login using Email ID <i class="fa-solid fa-arrows-rotate ms-3" style="color:black"></i></a>
                    </div>                             
                
                </form>


    </section>


<!-- Section 6 for row of images cart  -->
    <section class="container-fluid pt-5">
    <!-- Overall row -->
     <h3 class="container w-100 p-3 text-center"> 
        Recommanded deals
     </h3>
     <div class="row d-flex justify-content-center">

    <!-- Item 1 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6  ">
        <!-- Image 1 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="/Images/Raw images/Kgf1-top.webp" alt="" class="img-top img-fluid">
                <img src="/Images/Raw images/Kgf1-under.webp" alt="" class="img-under img-fluid">
            
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
        </div><!-- Item 1 ends here -->
    <!-- Item 2 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6 ">
        <!-- Image 2 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="/Images/Raw images/Kgf2-top.webp" alt="" class="img-top img-fluid">
                <img src="/Images/Raw images/Kgf2-under.webp" alt="" class="img-under img-fluid">

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
                <img src="/Images/Raw images/Kgf4-top.webp" alt="" class="img-top img-fluid">
                <img src="/Images/Raw images/Kgf4-under.webp" alt="" class="img-under img-fluid">

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
        </div><!-- Item 3 ends here -->
    <!-- Item 4 -->
        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-xs-6 d-none d-md-block ">
         <!-- Image 3 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="/Images/Raw images/Kgf3-top.webp" alt="" class="img-top img-fluid">
                <img src="/Images/Raw images/Kgf3-under.webp" alt="" class="img-under img-fluid">

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
        <div class="col-xl-2 col-lg-2  d-none d-md-none d-xl-block d-lg-block ">
        <!-- Image 5 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="/Images/Raw images/dothi 1 top.webp" alt="" class="img-top img-fluid">
                <img src="/Images/Raw images/dothi 1.jpg" alt="" class="img-under img-fluid">

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
        </div><!-- Item 5 ends here -->
    <!-- Item 6 --> 
        <div class="col-xl-2 col-lg-2  d-none d-md-none d-xl-block d-lg-block">
        <!-- Image 6 -->
            <div class="images d-flex flex-column align-items-center">
                <img src="/Images/Raw images/dothi 2 top.webp" alt="" class="img-top img-fluid">
                <img src="/Images/Raw images/dothi 2.jpg" alt="" class="img-under img-fluid">

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
    
<!-- Script for custom script file -->
    <script src="/JS/script.js"></script>
    <script src="/JS/script-register.js"></script>

<script>
  window.onload = function() {
    document.getElementById("login-form").reset();
  };
  if(<?php echo $login_status ?>){
    setTimeout(() => {
        window.location.replace("/index.php");

    }, 1000);
  }
</script>
</body>
</html>