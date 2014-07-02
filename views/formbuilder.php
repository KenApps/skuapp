<!doctype html>
<?php 
require_once './config.php';
  // Include the pagination class
        include './lib/paginator.php';
?>
<html>
 <head>
 <script type="text/javascript" src="<?= App::$baseUrl; ?>js/app.js"></script>
 <link type="text/css" src="<?= App::$baseUrl; ?>css/app.css" />
<style type="text/css">
   
        </style>
    </head>
    <body>    
        <div class="container">
            <?php

//Find a attribute by id;
$res = $app->getAttributeTypesByID(1);
echo $res->name;
echo "<hr/>";
//Find all attributes
$resAry = $app->getAttributeTypes();
foreach ($resAry as $res)
{
    echo "<br/>" . $res->name;
}
?>
<hr/>
            <a href="<?= App::$baseUrl; ?>dir/">Go to another dir</a>

	<?php 
       
        
        // some example data
        foreach (range(1, 200) as $value) {
          $products[] = array(
            'Product' => 'Product '.$value,
            'Price' => rand(100, 1000),
          );
        }

        // If we have an array with items
        if (count($products)) {
          // Create the pagination object
          $pagination = new Pagination($products, (isset($_GET['page']) ? $_GET['page'] : 1), 10);
          // Decide if the first and last links should show
          $pagination->setShowFirstAndLast(false);
          // You can overwrite the default seperator
          $pagination->setMainSeperator('');
          // Parse through the pagination class
          $productPages = $pagination->getResults();
          // If we have items
          if (count($productPages) != 0) {
            // Create the page numbers
             $pageNumbers = '<div class="numbers">'.$pagination->getLinks($_GET).'</div>';
            // Loop through all the items in the array
            ?>
         <table class="sku-grid">
            <thead>
              <tr>
                  <th><a href="#">Id</a></th>
                <th><a href="#">SKU</a></th>
                <th><a href="#">Manufacturer Part No</a></th>
                <th><a href="#">Manufacturer Name</a></th>
                <th><a href="#">Title</a></th>
                <th><a href="#">Price</a></th>
              </tr> 
            </thead>
            <tbody>
<!--             <tr class="filter">
                 <td><input type="text" name="id" value="" class="filter-in" /></td>
                <td><input type="text" name="id" value="" class="filter-in" /></td>
                <td><input type="text" name="id" value="" class="filter-in" /></td>
                <td><input type="text" name="id" value="" class="filter-in" /></td>
                <td><input type="text" name="id" value="" class="filter-in" /></td>
                <td><input type="text" name="id" value="" class="filter-in" /></td>
            </tr>-->
            <?php
            foreach ($productPages as $productArray) {
              // Show the information about the item
                ?> 
                <tr>
                <td><?php echo $productArray['Product']; ?></td>
                <td><?php echo $productArray['Price']; ?></td>
                <td><?php echo $productArray['Price']; ?></td>
                <td><?php echo $productArray['Price']; ?></td>
                <td><?php echo $productArray['Price']; ?></td>
                <td><?php echo $productArray['Price']; ?></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
          <?php echo $pageNumbers;
          
          }
        }
        ?>
             <form>
            <div class="form-wrapper">
                <div class="field-wrapper">
                    <label class="field-label" >skuId  </label>
                    <input class="form-field" type="text" name="skuId" />
                </div>
                 <div class="field-wrapper">
                    <label class="field-label" >skuText  </label>
                    <input class="form-field" type="text" name="skuText" />
                </div>
                <div class="field-wrapper">
                    <label class="field-label">manfpartno  </label>
                    <input class="form-field" type="text" name="manfpartno" />
                </div>
                 <div class="field-wrapper">
                    <label class="field-label">manfname  </label>
                    <input class="form-field" type="text" name="manfname" />
                </div>
                 <div class="field-wrapper">
                    <label class="field-label">title  </label>
                    <input class="form-field" type="text" name="title" />
                </div>
                <div class="field-wrapper">
                    <label class="field-label" >price  </label>
                    <input class="form-field" type="text" name="price" />
                </div>
                <div class="button-wrapper">
                    <input class="form-button" type="Submit" Value="Save" />
                </div>
            </div>
        
        </form>
            
        </div>
    </body>
</html>