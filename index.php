<?php
require_once'.gitignore/_connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$errors= [];
if(!empty($_POST)){
    $contentPost = array_map('trim', $_POST);
    $contentPost = array_map('htmlentities', $contentPost);
    $firstName = $contentPost["firstname"];
    $lastName = $contentPost["lastname"];

    if(strlen($firstName) <1 || strlen($lastName) <1){
        $errors[] = 'vous devez remplir les formulaires';
    }
    if(strlen($firstName) >45 || strlen($lastName) >45){
        $errors[] = 'vous ne pouvez pas mettre plus de 25 caractere';
    }
    if(!empty($errors)){
        foreach($errors as $error){
            echo $error . '<br>';
        }
    } else{
        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstName, :lastName)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstName', $firstName, \PDO::PARAM_STR);
        $statement->bindValue(':lastName', $lastName, \PDO::PARAM_STR);
        $statement->execute();
        header("location:/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="" method="post">
    <div>
    <label for="firstname">prénom</label>
    <input type="text" name="firstname" id= "firstname" required>
    </div>
    <div>
    <label for="lastname">nom</label>
    <input type="text" name="lastname" id= "lastname" required>
    </div>
    <button type="submit">envoyer</button>
</form>

<?php
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$table = $statement-> fetchall();
echo 'les personnes dans la liste sont: <br>';
foreach($table as $friend){
    echo $friend['firstname'] . ' ' . $friend['lastname'] . '<br>';
}
?>
</body>
</html>