<?php
session_start();
include("db.php");
class User extends Db{

    public $username;
    public $password;
    
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->username = $_POST['username'];
            $this->password = $_POST['password'];
        }
    }

    public function loginUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['submit'])) {
                if (empty(trim($this->username && $this->password))) {
                    echo "Vul de gegevens in aub";
                } else {
                    parent::connect();
                    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
                    $stmt->execute([$_POST['username']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user && password_verify($_POST['password'], $user['password'])) {
                        clearstatcache();
                        
                        $_SESSION['username'] = $this->username;
                        $_SESSION['id'] = $user['id'];
                        header("Location: admin.php");
                        exit;
                    } else {
                        echo "<h3 style='color:red; width:100vw; text-align:center'>
                        Either username or password is incorrect.
                        </h3>
                        ";
                    }

                }
            }
        }
    }
    
    public function UserAdd($user, $pass){

        try{
            $this->username = $user;
            $this->password = $pass;

            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

            $this->connect();
            $hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $hash);

            if(!$stmt->execute()){
                throw new Exception("Database query mislukt.");
            }
            echo "<h3 style='padding:20px; color:green;'>{$this->username} is toegevoegd</h3>";

        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function fetchUsers(){
        try {
        parent::connect();
        $stmt = "SELECT username, id FROM users";
        $result = $this->conn->query($stmt);

        if($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            echo "
            <div style='float:left; margin:10px; padding:25px; color:white; background-color:grey; text-align:center; width: 200px; height:150px'>
            <h4>" .$row['username'] ."</h4>
            <form action='userShow.php'; method='POST';>
            <input type='hidden' name='user_id' value='" . $row['id'] . "'>
            <input value='verwijderen'; type='submit'>    
            </form>
            </div>
            ";
        }
        }else{
            echo 'Geen records gevonden.';
        }
        
    }catch(PDOException $e) {
        echo "Queryfout: " . $e->getMessage();
    }
}

    public function deleteUsers($id){
        if(!empty($id)){
            try{
                parent::connect();
                $stmt = "DELETE FROM users WHERE id = :id";
                $query = $this->conn->prepare($stmt);
                $query->bindParam(':id', $id);
                $query->execute();
                echo "Gebruiker met id:". $id ." verwijderd";
            } catch (PDOException $e){
                echo "Gebruiker niet verwijderd" . $e->getMessage();
            }
        }
    }
    
}

?>