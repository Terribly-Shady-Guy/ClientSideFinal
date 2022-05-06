<?php

function sanitizeInput($input, $connection)
{
    $input = strip_tags($input);
    $input = htmlentities($input);
    return $connection->real_escape_string($input);
}

function validateUser($userID, $portID, $connection)
{
    $stmt = $connection->prepare("SELECT UserID FROM portfolio WHERE PortID=?");
    $stmt->bind_param("i", $portID);
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();

        $port = $result->fetch_array(MYSQLI_ASSOC);
        $result->close();
        $stmt->close();

        if ($userID == $port['UserID'])
        {
            return true;
        }
    }

    return false;
}

?>