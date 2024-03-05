<?php
interface DataWriterInterface {
    public function set_database_connection():void;
    public function createTable(): void;
    public function writeData(array $data): void;
}
?>