<?php
require_once "config.php";
$msg='';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"], $_POST["location"], $_POST["description"]) && isset($_FILES["image"])) {
    // Prepare and execute SQL query to insert data
    $sql = "INSERT INTO populardestination (title, location, description) VALUES (:title, :location, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $_POST["title"], PDO::PARAM_STR);
    $stmt->bindParam(':location', $_POST["location"], PDO::PARAM_STR);
    $stmt->bindParam(':description', $_POST["description"], PDO::PARAM_STR);
    $stmt->execute();

    // Get the last inserted ID
    $entryId = $conn->lastInsertId();

    // Upload image file
    $targetDir = "uploads/";
    $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $msg= "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedExtensions)) {
        $msg= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg= "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // Update database with image file path
            $updateSql = "UPDATE populardestination SET image = :image_path WHERE id = :entry_id";
            $stmtUpdate = $conn->prepare($updateSql);
            $stmtUpdate->bindParam(':image_path', $targetFilePath, PDO::PARAM_STR);
            $stmtUpdate->bindParam(':entry_id', $entryId, PDO::PARAM_INT);
            $stmtUpdate->execute();
            $msg= "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            $msg= "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Destination Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .container {
            max-width: 1300px;
            margin: auto;
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-5 mb-4">Create New Popular Destination</h2>
    <form id="createForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php 
    if (!empty($msg)) {
        echo '<div class="alert alert-success mt-1">' . $msg . '</div>';
    }

?>
</div>

<div class="container mt-5">
<div class="row">
    <?php
    // Fetch data from database
    $sql = "SELECT * FROM populardestination";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id= $row["id"];
        $title = htmlspecialchars($row["title"]);
        $location = htmlspecialchars($row["location"]);
        $description = htmlspecialchars($row["description"]);
        $imagePath = htmlspecialchars($row["image"]);
        echo '<div class="col-md-4 mb-4" id="card-' . $id . '">';
        echo '<div class="card">';
        echo '<img src="' . $imagePath . '" class="card-img-top" alt="' . $title . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $title . '</h5>';
        echo '<p class="card-text"><strong>Location:</strong> ' . $location . '</p>';
        echo '<p class="card-text"><strong>Description:</strong> ' . $description . '</p>';
        echo '<button onclick=deleteCard(' . $id . ') class="btn btn-danger">Delete</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
</div>
<script>
    // Reset form data after submission
    $(document).ready(function() {
    $('#createForm').submit(function(event) {
      event.preventDefault(); // Prevent form submission

      // Perform AJAX submission
      var formData = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          alert('Form submitted successfully!');
          $('#createForm')[0].reset(); // Reset form
        },
        error: function() {
          alert('Error submitting form!');
        }
      });
    });
  });
  function deleteCard(cardId) {
    $.ajax({
      url: 'delete_popular.php',
      type: 'POST',
      data: { id: cardId },
      success: function(data) {
        if(data === 'success') {
          $('#card-' + cardId).remove();
        }else{
          alert(data);
        }
      }
    })
  }
</script>
</body>
</html>
