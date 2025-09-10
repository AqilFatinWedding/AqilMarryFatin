<?php 

	$to = ""; 
	$from  = $_POST['email']; 
	$sender_name = $_POST['name'];
	$number_of_gustes = $_POST['guest'];
	$events = $_POST['events'];
	$notes = $_POST['notes'];


	$subject = "Form submission";
	$message = $sender_name . " is attending! The number of gustes of his / her is : " .  $number_of_gustes . " and his / her selected event is " . $events . ". He / she worte the following... ". "\n\n" . $notes;

	$headers = 'From: ' . $from;
	mail($to, $subject, $message, $headers);

?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name   = $_POST['name'] ?? '';
    $phone  = $_POST['phone'] ?? '';
    $guest  = $_POST['guest'] ?? '';
    $events = $_POST['events'] ?? '';
    $notes  = $_POST['notes'] ?? '';

    // Google Form endpoint (replace with your formResponse URL)
    $url = "https://docs.google.com/forms/d/e/1FAIpQLSeTxpyAndVV7xz3ma65FfeoxkFGI4MPuQ585_Uq787iqISQDg/formResponse";

    // Map PHP variables to Google Form entry IDs
    $postData = [
        "entry.1960125086" => $name,
        "entry.573919562"  => $phone,
        "entry.1545658107" => $guest,
        "entry.572109798"  => $events,
        "entry.628339473"  => $notes
    ];

    // Initialize cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(["status" => "error", "message" => curl_error($ch)]);
    } else {
        echo json_encode(["status" => "success", "message" => "RSVP submitted successfully"]);
    }

    curl_close($ch);
}
?>
