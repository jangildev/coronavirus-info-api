<?php
    //class for genereting base64 token
    class Token
    {
        private $json_token;
        public function __construct($login , $password ,  $post)
        {
            $this->json_token =  json_encode(array("login"=>$login , "password"=> $password , "post"=>$post));
        }

        public function GetToken()
        {
            return base64_encode($this->json_token);
        }
    }

?>