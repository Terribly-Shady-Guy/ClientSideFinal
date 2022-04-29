<?php

require_once "config.php";
require_once "utils.php";

if (isset($_POST['username']) && isset($_POST['password']))
{
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error)
    {
        $response['status'] = "db error";
        $response['message'] = "failed to connect to database";
    }
    else
    {
        $username = sanitizeInput($_POST['username'], $connection);
        $password = sanitizeInput($_POST['password'], $connection);

        $stmt = $connection->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute())
        {
            $users = $stmt->get_result();
            $rows = $users->num_rows;

            if ($rows > 0)
            {
                foreach ($users as $user)
                {
                    if (password_verify($password, $user['Password']))
                    {
                        session_start();

                        $response['status'] = "success";
                        $response['username'] = $username;
                        $response['auth'] = true;
                        $response['session'] = session_id();
                        
                        $_SESSION['username'] = $username;
                        $_SESSION['auth'] = true;
                        $_SESSION['userID'] = $user['UserID'];
                    }
                    else
                    {
                        $response['status'] = "error";
                        $response['message'] = "Incorrect password";
                    }
                }
            }
            else
            {
                $response['status'] = "error";
                $response['message'] = "No users found";
            }

            $users->close();
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
    $response['message'] = "Missing username and/or password";
}

echo json_encode($response);

?>