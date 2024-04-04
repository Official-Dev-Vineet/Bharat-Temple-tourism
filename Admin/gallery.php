<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["gallery"])) {
    // Connect to database
    require_once "config.php";
    // Define target directory to save uploaded images
    // create table 
    $sqlForTable = "CREATE TABLE IF NOT EXISTS gallery_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        file_name VARCHAR(255),
        file_path VARCHAR(255)
    )";
    $conn->query($sqlForTable);

    $targetDir = "uploads/";
      $successMsg=[]; 
      $errorMsg=[];
    // Loop through each file in the $_FILES["gallery"] array
    foreach ($_FILES["gallery"]["name"] as $key => $name) {
        // Generate unique filename
        $fileName = uniqid() . "_" . basename($name);
        $targetFilePath = $targetDir . $fileName;

        // Check if file is an actual image
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowedExtensions)) {
            // Upload file to the server
            if (move_uploaded_file($_FILES["gallery"]["tmp_name"][$key], $targetFilePath)) {
                // Insert image details into database using prepared statements
                $sql = "INSERT INTO gallery_images (file_name, file_path) VALUES (:file_name, :file_path)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':file_name', $fileName, PDO::PARAM_STR);
                $stmt->bindParam(':file_path', $targetFilePath, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    array_push($successMsg, $fileName);
                } else {
                    array_push($errorMsg, $fileName);
                }
            } else {
                echo "Error uploading file: " . $fileName . "<br>";
            }
        } else {
            echo "Invalid file format: " . $fileName . "<br>";
        }
    }

    // Close connection
    $conn = null; // This will close the PDO connection properly
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery Upload</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .container {
            max-width: 1400px;
            margin: auto;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Responsive grid layout */
            gap: 10px;
            padding: 10px;
        }

        .gallery-item {
            overflow: hidden;
            position: relative;
            border-radius: 5px;
            cursor: pointer;
            width:100%;
            height:100%;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit:cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1); /* Zoom effect on hover */
        }
        .gallery-item button{
          display:block;
          position:absolute;
          bottom:0;
          left:0;
          right:0;
          margin:auto;
          background-color:rgba(0,0,0,0.5);
          color:white;
          border:none;
          padding:5px;
          border-radius:0 0 5px 5px;
          width:100%;
          font-size:1.2rem;
          text-align:center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Upload Image Gallery</h2>
        <form id="uploadForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="gallery">Select Images:</label>
                <input
                    type="file"
                    class="form-control-file"
                    id="gallery"
                    name="gallery[]"
                    multiple
                    accept="image/*"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary">Upload Gallery</button>
        </form>
        <?php
        if (!empty($successMsg)) {
            echo "<p class='alert alert-success'>Uploaded successfully: " . implode(", ", $successMsg) . "</p>";
        }
        if (!empty($errorMsg)) {
            echo "<p class='alert alert-danger'>Failed to upload: " . implode(", ", $errorMsg) . "</p>";
        }
        ?>
      </div>
      <div class="container">
      <p class="mt-3">Uploaded Images:</p>
        <div class="gallery-container" id="uploadedImages">
            <!-- Add more gallery items as needed -->
            <p class="text-center">No images uploaded yet.</p>
        </div>
    </div>
    <!-- Fetch images from server -->
    <script>
        $(document).ready(function () {
            $.ajax({
                url: "fetch_images.php",
                type: "POST",
                dataType: "html",
                success: function (data) {
                    $("#uploadedImages").html(data);
                }
            });

            // Reset form data after successful submission
            $("#uploadForm").on("submit", function (e) {
                e.preventDefault(); // Prevent default form submission
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function () {
                        alert("File uploaded successfully!");
                        $("#uploadForm")[0].reset(); // Reset the form
                        // reload window after successful upload
                        location.reload();
                    },
                    error: function () {
                        alert("Error uploading file!");
                    }
                });
            });
        });
      function deleteImage(id){
        $.ajax({
          url: "delete_image.php",
          type: "POST",
          data: {id: id},
          success: function (data) {
            // check if the image was deleted successfully
            if (data === "success") {
              // remove the image from the DOM
              $("#gallery-item-" + id).remove();
            }
            else{
              alert(data);
            }
          }
        })
      }
    </script>
</body>
</html>
