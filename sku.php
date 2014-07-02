<?php
require_once './config.php';
// Include the pagination class
include './lib/paginator.php';
include("header.php");
?>

<div class="container">
    <div id="clear"></div>
    <?php
    require_once './config.php';
    $skus = $app->getAllSkus();
    $headers = $app->getAllSKUAttributes();

    // some example data
    //   echo "no of sku : " . count($skus);
    // If we have an array with items
    if (count($skus))
    {
        // Create the pagination object
        $pagination = new Pagination($skus, (isset($_GET['page']) ? $_GET['page'] : 1), 10);
        // Decide if the first and last links should show
        $pagination->setShowFirstAndLast(false);
        // You can overwrite the default seperator
        $pagination->setMainSeperator('');
        // Parse through the pagination class
        $skuPages = $pagination->getResults();
        // If we have items
        if (count($skuPages) != 0)
        {
            // Create the page numbers
            $pageNumbers = '<div class="numbers">' . $pagination->getLinks($_GET) . '</div>';
            // Loop through all the items in the array
            $sort = $_GET['sort'] ? $_GET['sort'] : 'ID';
            $order = $_GET['order'] ? $_GET['order'] : 'asc';
            $page = $_GET['page'] ? $_GET['page'] : 1;
            if ($order == 'asc')
                $order = 'desc';
            else
                $order = 'asc';
            ?>

            <?php
            if (isset($_SESSION['newsku']))
            {
                ?>
                <div class="newSku">
                    You new record has been added <?php unset($_SESSION['newsku']); ?>
                </div>
                <?php
            }
            ?>
    <div id="tableWraper">
                <table class="sku-grid">
                    <thead>
                        <tr>
                            <th>
                                <?php
                                $iSort = $_GET['sort'];
                                $iOrder = $_GET['order'];
                                if ($iSort == 'ID' && $iOrder == 'asc')
                                    $sortImage = "images/up_aro.png";
                                else if ($iSort == 'ID' && $iOrder == 'desc')
                                    $sortImage = "images/down_aro.gif";
                                else
                                {
                                    $sortImage = "images/up_aro.png";
                                }
                                ?>
                                <a href="sku.php?&sort=ID&order=<?php echo $order; ?>&page=<?php echo $page; ?>" id="" onclick="sort();">ID 
                                    <?php
                                    if (!isset($_GET['sort']) || $iSort == 'ID')
                                    {
                                        ?>    
                                        <img src="<?= App::$baseUrl . $sortImage; ?>" />
                                        <?php
                                    }
                                    ?>
                                </a>
                            </th>
                            <?php
                            foreach ($headers as $header) :
                                if ($iSort == $header->name && $iOrder == 'asc')
                                    $sortImage = "images/up_aro.png";
                                else if ($iSort == $header->name && $iOrder == 'desc')
                                    $sortImage = "images/down_aro.gif";
                                else
                                {
                                    $sortImage = "";
                                }
                                $h.='<th><a href="sku.php?&sort=' . $header->name . '&order=' . $order . '&page=' . $page . '" id="" onclick="sort();">' . ucwords($header->name) . '</a>';
                                if ($sortImage != "")
                                    $h.=" <img src=" . App::$baseUrl . $sortImage . " />";
                                $h.='</th>';
                            endforeach;
                            echo $h;
                            ?>

                        </tr> 
                    </thead>
                    <tbody>
                        <?php
                        //  echo "no of skus : " . count($skuPages);
                        foreach ($skuPages as $skuArray)
                        {
                            ?>
                            <tr>
                                <td><a href="<?= App::$baseUrl; ?>editSku.php?id=<?php echo $skuArray['ID']; ?>"><?php echo $skuArray['ID']; ?></a></td>
                                <?php
                                foreach ($headers as $header)
                                {
                                    ?> 

                                    <?php ?>
                                    <td><?php
                                        //  echo $skuArray[$header->name];
                                        if ($header->fieldType == 1)
                                        {
                                            $val = $app->getOptionValue($skuArray[$header->name]);
                                            echo $val;
                                        } else
                                        {
                                            $name=str_replace(" ","_",$header->name);
                                            echo $skuArray[$name]; 
                                        }
                                        ?></td>
                                    <?php
                                }
                                ?></tr>
                                <?php
                            }
                            ?>
                    </tbody>
                </table>
            </div>
            <?php
            echo $pageNumbers;
        }
    }
    ?>
</div>

<?php
include("footer.php");
?>
