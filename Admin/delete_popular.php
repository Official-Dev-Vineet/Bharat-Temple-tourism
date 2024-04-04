    <?php
    require_once 'config.php';
    // if request method is post 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate the ID parameter
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            // Invalid ID, return an error response
            echo "error: Invalid ID parameter";
            exit;
        } else {
            $sql = "DELETE FROM populardestination WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            // Return a success response
            $conn = null;
            echo "success";
            exit;
        }
    } else {
        // Invalid request method, return an error response
        echo "error: Invalid request method";
        exit;
    }
