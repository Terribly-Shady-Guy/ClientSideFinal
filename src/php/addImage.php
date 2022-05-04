<?php

require_once "config.php";
require_once "utils.php";

session_id($_POST['session']);
session_start();

if ($_SESSION['auth']
&& isset($_POST['description']) 
&& isset($_POST['dateTaken']))
{
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error)
    {
        $response['status'] = "db error";
        $response['message'] = "Failed to connect to database";
    }
    else
    {
        switch ($_FILES['picture']['type'])
        {
            case "image/jpeg":
                $ext = "jpg";
                break;
            case "image/png":
                $ext = "png";
                break;
            case "image/tiff":
                $ext = "tiff";
                break;
            default:
                $ext = "";
                break;
        }

        if ($ext)
        {
            $portID = null;
            $userID = $_SESSION['userID'];
            $picture = $_FILES['picture']['name'];
            $description = sanitizeInput($_POST['description'], $connection);
            $dateTaken = sanitizeInput($_POST['dateTaken'], $connection);
            $uploadDate = date("Y-m-d", time());

            $stmt = $connection->prepare("INSERT INTO portfolio  VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("iissss", $portID, $userID, $picture, $dateTaken, $description, $uploadDate);

            if ($stmt->execute())
            {
                $response['status'] = "success";

                $folder = "../assets/portfolio_images/" . $picture;
                move_uploaded_file($_FILES['picture']['tmp_name'], $folder);
            }
            else
            {
                $response['status'] = "db error";
                $error = $stmt->error;
                $response['message'] = "Could not insert data into database. Reason: $error";
            }

            $stmt->close();
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = "File is not an acceptable type. Please use a png, jpg, or tiff.";
        }
    }

    $connection->close();
}
else if (!$_SESSION['auth'])
{
    $response['status'] = "error";
    $response['message'] = "Not authorized. Please log in and try again.";
}
else
{
    $response['status'] = "error";
    $response['message'] = "Incomplete data. Please ensure that all fields are complete before subitting.";
}

echo json_encode($response);

?>