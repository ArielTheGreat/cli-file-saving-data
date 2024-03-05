<?php
require_once 'DataReaderInterface.php';
class MyXmlReader implements DataReaderInterface {
    protected $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function arrayWithRowValues($item): array{
        $arrayValuesRow = [];
        foreach ($item->children() as $childName => $childValue){
            if (count($childValue) > 1){
                echo "XML Files with fields that have subfields are not supported\n";
                throw new InvalidArgumentException("XML Field contains subfields: $childName");
            }else{
                $arrayValuesRow[$childName] = (string) $childValue;
            }
        }
        return $arrayValuesRow;
    }

    public function readData(): array {
        $xml = simplexml_load_file($this->filePath);
        $arrayValuesInsertDDBB = [];
        foreach ($xml -> item as $item){
            $arrayValuesInsertDDBB[] = $this->arrayWithRowValues($item);
        }
        return $arrayValuesInsertDDBB; 
    }
}
?>