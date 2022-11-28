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
    // if there are no errors, execute this code
    if(empty($errors)){
        // check if a new image was provided
        if(!empty($_FILES['image']['tmp_name'])){
            $image = $_FILES['image'];
            // ?? null; // ***** i think we don't need the ?? null statement, but it's doing no harm i guess
        }
        // if the image exists, save it somewhere
        if($image != null){  // ***** I THINK WE CAN JUST SAY IF $IMAGE, NO NEED FOR NOT NULL - in fact... we only create the $image variable in the condition above, so why check for it again?
            // check if there is an image dir and make one if not
            if(!is_dir('images')){
                mkdir('images');
            }
            // make a unique path for the image
            $image_path = 'images/'. random_string(8). '/'. $image['name'];
            // make directory for the unique path
            mkdir(dirname($image_path));
            // get the temp location and save it in a new file and location
            move_uploaded_file($image['tmp_name'], $image_path);
        }
        // make the intertions to the db
        $statement = $pdo->prepare("UPDATE products SET title = :title, description = :description, price = :price WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);
        $statement->execute();

        if($image != null){
            $statement = $pdo->prepare("UPDATE products SET image = :image WHERE id = :id");
            $statement->bindValue(':image', $image_path);
            $statement->bindValue(':id', $id);
            $statement->execute();
        }

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
                <!-- <br> -->
            </div>
            <div class="mb-3">
                <label class="form-label">Product Title</label>
                <input type="text" name="title" value="<?php echo $title ?>" class="form-control">
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