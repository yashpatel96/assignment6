<?php 
    session_start();
    $error = '';
    if (isset($_POST["submit"]) && $_POST["submit"]){
        if($_POST["email"] == '' ||  $_POST["password"] == ''){
            $error = "Please enter email address and password";
        }
        else{
            $db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");

            if ($db->connect_error){
                die ("Connection failed: " . $db->connect_error);
            }

            $checkData = "SELECT * FROM users WHERE email = '".$_POST["email"]."' AND password = '".$_POST["password"]."' ";
            $result = $db->query($checkData);
            // if row not found
            if($result->num_rows > 0){
                $row = $result->fetch_array();
                $_SESSION['logged'] = true;
                $_SESSION['id'] = $row['user_ID'];
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['avtar'] = $row['avtar'];
                header("Location: index.php");
            }
            else{
                $error = "Wrong email address or password";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            Welcomne to Login Page Page
        </title>
        
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="stylesheet" type="text/css" href="large.css" />

        <link rel="stylesheet" type="text/css" href="button.css" />

        <script type="text/javascript" src="validator.js"></script> 
        

    </head>
            
    <body>
        <header>
        <table>
            <tr>
                <td>
                <img src="image/krishna.png" alt=" logo " height="100" width="150"/>
                </td>
                <td>
                <h2> Welcome to Krishna Dishes - Login page</h2>
                </td>
            </tr>
        </table>
        </header>
        <hr/>
        <form action="login.php" id="Login" method="post" >
            <p><?= $error ?></p>
            <table>
                <tr><td></td><td><label id="email_msg" class="err_msg"></label></td></tr>
            <tr>
                <td>Email :</td>
                <td><p><input type="email" id="email" size="30" name="email" /></p></td>
            </tr>
            
            <tr><td></td><td><label id="pswd_msg" class="err_msg"></label></td></tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" id="pswd" size="30" name="password" /><br/></td>
            
            </tr>
            
            
            </table>
            <p></p>
            
            <p><input type="submit" value="Login" name="submit" /> </p>
            <p></p>
            <p><a href="signup.php">Create a New Account</a></p>

            

        </form>
        
        <div id="display_info"></div>

         <footer> 
         <p>&copy; 2021 Ypc350  All rights reserved.</p>
         </footer>    
          
    </body>
    
       
</html>
            