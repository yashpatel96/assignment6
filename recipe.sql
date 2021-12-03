-- Droping tables if exists
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS recipe;
DROP TABLE IF EXISTS feedback;

-- Creating tables
CREATE TABLE users (
	user_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR(30) NOT NULL,
	email VARCHAR(100) NOT NULL,
	DOB TIMESTAMP NOT NULL,
	password VARCHAR(30) NOT NULL,
	avtar VARCHAR(200) NOT NULL
);

CREATE TABLE recipe (
	recipe_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_ID INT NOT NULL,
	recipe_title VARCHAR (50) NOT NULL,
	ingredients VARCHAR (100) NOT NULL,
	content VARCHAR (200) NOT NULL,
	instruction VARCHAR (100) NOT NULL,
	recipe_image VARCHAR (200) NOT NULL,
	FOREIGN KEY (user_ID) REFERENCES users(user_ID),
	posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

CREATE TABLE feedback (
	feedback_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_ID INT NOT NULL,
	recipe_ID INT NOT NULL,
	name VARCHAR (50) NOT NULL,
	comment VARCHAR (200) NOT NULL,
	star INT NOT NULL,
	lastdt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_ID) REFERENCES users(user_ID),
	FOREIGN KEY (recipe_ID) REFERENCES recipe(recipe_ID)
);


-- Queries:

----B.Data Storage/ Update Queries---

--- Sign up Querry----
INSERT INTO users (user_ID, user_name, email, DOB, password, avtar) VALUE (1,'username','username@gmail.com','1996-06-05','password','https://www.nicepng.com/png/detail/186-1866063_dicks-out-for-harambe-sample-avatar.png');



---- create recipe querry----
INSERT INTO recipe (recipe_ID, user_ID, recipe_title, ingredients, content, instruction, recipe_image) VALUE (1,1,'recipe title is here','its ingredients','contents shouls be here','it is instruction','https://www.nicepng.com/png/detail/186-1866063_dicks-out-for-harambe-sample-avatar.png');




---recipe details querry----
INSERT INTO feedback (feedback_ID, user_ID, recipe_ID, name, comment, star) VALUE (1,1,1,'john','feedback is here',4);
UPDATE feedback 
SET star = 3
WHERE feedback_ID = 1222;

------C. Data Retrieval Queries------

----Login Form----

SELECT * FROM users WHERE user_name = 'username' AND password = 'password';

----Recipe List Page---
SELECT * FROM recipe ORDER BY posted_at DESC;


SELECT * FROM recipe JOIN users ON users.user_ID = recipe.user_ID;
SELECT * FROM recipe JOIN feedback ON feedback.recipe_ID = recipe.recipe_ID;

SELECT * FROM recipe JOIN feedback ON feedback.recipe_ID = recipe.recipe_ID WHERE recipe.recipe_ID = 1;


---Recipe Detail Page--

SELECT AVG(feedback.star) AS avarage, recipe.*, feedback.*  FROM feedback JOIN recipe ON feedback.recipe_ID = 1;
SELECT * FROM feedback JOIN recipe ON recipe.recipe_ID = feedback.recipe_ID WHERE feedback.user_ID = 1;