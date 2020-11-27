<!doctype html>
<html>
<body>

<?php 
$recName = $_POST["RecName"];
$recInstruct = $_POST["RecInstruct"];
$ingredients = $_POST["Ingredients"];
$f_ingredients = explode(" ", $ingredients);
$servername = "localhost";
$username = "root";
$dbname = "test2";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
//Create insert for Recipe Table
$recTable = "INSERT INTO Recipe (rec_name, rec_instruct) VALUES(?, ?)";

//Create insert for Ingredient Table
$inTable = "INSERT INTO Ingredient(in_name) (SELECT 'rice' FROM dual WHERE NOT EXISTS (SELECT in_name FROM Ingredient WHERE in_name='rice'))";

//Create insert for RecipeIngredient Table
$recInTable = "INSERT INTO recipe_ingredient(rec_id, in_id) 
VALUES((SELECT rec_id FROM recipe WHERE rec_name = ?), (SELECT in_id FROM ingredient WHERE in_name = ?)";


//Prepare the INSERT statement for Recipe Table
$statement = $conn->prepare($recTable);
    
//Bind inputs from user for Recipe Table
$statement->bind_param("ss", $i0, $i1);
$i0 = $recName;
$i1 = $recInstruct;

//Execute the INSERT Query for Recipe Table
$statement->execute();
 





//Bind inputs from user for RecipeIngredient Table
for ($x = 0; $x <= 10; $x++) {
    //Prepare the INSERT statement for RecipeIngredient Table
    $statement = $conn->prepare($recInTable);
    $statement->bind_param("ss", $i0, $i3);
    $i3 = $f_ingredients[$x];
    $statement->execute();
  }


mysqli_close($conn);

?>
</body>
</html>