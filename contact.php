<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST['website'])) {
        exit("Invalid submission.");
    }

    function clean($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $field_name    = clean($_POST['name'] ?? '');
    $field_email   = clean($_POST['email'] ?? '');
    $field_phone   = clean($_POST['phone'] ?? '');
    $field_company = clean($_POST['company'] ?? '');
    $field_message = clean($_POST['message'] ?? '');

    if (!$field_name || !$field_email || !$field_message || !$field_company) {
        exit("Required fields are missing.");
    }

    if (!filter_var($field_email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email format.");
    }

    if (preg_match("/[\r\n]/", $field_email)) {
        exit("Invalid email.");
    }

    if (preg_match('/https?:\/\//i', $field_message) || preg_match('/https?:\/\//i', $field_company)) {
        exit("Invalid submission.");
    }

    $blocked_names = [
        'johndut','robertdut','miadut','teddut','oscardut','freyadut',
        'oliviadut','georgedut','isladut','charliemic','simondut',
        'charliedut','leedut'
    ];
    if (in_array(strtolower($field_name), $blocked_names)) {
        exit("Invalid submission.");
    }

    $blocked_emails = [
        'ericjonesmyemail@gmail.com','xiceruxuk02@gmail.com',
        'aferinohis056@gmail.com','zekisuquc419@gmail.com',
        'yawiviseya67@gmail.com','dinanikolskaya99@gmail.com',
        'irinademenkova86@gmail.com'
    ];
    if (in_array(strtolower($field_email), $blocked_emails)) {
        exit("Invalid submission.");
    }

    $blocked_companies = ['spamcompany','fakecompany','test'];
    if (in_array(strtolower($field_company), $blocked_companies)) {
        exit("Invalid submission.");
    }

    $body_message  = "Name: $field_name\n";
    $body_message .= "Email: $field_email\n";
    $body_message .= "Phone: $field_phone\n";
    $body_message .= "Company: $field_company\n";
    $body_message .= "Message:\n$field_message\n";

    $mail_to = "web@32bytes.com, iraif@lilis.in";
    $subject = "Enquiry from Lilkis";

    $headers  = "From: Lilkis <iraif@lilis.in>\r\n";
    $headers .= "Reply-To: $field_email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($mail_to, $subject, $body_message, $headers)) {
        header("Location: /thank-you");
        exit;
    } else {
        exit("Error sending email.");
    }
}
?>