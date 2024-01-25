<?php
include("db.php");
class Product extends Db{
    public $title;
    public $description;
    public $content;
    public $user_id;
    public function addProduct($title, $description, $content, $user_id){
        try{
            $this->title = $title;
            $this->description = $description;
            $this->content = $content;
            $this->user_id = $user_id;


            $sql = "INSERT INTO producten (title, description, content, user_id) VALUES (:title, :description, :content, :user_id)";

            $this->connect();
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':user_id', $this->user_id);

            if(!$stmt->execute()){
                throw new Exception("Database query mislukt.");
            }

            echo "<h3 style='padding:20px; color:green;'>{$this->title} is toegevoegd.</h3>";

        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function fill()
    {
        $s_id = $_GET['product_id'];

        try {
            parent::connect();
            $stmt = "SELECT title, description, content, user_id FROM producten WHERE id =  $s_id";
            $result = $this->conn->query($stmt);
            if ($result->rowCount() > 0) {
               
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    if($_SESSION['id'] == $row['user_id']){
                    echo '
                    <style>
    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f5f5f5;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
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

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #del{
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float:right;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<form method="POST" action="editProduct.php">
    <label for="title">Title:</label><br>
    <input value="' . $row['title'] . '"; type="text" id="title" name="title" required><br><br>
    <label for="description">Description:</label><br>
    <input value="' . $row['description'] . '"; type="text" id="description" name="description" required><br><br>
    <input value="'. $_GET['product_id'] .'" type="hidden" name="id";

    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="4" required>' . $row['content'] . '</textarea><br><br>

    <input type="submit" value="Opslaan">
    <a href="editProduct.php?product_id=' . $_GET['product_id'] . '&action=delete"><input id="del" type="button" value="Verwijder"></a>

</form>

                    
            ';
                }else{
                    die ("Kan niet bewerken, geen toegang tot product");
                }
            }
            }

        } catch (PDOException $e) {
            echo "Queryfout: " . $e->getMessage();
        }
    }

    public function updateProduct($title, $description, $content, $id){

        try{
            parent::connect();
            $stmt = $this->conn->prepare("UPDATE producten SET title = ?, description = ?, content = ? WHERE id = ?");
            $stmt->bindParam(1, $title);
            $stmt->bindParam(2, $description);
            $stmt->bindParam(3, $content);
            $stmt->bindParam(4, $id);

            $stmt->execute();

            header("Location: ../productShow.php");

        } catch (PDOException $e) {
            echo "Queryfout: " . $e->getMessage();
}
    }
    public function deleteProduct($id){
        try {
            parent::connect();
            
            $stmt = $this->conn->prepare("DELETE FROM producten WHERE id = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            header("Location: productShow.php");
        } catch (PDOException $e) {
            echo "Queryfout: " . $e->getMessage();
        }
    }
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
            <form action="editProduct.php"; method="GET";>
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
}


?>