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
                'status_registro' => 2
            ];


            $query="SELECT * FROM `tbl_comite_competidores` 
            where email_registro=:email_registro and password_registro=:pass_login and status_registro=:status_registro";
            $result_login=$basededatos->connect()->prepare($query);
            $result_login->execute($data_login);

            if($result_login->rowCount()>0){
                $response=[
                    'respuesta' => 'login'
                ];
            }else{
                $response=[
                    'respuesta' => 'no_login'
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);

        break;
    }
