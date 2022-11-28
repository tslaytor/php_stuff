<?php

$id = $_GET['id'];

// establish connection
$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare statement and get values as associative array
$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$values = $statement->fetch(PDO::FETCH_ASSOC);

// save values in their own variables
$title = $values['title'];
$description = $values['description'];
$price = $values['price'];

// empty array for error checking
$errors = [];

// when the user submits the form
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    // get values from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // check form values have been provided
    if (empty($title)){
        $errors[] = "You need to provide a title";
    }
    if (empty($price)){
        $errors[] = "You need to provide a price";
    }
    if(empty($errors)){
        // check if a new image was provided
        if(!empty($_FILES['image']['tmp_name'])){
            $image = $_FILES['image'];
            if(!is_dir('images')){
                mkdir('images');
            }
            // make a unique path for the image, make directory, and move the image there
            $image_path = 'images/'. random_string(8). '/'. $image['name'];
            mkdir(dirname($image_path));
            move_uploaded_file($image['tmp_name'], $image_path);
            // update the image in the database
            $statement = $pdo->prepare("UPDATE products SET image = :image WHERE id = :id");
            $statement->bindValue(':image', $image_path);
            $statement->bindValue(':id', $id);
            $statement->execute();
        }
      
        // make the intertions to the db
        $statement = $pdo->prepare("UPDATE products SET title = :title, description = :description, price = :price WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);
        $statement->execute();
        // redirect to the index page
        header('Location: index.php');
    };
};

function random_string($n){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for($i=0; $i<$n; $i++){
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    } 
    return $str;
}
?>

<!DOCTYPE html>  
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Products CRUD</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="app.css" type="text/css">
    </head>
    <body>
        <h1>Edit <b><?php $values['title']?></b></h1>
        <img src="<?php echo $values['image']?>" class="edit-image">
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?php echo $error ?> </div>
                <?php endforeach; ?>
            <?php endif; ?>
 
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3"> 
                <label class="form-label">Product Image</label>
                <br>
                <input type="file" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label">Product Title</label>
                <input type="text" name="title" value="<?php echo $title ?>" class="form-control" autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"><?php echo $description ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" value="<?php echo $price ?>" step="0.01" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
   
    </body>
</html>