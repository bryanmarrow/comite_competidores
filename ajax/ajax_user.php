<?php

    require '../db/dbconfig.php';
    require '../functions/enviar_correo.php';

    $action=isset($_POST['action']) ? $_POST['action'] : '';


    switch ($action) {
        case 'register':

            
            $file=$_FILES['profilepic_user'];                        
            $data = file_get_contents($file['tmp_name']);
            $base64_profilepic = base64_encode($data);

            $email_register_comite=$_POST['email_register_comite'];
            $password_register_comite=$_POST['password_register_comite'];
            $name_register_comite=$_POST['name_register_comite'];
            $last_name_register_comite=$_POST['last_name_register_comite'];
            $dob_register_comite=$_POST['dob_register_comite'];            
            $phonenumber_register_comite=$_POST['phonenumber_register_comite'];
            $city_register_comite=$_POST['city_register_comite'];
            $country_register_comite=$_POST['country_register_comite'];
            $academia_register_comite=$_POST['academia_register_comite'];
            $id_register_comite=generateRandomString(10);

            $data_registro=[
                'email_register_comite' => $email_register_comite,
                'password_register_comite' => md5($password_register_comite),
                'name_register_comite' => $name_register_comite,
                'last_name_register_comite' => $last_name_register_comite,                
                'dob_register_comite' => $dob_register_comite,          
                'phonenumber_register_comite' => $phonenumber_register_comite,      
                'city_register_comite' => $city_register_comite,
                'country_register_comite' => $country_register_comite,
                'academia_register_comite' => $academia_register_comite,
                'id_register_comite' => $id_register_comite,
                'fecha_registro' => $fecha_registro
            ];

            $data_profilepic=[
                'data_profilepic' => $base64_profilepic,
                'format_profilepic' => $file['type'],
                'nombre_profilepic' => $file['name'],
                'id_registro' => $id_register_comite
            ];


            try{

                $query_registro="INSERT INTO `tbl_comite_competidores`(`user_id`,`name_registro`, `last_name_registro`, `email_registro`, 
                `password_registro`, `dob_registro`, `city_registro`, `country_registro`, `name_academia`, `fecha_registro`, `phonenumber_registro`) 
                VALUES (:id_register_comite, :name_register_comite, :last_name_register_comite, :email_register_comite, :password_register_comite, :dob_register_comite,                 
                :city_register_comite, :country_register_comite, :academia_register_comite, :fecha_registro, :phonenumber_register_comite)";
                $query_registro_exe=$basededatos->connect()->prepare($query_registro);
                $query_registro_exe->execute($data_registro);

                $query_profilepic="INSERT INTO `tbl_profilepics_comite`(`user_id`, `data_profilepic`, `format_profilepic`, `nombre_profilepic`) 
                VALUES (:id_registro, :data_profilepic, :format_profilepic, :nombre_profilepic)";
                $query_profilepic_exe=$basededatos->connect()->prepare($query_profilepic);
                $query_profilepic_exe->execute($data_profilepic);
                
                $response=[
                    'respuesta' => 'success'
                ];


            }catch(PDOException $e){
                $response=[
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }

            if($response['respuesta']=='success'){
                
                $nuevo_registro=nuevo_registro($data_registro);

                
                header('Content-Type: application/json');
                echo json_encode($nuevo_registro);
            }
            
            

        break;   
        case 'login':
            $email_login=isset($_POST['email_login']) ? $_POST['email_login'] : '';
            $pass_login=isset($_POST['pass_login']) ? $_POST['pass_login'] : '';

            $data_login=[
                'email_registro' => $email_login,
                'pass_login' => md5($pass_login),                
            ];


            $query="SELECT 
                a.name_registro, 
                a.last_name_registro,  
                a.email_registro, 
                b.pais country,
                a.user_id,
                c.data_profilepic,
                c.format_profilepic,
                a.status_registro
            FROM `tbl_comite_competidores` a
            INNER JOIN tbl_paises b ON a.country_registro = b.id
            INNER JOIN tbl_profilepics_comite c ON a.user_id = c.user_id
            where 
                a.email_registro=:email_registro and 
                a.password_registro=:pass_login ";
            $result_login=$basededatos->connect()->prepare($query);
            $result_login->execute($data_login);
            $fetch_login=$result_login->fetch(PDO::FETCH_ASSOC);

            if($result_login->rowCount()!==0){

                if($fetch_login['status_registro']==2){
                    session_start();
                    $_SESSION['data_user']=$fetch_login;

                    $response=[
                        'respuesta' => 'login',
                        'status_registro' => $fetch_login['status_registro']
                    ];

                }else{
                    $response=[
                        'respuesta' => 'login',
                        'status_registro' => $fetch_login['status_registro']
                    ];
                }

                
            }else{
                $response=[
                    'respuesta' => 'no_login'                    
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);

        break;
        case 'check_email':
            $email_register=isset($_POST['email_register']) ? $_POST['email_register'] : '';
            $query_checkemail="SELECT * FROM tbl_comite_competidores where email_registro='".$email_register."'";
            $check_email=$basededatos->connect()->prepare($query_checkemail);
            $check_email->execute();

            $respuesta=[
                'resultados'=>$check_email->rowCount()
            ];
            header('Content-Type: application/json');
            echo json_encode($respuesta);
        break;
        case 'recovery':
            $email_register=isset($_POST['email_recovery']) ? $_POST['email_recovery'] : '';
            $query_checkemail="SELECT * FROM tbl_comite_competidores where email_registro='".$email_register."'";
            $check_email=$basededatos->connect()->prepare($query_checkemail);
            $check_email->execute();
            $fetch_email=$check_email->fetch();

            if($check_email->rowCount()>0){
                // Enviar correo de recuperacion
                $correo_recuperacion=notificacion_email_recovery_password_user($fetch_email);

                if($correo_recuperacion['respuesta']=='success'){
                    $response=[
                        'respuesta' => 'success'
                    ];
                }
            }

            
            header('Content-Type: application/json');
            echo json_encode($response);
        break;
        case 'new-password':           
            $new_password=isset($_POST['new_password_comitee']) ? $_POST['new_password_comitee'] : '';
            $user_id=isset($_POST['user_recovery']) ? $_POST['user_recovery'] : '';
            
            try{
                $query_updatepassword="UPDATE `tbl_comite_competidores` SET 
                password_registro='".md5($new_password)."'
                WHERE id_registro='".$user_id."'";
                $update_password=$basededatos->connect()->prepare($query_updatepassword);
                $update_password->execute();

                $response=[
                    'respuesta' => 'success'
                ];
            }catch(PDOException $e){
                $response=[
                    'respuesta' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }    
            header('Content-Type: application/json');
            echo json_encode($response);
        break;
        case 'logout':
            session_start();
            session_destroy();
            $response=[
                'respuesta' => 'success'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        break;
    }
