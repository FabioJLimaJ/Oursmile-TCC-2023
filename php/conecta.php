<?php
try {
  $conn = new PDO('mysql:host=127.0.0.1:3306;dbname=db_oursmile', 'root', 'usbw');
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>