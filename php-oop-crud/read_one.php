<?php
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    
    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $product = new Product($db);
    $category = new Category($db);
    
    $product->id = $id;
    
    $product->readOne();
    $page_title = "Read One Product";
    include_once "layout_header.php";
    
    echo "<div class='right-button-margin'>";
        echo "<a href='index.php' class='btn btn-primary pull-right'>";
            echo "<span class='glyphicon glyphicon-list'></span> Read Products";
        echo "</a>";
    echo "</div>";

    echo "<table class='table table-hover table-responsive table-bordered'>";
    
        echo "<tr>";
            echo "<td>Name</td>";
            echo "<td>{$product->name}</td>";
        echo "</tr>";
    
        echo "<tr>";
            echo "<td>Price</td>";
            echo "<td>${$product->price}</td>";
        echo "</tr>";
    
        echo "<tr>";
            echo "<td>Description</td>";
            echo "<td>{$product->description}</td>";
        echo "</tr>";
    
        echo "<tr>";
            echo "<td>Category</td>";
            echo "<td>";
                $category->id=$product->category_id;
                $category->readName();
                echo $category->name;
            echo "</td>";
        echo "</tr>";
    
    echo "</table>";
    
    include_once "layout_footer.php";
?>