<?php

require_once './config.php';
$action = $_POST['action'];
$param = $_POST['param'];

switch ($action)
{
    case "getAttributeTypesByID":
        $row = $app->getAttributeTypesByID(1);
        return json_encode($row);
        break;

    case "getAttributeTypes":
        $rows = $app->getAttributeTypes();
        return json_encode($rows);
        break;
    
    case "xyz":
        //your logic
        break;
    default :
        echo "Invalid action";
        break;
}