<?php

function request_is_same_domain() {
    if(!isset($_SERVER['HTTP_REFERER'])) {
        return false;
    } else {
        $referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $server_host = $_SERVER['HTTP_HOST'];

        return ($referer_host == $server_host) ? true : false;
    }
}
?>
