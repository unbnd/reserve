<?php
include 'config.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM user_req ORDER BY created DESC');
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



?>

<html>
    <head>
        <title>User Requests</title>
        <link rel="stylesheet" href="./assets/css/admin.css">
    </head>
    <body>
        <div class="requests">
            <?php foreach ($requests as $request): ?>
                <span>
                    <?php if ($request['status'] == "0"): ?>
                        

                    <?php endif ?>
                </span>




            <?php endforeach; ?>
        </div>
    </body>
</html>