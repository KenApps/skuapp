<?php
require_once './config.php';
include './lib/paginator.php';
include("header.php");

$order='desc';
$sort='value';
$sortImage='images/down_aro.gif';
if(isset($_GET['order']) && isset($_GET['sort']))
{
    $sort=$_GET['sort'];
    if($_GET['sort']=='value')
    {
        if($_GET['order']=='desc')
        {
            $order='asc';
            $sortImage='images/up_aro.png';
        }
    }
    else
    {
        if($_GET['order']=='desc') 
        {
            $order='asc';
            $sortImage='images/up_aro.png';
        }
    }
}
    

?>
<script type="text/javascript" src="charts/FusionCharts.js"></script>
<div class="container">
    <input type="Button" id="displayButton" name="displayButton" value="Display Chart" onclick="displayTopSearchReport();" />
    <div id="chartContainer" style="margin-top: 10px; padding: 10px;"></div>
    <table class="sku-grid">
        <thead>
            <tr>
                <th>
                    <a href="?sort=label&order=<?=$order;?>">SKU
                        <?php 
                        if($sort=='label')
                        {
                            ?>
                            <img src="<?= App::$baseUrl . $sortImage; ?>" />
                            <?php
                        }
                        ?>
                    </a></th>
                <th>
                    <a href="?sort=value&order=<?=$order;?>">Hits
                        <?php 
                        if($sort=='value')
                        {
                            ?>
                            <img src="<?= App::$baseUrl . $sortImage; ?>" />
                            <?php
                        }
                        ?>
                    </a>
                </th>
            </tr> 
        </thead>
        <tbody>
            <?php
            $topSkuSearches = $app->getTopSearchSkus($displayChart = false, $sort, $order);
            foreach ($topSkuSearches as $topSkuSearch)
            {
                ?>
                <tr>
                    <td><?php echo $topSkuSearch['label']; ?></td>
                    <td><?php echo $topSkuSearch['value']; ?></td>
                </tr>

                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>       
<?php
include("footer.php");
?>