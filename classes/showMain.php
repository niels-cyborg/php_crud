<?php
include_once("classes/db.php");
class showMain extends Db
{

    private $naam;
    private $id;
    private $bericht;
    public function fetchProduct()
    {
        try {
            parent::connect();

            $per_page = isset($_GET['per_page']) && is_numeric($_GET['per_page']) ? $_GET['per_page'] : 6;

            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            $offset = ($page - 1) * $per_page;


            $stmt = "SELECT title, description, id FROM producten ORDER BY created_on ASC LIMIT $per_page OFFSET $offset";
            $result = $this->conn->query($stmt);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '
            <form action="../php_blog/index.php"; method="GET";>
            <div style="background:grey; color:white; text-align:center; padding:15px; margin:15px; float:left; width:20vw; height 15vh;">      
            <input style="font-weight:600; font-size: 20px; background-color:grey; color:white; border:none; cursor:pointer;" type="submit" value="' . $row['title'] . '">
            <input type="hidden" name="product_id" value="' . $row['id'] . '">
            <p>
            ' . $row['description'] . '
            </p>
           </div>
           </form>
            ';

                }
                $stmt = "SELECT COUNT(*) AS total FROM producten";
                $result = $this->conn->query($stmt);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $total_pages = ceil($row['total'] / $per_page);

                echo '<div style="position:absolute; margin-left:46.5%; margin-top:80vh;"; class="pagination">';
                if ($page > 1) {
                    echo '<a style="margin-right:10px;"; href="?per_page=' . $per_page . '&page=' . ($page - 1) . '">Vorige</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a style="list-style:none; padding:3px; margin:3px; background-color:grey; color:white;"; href="?per_page=' . $per_page . '&page=' . $i . '"' . ($page == $i ? ' class="active"' : '') . '>' . $i . '</a>';
                }
                if ($page < $total_pages) {
                    echo '<a style="margin-left:10px;"; href="?per_page=' . $per_page . '&page=' . ($page + 1) . '">Volgende</a>';
                }
                echo '</div>';
            } else {
                echo 'Geen records gevonden.';
            }

        } catch (PDOException $e) {
            echo "Queryfout: " . $e->getMessage();
        }


    }

    public function fill($id)
    {
        parent::connect();
        $stmt = "SELECT title, description, content, user_id FROM producten WHERE id =  $id";
        $result = $this->conn->query($stmt);
        if ($result->rowCount() > 0) {
            ob_end_clean();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "
                    <div style='background:lightgrey; float:left width:10vw; height:auto;'>
                    <p style='padding:5px; color:white; background:darkgrey; font-weight:600; font-size:20px;'>" . $row['title'] . "</p>
                    <section style='background-color:darkgrey; padding:5px;'>" . $row['description'] . "</section>
                    <div style='padding:5px; margin-top:2vh; background-color:lightgrey'>" . $row['content'] . "</div>
                    </div>
                    <style>
    form {
        max-width: 400px;
        margin: 0 auto;
        margin-top: 15vh;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f5f5f5;
    }

    label {
        font-weight: bold;
    }

    input[type='text'],
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    textarea {
        height: 100px;
    }

    input[type='submit'] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type='submit']:hover {
        background-color: #45a049;
    }
</style>

<form method='POST' action='../php_blog/index.php'>
<h2>Revieuw plaatsen</h2>
    <label for='name'>Naam:</label>
    <input type='text' id='name' name='name' required><br><br>
    <input value='". $id ."' type='hidden' name='id'>
    <label for='message'>Bericht:</label><br>
    <textarea id='message' name='message' rows='4' required></textarea><br><br>
    <input name='submit' type='submit' value='Verzenden'>
</form>

                    ";
            }
        }
    }

    public function addReview($naam, $bericht, $id)
    {
        try {
            $this->naam = $naam;
            $this->bericht = $bericht;
            $this->id = $id;

            $sql = "INSERT INTO comments (product_id, name, message) VALUES (:id, :naam, :bericht)";

            $this->connect();
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':naam', $this->naam);
            $stmt->bindParam(':bericht', $this->bericht);
            $stmt->bindParam(':id', $this->id);

            if (!$stmt->execute()) {
                throw new Exception("Database query mislukt.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function fetchRevieuws($id){
        parent::connect();
        $stmt = "SELECT name, message, created_on FROM comments WHERE product_id =  $id";
        $result = $this->conn->query($stmt);
        if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "
            <div style='width:20vw; height:auto; background-color:grey'>
            <p>Naam:". $row['name'] ."</p>
            <p>Message:".$row['message']."</p>
            <p>Timestamp:".$row['created_on']."</p>
            </div>
            ";
    }
}else{
    echo"Geen reviews";
}


}
}



?>