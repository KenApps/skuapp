<?php
require_once './config.php';
// Include the pagination class
include './lib/paginator.php';
//include "./lib/lib.php";
include("header.php");
//$app=new App();
$results = $app->getAllSkus();
//    echo "<pre>";
//    print_r($results);
// 
//    $headers=array_keys($results[0]);
//     print_r($headers);
//    echo "</pre>";
?>

<div class="container">
    <form action="#" method="POST" class="bootstrap-frm" style="width:898px;margin-left:0px;border-radius:0px;">
        <h1>
            Search SKU
            <span>Search SKU by selecting the drop down list.</span>
        </h1>
        <label>
            <span>Search :</span>
            <select id="search_sku" name="search_sku">
                <option value="0" selected="selected">Please select...</option>
                <?php
                require_once './config.php';
                $skus = $app->getAllSkus();
                foreach ($skus as $sku)
                {
                    echo '<option value="' . $sku['ID'] . '">' . $sku['SKU'] . '</option>';
                }
                ?>
            </select>
        </label>
        <label>
            <span>&nbsp;</span>
            <input type="button" class="button" value="Search" onclick="searchSku();" />
        </label>

    </form>
    <table id="searchResults" class="sku-grid">

    </table>

</div>
<?php
include("footer.php");
?>