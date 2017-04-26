<?php
require('config/connection.php');
require('src/User.php');

session_start();
//if (isset($_SESSION['userId'])) {
    //header('Location: main.php');
//}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['usernamesignup']) and isset($_POST['emailsignup']) and isset($_POST['passwordsignup']) and isset($_POST['passwordsignup_confirm'])) {
        if ($_POST['usernamesignup'] == "" or $_POST['emailsignup'] == "" or $_POST['passwordsignup'] == "" or $_POST['passwordsignup_confirm'] == "") {
            header('Location: registererror.php?action=not');
        } else {
            if ($_POST['passwordsignup'] == $_POST['passwordsignup_confirm']) {
                $newUser = new User();
                $newUser->setUsername($_POST['usernamesignup']);
                $newUser->setEmail($_POST['emailsignup']);
                $newUser->setHashedPassword($_POST['passwordsignup']);
                $result = $newUser->saveToDB($conn);
                if ($result == true) {
                    $_SESSION['userId'] = $newUser->getId();
                    header('Location: main.php?action=newUser');
                } else {
                    header('Location: registererror.php?action=email');
                }
            } else {
                header('Location: registererror.php?action=equal');
            }
        }
    } elseif (isset($_POST['email']) and isset($_POST['password'])) {
        if ($_POST['email'] == "" or $_POST['password'] == "") {
            header('Location: registererror.php?action=not');
        } else {
            $user = new User();
            $result = $user->loadUser($conn, $_POST['email'], $_POST['password']);
            var_dump($result);
            if ($result === true) {
                $_SESSION['userId'] = $user->getId();
                header('Location: main.php?action=login');
            } else {
                header('Location: registererror.php?action=login');
            }
        }
    }
}

?>


<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>
<html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>
<html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>
<html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8"/>
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
    <title>Sharenews login</title>
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/style.css">

</head>
<body>
<div class="container">

    <header>
        <h1>Welcome to ShareNews</h1>

    </header>
    <section>
        <div id="container_demo">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form">
                    <form action="" autocomplete="on" method="POST">
                        <h1>Log in</h1>
                        <p>
                            <label for="email" class="uname"> Your email </label>
                            <input id="email" name="email" required="required" type="text"
                                   placeholder="eg. mymail@mail.com"/>
                        </p>
                        <p>
                            <label for="password" class="youpasswd"> Your password </label>
                            <input id="password" name="password" required="required" type="password"
                                   placeholder="eg. X8df!90EO"/>
                        </p>
                        <p class="keeplogin">
                            <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping"/>
                            <label for="loginkeeping">Keep me logged in</label>
                        </p>
                        <p class="login button">
                            <input type="submit" value="Log in"/>
                        </p>
                        <p class="change_link">
                            Not a member yet ?
                            <a href="#toregister" class="to_register">Join us</a>
                        </p>
                    </form>
                </div>

                <div id="register" class="animate form">
                    <form action="" autocomplete="on" method="POST">
                        <h1> Sign up </h1>
                        <p>
                            <label for="usernamesignup" class="uname">Your username</label>
                            <input id="usernamesignup" name="usernamesignup" required="required" type="text"
                                   placeholder="mysuperusername690"/>
                        </p>
                        <p>
                            <label for="emailsignup" class="youmail"> Your email</label>
                            <input id="emailsignup" name="emailsignup" required="required" type="email"
                                   placeholder="mysupermail@mail.com"/>
                        </p>
                        <p>
                            <label for="passwordsignup" class="youpasswd">Your password </label>
                            <input id="passwordsignup" name="passwordsignup" required="required" type="password"
                                   placeholder="eg. X8df!90EO"/>
                        </p>
                        <p>
                            <label for="passwordsignup_confirm" class="youpasswd">Please confirm your password </label>
                            <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required"
                                   type="password" placeholder="eg. X8df!90EO"/>
                        </p>
                        <p class="signin button">
                            <input type="submit" value="Sign up"/>
                        </p>
                        <p class="change_link">
                            Already a member ?
                            <a href="#tologin" class="to_register"> Go and log in </a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>
</body>
</html>