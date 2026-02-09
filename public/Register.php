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

</head>
<body>
    
<script>
  if (performance.navigation.type === 2) {
    
    // Type 2 means back/forward navigation
    location.reload(true); // Force reload from server
  }
</script>
    <?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
        require_once __DIR__.'\..\config\bootstrap.php';
        require_once __DIR__.'\..\database\db_connection.php';
        require_once __DIR__.'\..\database\user_database.php';
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
            exit;
        }
    }

    // Variables for store data initial values are empty string
        $name = $mail_id = $phone_number = $gender =  $hash_password = $password = $cpassword = "";
        $DOB = $address = $city = $state = $country = $zipcode = "";

    // Variables for store Error msg  initial values are empty string
        $name_err = $mail_err = $phone_err = $gender_err = $password_err = $cpassword_err = "";
        $DOB_err = $city_err = $state_err = $zipcode_err = $address_err = "";

    // Final message for account creation status
        $final_msg = false;
        
    // Creating objects for Database connection
        $dbConn = new db_connection();
        $pdo = $dbConn->get_connection();
        $user_db = new user_database($pdo);

    // Sanitize the input
        function test($input){
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

    // Validate the Date of birth
        function validateDOB($DOB):bool{
            $dob = DateTime::createFromFormat('Y-m-d', $DOB);
            $now = new DateTime();
            $age = $now->diff($dob)->y;

            if(!$dob || $dob > $now){
                return false;
            }

            return ($age >= 15 && $age <= 70);
            
        }
// Overall form validation code block
        if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validation code for name input
            if(empty($_POST['name'])){
                $name_err = "Please fill the Name";
            }elseif(strlen($_POST['name']) > 255){
                $name_err = "Your Name is Too long";
            }elseif(!preg_match("/^[a-zA-Z-' ]*$/",$_POST['name'])){
                $name_err = "Only Letters and whitespaces allowed";
            }else{
                $name = test($_POST['name']);
            }

        // Validation code for mail input
            if(empty($_POST['mail'])){
                $mail_err = "Please fill the Mail Id";
            }elseif(strlen($_POST['mail']) > 100){
                $mail_err = "Your mail ID is Too long";
            }elseif(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
                $mail_err = "Invalid E-mail formate";
            }elseif($user_db->checkMail($_POST['mail'])){
                $mail_err = "This mail ID is already exists";
            }
            else{
                $mail_id = test($_POST['mail']);
            }

        // Phone Number Validation code
            if(empty($_POST['phone'])){
                $phone_err = "Please fill the Phone Number";
            }elseif(!preg_match("/^[6-9]\d{9}$/", $_POST['phone'])){
                $phone_err = "Invalid Phone Number";
            }elseif($user_db->checkPhone($_POST['phone'])){
                $phone_err = "This Phone Number is already exists";
            }else{
                $phone_number = test($_POST['phone']);
            }

        // Gender Validation code
            if(empty($_POST['gender'])){
                $gender_err = "Please select the Gender";
            }else{
                $gender = test($_POST['gender']);
            }

        // Date of birth validation code
            if(empty($_POST['DOB'])){
                $DOB = null;
            }else{
                if(validateDOB($_POST['DOB'])){
                    $DOB = $_POST['DOB'];
                }else{
                    $DOB_err = "Invalid Date of Birth";
                }
            }

        // Address validation code
            if(empty($_POST['address'])){
                $address = null;
            }elseif(strlen($_POST['address']) > 255){
                $address_err = "address is too Length";
            }else{
                $address = test($_POST['address']);
            }

        // City validation code
            if(strlen($_POST['city']) > 100){
                $city_err = "City name is too length";
            }elseif(empty($_POST['city'])){
                $city = null;
            }else{
                $city = test($_POST['city']);
            }

        // State validation code 
            if(strlen($_POST['state']) > 100){
                $state_err = test($_POST['state']);
            }elseif(empty($_POST['state'])){
                $state = null;
            }else{
                $state = test($_POST['state']);
            }

        // ZIP code validation code
            if(empty($_POST['zipcode'])){
                $zipcode = null;
            }
            elseif(!preg_match("/^[1-9][0-9]{5}$/", $_POST['zipcode'])){
                $zipcode_err = "Invalid ZIP code";
            }else{
                $zipcode = test($_POST['zipcode']);
            }

        // Password Validation code
            if(empty($_POST['password'])){
                $password_err = "Please create the password";
            }elseif(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/", $_POST['password'])){
                $password_err = "Invalid password";
            }else{
                $password = test($_POST['password']);
            }

        // Confirm password validation code
            if(empty($_POST['cpassword'])){
                $cpassword_err = "Please ender the confirm password";
            }else{
                $cpassword = test($_POST['cpassword']);
                if($cpassword === $password){
                    $hash_password = password_hash($cpassword, PASSWORD_DEFAULT);
                }else{
                    $cpassword_err = "Password does not match";
                }
            }
        }

        $condition_1 = empty($name_err) & empty($mail_err) & empty($phone_err) & empty($gender_err) & empty($DOB_err);
        $condition_2 = empty($address_err) & empty($city_err) & empty($state_err) & empty($zipcode_err) & empty($password_err) & empty($cpassword_err);

        if($condition_1 & $condition_2){
            $final_msg = $user_db->create_userAccount($name, $mail_id, $phone_number, $gender, $DOB, $address, $city, $state, $zipcode, $hash_password);
        }
        
        if($final_msg){
            unset($_POST);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;

        }

    ?>



<!-- Header for Header section  -->
    <header class=" container-fluid px-0 sticky-top border border-2 border-top-0 border-start-0 border-end-0 border-warning bg-light">
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
                <!-- Account icon -->
                 <div class="account">
                    <button class="s-btn" type="button" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Account " data-bs-placement="top" id="account-icon">
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
                    <a href="" class="s-btn " type="button" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-title="Wishlist " data-bs-placement="top" >
                        <i class="fa-solid fa-heart"></i>
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

    
<!-- Register section  -->
    <section class="register container-fluid overflow-hidden py-2 px-3 d-flex justify-content-center align-items-center">
        <div class="row py-2 px-3">
        <!-- Col 1 for Image -->
            <div class="col-xl-4 col-lg-4 d-none d-md-none d-lg-block overflow-hidden d-flex justify-content-center align-items-center border border-4 border-success border-start-0 border-top-0 border-bottom-0">
                <img src="/Images/Raw images/101.jpg" alt="alaya cotton tissue shirts" class="img-fluid ">
            </div>

        <!-- Col 2 for Registeration form -->
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12  ">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" class="register-form" id="register-form">   
                        <h2 class="w-100 text-center p-2">Welcome to the Family of Alaya cottons</h2>
                        <div class="row">
                        <!-- Col-1 inputs -->
                            <div class="personal-details col-xl-6 col-lg-6 col-md-6 col-12  border border-1 border-success border-start-0 border-top-0 border-bottom-0">
                                <h4 class="text-center w-100  border border-1 border-success border-start-0 border-top-0 border-end-0">Pesonal details</h4>
                            <!-- Input for Name -->
                                <div class="mb-2 w-100">
                                   <label for="name" class="text-dark fw-medium">Name</label>
                                   <span class="error_msg">* <?php echo $name_err; ?></span><!-- Error Msg-->
                                   <input type="text" class="form-control border border-1 border-primary" name="name" id="name_input" placeholder="Enter your full name"  value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                </div>

                            <!-- Input for Email -->
                               <div class="mb-2 w-100">
                                  <label for="email_input" class="text-dark fw-medium">E-mail ID</label>
                                  <span class="error_msg">* <?php echo $mail_err; ?></span><!-- Error Msg-->
                                  <input type="text" autocomplete="off" class="form-control border border-1 border-primary" name="mail" id="mail_input" placeholder="Enter your E-mail ID"  value="<?php echo isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : ''; ?>">
                               </div>    
                               
                            <!-- Input for Phone Number -->
                               <div class="mb-2 w-100">
                                  <label for="phone_input" class="text-dark fw-medium">phone Number</label>
                                  <span class="error_msg">* <?php echo $phone_err; ?></span><!-- Error Msg-->
                                  <input type="text" autocomplete="off" class="form-control border border-1 border-primary" name="phone" id="phone_input" placeholder="Enter your Phone Number"  value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                               </div>                        

                            <!-- Input for Gender -->
                                <div class="mb-2 w-100">
                                   <div class="text-dark fw-medium">Gender 
                                   <span class="error_msg">* <?php echo $gender_err; ?></span><!-- Error Msg-->
                                   </div>
                                   <div class="form-check d-flex justify-content-around align-items-center">
                                   <!-- Male radio button -->
                                      <div>
                                         <input class="form-check-input border border-1 border-primary" type="radio" name="gender" <?php if(isset($gender) && $gender == "male")  echo "checked"; ?> value="male" id="male-check">
                                         <label for="male-check" class="text-dark"> Male</label>
                                      </div>
                                   <!-- Female radio button -->
                                      <div>
                                         <input class="form-check-input border border-1 border-primary" type="radio" name="gender" <?php if(isset($gender) && $gender == "female")  echo "checked"; ?> value="female" id="female-check">
                                         <label for="female-check" class="text-dark">Female</label>
                                      </div>
                                   <!-- Others radio button -->
                                      <div>
                                         <input class="form-check-input border border-1 border-primary" type="radio" name="gender" <?php if(isset($gender) && $gender == "others")  echo "checked"; ?> value="others" id="others-check">
                                         <label for="others-check" class="text-dark">others</label>
                                      </div>

                                   </div>
                                </div>

                            <!-- Input for Date of birth -->
                               <div class="mb-2 w-100">
                                  <label for="DOB" class="text-dark fw-medium">Date of Birth</label>
                                  <span class="error_msg"> <?php echo $DOB_err; ?></span><!-- Error Msg-->
                                  <input type="date" class="form-control border border-1 border-primary" name="DOB" id="DOB" placeholder="Enter your Date of Birth"  value="<?php echo isset($_POST['DOB']) ? htmlspecialchars($_POST['DOB']) : ''; ?>">
                               </div> 
                               
                                <h4 class="text-center w-100 border border-1 border-success border-start-0 border-top-0 border-end-0">Address details</h4>
                            <!-- Input for Address -->
                               <div class="mb-2 w-100">
                                  <label for="address_input" class="text-dark fw-medium">Address</label>
                                  <span class="error_msg"><?php echo $address_err;?></span><!-- Error Msg-->
                                  <input type="text" class="form-control border border-1 border-primary" name="address" id="address_input" placeholder="Enter your Address"  value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                               </div>   
                                
                            <!-- Input for city -->
                               <div class="mb-2 w-100">
                                  <label for="city_input" class="text-dark fw-medium">City</label>
                                  <input type="text" class="form-control border border-1 border-primary" name="city" id="city_input" placeholder="Enter your City Name"  value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                               </div>                                 

                            </div><!-- Col-1 inputs ends here -->

                        <!-- Col-2 inputs -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">                 

                            <!-- Input for state -->
                               <div class="mb-2 w-100">
                                  <label for="State_input" class="text-dark fw-medium">State</label>
                                  <input type="text" class="form-control border border-1 border-primary" name="state" id="State_input" placeholder="Enter your State"  value="<?php echo isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>">
                               </div>                                           
                               
                            <!-- Input for ZIP code -->
                               <div class="mb-2 w-100">
                                  <label for="zipcode_input" class="text-dark fw-medium">ZIP code</label>
                                  <span class="error_msg"> <?php echo $zipcode_err; ?></span><!-- Error Msg-->
                                  <input type="text" class="form-control border border-1 border-primary" name="zipcode" id="zipcode_input" placeholder="Enter your zipcode"  value="<?php echo isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : ''; ?>">
                               </div>  

                            <!-- Input for Password -->
                                <div class="mb-2 w-100"> 
                                    <label for="password_input" class="text-dark fw-medium">Password</label>
                                    <span class="error_msg">* <?php echo $password_err; ?></span><!-- Error Msg-->
                                    <div class="form-control border border-1 border-primary d-flex justify-content-center align-items-center">
                                        <input type="password" class="" autocomplete="off" name="password" id="password_input" placeholder="Enter password"  value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']):"";?>">
                                        <button class="show_pass" type="button"><i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div>

                            <!-- Input for Confirm password -->
                                <div class="mb-2 w-100">
                                    <label for="cpassword_input" class="text-dark fw-medium">Confirm Password</label>
                                    <span class="error_msg">* <?php echo $cpassword_err; ?></span><!-- Error Msg-->
                                    <div class="form-control border border-1 border-primary d-flex justify-content-center align-items-center">                                    
                                        <input type="password" class="" autocomplete="off" name="cpassword" id="cpassword_input" placeholder="Confirm password"  value="<?php echo isset($_POST['cpassword']) ? htmlspecialchars($_POST['cpassword']):"";?>">
                                        <button class="show_cpass" type="button"><i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div>

                            <!-- Password conditions -->
                                <div class="pass-condition container-fluid rounded-3 border border-1 border-warning p-3" style="background-color: rgba(247, 241, 134, 1);">
                                    <ul>
                                        <li>Age limit is 15 to 70 only</li>
                                        <li>Password should have atleast 1 Capital letter</li>
                                        <li>Password should have atleast 1 Small letter</li>
                                        <li>Password should have atleast 1 Number</li>
                                        <li>Password should have atleast 1 Special Characters (@,#,$...)</li>
                                        <li>Password should have Min 8 characters</li>

                                    </ul>
                                </div>

                            <h6 class="mx-4 my-3">* Mantatory Fields</h6>
                            </div><!-- Col-2 inputs ends here -->
                        </div>
                        <div class="button-row d-flex justify-content-center align-items-center flex-column p-2">
                            <button type="submit" class="btn btn-danger px-4">Create Account</button>
                            <p class="p-2 ">Already have an account <a class="fw-bold" href="login-mail.php" class="link-primary">Login here</a></p>
                        </div>
                </form>

            <!-- Success message after submitting form  -->
                <!-- <div class="success-msg bg-white p-5 border border-2 border-success  d-flex align-items-center justify-content-center flex-column d-none">
                    <div class="text-success d-flex align-items-center justify-content-center flex-row"><i class="fa-solid fa-circle-check h1 mx-2"></i><p class="h4">Registeration successfull</p></div>

                    <a href="login.php" class="bg-green p-2 fw-bold"> Login Here</a>
                </div> -->
            </div><!-- Registeration form ends here  -->
        </div>
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

    <!-- <script>
        if(){
            document.querySelector(".register-form").classList.add("d-none");
            document.querySelector(".success-msg").classList.remove("d-none");
        }
    </script> -->
</body>
</html>