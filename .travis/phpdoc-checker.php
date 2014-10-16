<?php
$inputFile= $argv[1];

if (!file_exists($inputFile)) {
    throw new InvalidArgumentException('Invalid input file provided');
}

$xml = new SimpleXMLElement(file_get_contents($inputFile));
$errors = $xml->xpath('//file/error');
$errorCount = count($errors);

if ($errorCount > 0) {
    echo $errorCount . ' phpDocumentor errors found! Run phpdoc locally and review docs/api/checkstyle.xml'. PHP_EOL;
    exit(1);
}

echo 'No phpDocumentor errors detected - OK!' . PHP_EOL;
