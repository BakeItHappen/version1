<!doctype html>
<html>
<body>

<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1); 
$recipeTitle = $_POST["recipeTitle"];
$recipeDir = $_POST["recipeDir"];
$recipeIngr = $_POST["recipeIngr"];
$f_recipeIngr = explode(" ", $recipeIngr);
$servername = "localhost";
$username = "root";
$dbname = "test4";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

//Create insert for Recipe Table
$recTable = "INSERT INTO Recipe (recName, recInstruct) VALUES(?, ?)";

//Create insert for Ingredient Table
$inTable = "INSERT INTO ingredient(inName) (SELECT ? FROM dual WHERE NOT EXISTS (SELECT inName FROM ingredient WHERE inName=?))";

//Create insert for RecipeIngredient Table
$recInTable = "INSERT INTO recipe_ingredient(recID, inID) 
VALUES((SELECT recID FROM recipe WHERE recName = ?), (SELECT inID FROM ingredient WHERE inName = ?))";


//Prepare the INSERT statement for Recipe Table
$statement = $conn->prepare($recTable);
    
//Bind inputs from user for Recipe Table
$i0 = $recipeTitle;
$i1 = $recipeDir;
$statement->bind_param("ss", $i0, $i1);

//Execute the INSERT Query for Recipe Table
$statement->execute();




//For loop to iterate through all input ingredients
for ($x = 0; $x < sizeof($f_recipeIngr); $x++) {
    //Prepare the INSERT statement for Ingredient Table
    $statement = $conn->prepare($inTable);
    
    //Bind inputs
    $i1 = $f_recipeIngr[$x];
    $statement->bind_param("ss", $i1, $i1);
    
    //Execute the INSERT Query for RecipeIngredient Table
    $statement->execute();
}

//For loop to iterate through all input ingredients
for ($x = 0; $x < sizeof($f_recipeIngr); $x++) {
    //Prepare the INSERT statement for RecipeIngredient Table
    $statement = $conn->prepare($recInTable);

    //Bind inputs from user for RecipeIngredient Table
    $i1 = $f_recipeIngr[0];
    $statement->bind_param("ss", $i0, $i1);


  //Execute the INSERT Query for RecipeIngredient Table
    $statement->execute();
  }


mysqli_close($conn);

?>
</body>
</html>