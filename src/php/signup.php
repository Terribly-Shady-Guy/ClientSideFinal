<?php

require_once "config.php";
require_once "utils.php";

if (isset($_POST['username']) 
&& isset($_POST['password']) 
&& isset($_POST['firstName']) 
&& isset($_POST['lastName']) 
&& isset($_POST['email']))
{
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error)
    {
        $response['status'] = "db error";
        $response['message'] = "Failed to connect to database";
    }
    else
    {
        $id = null;
        $username = sanitizeInput($_POST['username'], $connection);
        $password = sanitizeInput($_POST['password'], $connection);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $firstName = sanitizeInput($_POST['firstName'], $connection);
        $lastName = sanitizeInput($_POST['lastName'], $connection);
        $email = sanitizeInput($_POST['email'], $connection);

        $stmt = $connection->prepare("INSERT INTO users VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("isssss", $id, $firstName, $lastName, $email, $username, $password);

        if ($stmt->execute())
        {
            $response['status'] = "success";
        }
        else
        {
            $response['status'] = "db error";
            $response['message'] = $stmt->error;
        }

        $stmt->close();
    }

    $connection->close();
}
else
{
    $response['status'] = "error";
    $response['message'] = "Missing data";
}

echo json_encode($response);

?>