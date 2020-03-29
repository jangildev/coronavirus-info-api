<?php

    if(isset($_POST["signin"]))
    {
        login();
    }

    if(isset($_POST["register"]))
    {
        register();
    }

    function login()
    {
        require_once(__DIR__."/database/database.php");

        $db = new Database();

        $login = $_POST["login"];
        $password = $_POST["password"];

        $user = new StdClass;
        $user->login = $login;
        $user->password = $password;

        $response = json_decode($db->login($user));

        if($response->Message == 1)
        {
            $_SESSION["info"] = "<b style='color : #7DB319;'>Your access token :  </b><textarea>".$response->Token."</textarea>";
        }
        else
        {
            $_SESSION["info"] = "<b style='color : #FF4824;'>Wrong login or password!</b>";
        }

    }

    function register()
    {
        require_once(__DIR__."/database/database.php");

        $db = new Database();

        $login = $_POST["login"];
        $password = $_POST["password"];

        if(strlen($login) < 5)
        {
            $_SESSION["info"] = "<b style='color : #FF4824;'>Login must have at least 5 characters!</b>";
        }
        else
        {
            if($db->loginExists($login))
            {
                $_SESSION["info"] = "<b style='color : #FF4824;'>Given login already is taken!</b>";
            }
            else
            {
                if(strlen($password) < 6)
                {
                    $_SESSION["info"] = "<b style='color : #FF4824;'>Password must have at least 6 characters!</b>";
                }
                else{
                    $user = new StdClass;
                    $user->login = $login;
                    $user->password = $password;
            
                    $response = json_decode($db->register($user));

                    if($response->Message == 1)
                    {
                        $_SESSION["info"] = "<b style='color : #7DB319;'>Registered successfully! Your access token :  </b><textarea>".$response->Token."</textarea>";
                    }
                    else
                    {
                        $_SESSION["info"] = "<b style='color : #FF4824;'>Something went wrong!</b>";
                    }
                }
            }
        }

        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coronavirus Info API</title>
    <link rel="stylesheet" type="text/css" href="./styles/token.css"/>
    <link rel='icon' href='../images/virus.ico' type='image/x-icon' />
</head>
<body>
    <div id="container">
        <div id="title">
            <h1>coronavirus-info-api</h1>
        </div>
        <br>
        <form action="token" method="POST">
            <div id="input"><text>Login</text><input type="text" name="login" placeholder="Login"></div>
            <div id="input"><text>Password</text><input type="password" name="password" placeholder="Password"></div></br>
            <div id="submit">
                <input type="submit" name="register" value="Register">
                <input type="submit" name="signin" value="Login">
            </div>
            <div id="info">
                <center>
                <?php
                    if(isset($_SESSION["info"]))
                    {
                        echo $_SESSION["info"];
                    }
                ?>
                </center>
            </div>
        </form>
    </div>
</body>
</html>
