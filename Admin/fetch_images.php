<?php 
// connect to database
require_once "config.php";

// get images from database if request method is post 
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $stmt = $conn->prepare("SELECT * FROM gallery_images ORDER BY id DESC");
    $stmt->execute();
    
    // Fetch results and fetch associative array
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // set alt text as file name
        echo '<div class="gallery-item" id="gallery-item-' . $row['id'] . '"> <img src="' .str_replace("../../Admin/", "", $row['file_path']) . '" alt="' . $row['file_name'] . '"  class="img-fluid" />   <button onclick="deleteImage(' . $row['id'] . ')">Delete</button> 
        </div>
        <h4>Review</h4>
        <p> ' .htmlspecialchars($row['review'], ENT_QUOTES, 'UTF-8') . ' </p>';
    }
}else{
    echo "Error: Method not allowed";
}
?>
