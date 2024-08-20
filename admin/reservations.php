<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


 
require_once "config.php";
include "reserve_config.php";
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM reservations WHERE status = 0 ORDER BY created DESC');
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmtDeny = $pdo->prepare("UPDATE reservations SET status = 2 WHERE id = ?");
$stmtDeny->bind_param("i", $reserve_id_deny);

$stmtAccept = $pdo->prepare("UPDATE reservations SET status = 1 WHERE id = ?");
$stmtAccept->bind_param("i", $reserve_id_accept);


// function updateStatusAccept($reserve_id) {
//     return ('UPDATE reservations SET status = 1 WHERE id = $reserve_id');
// };
// function updateStatusDeny($reserve_id) {
//     return ('UPDATE reservations SET status = 2 WHERE id = $reserve_id');
// };

if (isset($_POST['deny'])) {
    $reserve_id_deny = $_POST['reserve_id'];
    $stmtDeny->execute();
}
if (isset($_POST['accept'])) {
    $reserve_id_accept = $_POST['reserve_id'];
    $stmtAccept->execute();
}

?>
<html lang="en">
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/imgs/Divgram.png" id="logo_img">
            <h2>UnbndR</h2>
        </div>
        <div class="dropdown">
            <a href="index.php" style="text-decoration: none;">Dashboard</a>
            <br>
            <a href="reservations.php" style="text-decoration: none;"><u>User Reservations</u></a>
        </div>
        <div class="info">
            Logged in as <u><?php echo $_SESSION['username'] ?></u>
            <br>
            <a href="logout.php" style="color: orange; text-decoration: none;">Logout</a>
        </div>
    </div>
    <div class="center">
        <h1 style="margin-left: 5%;"><b>Reservations</b></h1>
        <div class="reservations">

        <?php foreach ($reservations as $reservation): ?>
            <div class="reservation">
                <form method="post">
                    <span class="username"><?=htmlspecialchars($reservation['username'], ENT_QUOTES)?></span><span class="dc_user"><?=htmlspecialchars($reservation['discord'], ENT_QUOTES)?></span>
                    <a href="" type="submit" id="btns" style="border: solid 1.5px green;">Accept</a>
                    <a href="" type="submit" id="btns" style="border: solid 1.5px red;">Deny</a>
                </form>
            </div>

        <?php endforeach ?>
        </div>
    </div>
</body>
</html>