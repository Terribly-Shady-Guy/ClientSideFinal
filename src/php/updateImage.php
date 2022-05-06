<?php

require_once "config.php";
require_once "utils.php";

session_id($_POST['session']);
session_start();

if ($_SESSION['auth']
&& isset($_POST['description'])
&& isset($_POST['dateTaken']))
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error)
    {
        $response['status'] = "db error";
        $response['message'] = "Failed to connect to database";
    }
    else
    {
        if (validateUser($_SESSION['userID'], $_POST['portID'], $connection))
        {
            if (is_uploaded_file($_FILES['picture']['tmp_name']))
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
                    $picture = sanitizeInput($_FILES['picture']['name'], $connection);
                    $folder = "../assets/portfolio_images/" . $picture;
                    move_uploaded_file($_FILES['picture']['tmp_name'], $folder);

                    $response = update($picture, $connection);
                }
                else
                {
                    $response['status'] = "error";
                    $response['message'] = "File must be a png, jpg, or tiff.";
                }
            }
            else
            {
                $picture = sanitizeInput($_POST['picture'], $connection);
                $response = update($picture, $connection);
            }
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = "You do not have access to this image";
        }
    }

    $connection->close();
}
else
{
    $response['status'] = "error";
    $response['message'] = "Not authorized. Please log in and try again.";
}

echo json_encode($response);



function update($picture, $connection)
{
    $portID = sanitizeInput($_POST['portID'], $connection);
    $description = sanitizeInput($_POST['description'], $connection);
    $dateTaken = sanitizeInput($_POST['dateTaken'], $connection);

    $stmt = $connection->prepare("UPDATE portfolio SET Picture=?, Description=?, DateTaken=? WHERE PortID=?");
    $stmt->bind_param("sssi", $picture, $description, $dateTaken, $portID);

    if ($stmt->execute())
    {
        $response['status'] = "success";
    }
    else
    {
        $response['status'] = "db error";
        $error = $stmt->error;
        $response['message'] = "Could not update data. Reason: $error";
    }

    $stmt->close();

    return $response;
}

?>