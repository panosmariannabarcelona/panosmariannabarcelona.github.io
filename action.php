<?php

session_start();

//for use with javascript unescape function
function encode($input) {
	$temp = ''; 
	$length = strlen($input); 
	for($i = 0; $i < $length; $i++) {
		$temp .= '%' . bin2hex($input[$i]);
	} 
	return $temp; 
}


//if posting only
if(isset($_POST['submit'])) {
	$return = array('type' => 'error', 'session' => $_SESSION);
	// $answer = isset($_POST['autovalue']) ? trim($_POST['autovalue']) : false;
	
	// if(!isset($_SESSION['_form_validate']) || !$answer || $_SESSION['_form_validate'] != $answer) {
	// if(!isset($_SESSION['_form_validate'])) {
	// 	$return['message'] = 'Παρακαλούμε απαντήστε σωστά στην ερώτηση ασφαλείας στο τέλος της φόρμας.';
	// } else {
		$to = 'panosmariannabarcelona@gmail.com'; // Change this line to your email.
		
		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
		$persons = isset($_POST['persons']) ? trim($_POST['persons']) : '';
		$message = isset($_POST['message']) ? trim($_POST['message']) : '';
		$prewedding = isset($_POST['prewedding']) ? trim($_POST['prewedding']) : '';
		$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
		$guestnames = isset($_POST['guestnames']) ? trim($_POST['guestnames']) : '';
		$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Νέα Εγγραφή για Γάμο σας';
		
		if($name && $email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "From: {$name} <{$email}>\r\n";
			
			$message .= 'Νέα Εγγραφή για το Γάμο σας<br />';
			$message .= ' <br /> Όνομα: ' . $name;
			$message .= ' <br /> Email: ' . $email;
			if($persons) {
				$message .= ' <br /> Αριθμός ατόμων: ' . $persons;
			}
			if($guestnames) {
				$message .= '<br /> Ονόματα Καλεσμένων: ' . $guestnames;
			}
			$message .= ' <br /> Prewedding: ' . $prewedding . '';
			if($comment) {
			$message .= ' <br /> Ονόματα Καλεσμένων - Σχόλια: ' . $comment;
			}
			
			@$send = mail($to, $subject, $message, $headers);
			
			if($send) {
				$return['type'] = 'success';
				$return['message'] = 'Η συμμετοχή σας εστάλη επιτυχώς.';
			} else {
				$return['message'] = 'Σφάλμα αποστολής συμμετοχής.';
			}
		} else {
			$return['message'] = 'Σφάλμα επικύρωσης συμμετοχής.';
		}
	// }
	
	die(json_encode($return));
}



// if(isset($_POST['get_auto_value'])) {
// 	$num1 = rand(1, 10);
// 	$num2 = rand(1, 10);
	
// 	$_SESSION['_form_validate'] = $num1 + $num2;
	
// 	$return = array(
// 		'data' => encode("Poso kanei {$num1} + {$num2}?"),
// 		'session' => $_SESSION
// 	);
	
// 	die(json_encode($return));
// }

?>