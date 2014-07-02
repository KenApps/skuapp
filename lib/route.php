<?php
require_once '../config.php';
require_once 'lib.php';
$action = trim($_POST["action"]);


switch ($action) {
    case 'addAttribute':
        $_SESSION['newAtt']=true;
        $attributeName = trim($_POST['attributeName']);
        $attributeType = trim($_POST['attributeType']);
        $attributeLabel = trim($_POST['attributeLabel']);
        $attributeOption = explode(',', $_POST["attributeOptions"]);
        if (count($attributeOption) < 1) {
            $options = null;
        }
        else {
            $options = $attributeOption;
        }
       // echo $attributeLabel;exit;
        $app->addAttributes($attributeName, $attributeType,$attributeLabel, $options);
        
        break;
    case 'createSku': 
        $postArray = $_POST;
        $SKU=$_POST['SKU'];
        $count=$app->checkSKU($SKU);
        
        if($count==0)
        {
            $app->createSKU($postArray);
            $_SESSION['newsku']=true;
            header('Location: ../sku.php');
        }
        else
        {
            $_SESSION['failedsku']='You have entered duplicate SKU "'.$SKU.'"';
            header('Location: ../createSku.php');
        }        
        break;
    case 'editSku':    
        $id=$_POST['edit_sku_id'];
        unset($_POST['action']);
        unset($_POST['edit_sku_id']);
        //exit;        
        //$app->updateSKU($id);
        $postArray = $_POST;        
        $app->updateSKU($id,$postArray);
        header('Location: ../sku.php');
        break;
    
    case 'getTopSkuSearch':
                    $displayChart = true;
                    $app->getTopSearchSkus($displayChart);
            break;
    case 'getSkuSearch':
        $postArray = $_POST;
                    $app->getSearchSku($postArray['skuId']);
            break;
    default:
        break;
}


