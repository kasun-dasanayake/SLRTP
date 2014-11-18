<?php

function reset_token() {
    return md5(uniqid(rand()));
}

function set_user_reset_token($username, $token_value) {
    $user = find_user_for_token($username);
    if($user) {
        update_user_token($username, $token_value);
        return true;
    } else {
        return false;
    }
}

function create_reset_token($username) {
    $token = reset_token();
    return set_user_reset_token($username, $token);
}

function delete_reset_token($username) {
    $token = null;
    return set_user_reset_token($username, $token);
}

function find_user_with_token($token) {
    if(!has_presence($token)) {
        return null;
    } else {
        $user = find_user_by_token($token);
        return $user;
    }
}

function email_reset_token($username) {
    $user = find_user_for_token($username);
    if($user) {
//        $token = $user['token'];
//        $to = $user['email'];
//        $subject = "Reset Password Request";
//        $url = "reset_password.php?token=" . u($token);
//
//        $message = "
//        <p>This page is a simulation of what a password reset token email might look like.</p>
//            <hr />
//            <p>
//                FROM: emailer@sample_app<br />
//                TO: {$username}@somewhere.com<br />
//                SUBJECT: Reset Password Request
//            </p>
//            <p>You can use the link below to reset your password.</p>
//            <p><a href=\"{$url}\">{$url}</a></p>
//            <p>If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.</p>
//            <hr />
//        ";
//
//        // Always set content-type when sending HTML email
//        $headers = "MIME-Version: 1.0" . "\r\n";
//        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//
//        // More headers
//        $headers .= 'From: <webmaster@example.com>' . "\r\n";
//        $headers .= 'Cc: myboss@example.com' . "\r\n";
//
//        mail($to,$subject,$message,$headers);
//        echo "yes";
        return true;
    } else {
        return false;
    }
}

?>
