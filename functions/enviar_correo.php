<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    
function nuevo_registro($data_email){

    

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    $user_id=base64_encode($data_email['id_register_comite']);
    $url_confirmacion='https://localhost/comite_competidores/confirm_user?action=confirm_email&user_id='.$user_id;
    $name_register_comite=$data_email['name_register_comite'];

    try{
        // //    Envio de correo
        $mail = new PHPMailer(true);
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
            
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = 'info@eurosonlatino.com.mx';     
        $mail->Password   = 'pyramid2021*';                      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        $mail->SMTPDebug = 4;
        $mail->setFrom('info@eurosonlatino.com.mx', 'Euroson Latino');
        $body = file_get_contents('../correos/confirmacion_email.html');
        
        
        $body = str_replace('$name_register_comite', $name_register_comite, $body);
        $body = str_replace('$url_confirmacion', $url_confirmacion, $body);

        $body = preg_replace('/\\\\/','', $body);

        $mail->MsgHTML($body);

        $mail->Subject = 'Confirma tu correo electrónico - Comité de Competidores #EurosonLatino';

        $mail->AddAddress('bryan.martinez.romero@gmail.com', 'Bryan Martinez');
        $mail->addBCC('bryan.martinez.romero@gmail.com');
        $mail->isHTML(true);

        $mail->send();
        
        $respuesta = array(
            'respuesta' => 'success'
        );

    }catch (phpmailerException $e) {

        $respuesta = array(
            'respuesta' => 'error',
            'tipo' => 'email',
            'mensaje' => $e->getMessage()
        );
    }

    // return $respuesta;

}

