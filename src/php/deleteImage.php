<?php

require_once "config.php";
require_once "utils.php";

session_id($_POST['session']);
session_start();

if ($_SESSION['auth'] && isset($_POST['portID']))
{
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error)
    {
        $response['status'] = "db error";
        $response['message'] = "Failed to connect to database";
    }
    else
    {
        $portID = $_POST['portID'];
        
        if (validateUser($_SESSION['userID'], $portID, $connection))
        {
            $stmt = $connection->prepare('DELETE FROM portfolio WHERE PortID=?');
            $stmt->bind_param("i", $portID);

            if ($stmt->execute())
            {
                $response['status'] = "success";
                $response['message'] = "Image was deleted";
            }
            else
            {
                $response['status'] = "error";
                $response['message'] = "Could not elete this image";
            }

            $stmt->close();
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = "You do not have access to delete this image.";
        }
    }

    $connection->close();
}
else
{
    $response['status'] = "error";
    $response['message'] = "Not authorized. Please log in and try again";
}

echo json_encode($response);

?>