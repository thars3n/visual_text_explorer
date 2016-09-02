<?php

session_start();

$fct = 0;
$tcdir = "tcupload";

/*
echo "Hello QRS...<br>";

echo "_Files data:<br>";
foreach($_FILES as $fKey) {
    echo '<pre>';
    print_r ($fKey);
    echo '</pre>';
}

echo "source file: ".$_FILES["sourcefile"]["name"]."<br>";
echo "list file: ".$_FILES["listfile"]["name"]."<br>";

$sfile = 0; //$_POST['sourcefile'];
$lfile = 1; //$_POST['listfile'];
*/

//make sure $_FILES exists and size>0 before running
if (($_FILES["sourcefile"]["size"] > 0) && ($_FILES["listfile"]["size"] > 0))  {

	echo "Uploading source file: ".$_FILES["sourcefile"]["name"]." ...<br>";
	echo "<script>";
	echo "var sourcefile =".json_encode($_FILES["sourcefile"]["name"]).";";
	echo "console.log('Source: ' + sourcefile);";
	echo "$('#keyRight').append('<span>Source: ' + sourcefile + '</span>');";
	echo "</script>";
	echo "Uploading list file: ".$_FILES["listfile"]["name"]." ...<br>";
	echo "<script> var listfile =".json_encode($_FILES["listfile"]["name"])."; </script>";

	$_SESSION['sourcefilename'] = $_FILES["sourcefile"]["name"];
	$_SESSION['listfilename'] = $_FILES["listfile"]["name"];

        if ($_FILES["sourcefile"]["error"] > 0) {

          echo "Source File Upload Error: ".$_FILES["sourcefile"]["error"]."<br>";

        } else if ($_FILES["listfile"]["error"] > 0) {

          echo "List File Upload Error: ".$_FILES["listfile"]["error"]."<br>";

        } else {

          //save the original file name for later use
          $sourcefilenameorigstr = $_FILES["sourcefile"]["name"];
          $listfilenameorigstr = $_FILES["listfile"]["name"];


          //build new filename
//          $filenamestr[$fnsct] = $_FILES["file"]["name"][$farray[$fct]];
//          $filenamestr[$fnsct] = mb_convert_encoding($filenamestr[$fnsct], "UTF-8");
//          date_default_timezone_set('UTC');
//          $datetimestr = date(YmdHis);
//          $filenamestr[$fnsct] = $datetimestr."_".$filenamestr[$fnsct];

          //echo "Filenamestr = ".$filenamestr[$fct]."<br>";
          //echo "Temp name = ".$_FILES["file"]["tmp_name"][$fct]."<br><br>";


		  $sourcefilefullpath = $tcdir."/".$sourcefilenameorigstr;
		  $listfilefullpath = $tcdir."/".$listfilenameorigstr;

          //move files to upload dir
          $movechk = move_uploaded_file($_FILES["sourcefile"]["tmp_name"], $sourcefilefullpath) or die("Source File Move: Fatal Error<br>");
          $movechk = move_uploaded_file($_FILES["listfile"]["tmp_name"], $listfilefullpath) or die("List File Move: Fatal Error<br>");

          echo "Files uploaded successfully.<br>";
          $fct = 1;

        }

  }

  if ($fct>=1) {
    //run file parse
//echo "<br>go to output<br><br>";
    include("visual_text_explorer.php");
		echo "<button id='keyLeftButton'>LIST KEY</button>";
		echo "<div id='keyLeftDropdown'>";
		echo "</div>";
  }

?>
