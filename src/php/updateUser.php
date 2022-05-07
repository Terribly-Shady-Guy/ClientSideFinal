<?php

require_once "config.php";
require_once "utils.php";

session_id($_POST['session']);
session_start();

if ($_SESSION['auth']
&& isset($_POST['username'])
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
        $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/";
        $password = sanitizeInput($_POST['password'], $connection);

        if (preg_match($pattern, $password) || $password == "")
        {
            $id = $_SESSION['userID'];

            if ($password == "")
            {
                $query = "SELECT Password FROM users WHERE UserID=$id";
                $result = $connection->query($query);

                $user = $result->fetch_array(MYSQLI_ASSOC);
                $password = $user['Password'];

                $result->close();
            }
            else
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
            
            $username = sanitizeInput($_POST['username'], $connection);
            $firstName = sanitizeInput($_POST['firstName'], $connection);
            $lastName = sanitizeInput($_POST['lastName'], $connection);
            $email = sanitizeInput($_POST['email'], $connection);

            $stmt = $connection->prepare('UPDATE users SET Username=?, Password=?, FirstName=?, LastName=?, Email=? WHERE userID=?');
            $stmt->bind_param("sssssi", $username, $password, $firstName, $lastName, $email, $id);

            if ($stmt->execute())
            {
                $response['status'] = "success";
            }
            else
            {
                $response['status'] = "db error";
                $error = $stmt->error;
                $response['message'] = "Could not update user. Reason: $error";
            }

            $stmt->close();
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = "Password does not meet the requirements";
        }
    }

    $connection->close();
}
else if (!$_SESSION['auth'])
{
    $response['status'] = "error";
    $response['message'] = "Not authorized. Please log in and try again";
}
else
{
    $response['status'] = "error";
    $response['message'] = "Incomplete data. Please ensure that all fields are complete before subitting.";
}

echo json_encode($response);

?>