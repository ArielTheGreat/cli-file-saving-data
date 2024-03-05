<?php
require_once __DIR__ . '/../src/DataFactory.php';
require_once __DIR__ . '/../src/MyXmlReader.php';
require_once __DIR__ . '/../src/MySqliteWriter.php';
use PHPUnit\Framework\TestCase;

class DataFactoryTest extends TestCase
{
    public function testCreateReaderWithXmlType()
    {
        $filePath = dirname(__FILE__) . '/../feed.xml';
        $reader = DataFactory::createReader('xml', $filePath);
        
        $this->assertInstanceOf(MyXmlReader::class, $reader);
    }

    public function testCreateWriterWithSqliteType()
    {
        $nameTable = 'testTable';
        $writer = DataFactory::createWriter('sqlite', $nameTable);
        
        $this->assertInstanceOf(MySqliteWriter::class, $writer);
    }

    public function testCreateReaderWithUnsupportedType()
    {
        $this->expectException(InvalidArgumentException::class);
        DataFactory::createReader('unsupportedType', dirname(__FILE__) . '/../log/log_errors.log');
    }

    public function testCreateWriterWithUnsupportedType()
    {
        $this->expectException(InvalidArgumentException::class);
        DataFactory::createWriter('postgresql', 'testTable');
    }
}
?>