<?php

$data = json_encode(file_get_contents('php://input'), JSON_PRETTY_PRINT);
file_put_contents("csp.log", "$data\n", FILE_APPEND);

