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

$word_file = 'C:\Users\user\OneDrive\Desktop\work\ai_platforms_compiled.docx';

try {
    $phpWord = IOFactory::load($word_file);
} catch (Exception $e) {
    die("error in download the word file: " . $e->getMessage());
}

$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");

$rowCount = 0;

// 5. قراءة المستند وإدخال البيانات
foreach ($phpWord->getSections() as $section) {
    foreach ($section->getElements() as $element) {
        if ($element instanceof Table) {
            foreach ($element->getRows() as $rowIndex => $row) {
                // تخطي الصف الأول إذا كان يحتوي على عناوين الأعمدة
                if ($rowIndex === 0) {
                    continue;
                }

                $rowData = [];
                foreach ($row->getCells() as $cell) {
                    $cellText = '';
                    foreach ($cell->getElements() as $cellElement) {
                        if ($cellElement instanceof TextRun) {
                            foreach ($cellElement->getElements() as $textElement) {
                                if ($textElement instanceof Text) {
                                    $cellText .= $textElement->getText();
                                }
                            }
                        }
                    }
                    $rowData[] = trim($cellText);
                }

                // 6. تنفيذ استعلام الإدخال مع بيانات الصف
                // تأكد أن عدد البيانات يتطابق مع عدد علامات الاستفهام في الاستعلام
                if (count($rowData) === 2) { // للتأكد من أن الصف يحتوي على عمودين
                    $stmt->execute($rowData);
                    $rowCount++;
                }
            }
        }
    }
}

echo "تم إدخال " . $rowCount . " صفًا بنجاح في قاعدة البيانات.";