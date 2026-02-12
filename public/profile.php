<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

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
    <link rel="stylesheet" href="/CSS/style-profile.css">
    

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
    require_once __DIR__."\..\database\wishlist_db.php";
    require_once __DIR__.'\..\database\session_management.php';

// Creating objects for Database connection
    $dbConn = new db_connection();
    $pdo = $dbConn->get_connection();//PDO connection object
    $user_db = new user_database($pdo);//User database

    $session = new session_management(); //Session management

    $client_name = "";
    $client_id = "";
    $client_details = array();
    if($session->checkSession()){
        $client_name = $_SESSION['user_name'];
        $client_id = $_SESSION['id'];
        $wishlist = new wishlist($pdo, $client_id, $client_name);
        $client_details = $user_db->fetchAllDetails($client_id);
    }else{
        header("location: login-mail.php");
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST["logout"])){
            $session->logout();
            header("location: login-mail.php");
            exit;
        }
    }

?>

<!-- Header for Header section  -->
    <header class="container-fluid px-0 sticky-top border border-2 border-top-0 border-start-0 border-end-0 border-warning bg-light">
    <!-- Main bar Icons and Logo -->
        <div class="container-fluid ">
            <div class="main-bar row ">
            <!-- Column 1 for Search icon -->
                <div class="col-lg-2 col-md-2 col-sm-2 col-3 d-flex align-items-center justify-content-center">
                    <a href="#" class="s-btn nav-link " data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Search " data-bs-placement="bottom">
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

                <!-- Wishlist icon -->
                    <a href="wishlist.php" class="s-btn position-relative" type="button" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Wishlist" data-bs-placement="top" >
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
                    <a href="cart.php" class="s-btn " type="button" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="cart" data-bs-placement="top">
                       <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                   
                </div>

            <!-- column for empty space -->
                <div class="col-lg-1 col-md-1 col-sm-1 col-1 d-none d-lg-block ">

                </div>
        </div>
        </div>

    </header>

<!-- Profile details section -->
    <section class="profile container-fluid p-0">
        <div class="container-fluid p-3 m-0 d-flex justify-content-start align-items-center" style="background-color: rgba(245, 237, 166, 1);">
            <img class="profile-img" src="/Images/Raw images/account-avatar-profile-user-6-svgrepo-com.svg" alt="profile picture alaya cotton " >
            <div class="container-fluid d-flex justify-content-start align-items-start flex-column ms-2 border border-5 border-secondary border-top-0 border-end-0 border-bottom-0">
                <p class="h2 text-success fw-bold"><?php echo $client_details['client_name']?></p>
                <p><b>client_id: </b><?php echo $client_id?></p>
                <form action="" method="POST" >
                    <button class="btn btn-danger fw-bold px-3" name="logout">Logout</button>
                </form>
            </div>
        </div>
        <div class="row p-5" style="background-color: rgba(255, 248, 222, 1);">
        <!-- First column for client data -->
            <div class="col-lg-6">
            <!-- Name -->
                <div class="data-box form-group mb-2 mb-2">  
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" class="name form-control border-warning" id="name" value="<?php echo htmlspecialchars($client_details["client_name"]) ?>" readonly>
                </div>

            <!-- Mail ID -->
                <div class="data-box form-group mb-2">  
                    <label for="mail-id" class="form-label fw-bold">Mail ID</label>
                    <input type="text" class="mail-id form-control border-warning" id="mail-id" value="<?php echo htmlspecialchars($client_details["mail_id"]) ?>" readonly>
                </div>
                
            <!-- Phone Number -->
                <div class="data-box form-group mb-2">  
                    <label for="phone" class="form-label fw-bold">Phone Number</label>
                    <input type="text" class="phone form-control border-warning border-warning" id="phone" value="<?php echo htmlspecialchars($client_details["phone_number"]) ?>" readonly>
                </div>
                
            <!-- Gender -->
                <div class="data-box form-group mb-2">  
                    <label for="gender" class="form-label fw-bold">Gender</label>
                    <input type="text" class="gender form-control border-warning" id="gender" value="<?php echo htmlspecialchars($client_details["gender"]) ?>" readonly>
                </div>  
                
            <!-- Data of birth -->
                <div class="data-box form-group mb-2">  
                    <label for="DOB" class="form-label fw-bold">Date of birth</label>
                    <input type="text" class="DOB form-control border-warning" id="DOB" value="<?php echo $client_details["date_of_birth"]===null ? "YYYY:MM:DD":htmlspecialchars($client_details["date_of_birth"]) ?>" readonly>
                </div>                
                          
            </div>


        <!-- Second column for client data -->
            <div class="col-lg-6">
            <!-- Address -->
                <div class="data-box form-group mb-2">  
                    <label for="address" class="form-label fw-bold">Address</label>
                    <input type="text" class="address form-control border-warning" id="address" value="<?php echo $client_details["client_address"]===null ? "---":htmlspecialchars($client_details["client_address"])?>" readonly>
                </div>

            <!-- City -->
                <div class="data-box form-group mb-2">  
                    <label for="city" class="form-label fw-bold">City</label>
                    <input type="text" class="city form-control border-warning" id="city" value="<?php echo $client_details["city"]===null ? "---":htmlspecialchars($client_details["city"])?>" readonly>
                </div>
                
            <!-- State -->
                <div class="data-box form-group mb-2">  
                    <label for="state" class="form-label fw-bold">State</label>
                    <input type="text" class="state form-control border-warning" id="state" value="<?php echo $client_details["state"]===null ? "---":htmlspecialchars($client_details["state"]) ?>" readonly>
                </div>
                
            <!-- Zip code -->
                <div class="data-box form-group mb-2">  
                    <label for="zipcode" class="form-label fw-bold">Zip code</label>
                    <input type="text" class="zipcode form-control border-warning" id="zipcode" value="<?php echo $client_details["zip_code"]===null ? "---":htmlspecialchars($client_details["zip_code"]) ?>" readonly>
                </div>                
            </div>
            </div>
        </div>  
    </section>


<!-- Script for custom script file -->
    <script src="/JS/script.js"></script>
    <script src="/JS/script-register.js"></script>


</body>
</html>