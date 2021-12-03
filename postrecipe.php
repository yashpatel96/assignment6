<!DOCTYPE html>
<?php 
    session_start();
    if(isset($_POST['title']) && $_POST['title'] != '')
    {
        $db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");

            if ($db->connect_error){
                $error = "Database connection failed";
                die ("Connection failed: " . $db->connect_error);
            }

        $title = $_POST['title'];
        $ingrediants = $_POST['ingredients'];
        $details = $_POST['recipe_detail'];
        $instructions = $_POST['instructions'];
        $user_id = $_SESSION['id'];
            //print_r($_FILES['recipe_img']);
        $target_dir = "image/";
                    $target_file = $target_dir . basename($_FILES["recipe_img"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    
                    if(isset($_FILES['recipe_img']) && $_FILES['recipe_img']['size'] > 0) 
                    {
                        $upload = move_uploaded_file($_FILES["recipe_img"]["tmp_name"], $target_file);
                        if ($upload)
                        {
                            // upload success
                            // Part 2: Insert the record to the table
                            $fileLocation = 'image/'.basename( $_FILES["recipe_img"]["name"]);
                            $insertQuery = "INSERT INTO recipe (user_ID, recipe_title, ingredients, content, instruction, recipe_image) VALUES ($user_id,'$title','$ingrediants', '$details', '$instructions', '$fileLocation')";
                            $insertResult = $db->query($insertQuery);
                            if ($insertResult == true)
                            {
                                header("Location: index.php");
                                exit();
                            }
                            else 
                            {
                                echo "Sorry, there was an error insert the row";
                            }
                        } 
                          else 
                            {
                            echo "Sorry, there was an error uploading your file.";
                            }
                    } 
                    else 
                    {
                        echo "Sorry, your file was not uploaded.";
                    }

        
    }
?>
<html lang="en">
    <head>
        <title>
            Welcomne to Post Recipe Page
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="stylesheet" type="text/css" href="large.css" />

        <link rel="stylesheet" type="text/css" href="button.css" />
        
        
        
    </head>
         
    <body>
        <header>
            <table>
            <tr>
                <td>
                <img src="image/krishna.png" alt=" logo " height="100" width="150"/>
                </td>
                <td>
                <h2> Post Your Dishes</h2>
                </td>
            </tr>
            </table>
            <?php
                if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                    echo '<p>Welcome '.$_SESSION['username'].'!!!</p>';
                    echo '<a href="Logout.php" style="color:lightblue;">Logout</a>';
                } 
                else{
                    echo '<a href="login.php" style="color:lightblue; float:left;">Login</a><a href="signup.php" style="color:lightblue; float:right;">Sign Up</a>';
                }
            ?>
        <hr/>
        </header>   


            <form action="postrecipe.php" id="postform" method="post" onsubmit="postForm(event)" enctype="multipart/form-data">
                <table>
                
                <tr>
                        <td>Recipe Title:</td>
                        <td><textarea id="textbox" onkeyup="charcountupdate(this.value)" rows="2" cols="30" name="title"  placeholder="Give your Recipe title here..."></textarea>
                        <span id=charcount></span></td>
                </tr>
                <tr><td></td><td><label id="charcount_msg" class="err_msg"></label></td></tr>
                
                
                <tr>
                    <td>Ingredients:</td>
                   <td><textarea rows="3" cols="30" id="ing" name="ingredients"></textarea></td>
                </tr>

                
                <tr>
                   <td>Recipe Details:</td>
                   <td><textarea name="recipe_detail" rows="4" cols="50" id="details" placeholder="Give your Recipe Details here..."></textarea></td>
                   
                </tr>
                <tr>
                    <td>Recipe Instruction:</td>
                    <td><textarea name="instructions" rows="4" cols="50" id="comment" placeholder="Give your instruction here..."></textarea></td>
                    
                 </tr>
                <tr>
                   <td><label for="img">Recipe image:</label></td>
                   <td><input type="file" id="img" name="recipe_img" accept="image/*" /></td>
                </tr>
               
                </table>
                
                <?php
                if($_SESSION['id']){
                
                echo '<p><input type="submit" value="Submit" name="recipe_submit" />
                <input type="button" value="Cancel" name="Cancel" /></p>';
                }
                else
                echo '<p style = "color:red";>You have to Login First!!!</p>'

                ?>

            </form>

            <script src="validator.js" type="text/javascript"></script>

            <p></p>
            <p><a href="index.php">Back to Main page</a></p>

         <footer> 
            <hr/>
            
            <p>&copy; 2021 Ypc350  All rights reserved.</p>
        </footer>    
          
    </body>
    
       
</html>