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

        $query = "SELECT PortID, Picture, DateTaken, Description, UploadDate FROM portfolio WHERE UserID=$id";
        $result = $connection->query($query);

        if ($result)
        {
            $rows = $result->num_rows;

            if ($rows > 0)
            {
                $response['status'] = "success";
                $images = array();
                
                foreach ($result as $image)
                {
                    $images[] = $image;
                }

                $response['images'] = $images;
            }
            else
            {
                $response['status'] = "error";
                $response['message'] = "No images found. Click on 'Add Image' to add your first image!";
            }
        }
        else
        {
            $response['status'] = "db error";
            $response['message'] = "failed to get image data";
        }

        $result->close();
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