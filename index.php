<?php 
include "fuctions.php";
session_start();

    if(isset($_POST["paybtn"])){
        processpayment();
        header("location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Page</title>
        <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            text-decoration: none;
        }

        .logo-accent {
            color: #3498db;
        }

        .nav-menu {
            display: flex;
            list-style: none;
        }

        .nav-item {
            margin: 0 15px;
            position: relative;
        }

        .nav-link {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 500;
            font-size: 16px;
            padding: 8px 0;
            transition: color 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: #3498db;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #3498db;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 24px;
            height: 18px;
            cursor: pointer;
        }

        .mobile-toggle span {
            height: 2px;
            width: 100%;
            background-color: #2c3e50;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex;
            }

            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: white;
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                transform: translateY(-10px);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s;
            }

            .nav-menu.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            .nav-item {
                margin: 10px 0;
            }
        }

                    /* From Uiverse.io by Smit-Prajapati */ 
            .container {
            max-width: 350px;
            background: #F8F9FD;
            background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid rgb(255, 255, 255);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
            margin: 20px;
            }

            .heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(16, 137, 211);
            }

            .form {
            margin-top: 20px;
            }

            .form .input {
            width: 100%;
            background: white;
            border: none;
            padding: 15px 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: #cff0ff 0px 10px 10px -5px;
            border-inline: 2px solid transparent;
            }

            .form .input::-moz-placeholder {
            color: rgb(170, 170, 170);
            }

            .form .input::placeholder {
            color: rgb(170, 170, 170);
            }

            .form .input:focus {
            outline: none;
            border-inline: 2px solid #12B1D1;
            }

            .form .forgot-password {
            display: block;
            margin-top: 10px;
            margin-left: 10px;
            }

            .form .forgot-password a {
            font-size: 11px;
            color: #0099ff;
            text-decoration: none;
            }

            .form .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white;
            padding-block: 15px;
            margin: 20px auto;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
            }

            .form .login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
            }

            .form .login-button:active {
            transform: scale(0.95);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
            }

            .social-account-container {
            margin-top: 25px;
            }

            .social-account-container .title {
            display: block;
            text-align: center;
            font-size: 10px;
            color: rgb(170, 170, 170);
            }

            .social-account-container .social-accounts {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 5px;
            }

            .social-account-container .social-accounts .social-button {
            background: linear-gradient(45deg, rgb(0, 0, 0) 0%, rgb(112, 112, 112) 100%);
            border: 5px solid white;
            padding: 5px;
            border-radius: 50%;
            width: 40px;
            aspect-ratio: 1;
            display: grid;
            place-content: center;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 12px 10px -8px;
            transition: all 0.2s ease-in-out;
            }

            .social-account-container .social-accounts .social-button .svg {
            fill: white;
            margin: auto;
            }

            .social-account-container .social-accounts .social-button:hover {
            transform: scale(1.2);
            }

            .social-account-container .social-accounts .social-button:active {
            transform: scale(0.9);
            }

            .agreement {
            display: block;
            text-align: center;
            margin-top: 15px;
            }

            .agreement a {
            text-decoration: none;
            color: #0099ff;
            font-size: 9px;
            }




                    /* another one */
                    /* From Uiverse.io by fthisilak */ 
        .pay-btn {
        position: relative;
        padding: 12px 24px;
        font-size: 16px;
        background: #0099ff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        }

        .pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        .icon-container {
        position: relative;
        width: 24px;
        height: 24px;
        }

        .icon {
        position: absolute;
        top: 0;
        left: 0;
        width: 24px;
        height: 24px;
        color: white;
        opacity: 0;
        visibility: hidden;
        }

        .default-icon {
        opacity: 1;
        visibility: visible;
        }

        /* Hover animations */
        .pay-btn:hover .icon {
        animation: none;
        }

        .pay-btn:hover .wallet-icon {
        opacity: 0;
        visibility: hidden;
        }

        .pay-btn:hover .card-icon {
        animation: iconRotate 2.5s infinite;
        animation-delay: 0s;
        }

        .pay-btn:hover .payment-icon {
        animation: iconRotate 2.5s infinite;
        animation-delay: 0.5s;
        }

        .pay-btn:hover .dollar-icon {
        animation: iconRotate 2.5s infinite;
        animation-delay: 1s;
        }

        .pay-btn:hover .check-icon {
        animation: iconRotate 2.5s infinite;
        animation-delay: 1.5s;
        }

        /* Active state - show only checkmark */
        .pay-btn:active .icon {
        animation: none;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        }

        .pay-btn:active .check-icon {
        animation: checkmarkAppear 0.6s ease forwards;
        visibility: visible;
        }

        .btn-text {
        font-weight: 600;
        font-family:
            system-ui,
            -apple-system,
            sans-serif;
        }

        @keyframes iconRotate {
        0% {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px) scale(0.5);
        }
        5% {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        15% {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        20% {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.5);
        }
        100% {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.5);
        }
        }

        @keyframes checkmarkAppear {
        0% {
            opacity: 0;
            transform: scale(0.5) rotate(-45deg);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.2) rotate(0deg);
        }
        100% {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
    }
    </style>
</head>
<body>
      <!-- showing toast messages -->
    <?php
    //session_start();
    if (isset($_SESSION["toast"])) {
        $type = $_SESSION["toast"]["type"];     // success, error, info, warning
        $message = $_SESSION["toast"]["message"];
        echo "
        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 4000
            };
            toastr['$type']('$message');
        </script>
        ";

        unset($_SESSION["toast"]);
    }
    ?>
    <!-- showing toast messages End -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <a href="#" class="logo-text">Pay<span class="logo-accent">ments</span></a>
            </div>
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Pay Now</a>
                    </li>
                    <li class="nav-item">
                        <a href="transactions.php" class="nav-link">Transactions</a>
                    </li>
                </ul>
            </nav>

             <div class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <div style="display: flex;justify-content: center;align-items: center;height: 80vh;">
       <!-- From Uiverse.io by Smit-Prajapati --> 
<div class="container">
    <div class="heading">Payment Form.</div>

    <form action="" method="post" class="form">
      <input required="" class="input" type="text" name="number" id="number" placeholder="Phone Number">
      <input required="" class="input" type="text" name="amount" id="amount" placeholder="Amount">
       <!-- From Uiverse.io by fthisilak --> 
<button class="pay-btn" type="submit" name="paybtn" style="margin-left: 50px;margin-top: 20px;">
  <span class="btn-text">Pay Now</span>
  <div class="icon-container">
    <svg viewBox="0 0 24 24" class="icon card-icon">
      <path
        d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18C2,19.11 2.89,20 4,20H20C21.11,20 22,19.11 22,18V6C22,4.89 21.11,4 20,4Z"
        fill="currentColor"
      ></path>
    </svg>
    <svg viewBox="0 0 24 24" class="icon payment-icon">
      <path
        d="M2,17H22V21H2V17M6.25,7H9V6H6V3H18V6H15V7H17.75L19,17H5L6.25,7M9,10H15V8H9V10M9,13H15V11H9V13Z"
        fill="currentColor"
      ></path>
    </svg>
    <svg viewBox="0 0 24 24" class="icon dollar-icon">
      <path
        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"
        fill="currentColor"
      ></path>
    </svg>

    <svg viewBox="0 0 24 24" class="icon wallet-icon default-icon">
      <path
        d="M21,18V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V6H12C10.89,6 10,6.9 10,8V16A2,2 0 0,0 12,18M12,16H22V8H12M16,13.5A1.5,1.5 0 0,1 14.5,12A1.5,1.5 0 0,1 16,10.5A1.5,1.5 0 0,1 17.5,12A1.5,1.5 0 0,1 16,13.5Z"
        fill="currentColor"
      ></path>
    </svg>

    <svg viewBox="0 0 24 24" class="icon check-icon">
      <path
        d="M9,16.17L4.83,12L3.41,13.41L9,19L21,7L19.59,5.59L9,16.17Z"
        fill="currentColor"
      ></path>
    </svg>
  </div>
</button>
<!-- end btn -->
    </form>
  
  </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobileToggle');
            const navMenu = document.getElementById('navMenu');
            
            mobileToggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                
                // Animate hamburger to X
                const spans = this.querySelectorAll('span');
                if (navMenu.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                } else {
                    spans[0].style.transform = 'none';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'none';
                }
            });
        });
    </script>
</body>
</html>