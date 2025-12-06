<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Updation</title>

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

    

<!-- Fontawsome link for icons -->
    <script src="https://kit.fontawesome.com/2a292e456c.js" crossorigin="anonymous"></script>


<!-- GSAP Link -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>    

<style>

</style>

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
    require_once __DIR__.'\..\database\product-database.php';

// Creating objects for Database connection
    $dbConn = new db_connection();
    $pdo = $dbConn->get_connection();//PDO connection object

    $product_db = new product_db($pdo);

// Variables for storing data
    $file_limit = 5;
    $max_size = 2*1024*1024;
    $total_size = 0;
    $allowed_formats = ['jpg', 'jpeg', 'png', 'webp'];
    $upload_Dir = __DIR__."\..\product-images\\";
    $product_img_name = array();
    $product_name = $product_category = $quantity = $buy_price = $sell_price = $product_description = "";
    $staff_name = $staff_id = "";

// Array for storing errors
    $file_error =  $upload_error = array();
    $success_msg = "";
    $db_update = $file_upload = false;
// Array for storing uniq Names for images
    $original_name_array = array();
    $uniq_name_array = array();

// Validation code
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // other validation
    $product_name = $_POST['product-name'];
    $product_category = $_POST['product-category'];
    $quantity = $_POST['quantity'];
    $buy_price = $_POST['buy-price'];
    $sell_price = $_POST['sell-price'];
    $product_description = $_POST['description'];

    // Images validation code
        if(!empty($_FILES['image']['name'][0])){
        // Total number for images in File superglobal array
            $total_files = count($_FILES['image']['name']);

        // Foreach for validate each image
            foreach($_FILES['image']['name'] as $i => $name){
            // Variable to store indivitual image data
                $temp = $_FILES['image']['tmp_name'][$i];
                $error = $_FILES['image']['error'][$i];
                $size = $_FILES['image']['size'][$i];

            // Pictures limit code 2 to 5 images only otherwise unable to submit
                if($total_files > $file_limit){
                    $file_error[] = "Maximum images limit $file_limit only";
                    break;
                }elseif($total_files < 2){
                    $file_error[] = "Minimum 2 images required";
                    break;
                }

            // If file upload error is 0 block runs
                if($error === UPLOAD_ERR_OK){
                // Extension validation code
                    $safeName = basename($name);
                    $ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));

                    if(!in_array($ext, $allowed_formats)){
                        $file_error[] =  "<b>$name</b> is having Invalid file format ";
                        continue;
                    }

                // Size validation code
                    if($size > $max_size){
                        $file_error[] =  "<b>$name</b> is greater than 2MB image ";
                        continue;
                    }

                // File type validation code image type only allowed
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $temp);

                    if(!strpos($mime, 'image/')===0){
                        $file_error[] = "<b>$name</b> is not an image";
                        continue;
                    }

                // Unique name generation code and names are stored in $uniq_name_array Array
                    $unique_name = time().'_'.bin2hex(random_bytes(6)).'.'.$ext;
                    $uniq_name_array[] = $unique_name; //unique names 
                    $original_name_array[] = $safeName; //original names

                }//if($error === UPLOAD_ERR_OK) ends here
                else{
                    $file_error[] = "<b>$name</b> File upload error image skipped";
                }           

            }//Foreach ($_FILES['image']['name'] as $i => $name) ends here

            if(empty($file_error)){
                for($i=$total_files; $i<$file_limit;$i++){
                    $uniq_name_array[$i]="null";
                    $original_name_array[$i] = "null";
                }

                foreach($_FILES['image']['name'] as $num => $name){
                    $temp = $_FILES['image']['tmp_name'][$num];

                    $destination = $upload_Dir.$uniq_name_array[$num];
                    if(move_uploaded_file($temp, $destination)){
                        $file_upload = true;
                    }else{
                        $upload_error[] = "<b>$name</b> upload failed";
                        $original_name_array[$num] = "null";
                        $uniq_name_array[$num] = "null";
                        continue;
                    }
                }

            // Product final Database entry

                $db_update = $product_db->createNewProduct($product_name, $product_category, $quantity, $buy_price, $sell_price, $product_description, $original_name_array, $uniq_name_array, "Siva", "11");
                if(!$db_update){
                    foreach($uniq_name_array as $names){
                        if($names != "null"){
                            $destination = $upload_Dir.$names;
                            if(file_exists($destination)){
                                unlink($destination);
                            }
                        }

                    }
                }
                $_POST = array();
                $_FILES = array();
                $original_name_array = array();
                $uniq_name_array = array();
                header("location:". $_SERVER['PHP_SELF']);
                exit;   

            }  //if(empty($file_error)) ends here
        }
    }

?>

<!-- Header for Header section  -->
    <header class=" container-fluid px-0 border border-2 border-top-0 border-start-0 border-end-0 border-warning bg-light">
    <!-- Main bar Icons and Logo -->
        <div class="container-fluid ">
            <div class="main-bar row ">
            <!-- Logo -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex align-middle justify-content-center py-3 ">
                    <a href="/index.php">
                        <img src="/Images/Raw images/Alaya-Logo---English_01.jpg" alt="Alaya logo image" title="Alaya logo image"  width="150px" class="logo-icon">
                    </a>
                </div>
            </div>
        </div>

    </header>

<!-- Section for product updation -->
<section class="container-fluid bg-warning p-3 d-flex justify-content-center align-items-center flex-column">
    <ul class="list-group border border-success border-1">
        <?php
            if(!empty($success_msg)){
                echo "<li class='text-success list-group-item fw-bold '>$success_msg</li>";
            }
            if($db_update){
                echo "<li class='text-success list-group-item fw-bold '>DB update completed</li>";
            }
        ?>
    </ul>
    <ul class="list-group border border-danger border-1 ">
        <?php
            foreach($upload_error as $error){
                echo "<li class='text-danger list-group-item fw-bold '>$error</li>";
            }
        ?>
    </ul>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data" class=" p-3 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 d-flex justify-content-center align-items-center flex-column px-3">
        <h1 class="text-dark">Update product</h1>
        
    <!-- Product Name -->
        <div class="form-group w-100">
            <label for="product-name" class="form-label fw-bold">Product Name</label>
            <span class="error_msg"></span>
            <input type="text" class="form-control" name="product-name" id="product-name" placeholder="Enter product name" value="<?php echo isset($_POST['product-name'])? htmlspecialchars($_POST['product-name']):"";?>" style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);">
        </div>

    <!-- Product category -->
        <div class="form-group mt-3 w-100">
            <label for="product-category " class="form-label fw-bold">Product category</label>
            <span class="error_msg"></span>
            <select  class="form-select " name="product-category" id="product-category" style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);">
                <option value="select" <?php if(isset($_POST['product-category']) && $_POST['product-category'] == "select") echo "selected"?>>Select category</option>
                <option value="shirt" <?php if(isset($_POST['product-category']) && $_POST['product-category'] == "shirt") echo "selected" ?>>Shirt</option>
                <option value="dhosti" <?php if(isset($_POST['product-category']) && $_POST['product-category'] == "dhosti") echo "selected"?>>Dhosti</option>
            </select>
        </div>

    <!-- Product quantity -->
        <div class="form-group w-100  mt-3">
            <label for="quantity" class="form-label fw-bold">Product Quantity</label>
            <span class="error_msg"></span>
            <input type="number" min="0" max="1000" class="form-control" name="quantity" id="quantity" placeholder="Enter product qunatity" value="<?php echo isset($_POST['quantity'])? htmlspecialchars($_POST['quantity']):"";?>" style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);">
        </div>

    <!-- Product price -->
        <div class="row w-100 mt-3 p-0">
            <div class="col m-0">
                <label for="buy-price" class="form-label fw-bold">Buy price</label>
                <span class="error_msg"></span>
                <input type="number" min="0" max="5000" class="form-control" name="buy-price" id="buy-price" placeholder="Enter product Buy price" value="<?php echo isset($_POST['buy-price'])? htmlspecialchars($_POST['buy-price']):"";?>" style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);">
            </div>

            <div class="col m-0">
                <label for="sell-price" class="form-label fw-bold">Sell price</label>
                <span class="error_msg"></span>
                <input type="number" min="0" max="5000" class="form-control" name="sell-price" id="sell-price" placeholder="Enter product Sell price" value="<?php echo isset($_POST['sell-price'])? htmlspecialchars($_POST['sell-price']):"";?>" style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);">
            </div>
        </div>


    <!-- Product description -->
        <div class="form-group w-100  mt-3">
            <label for="description" class="form-label fw-bold">Product Name</label>
            <span class="error_msg"></span>
            <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter product description"  style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);"></textarea>
        </div>        
        <div class="mt-3">
            <ul class="list-group border border-1 border-danger">
                <?php
                    foreach($file_error as $error){
                        echo "<li class='text-danger list-group-item'>$error</li>";
                    }
                    
                ?>
            </ul>
        </div>

    <!-- File upload for photos -->
        <div class="form-group mt-3 w-75">
            <label for="image[]"class="form-label text-dark fw-bold">Upload Images</label>
            <input type="file" class="form-control border-success bg-success btn-success" name="image[]" multiple  style="box-shadow: 3px 5px 30px -5px rgba(81, 80, 80, 0.89);">
        </div>

        <button class="btn btn-success mt-5 w-lg-25 w-50" type="submit" name="submit">Upload Product</button>
    </form>
    <div class="container">
        <h3 class="text-dark fw-bold">
            File error
        </h3>
        <?php
            foreach($file_error as $error){
                echo "<p class='text-success'>$error</p>";
            }
        ?>
        <h3 class="text-dark fw-bold mt-3">
            Upload error
        </h3>
        <?php
            foreach($upload_error as $error){
                echo "<p class='text-success'>$error</p>";
            }
        ?>
        <h3 class="text-dark fw-bold mt-3">
            Original names
        </h3>
        <?php
            foreach($original_name_array as $org_name){
                echo "<p class='text-success'>$org_name</p>";
            }
        ?>
        <h3 class="text-dark fw-bold mt-3">
            Unique names
        </h3>
        <?php
            foreach($uniq_name_array as $u_name){
                echo "<p class='text-success'>$u_name</p>";
            }
        ?>
    </div>
</section>



</body>
</html>

