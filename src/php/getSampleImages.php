<?php

require_once "config.php";

$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error)
{
    $response['status'] = "db error";
    $response['message'] = "Failed to connect to database";
}
else
{
    $query = "SELECT Picture, DateTaken, Description FROM portfolio LIMIT 4";
    $result = $connection->query($query);

    if ($result)
    {
        $rows = $result->num_rows;
        if ($rows > 0)
        {
            $images = array();
            foreach ($result as $sample)
            {
                $images[] = $sample;
            }

            $response['status'] = "success";
            $response['images'] = $images;
        }
        else
        {
            $response['status'] = "error";
            $response['message'] = "No images available";
        }
    }
    else
    {
        $response['status'] = "db error";
        $response['message'] = "Failed to get image data";
    }
}

$connection->close();

echo json_encode($response);

?>