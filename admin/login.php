<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect them to dashboard page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM admin_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to dashboard page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<html lang="en">
<head>
    <title>PostNow | Administration Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- -<script src="./assets/js/scripts.js" type="module"></script> --->
    <script src=" https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2.21.0/dist/umd/supabase.min.js "></script>
    <script>
        const sb = supabase.createClient('https://db.lslslkofvbnjtjgfdwcq.supabase.co', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImxzbHNsa29mdmJuanRqZ2Zkd2NxIiwicm9sZSI6ImFub24iLCJpYXQiOjE2ODM0NjgwMTQsImV4cCI6MTk5OTA0NDAxNH0.DyqVwFgwIyxQpX6V9RrPs2HqbmIrY7ysKFxMXhz12DQ')
        // it works!
    </script>
</head>
<body>
    <div class="navbar">

        <div class="logo">
            <img src="../assets/imgs/Divgram.png" id="logo_img">
            <h2>PostNow!</h2>
        </div>

        <div class="nav_btns"> <!-- made transparent due the home, about page not being done-->
            <a href="#" style="color: #ffffff00; text-decoration: none;">Home</a>
            <a href="#" style="color: #ffffff00; text-decoration: none;">About</a>
            <a href="#" style="color: #ffffff00; text-decoration: none;">Reserve</a> <!--margin-right: 0%; -->
        </div>


    </div>

    <div class="center">
        <img src="../assets/imgs/lock.png">
        <div>&nbsp;</div>
        <h3>Reserve</h3>
        <div class="seperator">&nbsp;</div>
        <div>&nbsp;</div>
        <!-- form for input to go to action_page -->
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group-user">
                <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <p><span class="invalid-feedback"><?php echo $username_err; ?></span></p>
            </div>    
            <div class="form-group-pass">
                <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <p><span class="invalid-feedback"><?php echo $password_err; ?></span></p>
            </div>
            <div class="form-group-submit">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
        <p class="info" style="color: #fff;">By reserving an account, you agree to our terms and conditions</p>
    </div>

</body>

</html>