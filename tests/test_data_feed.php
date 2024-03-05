<?php
require_once '../src/main.php'; 

$input = "/Users/randomUSername/Desktop/Kauflandproject/data_feed.xml";
$expectedOutput = "xml";
$actualOutput = getFileExtension($input);

if ($actualOutput === $expectedOutput) {
    echo "Test passed: getFileExtension\n";
} else {
    echo "Test failed: getFileExtension\n";
}


$input = "randomName/random";
$expectedOutput = False;
$actualOutput = validateName($input);

if ($actualOutput === $expectedOutput) {
    echo "Test passed: validateName\n";
} else {
    echo "Test failed: validateName\n";
}
?>