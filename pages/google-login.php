<?php
require_once __DIR__ ."/google-config.php";
header("Location: " . $client->createAuthUrl());
exit;

?>