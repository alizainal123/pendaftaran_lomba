<?php

require 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 


    $sql = "DELETE FROM competitions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param('i', $id); 
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
        
            header("Location: index.php?message=deleted");
        } else {
       
            header("Location: index.php?message=error");
        }
        $stmt->close();
    } else {
      
        header("Location: index.php?message=error");
    }
} else {
    header("Location: index.php?message=error");
}

$conn->close();
?>
