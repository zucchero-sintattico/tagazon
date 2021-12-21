<?php
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__.'/mailer/PHPMailer.php';
require __DIR__.'/mailer/SMTP.php';


function sendMail($to, $subject, $message)
{
	$email = "tagazon@programmer.net";

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = 'smtp.mail.com';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = $email;
	$mail->Password = 'DejK5FT6BFsO';
	$mail->SMTPSecure = 'tls';
	$mail->From = $email;
	$mail->FromName = 'Tagazon';
	$mail->AddAddress($to);
	$mail->AddReplyTo($email);
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->AltBody = $message;
	return $mail->Send();
}

function parse_raw_http_request(array &$a_data)
{
	// read incoming data
	$input = file_get_contents('php://input');

	// grab multipart boundary from content type header
	preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
	if (count($matches) == 0){
		parse_str(file_get_contents('php://input'), $a_data);
		foreach($a_data as $key => $value) {
			if (in_array($value, ['true', 'false'])) {
				$a_data[$key] = $value == "true";
			}
		}
		return;
	}
	$boundary = $matches[1];

	// split content by boundary and get rid of last -- element
	$a_blocks = preg_split("/-+$boundary/", $input);
	array_pop($a_blocks);

	// loop data blocks
	foreach ($a_blocks as $id => $block) {
		if (empty($block))
			continue;

		// you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

		// parse uploaded files
		if (strpos($block, 'application/octet-stream') !== FALSE) {
			// match "name", then everything after "stream" (optional) except for prepending newlines 
			preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
		}
		// parse all other fields
		else {
			// match "name" and optional value in between newline sequences
			preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
		}
		$a_data[$matches[1]] = $matches[2];
	}
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>