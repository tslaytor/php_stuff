<?php

// establish connection
require_once('database.php');

$title = '';
$description = '';
$price = '';

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    $errors = [];

    // check form values have been provided
    if (empty($title)){
        $errors[] = "You need to provide a title";
    }
    if (empty($price)){
        $errors[] = "You need to provide a price";
    }
    // if there are no errors, execute this code
    if(empty($errors)){
        // set the value of $image
        $image = $_FILES['image'] ?? null;
        // if the image exists, save it somewhere
        if($image && $image['tmp_name']){
            // check if there is an image dir and make one if not
            if(!is_dir('images')){ 
                mkdir('images');
            }
            
            // make a unique path for the image
            $image_path = 'images/'. random_string(8). '/'. $image['name'];

            mkdir(dirname($image_path));
            // get the temp location and save it in a new file and location
            move_uploaded_file($image['tmp_name'], $image_path);
        }
        // make the intertions to the db
        $statement = $pdo->prepare("INSERT INTO products (title, description, image, price, create_date) VALUES(:title, :description, :image, :price, :create_date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $image_path);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':create_date', $date);
        $statement->execute();

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

<?php include_once('views/partials/header.php') ?>

<h1>Create new Product</h1>

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
   
<?php include_once('views/partials/footer.php'); ?>