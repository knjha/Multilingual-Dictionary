<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <?php

    $host = "localhost";
    $databaseName = "DICTIONARY";
    $username = "kanhaiya";
    $password = "1234";

    $conn = "mysql:host=$host; dbname = $databaseName";
    $word = $_GET['w'];
    try {
        $dconn = new PDO("mysql:host=$host;dbname=$databaseName",$username,$password);
        
        $sql = $dconn->query("SELECT * FROM WORDS_TABLE where WORD = '$word'");
        foreach ($sql as $row) {
            $id = $row['W_ID'];
            echo "<h1>". $row['WORD']."</h1>";
            echo "<b>". "Syllable : " .$row['SYLLABLE']. "</b>" ."<br>";
            echo "<b>". "Pronunciation : " .$row['PRONUNCIATION']. "</b>" ."<br>";
            if ($row['SCIENTIFIC_NAME']!=NULL) {
                echo "<b>". "Scientific Name : " .$row['SCIENTIFIC_NAME']. "</b>" ."<br><hr>";
            }
         $sql = $dconn->query("SELECT * FROM IMAGE WHERE IMAGE.W_ID = '$id'");
         foreach($sql as $row){
            echo '<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($row['IMAGE_FILE']).'"/>'."<br><hr>";
         }
            $sql = $dconn->query("SELECT * from PARTOFSPEECH where PARTOFSPEECH.W_ID = $id");
            foreach($sql as $row){
                $posid = $row['P_ID'];
            echo "<h3>". $row['POS'] ."</h3>";
            $sql = $dconn->query("SELECT * FROM MEANING where MEANING.P_ID = $posid");
            foreach ($sql as $row) {
                $meanID = $row['M_ID'];
                echo "<b>". "meaning: " . "</b>" .$row['MEANING']. "<br>";
                $sql = $dconn->query("SELECT EXAMPLE from EXAMPLE where EXAMPLE.M_ID = $meanID");
                foreach ($sql as $row ) {
                    echo "<b>". "Example: " . "</b>" .$row['EXAMPLE']. "<br>";
                }
                
                $sql = $dconn->query("SELECT SYNONYM from  SYNONYM_TABLE where SYNONYM_TABLE.M_ID = $meanID");
                foreach ($sql as $row ) {
                    echo "<b>". "Synonyms: ". "</b>". $row['SYNONYM']. "<br>";
                }
                $sql = $dconn->query("SELECT ANTONYM from ANTONYM_TABLE where ANTONYM_TABLE.M_ID = $meanID");
                foreach ($sql as $row ) {
                    echo "<b>". "Antonyms ". "</b>". $row['ANTONYM']. "<br><br><hr>";
                }
            }
            }
                
                $sql = $dconn->query("SELECT HINDI, SANSKRIT, TELGU from LANGUAGE where LANGUAGE.W_ID=$id");
                foreach ($sql as $row ) {
                    echo "<br>"."<b>". "Hindi  "."</b>". $row['HINDI']. "<br><br>";
                    echo "<b>". "Sanskrit  "."</b>". $row['SANSKRIT']. "<br><br>";
                    echo "<b>". "Telgu  "."</b>". $row['TELGU']. "<br><br><hr>";
                }
                $sql = $dconn->query("SELECT IMAGE_FILE from IMAGE WHERE IMAGE.W_ID = $id");
                foreach ($sql as $row ) {   ?>
                 <img src="data:image/jpg;charset=utf8;based64,<?php echo based64_encode($row['IMAGE_FILE'])?>;
                 <?php
              }
        }
    } catch ( PDOException $error) {
        echo "$error";
    }
    ?>    
    </body>
    </html>