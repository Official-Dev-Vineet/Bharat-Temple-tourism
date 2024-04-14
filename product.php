<?php
require_once "Admin/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['searchTerm'];
    $filterBy = $_POST['filterBy'];
    try {
        $sql = "SELECT * FROM tourpackages";
        $params = array();

        if (!empty($searchTerm) && $filterBy == 'review') {
            $sql .= " WHERE title LIKE :searchTerm OR description LIKE :searchTerm OR location LIKE :searchTerm ORDER BY reviewCount DESC";
            $params[':searchTerm'] = "%$searchTerm%";
        } elseif (!empty($searchTerm) && $filterBy == 'price') {
            $sql .= " WHERE title LIKE :searchTerm OR description LIKE :searchTerm  OR location LIKE :searchTerm ORDER BY price ASC";
            $params[':searchTerm'] = "%$searchTerm%";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            foreach ($result as $row) {
                // Output the filtered results, you can modify this part based on your table structure
?>
                <li class="package" title="<?= $row['title'] ?>">
                    <figure>
                        <img src="Admin/<?= $row['image'] ?>" alt="<?= $row['title'] ?>" loading="lazy" />
                    </figure>
                    <h3 class="title">
                        <?= $row['title'] ?>
                    </h3>
                    <p class="mx-3"><strong>Price :<?= $row['price'] ?> ₹</strong></p>
                    <p class="mx-3"><strong>Review : <?= $row['reviewCount'] ?> </strong></p>
                    <div class="btns">
                        <button class="btn btn-primary" onclick="window.location.href='package.php?id=<?= $row['tourId'] ?>'" title="view details">View</button>
                        <button class="btn btn-primary" title="share" onclick="share(window.location.href.replace('/index.php', '').replace(/#/g,'') + '/package.php?id=<?= $row['tourId'] ?>')">Share</button>
                    </div>
                </li>
<?php
            }
        } else {
            echo "<p class='text-center'>No results found for <strong>'$searchTerm'</strong>.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>