<?php

class user_database{
    private PDO $pdo;
    private $pdo_error = "";

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

// Create account function
    function create_userAccount($name, $mail, $phone, $gender, $DOB, $address, $city, $state, $zipcode, $hash_password){
        $name = $name;
        $mail = $mail;
        $phone = $phone;
        $gender = $gender;
        $DOB = $DOB;
        $address = $address;
        $city = $city;
        $state = $state;
        $zipcode = $zipcode;
        $hash_password = $hash_password;
        try{
            $insert_query = "INSERT INTO client_info(client_name, mail_id, phone_number, gender, hash_password, date_of_birth, client_address, city, state, zip_code) 
            values (:client_name, :mail_id, :phone_number, :gender, :hash_password, :date_of_birth, :address, :city, :state, :zipcode)";
            $statement = $this->pdo -> prepare($insert_query);
            $statement->execute([
                ':client_name' => $name,
                ':mail_id' => $mail,
                ':phone_number' => $phone,
                ':gender' => $gender,
                ':hash_password' => $hash_password,
                ':date_of_birth' => $DOB,
                ':address' => $address,
                ':city' => $city,
                ':state' => $state,
                ':zipcode' => $zipcode
            ]);

            return true;
           }
            catch(PDOException $e){
                $this->pdo_error;
                $e->getMessage();
                return false;
            }

    }

// Check mail ID availablity
    function checkMail(string $mail):bool{
        try{
            $check_query = "SELECT * FROM client_info WHERE mail_id = :mail LIMIT 1";
            $statement = $this->pdo->prepare($check_query);
            $statement->execute([
                ':mail' => $mail
            ]);

            if($statement->rowCount() > 0){
                return true;
            }

            return false;
        }catch(PDOException $e){
            $this->pdo_error;
            $e->getMessage();
            return false;
        }
    }

// Check mobile Number availability
    function checkPhone(string $phone):bool{
        try{
            $check_query = "SELECT * FROM client_info WHERE phone_number = :phone LIMIT 1";
            $statement = $this->pdo -> prepare($check_query);
            $statement -> execute([
                ':phone' => $phone
            ]);

            if($statement -> rowCount() > 0){
                return true;
            }
        }catch(PDOException $e){
            $this->pdo_error;
            $e->getMessage();
            return false;
        }


        return false;
    }

// This method fetch all detail in DB for mentioned user and return an array of user details
    private function fetchAllData(string $id){
        try{
            $check_query = "SELECT client_id, created_at, client_name, mail_id, phone_number, gender, date_of_birth, client_address, city, state, zip_code FROM client_info WHERE client_id = :id LIMIT 1";

            $statement = $this->pdo -> prepare($check_query);
            $statement -> execute([
                ':id' => $id
            ]);
            return $statement -> fetch();

        }catch(PDOException $e){
            $this->pdo_error;
            $e->getMessage();
            return null;
        }
    }

// fetchAllData() method runs inside fetchAllDetails() method
    public function fetchAllDetails(string $id){
        return $this->fetchAllData($id);
    }

    private function fetchSessionData(string $credential){
        try{
            if(preg_match("/^[6-9]\d{9}$/", $credential)){
                $check_query = "SELECT client_id, client_name FROM client_info WHERE phone_number = :input LIMIT 1";
            }else{  
                $check_query = "SELECT client_id, client_name FROM client_info WHERE mail_id = :input LIMIT 1";
            }
            $statement = $this->pdo -> prepare($check_query);
            $statement -> execute([
                ':input' => $credential
            ]);

            return $statement -> fetch();

        }catch(PDOException $e){
            $this->pdo_error;
            $e->getMessage();
            return null;
        }
    }

// fetchSessionData() method runs inside the fetchSessionDetails() method
    public function fetchSessionDetails(string $credential){
        return $this->fetchsessionData($credential);
    }

// This function only works on Currect Phone number or mail ID is passed through the function parameter otherwise null value returned
    private function fetchPassword(string $credential){
        try{
            if(preg_match("/^[6-9]\d{9}$/", $credential)){
                $check_query = "SELECT hash_password FROM client_info WHERE phone_number = :input LIMIT 1";
            }else{  
                $check_query = "SELECT hash_password FROM client_info WHERE mail_id = :input LIMIT 1";
            }
            $statement = $this->pdo -> prepare($check_query);
            $statement -> execute([
                ':input' => $credential
            ]);

            return $statement->fetch();

        }catch(PDOException $e){
            $this->pdo_error;
            $e->getMessage();
            return null;
        }
    }

// For debug purpose only (console messege)
    function runMsg(string $msg){
        $msg = $msg;
        echo '<script> console.log("'.$msg.'");</script>';
    }

// password verifier for phone input
    function verifyPasswordPhone(string $phone, string $password){
        if($this->checkPhone($phone)){

            $user_data = $this->fetchPassword($phone);
            if($user_data == null){
                return false;
            }else{
                return password_verify($password, $user_data['hash_password']);
            }
        }

        return false;
    }

// password verifier for Mail ID input
    function verifyPasswordMail(string $mail, string $password){
        if($this->checkMail($mail)){
            $user_data = $this->fetchPassword($mail);
            if($user_data == null){
                return false;
            }else{
                return password_verify($password, $user_data['hash_password']);
            }
        }

        return false;
    }
}
?>