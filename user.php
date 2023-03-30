<?php
    // Functie: classdefinitie User 
    // Auteur: Wigmans

    class User{

        // Eigenschappen 
        public $username;
        public $email;
        private $password;
        
        function SetPassword($password){
            $this->password = $password;
        }
        function GetPassword(){
            return $this->password;
        }

        public function ShowUser() {
            echo "<br>Username: j<br>";
            echo "<br>Password: $this->password<br>";
            echo "<br>Email: $this->email<br>";
        }

        public function RegisterUser(){
            $status = false;
            $errors=[];
            if($this->username != "" || $this->password != ""){

                // Check user exist
                if(true){
                    array_push($errors, "Username bestaat al.");
                } else {
                    // username opslaan in tabel login
                    // INSERT INTO `user` (`username`, `password`, `role`) VALUES ('kjhasdasdkjhsak', 'asdasdasdasdas', '');
                    // Manier 1
                    
                    $status = true;
                }
                            
                
            }
            return $errors;
        }

        function ValidateUser(){
            $errors=[];

            if (empty($this->username)){
                array_push($errors, "Invalid username");
            } else if (empty($this->password)){
                array_push($errors, "Invalid password");
            }

            // Test username > 3 tekens

            if(strlen($this->username) < 3){
                array_push($errors, "username te kort");
            }
            
            return $errors;
        }

        public function LoginUser(){

            // Connect database
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=user5", 'root', '');
                // Set PDOException
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Connected Succesfully';
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Zoek user in de table user

            $query = "SELECT * FROM user WHERE username = :username AND password = :password";
            $stmt = $pdo->prepare($query);
            $stmt->execute(
                array(
                    "username"=> $this->username,
                    "password" => $this->password
                )
            );

            $count = $stmt->rowCount();

            // Indien gevonden dan sessie vullen

            if($count > 0) {
                session_start();

                $_SESSION["username"] = $this->username;

                return true;
            } else {
                echo 'Verkeerde input';
                return false;
            }

        }

        // Check if the user is already logged in
        public function IsLoggedin() {
            // Check if user session has been set
            if(isset($_SESSION["username"])) {
                return true;
            } else {
                return false;
            }
            
        }

        public function GetUser($username){

		    // Doe SELECT * from user WHERE username = $username
            if (false){
                //Indien gevonden eigenschappen vullen met waarden uit de SELECT
                $this->username = $_SESSION['username'];
            } else {
                return NULL;
            }   
        }

        public function Logout(){
            session_start();
            // remove all session variables
            unset($_SESSION['username']);

            // destroy the session
            session_destroy();

            header('location: index.php');
        }


    }