<?php
// database connection 

require_once "config.php";
$msg = '';
$warning = '';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"], $_POST["description"], $_FILES["image"], $_POST["pax"], $_POST["location"], $_POST["day"], $_POST["night"], $_POST["price"], $_POST["reviewCount"])) {
  // Connect to your database (modify these with your actual database credentials)

  try {
    // Prepare and execute SQL query to insert data into tour_packages table
    $stmt = $conn->prepare("INSERT INTO tourpackages (title, description, image, pax, location, day, night, price, reviewCount)VALUES (:title, :description, :image, :pax, :location, :day, :night, :price, :reviewCount)");

    $stmt->bindParam(':title', $_POST["title"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->bindParam(':image', $_FILES["image"]["name"]);
    $stmt->bindParam(':pax', $_POST["pax"]);
    $stmt->bindParam(':location', $_POST["location"]);
    $stmt->bindParam(':day', $_POST["day"]);
    $stmt->bindParam(':night', $_POST["night"]);
    $stmt->bindParam(':price', $_POST["price"]);
    $stmt->bindParam(':reviewCount', $_POST["reviewCount"]);
    $stmt->execute();
    // upload file into uploads folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"])) {
      $msg = "Image uploaded successfully and ";
    } else {
      $warning = "Failed to upload image";
    }
    $msg = "New tour package created successfully!";
  } catch (PDOException $e) {
    $warning = "Error: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tour Package Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
  .container {
    max-width: 1400px;
    margin: 50px auto;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 1rem;
  }
</style>

<body>
  <div class="container mt-5">
    <h2>Create a new tour.</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="createATour">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter tour title" required />
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter tour description" required></textarea>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Image URL</label>
        <input type="file" class="form-control" id="image" name="image" placeholder="Upload image" required />
      </div>

      <div class="mb-3">
        <label for="pax" class="form-label">Pax</label>
        <input type="number" class="form-control" id="pax" name="pax" placeholder="Enter maximum number of participants" required />
      </div>

      <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" required class="form-control" id="location" name="location" placeholder="Enter tour location" />
      </div>

      <div class="row g-3 mb-3">
        <div class="col">
          <label for="day" class="form-label">Days</label>
          <input type="number" required class="form-control" id="day" name="day" placeholder="Number of days" />
        </div>
        <div class="col">
          <label for="night" class="form-label">Nights</label>
          <input type="number" required class="form-control" id="night" name="night" placeholder="Number of nights" />
        </div>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" required class="form-control" id="price" name="price" placeholder="Enter price" />
      </div>

      <div class="mb-3">
        <label for="reviewCount" class="form-label">Review Count</label>
        <input type="number" class="form-control" id="reviewCount" name="reviewCount" placeholder="Enter number of reviews" required />
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
    if (!empty($msg)) {
    ?>
      <div class="alert alert-success mt-3" role="alert">
        <?php echo $msg; ?>
      </div>
    <?php
    }
    if (!empty($warning)) {
    ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?php echo $warning; ?>
      </div>
    <?php
    }

    ?>
  </div>
  <?php
  $stmt = $conn->prepare("SELECT * FROM tourpackages");
  $stmt->execute();
  $tourpackages = $stmt->fetchAll();

  ?>
  <?php
  if (!empty($tourpackages)) {
  ?>
    <div class="container mt-5">
      <h2>Tour Packages</h2>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#Id</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Image</th>
              <th scope="col">Pax</th>
              <th scope="col">Location</th>
              <th scope="col">Day</th>
              <th scope="col">Night</th>
              <th scope="col">Price</th>
              <th scope="col">Review Count</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($tourpackages as $tourpackage) {
            ?>
              <tr id="tourpackage<?php echo $tourpackage["id"]; ?>">
                <th scope="row"><?php echo $tourpackage["id"]; ?></th>
                <td><?php echo $tourpackage["title"]; ?></td>
                <td><?php echo $tourpackage["description"]; ?></td>
                <td><img src="uploads/<?php echo $tourpackage["image"]; ?>" width="100" alt="tour package image"></td>
                <td><?php echo $tourpackage["pax"]; ?></td>
                <td><?php echo $tourpackage["location"]; ?></td>
                <td><?php echo $tourpackage["day"]; ?></td>
                <td><?php echo $tourpackage["night"]; ?></td>
                <td><?php echo $tourpackage["price"]; ?></td>
                <td><?php echo $tourpackage["reviewCount"]; ?></td>
                <td> <button type="button" class="btn btn-danger" onclick='deleteTourPackage(<?php echo $tourpackage["id"]; ?>)'>Delete</button> </td>
              </tr>
            <?php
            }
          } else {
            ?>
            <div class="alert alert-warning mt-3" role="alert">
              No tour packages found
            </div>
          <?php
          }

          ?>
          </tbody>
        </table>
      </div>
    </div>
    <script>
      // reset form using ajax 

      document.getElementById("createATour").addEventListener("submit", function(event) {
        event.preventDefault();
        $.ajax({
          url: $(this).attr("action"),
          type: $(this).attr("method"),
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function() {
            alert("tour created successfully!");
            $("#createATour")[0].reset(); // Reset the form
          },
          error: function() {
            alert("Error uploading file!");
          }
        });
      })

      // delete tour package
      function deleteTourPackage(id) {
        $.ajax({
          url: "delete_tourpackage.php",
          type: "POST",
          data: {
            id: id
          },
          success: function(data) {
            if (data === "success") {
              alert("Tour package deleted successfully");
              $("#tourpackage" + id).remove();
            } else {
              alert("Failed to delete tour package");
            }
          }
        })
      }
    </script>
</body>

</html>