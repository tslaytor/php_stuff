<?php

$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = trim($_GET['search'] ?? '');

if($search){
    $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :search ORDER BY id DESC');
    $statement->bindValue(':search', "%$search%");
}
else {
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY id DESC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


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
        <h1>Products CRUD</h1>

        <form>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $search ?>" autocomplete="off">
                <button type="submit" class="input-group-text">Search</button>
            </div>
        </form>
        
        <p>
            <a href="create.php" class="btn btn-success">Create</a>
        </p>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Create Date</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $i => $product): ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td>
                        <img src="<?php echo $product['image']?>" class="image">
                    </td>
                    <td><?php echo $product['title'] ?></td>
                    <td><?php echo $product['price'] ?></td>
                    <td><?php echo $product['create_date'] ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $product['id']?>" class="btn btn-primary">Edit</a>
                        <form action="delete.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        
                    </td>
                    
                </tr>
                <?php endforeach ?>
                
                
                
                
            </tbody>
        </table>
   
    </body>
</html>
