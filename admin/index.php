<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
require_once "config.php";
?>
<html lang="en">
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/imgs/Divgram.png" id="logo_img">
            <h2>UnbndR</h2>
        </div>
        <div class="dropdown">
            <a href="index.php" style="text-decoration: none;"><u>Dashboard</u></a>
            <br>
            <a href="reservations.php" style="text-decoration: none;">User Reservations</a>
        </div>
        <div class="info">
            Logged in as <u><?php echo $_SESSION['username'] ?></u>
            <br>
            <a href="logout.php" style="color: orange; text-decoration: none;">Logout</a>
        </div>
    </div>
    <div class="center">
        <div class="cards">
            <a href="reservations.php" class="card" style="background-color: rgb(113, 216, 29); text-decoration: none;">
                <text>
                    <b>Username Reservations</b><br>
                    <u>Total: ##</u>
                </text>
            </a>
            <a href="#" class="card" style="background-color: blue; text-decoration: none;">
                <text>
                    <b>Blue Card</b><br>
                    <u>Click</u><br>
                    <u>Me</u>
                </text>
            </a>
            <a href="#" class="card" style="background-color: red; text-decoration: none;">
                <text>
                    <b>Red Card</b><br>
                    <u>Click</u><br>
                    <u>Me</u>
                </text>
            </a>
        </div>
        <div class="charts"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
    </div>
</body>
<script src="../assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

</html>