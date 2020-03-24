<?php

    require_once(__DIR__."/token.php");

    class Database
    {
        private $host = "localhost";
        private $database = "coronavirus";
        private $user = "root";
        private $password = "";
        private $conn;

        function __construct()
        {
            try 
            {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->user ,  $this->password);
            }
            catch(PDOException $ex)
            {
               echo "{ \"Message\" : \"No connection\" }";
            }
        }


        public function citys()
        {
            $sql = "SELECT * FROM cities";
            $stmt = $this->conn->query($sql);
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC) , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        public function city($city)
        {
            $sql = "select cities.id , cities.name , statistics.infected , statistics.deaths , statistics.recovered   from cities join statistics on cities.id = statistics.city_id  where cities.id = :city";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":city" , $city);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result[0] , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        public function states()
        {
            $sql = "SELECT * FROM states";
            $stmt = $this->conn->query($sql);
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC) , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        public function state($state)
        {
            $sql = "select cities.id , cities.name from cities join states on states.id = cities.state_id where states.id = :state";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":state" , $state);
            $stmt->execute();

            $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = "select states.quarantine  , states.name , states.overwatch from states where states.id = :state";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":state" , $state);
            $stmt->execute();

            $row = $stmt->fetch();

            $result = array('state' => $row[1] , 'quarantine' => $row[0] , 'overwatch' => $row[2] , 'cities' => $cities);

            return json_encode($result , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        
        public function stats()
        {
            $sql = "select cities.id , cities.name , statistics.infected , statistics.deaths , statistics.recovered from statistics join cities on cities.id = statistics.city_id";
            $stmt = $this->conn->query($sql);
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC) , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    
        public function poland()
        {
            $sql = "select SUM(statistics.infected ) as 'infected', SUM(statistics.deaths) as 'deaths' , SUM(statistics.recovered) as 'recovered' from statistics";
            $stmt = $this->conn->query($sql);
            $set1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = "select SUM(states.quarantine ) as 'quarantine', SUM(states.overwatch) as 'overwatch' from states";
            $stmt = $this->conn->query($sql);
            $set2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result = array_merge($set1[0] , $set2[0]);
            return json_encode( $result , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        public function register($user)
        {
            $sql = "INSERT INTO users (login , password , token) VALUES (:login , :password , :token)";
            $stmt = $this->conn->prepare($sql);
            if(property_exists($user , 'login') && property_exists($user , 'password'))
            {
                $pwd = md5($user->password);
                $token = new Token($user->login , $pwd ,  0);
                $stoken = $token->GetToken();
                $stmt->bindParam(":login" , $user->login);
                $stmt->bindParam(":password" , $pwd);
                $stmt->bindParam(":token" , $stoken);
                $stmt->execute();
                return json_encode(array("Message"=>"1" , "Token"=>$stoken));
            }
            return json_encode(array("Message"=>"0") , JSON_PRETTY_PRINT);
        }

        public function tokenExists($token)
        {
            $sql = "SELECT COUNT(*) as 'count' FROM users where token = :token";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":token" , $token);
            $stmt->execute();

            return $stmt->fetch()["count"] != 0;
        }

        public function loginExists($login)
        {
            $sql = "SELECT COUNT(*) as 'count' FROM users where login = :login";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":login" , $login);
            $stmt->execute();

            return $stmt->fetch()["count"] != 0;
        }

        public function login($user)
        {
            $sql = "SELECT COUNT(*) as 'count', users.token as 'token' FROM users WHERE login = :login and password = :password";
            $stmt = $this->conn->prepare($sql);
            if(property_exists($user , "login") && property_exists($user , "password"))
            {
                $pwd = md5($user->password);
                $stmt->bindParam(":login" , $user->login);
                $stmt->bindParam(":password" , $pwd);
                $stmt->execute();
                $result = $stmt->fetch();

                if($result["count"] == 0)
                {
                    return json_encode(array("Message" => "0") , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }

                return json_encode(array("Message" => "1" , "Token" => $result["token"]) , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            return json_encode(array("Message" => "0") , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        
    }

?>