<?php
include "db.php";
session_start();
include "fuctions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Page</title>
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


 .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #f1f5f9;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
        }
        
        td {
            padding: 14px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
        }
        
        tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .status-failed {
            color: #dc2626;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 600px;
            }
        }
        /*noo record css*/
        .no-records {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }
        
        .no-records i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #bdc3c7;
        }
        
        .no-records h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #95a5a6;
        }
        
        .no-records p {
            font-size: 1rem;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.5;
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
        <div style="display:flex;justify-content: center;align-items: center;margin-top: 50px;">
     <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
             <?php  transactionlist();?>
            </tbody>
        </table>
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