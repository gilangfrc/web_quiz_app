<?php

// error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

if (!session_id()) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'].'/app/init.php';
$app = new App();