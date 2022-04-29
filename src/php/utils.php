<?php

function sanitizeInput($input, $connection)
{
    $input = strip_tags($input);
    $input = htmlentities($input);
    return $connection->real_escape_string($input);
}

?>