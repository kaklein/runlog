<?php

    include ('getdata.php');

    $conn = connectToDatabase();

    $id = $_GET['id'];

    $del = 'DELETE FROM runs WHERE id="' . $id . '"';

    try {
        $conn->exec($del);
    } catch (exception $e) {
        echo "Error deleting record";
    } finally {
        header("location:index.php");
        exit;
    }
?>