<?php

class App
{
    public $db;
    private static $db_instance;
    public static $baseUrl; //http://localhost/app (app is my folder in localost)

    function __construct()
    {
        self::$baseUrl = 'https://eaohealth.sasken.com/skuapp/';

        /* ========= Singleton Database Connection ========== */
        $dsn = 'mysql:host=' . Config::read('db.host') .
                ';dbname=' . Config::read('db.basename') .
                ';port=' . Config::read('db.port') .
                ';connect_timeout=15';

        $user = Config::read('db.user');
        $password = Config::read('db.password');

        try
        {
            $this->db = new PDO($dsn, $user, $password);
        } catch (PDOException $e)
        {
            echo "<p><b>Error</b>: Database connection</p>";
            echo "<div>" . $e->errorInfo . "</div>";
            die();
        }
        /* ========= Singleton Database Connection ========== */
    }

    public static function getDBInstance()
    {
        if (!isset(self::$db_instance))
        {
            $object = __CLASS__;
            self::$db_instance = new $object;
        }
        return self::$db_instance;
    }

    public function say($message)
    {
        return $message;
    }

    public function getAttributeTypes()
    {
        try
        {
            $sql = "SELECT * FROM attribute_types";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rows;
        } catch (PDOException $e)
        {
            echo $e->errorInfo;
            die();
        }
    }
    
    public function getAllSkus()
    {
        try
        {
            $sort=$_GET['sort'] ? $_GET['sort'] : 'ID';
            $order=$_GET['order'] ? $_GET['order'] : 'asc';
            $sql = "SELECT * FROM sku order by ".$sort." ".$order;
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e)
        {
            echo $e->errorInfo;
            die();
        }
    }
    
    public function getSkusByID($id)
    {
        try
        {
            $sql = "SELECT * FROM sku WHERE ID = :id";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e)
        {
            echo $e->errorInfo;
            die();
        }
    }

    public function getAttributeTypesByID($id)
    {
        try
        {
            $sql = "SELECT * FROM attribute_types WHERE ID = :id";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row;
        } catch (PDOException $e)
        {
            echo $e->errorInfo;
            die();
        }
    }

    public function getOptions($Id)
    {
        try
        {
            $sql = "SELECT * FROM `attribute_options` WHERE `attribute_id`=:id";//exit;
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->bindParam(':id', $Id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e)
        {
            echo $e->errorInfo;
            die();
        }
    }
    
    public function addAttributes($name, $attributeTypeId,$attributeLabel, $options)
    {
        try
        {
            $sql = "INSERT INTO attributes (name, attribute_type_id,label) values (:name, :attribute_type, :attribute_label)";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':attribute_type', $attributeTypeId, PDO::PARAM_STR);
            $stmt->bindParam(':attribute_label', $attributeLabel, PDO::PARAM_STR);
            $isAddAttribute = $stmt->execute();
            $attributeId = $app->db->lastInsertId();
            $sql = "ALTER TABLE `sku` ADD `$name` INT( 11 ) NOT NULL AFTER `Price` ;";
            $stmt = $app->db->prepare($sql);
            $alterTable = $stmt->execute();
            
            if ($isAddAttribute) {
                if ($attributeTypeId == "1" || $attributeTypeId == "2" || $attributeTypeId == "3")  {
                    $app->addAttributeOptions($options, $attributeId);
                }
                echo "true";
            }
            
        } catch (PDOException $e) {
            echo $e->errorInfo;
            die();
        }
    }
    
    public function addAttributeOptions($options, $attribute_id)
    {
        try
        {
           foreach ($options as $key => $value) {
                $sql = "INSERT INTO attribute_options (name, attribute_id) values (:name, :attribute_id)";
                $app = App::getDBInstance();
                $stmt = $app->db->prepare($sql);
                $stmt->bindParam(':name', $value, PDO::PARAM_STR);
                $stmt->bindParam(':attribute_id', $attribute_id, PDO::PARAM_STR);
                $stmt->execute();
            }
          
        } catch (PDOException $e) {
            echo $e->errorInfo;
            die();
        }
    }
    
    public function createSku($postArray)
    {
        try {
            $cols=array_keys($postArray);
            foreach ($cols as $index => $value) {
                if ($value == 'action' ) {
                    unset($cols[$index]);
                }
            }
            $inskey=implode(',',$cols);
            foreach ($postArray as $index => $value) {
                if ($value == 'createSku' ) {
                    unset($postArray[$index]);
                }
            }
            $insbind="'".implode("','",$postArray)."'";
            $sql = "INSERT INTO sku ($inskey) values ($insbind)";//exit;
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->errorInfo;
            die();
        }
    }

    
    public function updateSku($postArray)
    {
        try {
             $editId=$postArray['edit_sku_id']; $i=0;
             foreach ($postArray as $index => $value) {
                if ($index == 'action' || $index == 'edit_sku_id') {
                    unset($postArray[$index]);
                }else {
                 $inskey[$i]="$index='$value'";
                $i++; 
                }
            }
            $inskey=implode(', ',$inskey);
            $sql = "UPDATE sku SET ".$inskey." where ID=".$editId;//exit;
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->errorInfo;
            die();
        }
    }
    
    public function getNewAttributes()
    {
        try
        {
            $sql = "SELECT a . * , at.name as fldname, at.ID as fieldType
                    FROM `attributes` AS a
                    LEFT JOIN `attribute_types` AS at ON at.ID = a.`attribute_type_id` ";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
        //    $stmt->bindParam(':is_new', $is_new, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e)
        {
            echo $e->errorInfo;
            die();
        }
    }    
    public function getAllSKUAttributes() {
        try
        {
            $sql = "SELECT a . * , at.name as fldname, at.ID as fieldType
                    FROM `attributes` AS a
                    LEFT JOIN `attribute_types` AS at ON at.ID = a.`attribute_type_id` ";
            $is_new = "1";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rows;
        } catch (PDOException $e) {
            echo $e->errorInfo;
            die();
        }
    }
      public function getOptionValue($Id) {
        try
        {
           // echo $Id;
            $sql = "SELECT name FROM attribute_options where ID=:id ";
            $is_new = "1";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->bindParam(':id', $Id, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // print_r($rows);exit;
            return $rows ? $rows[0]['name'] : '';
        } catch (PDOException $e) {
            echo $e->errorInfo;
            die();
        }
    }
    
	public function getTopSearchSkus($displayChart) {
        try
        {

            $sql = "SELECT sk.sku as label, skus.num_hits as value FROM sku_search_history as skus LEFT JOIN sku as sk ON skus.sku_id = sk.ID ORDER BY skus.num_hits";
            $app = App::getDBInstance();
            $stmt = $app->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);	
            if($displayChart){
                echo json_encode($rows);
            }
            else{
                return $rows;
            }
            } catch (PDOException $e)
            {
                echo $e->errorInfo;
                die();
            }
	}
	
	public function getSearchSku($id) {
            try
            {
                $this->updateSkuHits($id);
                 $sql = "SELECT * FROM sku WHERE ID = :id";
                $app = App::getDBInstance();
                $stmt = $app->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                			
                //print_r($rows);
              echo json_encode($rows);
            } catch (PDOException $e)
            {
                echo $e->errorInfo;
                die();
            }
	}
        
        public function updateSkuHits($id) {
            try
            {
                $sql = "SELECT * FROM sku_search_history WHERE sku_id = :id";
                $app = App::getDBInstance();
                $stmt = $app->db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $rows1 = $stmt->fetch(PDO::FETCH_OBJ);
               
                    $hits = $rows1->num_hits;
                    //echo "Hits : " . $hits;
                    //exit;
                    if(!$hits) {
                        $hits = 1;
                        $sql = "INSERT INTO `sku_search_history`( `sku_id`, `num_hits`) VALUES (:one,:two)";
                        $app = App::getDBInstance();
                        $stmt = $app->db->prepare($sql);
                        $stmt->bindParam(':one', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':two', $hits, PDO::PARAM_INT);
                        $stmt->execute();
                     }
                    else {
                        $hits = $hits + 1;
                        $sql = "UPDATE sku_search_history set num_hits=:value WHERE sku_id=:id";
                        $app = App::getDBInstance();
                        $stmt = $app->db->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':value', $hits, PDO::PARAM_INT);
                        $stmt->execute();
                    }

                
                
               
                return $row;
            } catch (PDOException $e)
            {
                echo $e->errorInfo;
                die();
            }
        }
    
}


?>