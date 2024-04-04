<?php 
// Include the database connection file
require_once "config.php";

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the ID parameter
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id === false || $id === null) {
        // Invalid ID, return an error response
        echo "error: Invalid ID parameter";
        exit;
    }

    // Prepare and execute the SQL query to delete the image from the database
    $sql = "DELETE FROM gallery_images WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        // Successfully deleted from the database
        // Fetch the filename associated with the deleted image
        $sqlFetchFileName = "SELECT file_name FROM gallery_images WHERE id = :id";
        $stmtFetchFileName = $conn->prepare($sqlFetchFileName);
        $stmtFetchFileName->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtFetchFileName->execute();
        $fileName = $stmtFetchFileName->fetchColumn();

        // Delete the file from the server if it exists and is a regular file
        $filePath = __DIR__ . "/uploads/" . $fileName; // Assuming the uploads folder is in the same directory as this PHP script
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
        $conn= null;
        echo "success"; // Return success response
        exit;
    } else {
        echo "error: Failed to delete from database";
        $conn= null;
        exit ;
    }
} else {
    echo "error: Invalid request method";
    exit;
}
?>
