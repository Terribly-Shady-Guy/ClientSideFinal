<?php

require_once "config.php";

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
        $id = $_SESSION['userID'];
        $query = "SELECT * FROM users WHERE UserID=$id";
        $result = $connection->query($query);

        if ($result)
        {
            $user = $result->fetch_array(MYSQLI_ASSOC);
            $response['status'] = "success";
            $response['username'] = $user['Username'];
            $response['firstName'] = $user['FirstName'];
            $response['lastName'] = $user['LastName'];
            $response['email'] = $user['Email'];
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = "Could not find user";
        }

        $result->close();
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