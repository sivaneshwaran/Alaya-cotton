<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>

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

<!-- Css links -->
    <link rel="stylesheet" href="styles/admin-style.css">

</head>
<body>
    <section class="body">
    <!-- Column for sidebar -->
        <div class="sidebar"> 
            <div class="container-fluid p-0 d-flex justify-content-center align-items-center flex-column mb-5 mt-2">
                <img src="/Images/Raw images/Alaya-Logo---English_01.jpg" alt="Alaya cotton logo" class="logo">
            </div>
            <ul class="menu">
                <li><button class="menu-item active-menu" onclick="show()" id="analysis-btn"><i class="fa-solid fa-chart-line"></i> Analysis</button></li>
                <li><button class="menu-item" onclick="show()" id="customer-btn"><i class="fa-solid fa-user"></i>Customer Details</button></li>
                <li><button class="menu-item" onclick="show()" id="product-btn"><i class="fa-solid fa-cubes"></i>Product Details</button></li>
            </ul>
        </div>
    <!-- Column for main content -->
        <div class="main-content ">

        </div>
    </section>

    <script src="script/admin-script.js"></script>
</body>
</html>