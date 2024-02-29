<?php


    require 'db/dbconfig.php';
    // require 'functions/enviar_correo.php';

    $user_id=$_GET['user_id'];
    $action=$_GET['action'];

    switch ($action) {
        case 'confirm_email':
            $encode_user_id=base64_decode($user_id);
            try {
                $query_confirm_register="SELECT * FROM tbl_comite_competidores where user_id='".$encode_user_id."'";
                $query_confirm_register_exe=$basededatos->connect()->prepare($query_confirm_register);
                $query_confirm_register_exe->execute();

            } catch (PDOException $e) {
                

            }
            $fetch_user=$query_confirm_register_exe->fetch(PDO::FETCH_ASSOC);
            $pagina_confirmacion=$fetch_user['status_registro']==0 ? 'registro_exitoso.inc.php' : 'registro_completado.inc.php';

            if($fetch_user['status_registro']==0){

                $confirm_register="UPDATE `tbl_comite_competidores` 
                SET `status_registro`=1 
                WHERE `user_id`='".$encode_user_id."'";
                $confirm_register_exe=$basededatos->connect()->prepare($confirm_register);
                $confirm_register_exe->execute();   
                
                $pagina_confirmacion='registro_exitoso.inc.php'; 

            }else{                
                // var_dump($fetch_user);
                if($fetch_user['status_registro']==1){
                    $pagina_confirmacion='registro_completado.inc.php';
                }
                if($fetch_user['status_registro']==2){
                    $pagina_confirmacion='registro_aprobado.inc.php';
                }
            }
            break;        
    }

    require 'db/meta_names.php';
    require 'templates/header.php';
    require 'pages/'.$pagina_confirmacion;
    require 'templates/footer.php';