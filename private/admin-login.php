<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Alaya cottons</title>

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

<!-- Fontawsome link for icons -->
    <script src="https://kit.fontawesome.com/2a292e456c.js" crossorigin="anonymous"></script>


<!-- GSAP Link -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>    

    <style>
        *{
            margin: 0;
            padding: 0;
        }

        .login{
            width: 100%;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            /* background-image: url("/Images/bg-blue white.jpg"); */
            /* background-blend-mode: overlay; */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: bottom;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .login-box{
            width: 400px;
            height: 300px;
            background-image: linear-gradient(45deg, #03fafaff, #9efad5ff);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-direction: column;
            border: 3px solid #1B3C53;
            border-radius: 20px;
        }

        h1{
            color: #1B3C53;
            font-weight: bold;
        }

        .login-form{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

        }

        .input-box input{
            width: 100%;
            height: 35px;
            border: 2px solid #1B3C53;
            border-radius: 5px;
            padding-left: 10px;
            outline-color: gray;
            outline-width: 5px;
        }

        

    </style>

</head>
<body>
    <section class="login ">
        <div class="login-box">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" class="login-form" >
                <div class="input-box form-group w-100 p-2">
                    <label for="user-id fw-bold">User ID</label>
                    <input type="text" class="user-id " id="user-id" placeholder="Please Enter your User ID">
                </div>
        
                <div class="input-box form-group  w-100 p-2">
                    <label for="password">Password</label>
                    <input type="password" class="password " id="password" placeholder="Please Enter your password">
                </div>        
            </form>
        </div>

        
    </section>
</body>
</html>