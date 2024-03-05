#! /usr/bin/env.php
<?php
require_once 'DataFactory.php';

ini_set('log_errors', 'On');
ini_set('error_log', dirname(__FILE__) . '/../log/log_errors.log');
ini_set('display_errors', 'Off');

if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    main();
}

function main(){
    $database = 'sqlite';

    welcomeText();
    while (True){
        $name_table_ddbb = readline('Please enter the name you would like your table to be called (only alphanumerical and underscores are allowed): ');
        if (validateName($name_table_ddbb)){
            break;
        }
    }

    while(True){
        $filePath = readline("Please enter the file path (absolute or relative): ");

        if (file_exists($filePath) && is_file($filePath)) {
            break;
        } else {
            echo "File does not exist.\n";
        }
    }
    
    $fileExtension = getFileExtension($filePath);

    $xmlData = DataFactory::createReader($fileExtension, $filePath);
    $arrayDataXml = $xmlData->readData();
    $ddbb = DataFactory::createWriter($database,$name_table_ddbb);
    $ddbb->set_database_connection();
    $ddbb->createTable($arrayDataXml);
    $ddbb->writeData($arrayDataXml);
}

function getFileExtension($filePath){
    $pieces = preg_split("#[/\\\\]#", $filePath);
    $fileExtension = explode(".", end($pieces));
    return end($fileExtension);
}

function welcomeText(){
    echo "WELCOME TO FILE SAVER\n";
    echo "************************\n";
    echo "We will save the data from a file into a database\n";
}

function validateName($tableName) {
    $pattern = '/^[a-zA-Z0-9_]+$/';

    if (preg_match($pattern, $tableName)) {
        return True;
    } else {
        return false;
    }
}
?>