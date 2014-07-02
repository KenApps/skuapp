<?php
require_once './config.php';
// Include the pagination class
include './lib/paginator.php';
//include "./lib/lib.php";
include("header.php");

$attributes = $app->getNewAttributes()
?>
<div class="container">

    <form action="#" method="POST" class="bootstrap-frm" id="bootstrap-frm" style="width:500px!important;">
        <h1>
            Add Attribute
            <span>Please fill all the texts in the fields.</span>
        </h1>
        <label>
            <span>Label :</span>
            <input id="attribute_label" type="text" name="attribute_label" placeholder="Enter label" required="required"/>
        </label>
        <label>
            <span>Name :</span>
            <input id="attribute_name" type="text" name="attribute_name" placeholder="Enter name" required="required"/>
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
        <p id="Message">
            <?php
            if(isset($_SESSION['newAtt']))
            {
                ?>
                <div class='success'>Field has been added successfully.</div>
                <?php
                unset($_SESSION['newAtt']);
            }
            ?>
        </p>
    </form>
    <table class="sku-grid">
        <thead>
            <tr>
                <th><a href="#" id="" onclick="sort();">ID</a></th>
                <th><a href="#">Name</a></th>
                <th><a href="#">Label</a></th>
                <th><a href="#">Attribute Type</a></th>
            </tr> 
        </thead>
        <tbody>
            <?php
            foreach ($attributes as $productArray)
            {
                ?> 
                <tr>
                    <td><?php echo $productArray['ID']; ?></td>
                    <td><?php echo $productArray['name']; ?></td>
                    <td><?php echo $productArray['label']; ?></td>
                    <td><?php echo $productArray['fldname']; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include("footer.php");
?>