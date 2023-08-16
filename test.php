<form method="POST">
    <input type="text" name="Qmiddel" value="<?php echo$_POST['Qmiddel']?>">
    <input type="submit" name="submit" value="submit">
</form>

<?php

if(isset($_POST['submit'])){
    HentMetadata();
}

function HentMetadata(){
    $MetadataFile = "users/2-jonas/projects/testproj/MetadataKlvtveitvatn.csv";

    if(file_exists($MetadataFile)){
        $file = fopen($MetadataFile, "r");
        while(($row = fgetcsv($file, 1024, ";")) !== false){
            $key = $row[0]; // Assuming the key is in the first column
            $value = $row[1]; // Assuming the value is in the second column
            echo $key . " " . $value . "<br>";
            
            if($key == "Qmiddel"){
                $_POST['Qmiddel'] = $value; // Set the form field value from CSV
                break; // Stop reading once the value is found
            }
        }
        fclose($file);
    }
    else{
        die("File does not exist");
    }
}
?>
