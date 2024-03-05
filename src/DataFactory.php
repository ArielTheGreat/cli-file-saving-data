<?php
require_once 'DataReaderInterface.php';
require_once 'DataWriterInterface.php';
require_once 'MyXmlReader.php';
require_once 'MySqliteWriter.php';

class DataFactory {
    public static function createReader($type, $filePath): DataReaderInterface {
        switch ($type) {
            case 'xml':
                return new MyXmlReader($filePath);
            default:
                echo "File type not supported\n";
                throw new InvalidArgumentException("Unsupported reader type: $type");
        }
    }

    public static function createWriter($type, $nameTable): DataWriterInterface {
        switch ($type) {
            case 'sqlite':
                return new MySqliteWriter($nameTable);
            default:
                echo "Database not supported\n";
                throw new InvalidArgumentException("Unsupported writer type: $type");
        }
    }
}
?>