
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>
            Welcome to Sign up Page
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
                <img src="image/krishna.png" alt=" logo " height="100" width="150" />
                </td>
                <td>
                <h2> Welcome to Krishna Dishes - Sign up page</h2>
                </td>
            </tr>
        </table>
        </header>
        <hr/>

<?php
    $validate = true;
    $error = "";
    $reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
    $reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
    // $reg_Bday = "/^\d{1,2}\/\d{1,2}\/\d{4}$/";
    $email = "";
    // $date = "mm/dd/yyyy";


// check if form is submitted
if (isset($_POST["submit"]) && $_POST["submit"]){
    // verify null fields
    if($_POST["email"] == "" || $_POST["username"]== "" || $_POST["dob"] == "" || $_POST["password"]== "" || $_POST["cpassword"] == ""){
        $validate = false;
        $error = "Validation failed. please fill all the fields";
    }
    else if($_POST["password"] != $_POST["cpassword"]){
        $validate = false;
        $error = "Password and confirm password is not same";    
    }
    else{
        // correct data
        $email = trim($_POST["email"]);
        $username = trim($_POST["username"]);
        $dob = $_POST["dob"];
        // $avtar = trim($_POST["avtar"]);
        $password = trim($_POST["password"]);


        // validate correct data
        $emailMatch = preg_match($reg_Email, $email);
        $pswdLen = strlen($password);
        $pswdMatch = preg_match($reg_Pswd, $password);
        // $bdayMatch = preg_match($reg_Bday, $dob);

        // check if email is valid 
        if($email == null || $email == "" || $emailMatch == false)
        {
            $validate = false;
            $error = "Email address cannot be empty";
        }
        else if($password == null || $password == "" || $pswdLen< 8 || $pswdMatch == false){
                $validate = false;
                $error = "Password cannot be empty";
        }
        
        else if($dob == null || $dob == ""){
            $validate = false;
            $error = "Date of birth cannot be empty";
        }
        else{
            // connect db
            $db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");

            if ($db->connect_error){
                $error = "Database connection failed";
                die ("Connection failed: " . $db->connect_error);
            }

            // get data
            $checkData = "SELECT * FROM users WHERE email = '$email'";
            $result = $db->query($checkData);

            // if row not found
            if($result->num_rows > 0){
                $validate = false;
                $error = "Email address is already taken";
            }
            else{
                if($validate == true){
                    $dateFormat = date("Y-m-d", strtotime($dob));

                    // Part 1: upload the image to the /image folder
                    $target_dir = "avtar/";
                    $target_file = $target_dir . basename($_FILES["avtar"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["avtar"]["tmp_name"]);
                    if($check !== false) {
                        $upload = move_uploaded_file($_FILES["avtar"]["tmp_name"], $target_file);
                        if ($upload){
                            // upload success
                            // Part 2: Insert the record to the table
                            $fileLocation = 'avtar/'.basename( $_FILES["avtar"]["name"]);
                            $insertQuery = "INSERT INTO users (user_name, email, DOB, password, avtar) VALUES ('$username','$email', '$dateFormat', '$password', '$fileLocation')";
                            $insertResult = $db->query($insertQuery);
                            if ($insertResult == true){
                                header("Location: login.php");
                                exit();
                            }
                            else {
                                echo "Sorry, there was an error insert the row";
                              }
                          } 
                          else {
                            echo "Sorry, there was an error uploading your file.";
                          }
                    } else {
                        echo "Sorry, your file was not uploaded.";
                    }
                }
                else{
                    $error= "Something went wrong";
                }
            }
            $db->close();
        }
    }
}

?>

        <form action="signup.php" id="formSignUp" method="post" enctype="multipart/form-data">
            <table>

            <tr><td></td><td><label id="email_msg" class="err_msg"><?= $error ?></label></td></tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" size="30" id="email" name="email" /></td>
            </tr>
            
            <tr><td></td><td><label id="uname_msg" class="err_msg"></label></td></tr>
            <tr>
                <td>User Name :</td>
                <td><input type="text" size="30" id="uname" name="username" /></td>
            
            </tr>

            <tr><td></td><td><label id="bday_msg" class="err_msg"></label></td></tr>
            <tr>
                <td><label>Birthday:</label></td>
                <td><input type="date" id="bday" name="dob" /></td>
            </tr>

            <tr><td></td><td><label id="avtar_msg" class="err_msg"></label></td></tr>
            <tr>
                <td><label>Profile Picture:</label></td>
                <td><input type="file"  accept="image/*" id="avtar" name="avtar" /></td>
             </tr>
            
            <tr><td></td><td><label id="pswd_msg" class="err_msg"></label></td></tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" size="30" id="pswd"  name="password" /></td>
            
            </tr>
            
            <tr><td></td><td><label id="pswdr_msg" class="err_msg"></label></td></tr>
            <tr>
            
                <td>Confirm Password:</td>
                <td><input type="password" size="30" id="pswdr" name="cpassword" /></td>
            </tr>
            </table>
            
            <p></p>
            <p><input type="submit" value="Sign-Up" name="submit" /> </p>
            <p><input type="reset" value ="Reset " onclick="ResetForm()"/></p>

            
             
        </form>

        <div id="display_info"></div>
         
            <p><a href="login.php">Back to Login Page</a></p>
        
            <footer> 
            <p>&copy; 2021 Ypc350  All rights reserved.</p>
            </footer>  

    </body>
            
</html>
            