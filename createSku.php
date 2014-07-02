<?php
require_once './config.php';
// Include the pagination class
include("header.php");
?>
<div class="container">
    <div id="clear"></div>
    <form action="./lib/route.php" method="POST" class="bootstrap-frm">
        <input type="hidden" id="action" name="action" value="createSku" />
        <div id="bootstrap-frm"> 
            <h1>
                Create SKU
                <span>Please fill all the texts in the fields.</span>
                <?php
                if (isset($_SESSION['failedsku']))
                {
                    ?>
                    <p class="error"><?= $_SESSION['failedsku']; ?></p>
                    <?php
                    unset($_SESSION['failedsku']);
                }
                ?>
            </h1>
            <?php
            $fields = $app->getAllSKUAttributes();
            foreach ($fields as $field)
            {
                ?>
                <label>
                    <span><?php echo $field->label; ?>:</span>
                    <?php
                    switch ($field->fieldType)
                    {
                        case 1:
                            ?>
                            <select id="<?php echo $field->name; ?>" type="<?php echo $field->fldname; ?>" name="<?php echo $field->name; ?>" >
                                <option value=''>Please Select <?php echo $field->label; ?></option>
                                <?php
                                $options = $app->getOptions($field->ID);
                                //print_r($options);exit;
                                foreach ($options as $option)
                                {
                                    ?>
                                    <option value="<?php echo $option['ID']; ?>" 


                                            ><?php echo $option['name']; ?></option>
                                            <?php
                                        }
                                        ?>

                            </select> 
                            <?php
                            break;
                        case 2:
                            ?>
                            <input required <?php echo $field->fldname; ?> id="<?php echo $field->name; ?>"  name="<?php echo $field->name; ?>" placeholder="<?php echo $field->label; ?>" />
                            <?php
                            break;
                        case 3:
                            ?>
                            <input required <?php echo $field->fldname; ?> id="<?php echo $field->name; ?>"  name="<?php echo $field->name; ?>" placeholder="<?php echo $field->label; ?>" />
                            <?php
                            break;
                        case 4:
                            ?>
                            <input required id="<?php echo $field->name; ?>" type="<?php echo $field->fldname; ?>" name="<?php echo $field->name; ?>" placeholder="<?php echo $field->label; ?>" />
                            <?php
                            break;
                        case 5:
                            ?>
                            <input  required <?php echo $field->fldname; ?> id="<?php echo $field->name; ?>"  name="<?php echo $field->name; ?>" placeholder="<?php echo $field->label; ?>" /></textarea>
                            <?php
                            break;
                    }
                    ?>
                </label>
                <?php
            }
            ?>



        </div>
        <label>
            <span>&nbsp;</span>
            <input type="submit" class="button" value="Create"  />
        </label>        
    </form>

    <div id="light" class="white_content">
        <form action="#" method="POST" class="bootstrap-frm" id="bootstrap-frm" style="width:500px!important;">
            <h1>
                Add Attribute
                <span>Please fill all the texts in the fields.</span>
            </h1>
            <label>
                <span>Name :</span>
                <input id="attribute_name" type="text" name="attribute_name" placeholder="" required/>
            </label>
            <label>
                <span>Type :</span>
                <select id="attribute_type" name="attribute_type" onchange="addAttributeOptions();">
                    <option value="0" selected="selected">Please select...</option>
                    <?php
                    require_once './config.php';
                    $attributeTypes = $app->getAttributeTypes();
                    foreach ($attributeTypes as $attributeType)
                    {
                        echo '<option value="' . $attributeType->ID . '">' . $attributeType->name . '</option>';
                    }
                    ?>
                </select>
            </label>

            <div id="attributeOptions" style="display:none;">
                <div id="option_0">
                    <label>
                        <span>Option1 :</span>
                        <input id="option0" type="text" name="option[]" /><a href="#" onclick="addOption();" id="addLink">Add</a>&nbsp;&nbsp;<a href="#" onclick="deleteOption();" id="addLink">Delete</a>
                    </label>
                </div>
            </div>
            <label>
                <span>&nbsp;</span>
                <input type="button" class="button" value="Add" onclick="addAttribute();" />
            </label>
        </form> <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" style="float: right;left: 11px;position: relative;top: -278px;"><img src="./images/close.png" style="border: none;"></img></a>
    </div>
    <div id="fade" class="black_overlay"></div>
</div>

<?php
include("footer.php");
?>