<?php

    session_start();
     
    require 'db/meta_names.php';
    require 'templates/header-login.php';

    $data_user=$_SESSION['data_user'];
    $name=$data_user['name_registro'].''.$data_user['last_name_registro'];
    $email=$data_user['email_registro'];
    $pais=$data_user['country'];
    $user_id=$data_user['user_id'];
    $data_profilepic=$data_user['data_profilepic'];
    $format_profilepic=$data_user['format_profilepic'];

    require 'pages/home.inc.php';
    require 'templates/footer-login.php';