<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require("phpmailer/PHPMailer.php");
    require("phpmailer/Exception.php");
    require("phpmailer/SMTP.php");

    class MailItem {
        private $_address;
        private $_display;

        function __construct($address, $display) {
            $this->_address = $address;
            $this->_display = $display;
        }

        function getAddress() {
            return $this->_address;
        }

        function getDisplay() {
            return $this->_display == "" ? $this->_address : $this->_display;
        }
    }

    class SMTPMailerPluggable {
        private $_host;
        private $_auth;
        private $_user;
        private $_pass;
        private $_secure;
        private $_port;

        function __construct($host, $auth, $user, $pass, $secure, $port) {
            $this->_host = $host;
            $this->_auth = $auth;
            $this->_user = $user;
            $this->_pass = $pass;
            $this->_secure = $secure;
            $this->_port = $port;
        }

        function send($from,$to,$cc,$bcc,$atts,$subject,$body,$altbody,$html=true) {
            try{
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = $this->_host;
                $mail->SMTPAuth = $this->_auth;
                if($this->_auth){
                    $mail->Username = $this->_user;
                    $mail->Password = $this->_pass;
                    if($this->_secure != "")
                        $mail->SMTPSecure = $this->_secure;
                }
                $mail->Port = $this->_port;

                $mail->setFrom($from->getAddress(), $from->getDisplay());

                if(!is_array($to))
                    $to = array($to);
                foreach($to as $addr) {
                    $mail->addAddress($addr->getAddress(),$addr->getDisplay());
                }

                if($cc != null){
                    if(!is_array($cc))
                        $cc = array($cc);
                    foreach($cc as $addr) {
                        $mail->addCC($addr->getAddress(),$addr->getDisplay());
                    }
                }

                if($bcc != null){
                    if(!is_array($bcc))
                        $bcc = array($bcc);
                    foreach($bcc as $addr) {
                        $mail->addBCC($addr->getAddress(),$addr->getDisplay());
                    }
                }

                if($atts != null){
                    if(!is_array($atts))
                        $atts = array($atts);
                    foreach($atts as $att) {
                        $mail->addAttachment($att->getAddress(),$att->getDisplay());
                    }
                }

                $mail->isHTML($html);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->AltBody = $altbody;

                $mail->send();
            } catch (Exception $e) {
                return $mail->ErrorInfo;
            }
            return true;
        }
    }

    global $_mail;
    $_mail = new SMTPMailerPluggable(
        $smtpHost,
        $smtpAuth,
        $smtpUser,
        $smtpPassword,
        $smtpSecure,
        $smtpPort
    );
?>