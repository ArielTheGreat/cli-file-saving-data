<?php
require_once 'DataWriterInterface.php';
class MySqliteWriter implements DataWriterInterface {
    protected $pdo;
    protected $name_table;
    protected $differentStructureThanFeed = False;

    public function __construct(string $name_table_ddbb) {
        $this->name_table = $name_table_ddbb;
    }

    public function set_database_connection(): void {
        try{
            $pdo = new PDO('sqlite:' . dirname(__FILE__) . '/../ddbb_data_feed.db');
            $this->pdo = $pdo;
        }catch(PDOException $e){
            die('Could not connect to the database');
        }
    }

    public function createTable(): void {
        $query = "CREATE TABLE IF NOT EXISTS `$this->name_table`(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category_name varchar(200) null,
            sku varchar(100) null,
            name varchar(200) not null,
            description text null,
            short_desc text null,
            price float not null,
            link varchar(250) null,
            image_url varchar(250) null,
            brand varchar(150) null,
            rating integer null,
            caffeine_type varchar(50) null,
            count integer null,
            flavoured varchar(10) null,
            seasonal varchar(10) null,
            stock varchar(10) null,
            facebook integer not null default 0,
            is_k_cup integer not null default 0
        )";
        $this->pdo->exec($query);
    }

    public function removeCreatedFile(){
        $filePath = dirname(__FILE__) . '/../ddbb_data_feed.db';

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function insertDataTable($arrayValuesInsertDDBB){
        try{
            $query_insert=$this->pdo->prepare("INSERT INTO `$this->name_table` (id,category_name,sku,name,description,short_desc,price,link,image_url,brand,rating,caffeine_type,count,flavoured,seasonal,stock,facebook,is_k_cup)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query_insert->execute([$arrayValuesInsertDDBB['entity_id'], $arrayValuesInsertDDBB['CategoryName'],$arrayValuesInsertDDBB['sku'],$arrayValuesInsertDDBB['name'],$arrayValuesInsertDDBB['description'],$arrayValuesInsertDDBB['shortdesc'],$arrayValuesInsertDDBB['price'],$arrayValuesInsertDDBB['link'],$arrayValuesInsertDDBB['image'],$arrayValuesInsertDDBB['Brand'],$arrayValuesInsertDDBB['Rating'],$arrayValuesInsertDDBB['CaffeineType'],$arrayValuesInsertDDBB['Count'],$arrayValuesInsertDDBB['Flavored'],$arrayValuesInsertDDBB['Seasonal'],$arrayValuesInsertDDBB['Instock'],$arrayValuesInsertDDBB['Facebook'],$arrayValuesInsertDDBB['IsKCup']]);
        }catch (PDOException $e) {
            error_log("Error inserting data into table {$this->name_table}: " . $e->getMessage() . "\n", 3, dirname(__FILE__) . '/../log/log_errors.log');
            $this->differentStructureThanFeed = True;
            $this->removeCreatedFile();
            echo "XML format structure not admitted.\n";
        }
    }

    public function writeData(array $arrayDataXml): void {
        foreach ($arrayDataXml as $innerArray){
            $this->insertDataTable($innerArray);
        }
        if ($this->differentStructureThanFeed == False)
        {
            echo "Data successfully saved in the database!\n";
        }
    }
}
?>