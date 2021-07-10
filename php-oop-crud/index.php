<?php
    // page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
    // set number of records per page
    $records_per_page = 5;
    
    // calculate for the query LIMIT clause
    $from_record_num = ($records_per_page * $page) - $records_per_page;
    
        // include database and object files
    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';
    
    // instantiate database and objects
    $database = new Database();
    $db = $database->getConnection();
    
    $product = new Product($db);
    $category = new Category($db);
    
    // query products
    $stmt = $product->readAll($from_record_num, $records_per_page);
    $num = $stmt->rowCount();

    // set page header
    $page_title = "Read Products";
    include_once "layout_header.php";
    
    "<div class='right-button-margin'>
    <a href='create_product.php' class='btn btn-default pull-right'>Create Product</a>
    </div>";
    
    // set page footer
    include_once "layout_footer.php";

    if($num>0){
    
        echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                echo "<th>Product</th>";
                echo "<th>Price</th>";
                echo "<th>Description</th>";
                echo "<th>Category</th>";
                echo "<th>Actions</th>";
            echo "</tr>";
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
                extract($row);
    
                echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td>{$price}</td>";
                    echo "<td>{$description}</td>";
                    echo "<td>";
                        $category->id = $category_id;
                        $category->readName();
                        echo $category->name;
                    echo "</td>";
    
                    echo "<td>";
                        echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                            <span class='glyphicon glyphicon-list'></span> Read
                        </a>
                        
                        <a href='update_product.php?id={$id}' class='btn btn-info left-margin'>
                            <span class='glyphicon glyphicon-edit'></span> Edit
                        </a>
                        
                        <a delete-id='{$id}' class='btn btn-danger delete-object'>
                            <span class='glyphicon glyphicon-remove'></span> Delete
                        </a>";
                    echo "</td>";
    
                echo "</tr>";
    
            }
    
        echo "</table>";
    
        $page_url = "index.php?";
        
        $total_rows = $product->countAll();
        
        include_once 'paging.php';
    }
    
    else{
        echo "<div class='alert alert-info'>No products found.</div>";
    }
?>