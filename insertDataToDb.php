<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;

$db_host = 'localhost';
$db_name = 'ai_platform_users'; 
$db_user = 'root';    
$db_pass = ''; 

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "succesful connection\n";
} catch (PDOException $e) {
    die("connection faild" . $e->getMessage());
}

$word_file = 'C:\wamp64\www\project1_AI_Platform\ai_platforms_compiled.docx';

try {
    $phpWord = IOFactory::load($word_file);
} catch (Exception $e) {
    die("error in download the word file: " . $e->getMessage());
}

$stmt = $pdo->prepare("INSERT INTO platforms (name, description, link, idCategory) VALUES (?, ?,?,?)");

$rowCount = 0;

//read data from word file
foreach ($phpWord->getSections() as $section) { //sections like pages
    foreach ($section->getElements() as $element) {
        if ($element instanceof Table) {
            foreach ($element->getRows() as $rowIndex => $row) {
                // skip the header row
                if ($rowIndex === 0) {
                    continue;
                }

                $rowData = [];
                foreach ($row->getCells() as $cell) {
                    $cellText = '';
                    foreach ($cell->getElements() as $cellElement) {// cell can contain multiple elements like text, images, etc.
                        if ($cellElement instanceof TextRun) {// a text run can contain multiple text elements like bold, italic, etc.
                            foreach ($cellElement->getElements() as $textElement) {
                                if ($textElement instanceof Text) { // actual text element
                                    $cellText .= $textElement->getText();
                                }
                            }
                        }
                    }
                    $rowData[] = trim($cellText);
                }

                // insert only if we have exactly 4 columns
                if (count($rowData) === 4) { 
                    $stmt->execute($rowData);
                    $rowCount++;
                }
            }
        }
    }
}

echo  $rowCount . " rows inserted successfully.";
?>