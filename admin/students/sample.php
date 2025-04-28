<?php
require_once('db_connect.php'); // make sure you have a DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode (
        "ECHO ECHo"
    )
}