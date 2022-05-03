<?php

require_once "config.php";
require_once "utils.php";

session_id($_POST['session']);
session_start();

if ($_SESSION['auth'])
{
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error)
    {
        $response['status'] = "db error";
        $response['message'] = "Failed to connect to database";
    }
    else
    {
        $portID = sanitizeInput($_POST['portID'], $connection);

        $stmt = $connection->prepare("SELECT Picture, Description, DateTaken FROM portfolio WHERE PortID=?");
        $stmt->bind_param("i", $portID);

        if ($stmt->execute())
        {
            $result = $stmt->get_result();

            $response['status'] = "success";
            $response['picture'] = $result['Picture'];
            $response['description'] = $result['Description'];
            $response['dateTaken'] = $result['DateTaken'];
        }
        else
        {
            $response['status'] = "db error";
            $response['message'] = "Failed to get data";
        }

        $stmt->close();
    }

    $connection->close();
}
else
{
    $response['status'] = "error";
    $response['message'] = "Not authorized. Please log in and try again.";
}

echo json_encode($response);

?>