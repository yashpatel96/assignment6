<?php 

    session_start();
    $db = new mysqli("localhost", "ypc350", "papa9875", "ypc350");

/*  if($db->connect_error)
    {
        die("Connection Failed: !!" . $db->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $feedback_ID = trim($_POST["feedback_ID"]);

        if (intval($feedback_ID) > 0)
        {
            $q = "INSERT INTO feedback (feedback_ID, recipe_ID, user_ID, star) VALUES (" . $feedback_ID .", ". $_SESSION["recipe_ID"] . ",". $_SESSION["id"] . ", ".$_POST["star"] .")";

            $result = $db->query($q);
        }
    }

    */
 

    $get_receipe = 'SELECT COUNT(feedback.star) AS countVote, AVG(feedback.star) AS avarage , users.user_ID, user_name, avtar, recipe.user_ID, recipe.recipe_ID, content, instruction, posted_at, ingredients, recipe_image, star, feedback.feedback_ID,feedback.recipe_ID 
                    FROM users LEFT JOIN recipe ON (users.user_ID = recipe.user_ID)
                    LEFT JOIN feedback ON feedback.recipe_ID =recipe.recipe_ID
                    GROUP BY recipe.recipe_ID ORDER BY recipe.posted_at desc';
    
    $result = $db->query($get_receipe);
    
  if (isset($_POST["submit_vote"]) && $_POST["vote"] != '')
    {
    $rate = $_POST['vote'];
    $user_ID = $_SESSION['id'];
    $recipe_ID = $_POST['recipe_ID'];
       

     $insertVoteQuery = "INSERT INTO feedback (user_ID, recipe_ID, star) VALUES ($user_ID,$recipe_ID,$rate)";
                            $insertResult = $db->query($insertVoteQuery);
                            if ($insertResult == true)
                            {

                             header("Location: index.php");
                              // header("Refresh:0");
                                exit();
                            }
                            else 
                            {
                               echo "Sorry, there was an error insert the row";
                            }
                          
    }
   
 
    
            
?>

<!DOCTYPE html>
<html lang="en-US">
    
    <head>
        <title>
            Welcomne to Recipe page
        </title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

        <link rel="stylesheet" type="text/css" href="large.css"  />

        <link rel="stylesheet" type="text/css" href="button.css" />

        <script type="text/javascript" src="validator.js"></script>
        <script type="text/javascript" src="ajax.js"></script>
       
        

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    </head>
   
    <body>
        <header>
            <table>
                <tr>
                    <td>
                    <img src="image/krishna.png" alt=" logo " height="100" width="150"/>
                    </td>
                    <td>
                    <h2> Welcome to Krishna Dishes</h2>
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
            <br/>
            <hr/>
        </header>   
        <nav>
            <ul>
                <li><a href="#about">About Us</a></li>
                <li>|</li>
                <li><a href="#dishes">Dishes</a></li>
                <li>|</li>
                <li><a href="#updates">Updates</a></li>
                <li>|</li>
                <li><a href="postrecipe.php">Post New Recipe</a></li>
                
                
                <li> 
        
                    <form class="search" action="index.php" style="float:right;">
                    <input type="text" placeholder="Type here"  />
                    <button type="submit" value="search"><i class="fa fa-search"></i></button>
                    </form>
            
                </li>
            </ul>


            </nav>
            
            
    
            <section id="dishes">
                <h3 style="color:peru">Dishes</h3>
                <button id ="refresh-btn">Refresh Vote Count</button>
                <?php 
                    while ($row = $result->fetch_array()) { ?>
                    

                    <article>
                     <h3><?php echo $row['recipe_title']; ?></h3>
                     <p><img src="<?php echo $row['avtar']; ?>" alt=" person " height="15" width="15"/><?php echo 'Posted By ' . htmlspecialchars($row['user_name']) . ' at ' . htmlspecialchars($row['posted_at']) . '!';?></p>
                    <table>
                        <tr>
                            <td>
                               <p> <img src="<?php echo $row['recipe_image']; ?>" alt=" logo " height="100" width="150"/></p>
                            </td>
                            <td>
                                <p><?php echo $row['content']; ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Ingredients:</p>
                            </td>
                            <td>
                                <p><p><?php echo $row['ingredients']; ?> </p></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>How to Make it:</p>
                            </td>
                            <td>
                                <p><p><?php echo $row['instruction']; ?> </p></p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Details of Recipe:</td>
                            <td>
                            <a href="recipedetails.php?recipe_ID=<?php echo $row['recipe_ID'] ?>">Click here for Recipe Details...</a>
                            </td>
                        </tr>

                        <tr>
                            <td>Avrage Rating:</td>
                            <td>
                            <?php echo 'Out of 5 : ' . htmlspecialchars($row['avarage']) . '';?>
                            </td>
                        </tr>

                        <tr>
                            <td>Count the Vote:</td>
                            <td>
                            <?php echo 'Total Votes : ' . htmlspecialchars($row['countVote']) . '';?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Vote this Recipe:</td>
                            <td>
                            <form action = "" method = "POST">
                            <input type = "hidden" name = "recipe_ID" value = "<?php echo $row['recipe_ID']; ?>">
                            <input type = "text" name="vote" placeholder = "Rate out of 5" />
                            <?php
                            if($_SESSION['id']){
                            echo '<input type="submit" value="Vote" name="submit_vote" id="input_letter" />';
                            }
                            else
                            echo '<p style = "color:red";>For Voting the recipe; You have to Log into the page First!!!</p>'
                            ?>
                            </form>
                        
                            
                            </td>
                        </tr>
                        

                    </table> 
                </article>
                <?php }
                ?>
                
                
    
    
            </section>
            
            <section id="about">
                <h3 style="color:purple">About Krishna Dishes!</h3>
                <p>Hey there! Krishna Dishes intoduce about new recipe and also Give you opportunity to rate the Recipe!
                    <br/> Not only that! We give you the opportunity to "Post Your Favourite Recipe"!!! and Explore the World!
                </p>
                <p>Krishna Dishes is Just started for CS215 Assignment! But who knows it becomes  one of the Billions company!
                    <br/> So, Stay contacted with Us.
                    <br/> Thank You!
                </p>


                <p style="color:rgb(78, 65, 5)">You can contanct us at your gmail (krishnadishes96@gmail.com) phone me at +1-306-320-9875.</p>
            </section>

            <aside id="updates">
                <h3 style="color:rebeccapurple">What's Happening</h3>
                    <article>
                        <h4>Recently Posted Recipe</h4>
    
                        <ol>
                            <li>Cheese Pakoda</li>
                            <li>Gulab-Jamu</li>
                            <li>Panner Chilly</li>
                        </ol>
                        
                    </article>
    
                    <article>
                    <h4>Most Popular Dishes</h4>
                        <ol>
                            <li>South Indian Dosa</li>
                            <li>Vegitable Samosa</li>
                            <li>Panner Kadai</li>
                        </ol>
                   
                   </article>
    
                   <article>
                    <h4>Recipe Tips</h4>
                        <ol>
                            <li>Breakfast is the most important meal of the day so start the day off right. From quiches to egg sandwiches or even breakfast pizza, we have many to choose from.</li>
                            <li>Kid and budget friendly, chicken is a go to meal for most homes. Try some new recipes so your family stays happy</li>
                            <li>For all you sweet tooth people out there, we can fix that (or make it worse, I suppose). Chocolate lovers beware!</li>
                        </ol>
                    
                   </article>
            </aside>   
        <footer>
            
            
            <p>&copy; 2021 Ypc350  All rights reserved.</p>
        </footer>
          
    </body>
    
       
</html>