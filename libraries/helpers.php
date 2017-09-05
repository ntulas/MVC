<?php
Class Helpers {
  function __construct(){  
    global $siteInfo;
    $this->siteInfo = $siteInfo;
} 

public function sendEmail($args){
   
    $recipient = ($args["recipient"] ? $args["recipient"] : $this->siteInfo["email"]);
    $subject = ($args["subject"] ? $args["subject"] : $this->siteInfo["company_name"]);
    $from = ($args["from"] ? $args["from"] : $this->siteInfo["email_from"]);
    $from_name = ($args["from_name"] ? $args["from_name"] : $this->siteInfo["email_from_name"]);
    $bcc = ($args["bcc"] ? $args["bcc"] : $this->siteInfo["email_bcc"]);
    $cc = ($args["cc"] ? $args["cc"] : $this->siteInfo["email_cc"]);
    $rules = $args["rules"];
    $error_texts = $args["error_texts"];

    require 'libraries/recaptchalib.php'; 

    $secret = $this->siteInfo["secret_key"];
    $response = null;

    $reCaptcha = new ReCaptcha($secret);
    if ($_POST["g-recaptcha-response"]){

        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
            );

        if ($response != null && $response->success){

            require 'libraries/gump.class.php'; 
            $gump = new GUMP();
            $validated = $gump->validate($_POST,$rules);

            if($validated === TRUE){

                require 'libraries/class.phpmailer.php'; 
                $form = $_POST;
                $mail = new PHPMailer;
                $mail->setFrom($from, $from_name);
                $recipient_array = explode(',', $recipient);
                 
                foreach ($recipient_array as $individual_recipient){
                    $mail->addAddress($individual_recipient);
                }

                $mail->addReplyTo($form['email']);

                if($cc !== ''){
                    $cc_array = explode(',', $cc);
                    foreach ($cc_array as $individual_cc){
                        $mail->addCC($individual_cc);
                    }
                }
                if($bcc !== ''){
                    $bcc_array = explode(',', $bcc);
                    foreach ($bcc_array as $individual_bcc){
                        $mail->addBCC($individual_bcc);
                    }
                }

                $mail->isHTML(true);

                if($form['subject']){
                    $mail->Subject = $form['subject'];
                }
                else{
                    $mail->Subject  = $subject;
                }

                $mail->Body     = '<html><head><style>table{border-collapse: collapse;max-width:500px}td{border:none;padding:5px;vertical-align:top}</style></head><body><table>';

                foreach($form as $name => $value){
                    if($name != "g-recaptcha-response"){
                    $real_value = $value;
                    if(is_array($value)){
                        $real_value = "";
                        foreach ($value as $val){
                            $real_value = $real_value.$val."<br>";
                        }
                    }

                    $mail->Body .= '<tr><td style="text-align:right;font-weight:700">'.ucwords(str_replace("_"," ",$name)).':</td><td>'.$real_value.'</td></tr>';
                    }
                }

                $mail->Body .= '</table></body></html>';
                $mail->AltBody = "";

                foreach($form as $name => $value){
                    $mail->AltBody .=ucwords(str_replace("_"," ",$name)).":".$value."\r\n";
                }

                               
                if(!$mail->send()) {
                    echo 'not-sent';
                }
                else{
                    if($form['email']){
                        $mail->clearAllRecipients();
                        $mail->Subject  = "Thank you";
                        $mail->Body = "<p>Thank you for your message. This is to confirm that you have sent the following information below. Please allow us 24 hours to respond.</p>".$mail->Body;
                        $mail->addAddress($form['email']);
                        $mail->send();
                    }

                unset($_POST);
                echo 'sent';

                }
            }
            else{   
                $return_error = array();
                foreach($validated as $key=>$error){
                    $return_error[] = array('name'=>$error['field'],'msg'=>$error_texts["{$error['field']}"]);
                }
                echo json_encode($return_error);
            }

        } else {
            echo "wrong-recaptcha";
        }
    }

    else {
        echo "no-recaptcha";
    }     
}

public function  isActiveMenu($view){   
    $extension = null;

    if (isset($_GET['url'])) {
        $url = trim($_GET['url'], '/');
        $url = explode('/', $url);

        $extension = isset($url[0]) ? $url[0] : null;
        unset($url[0], $url[1]);
    }

    if($extension === $view || ($extension === null && $view === "home")){
        echo " class=\"active-menu\"";
    } 
}

public function seo($view){
    $res = array();
    $file = fopen('csvDB/seo.csv', "r") or die("Cannot open");
    $templateArr =(fgetcsv($file));
    $index=0;

    while(!feof($file)){

        $storageArray = array();
        $elems = fgetcsv($file);
        for ($i = 0; $i <= count($templateArr)-1; $i++){
            $storageArray[$templateArr[$i]] = $elems[$i];
        }
        $res[$index++] = $storageArray;
    }

    fclose($file);
    $has_seo = false;

    foreach($res as $value){   
      if($view == $value["page_name"]) { 
        echo "<title>".$value["title"]."</title>";
        echo '<meta name="keywords" content="'.$value["keywords"].'">';
        echo '<meta name="description" content="'.$value["description"].'">';
        $has_seo = true;
        break;
        }
    }

    if($has_seo == false){
        echo "<title>".$res[0]["title"]."</title>";
        echo '<meta name="keywords" content="'.$res[0]["keywords"].'">';
        echo '<meta name="description" content="'.$res[0]["description"].'">';
    }
}

public function analytics(){
    if($this->siteInfo['ga_tracking_id'] != ''){
            echo "<script>
                  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                  ga('create', '".$this->siteInfo['ga_tracking_id']."', 'auto');
                  ga('send', 'pageview');
                </script>";
    }
}

public function bodyClasses($view){
    if($view != "home"){
        echo 'class="inner '.$view.'-page"';
    }
    else{
        echo 'class="home"';
    }
}

public function htmlClasses(){
		$htmlClass = 'class="';
		if($this->siteInfo["suspended"]){
			$htmlClass .= ' suspended';
			echo $htmlClass.'"';
		}
	}
public function suspensionRedirect($view){
	  if($this->siteInfo["suspended"] && $view != "home"){
			header("Location:".URL);
	  }	
	}
}