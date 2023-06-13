<?php
$mail->isSMTP();
            $mail->Host = '217.116.0.228';
            $mail->Port = 587;
            $mail->SMTPSecure = 'TLS';
            $mail->SMTPAuth = true;
            $mail->Username = "info@logisticstrack.es";
            $mail->Password = "Elefante1234";
            $mail->setFrom('info@logisticstrack.es', "Probando");
            $mail->Subject = 'hola';

?>