<?php
    include('connect.php');
    include('update.php');

    $conn = connectToDatabase();

    $id = $_POST['deleteId'];   
    $del = 'DELETE FROM runs WHERE id="' . $id . '"';

    try {
        $conn->exec($del);
        updateUserStats($conn);
    } catch (exception $e) {
        echo "Error deleting record";
    } finally {
        header("location:index.php");
        exit;
    }     
?>