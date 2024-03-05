<?php
require_once __DIR__ . '/../src/MyXmlReader.php';
use PHPUnit\Framework\TestCase;

class MyXmlReaderTest extends TestCase
{
    public function testReadData()
    {
        $filePath = dirname(__FILE__) . '/../feed.xml';
        $reader = new MyXmlReader($filePath);
        $data = $reader->readData();

        $this->assertIsArray($data, 'Expected data to be an array');
        $this->assertNotEmpty($data, 'Expected data array not to be empty');

        $this->assertEquals('340', (string) $data[0]['entity_id'], 'First item name should be "340"');
        $this->assertEquals('20', (string) $data[0]['sku'], 'First item value should be "20"');
    }

    public function testReadData2()
    {
        $filePath2 = dirname(__FILE__) . '/../feed2.xml';
        $reader2 = new MyXmlReader($filePath2);
        $this->expectException(InvalidArgumentException::class);
        $data2 = $reader2->readData();
    }
}
?>