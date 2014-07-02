<?php
require_once './config.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = $_GET['id'];

$sku = $app->getSkusByID($id);
//print_r($sku);
include("header.php");
?>
<div class="container">
    <div id="clear"></div>
    <form action="./lib/route.php" method="POST" class="bootstrap-frm">
        <input type="hidden" id="action" name="action" value="editSku" />
        <input type="hidden" id="edit_sku_id" name="edit_sku_id" value="<?php echo $sku['ID'];?>" />
        <div id="bootstrap-frm"> 
        <h1>
            Edit SKU
            <span>Please fill all the texts in the fields.</span>
        </h1>
        <?php $fields=$app->getAllSKUAttributes();
            foreach($fields as $field) {
            ?>
           <label>
                <span><?php echo $field->label;?>:</span>
                <?php 
                switch($field->fieldType) {
                    case 1: ?>
                      <select id="<?php echo $field->name;?>" type="<?php echo $field->fldname;?>" name="<?php echo $field->name;?>" >
                          <option value=''>Please Select <?php echo $field->label;?></option>
                          <?php 
                         
                          $options=$app->getOptions($field->ID);
                          //print_r($options);exit;
                          foreach($options as $option){
                              ?>
                          <option value="<?php  echo $option['ID']; ?>" 
                                  <?php if($option['ID']==$sku[$field->name])
                                      echo " selected";
                                      ?>
                                  
                                  ><?php echo $option['name']; ?></option>
                          <?php
                          }
                          ?>
                          
                      </select>     

                      <?php  break;
                    case 2:
                        $name=str_replace(array(" ","-") ,"_",trim($field->name));
                        ?>
                       <input <?php echo $field->fldname;?> id="<?php echo $name;?>"  name="<?php echo $name;?>" value="<?php echo $sku[$name]; ?>" placeholder="<?php echo $field->label;?>" />
                      <?php
                        
                        break;
                    case 3:
                        $name=str_replace(array(" ","-") ,"_",trim($field->name));
                        ?>
                       <input <?php echo $field->fldname;?> id="<?php echo $name;?>"  name="<?php echo $name;?>"  value="<?php echo $sku[$name]; ?>" placeholder="<?php echo $field->label;?>" />
                       <?php
                        break;
                    case 4:
                        $name=str_replace(array(" ","-") ,"_",trim($field->name));
                        ?>
                       <input id="<?php echo $name;?>" type="<?php echo $field->fldname;?>" name="<?php echo $name;?>"  value="<?php echo $sku[$name]; ?>" placeholder="<?php echo $field->label;?>" />
                      <?php
                        break;
                    case 5:
                        ?>
                       <input <?php echo $field->fldname;?> id="<?php echo $field->name;?>"  name="<?php echo $field->name;?>"  value="<?php echo $sku[$field->name]; ?>"  placeholder="<?php echo $field->label;?>" /></textarea>
                      <?php
                        break;
                }
                ?>
           </label>
            <?php   
            }
            ?>
        <label>
            <span>&nbsp;</span>
            <input type="submit" class="button" value="Update" />
        </label>
        
    </form>
</div>

<?php
include("footer.php");
?>
