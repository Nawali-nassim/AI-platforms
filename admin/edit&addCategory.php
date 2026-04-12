<?php
session_start();
include "../connectDB.php";
if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0) {
   if(isset($_POST['platform_name']) && isset($_POST['platform_description'])) {
        $name = trim($_POST['platform_name']);
        $description = trim($_POST['platform_description']);

        if($_POST['action']==='edit-category'){
            $categoryId = intval($_POST['platform_id']);
            $sql = "UPDATE categories SET name = ?, description = ? WHERE idC = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssi", $name, $description, $categoryId);
            if ($stmt->execute()) {
                echo "Category updated successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }else{
            $sql = "INSERT into categories (name, description) values(?,?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ss", $name, $description);
            if ($stmt->execute()) {
                echo "Category added successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
   }else{
    echo "Error : you should fill the fields.";
   }
}else{
    die("You must be logged in as admin to perform this action.");
}
?>