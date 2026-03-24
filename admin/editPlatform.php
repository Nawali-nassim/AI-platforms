<?php
session_start();
include "../connectDB.php";
if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0) {
   if(isset($_POST['platform_name']) || isset($_POST['platform_description']) || isset($_POST['platform_link']) || isset($_POST['platform_numberC']) || isset($_FILES['platform_icon']) ) {
        $name = trim($_POST['platform_name']);
        $description = trim($_POST['platform_description']);
        $url = trim($_POST['platform_link']);
        $categoryId = intval($_POST['platform_numberC']);

        if($_POST['action']==='edit'){
            $platformId = intval($_POST['platform_id']);

            if(isset($_FILES['platform_icon']) && $_FILES['platform_icon']['error'] === 0) {
                $ext=pathinfo($_FILES['platform_icon']['name'], PATHINFO_EXTENSION); 
                $newIconName=uniqid($name).".".$ext;// give it a unique id to avoid replacing icons
                move_uploaded_file($_FILES['platform_icon']['tmp_name'], "../images/".$newIconName);// put the icon in the folder(images)
                $sql = "UPDATE platforms SET name = ?, description = ?, link = ?, idCategory = ?, icon = ? WHERE idP = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sssisi", $name, $description, $url, $categoryId, $newIconName, $platformId);
                if ($stmt->execute()) {
                    echo "Platform updated successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                $sql = "UPDATE platforms SET name = ?, description = ?, link = ?, idCategory = ? WHERE idP = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sssii", $name, $description, $url, $categoryId, $platformId);
                if ($stmt->execute()) {
                    echo "Platform updated successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        }else{
            if(isset($_FILES['platform_icon']) && $_FILES['platform_icon']['error'] === 0) {
                $ext=pathinfo($_FILES['platform_icon']['name'], PATHINFO_EXTENSION); 
                $newIconName=uniqid($name).".".$ext;// give it a unique id to avoid replacing icons
                move_uploaded_file($_FILES['platform_icon']['tmp_name'], "../images/".$newIconName);// put the icon in the folder(images)
                $sql = "INSERT into platforms (name, description, link, idCategory, icon) values(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sssis", $name, $description, $url, $categoryId, $newIconName);
                if ($stmt->execute()) {
                    echo "Platform added successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                echo "Error: Icon upload failed with error code " . $_FILES['platform_icon']['error'];
            }
        }
    }
}else{
    die("You must be logged in as admin to perform this action.");
}
?>