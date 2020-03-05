<?php 
$errors = array();
$uploadedFiles = array();
$extension = array("jpeg","jpg","png","gif");
$bytes = 1000000;
$totalBytes = $bytes;
$UploadFolder = "UploadFolder";
 
$counter = 0;

//looping na diri sa foreach 
foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
    $temp = $_FILES["files"]["tmp_name"][$key];
    $name = $_FILES["files"]["name"][$key];
//checking kung empty ang temp     
    if(empty($temp))
    {
        break;
    }
//boolean happens here.. checking sa imung file(s).. 
    $counter++;
    $UploadOk = true;
//cheking sa file size limit kay 10mb..   
    if($_FILES["files"]["size"][$key] > $totalBytes)
    {
        $UploadOk = false;
        array_push($errors, $name." file size is larger than the 10 MB.");
    }
//diri ang extension i.check kung valid file type imung gi upload..    
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    if(in_array($ext, $extension) == false){
        $UploadOk = false;
        array_push($errors, $name." is invalid file type.");
    }
//checking kung imung file mana og upload..    
    if(file_exists($UploadFolder."/".$name) == true){
        $UploadOk = false;
        array_push($errors, $name." file is already exist.");
    }
   
    if($UploadOk == true){
        move_uploaded_file($temp,$UploadFolder."/".$name);
        array_push($uploadedFiles, $name);
    }
}
 
if($counter>0){
    if(count($errors)>0)
    {
        echo "<b>Errors:</b>";
        echo "<br/><ul>";
        foreach($errors as $error)
        {
            echo "<li>".$error."</li>";
        }
        echo "</ul><br/>";
    }
     
    if(count($uploadedFiles)>0){
        echo "<b>Uploaded Files:</b>";
        echo "<br/><ul>";
        foreach($uploadedFiles as $fileName)
        {
            echo "<li>".$fileName."</li>";
        }
        echo "</ul><br/>";
         
        echo count($uploadedFiles)." file(s) are successfully uploaded.";
    }                               
}
else{
    echo "Please, Select file(s) to upload.";
}

?>