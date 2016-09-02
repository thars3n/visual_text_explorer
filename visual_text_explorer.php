<?php
session_start();

// Set encoding to UTF-8
mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");

// Set up global variables
$sourcedir = ".";    					//$tcdir;
$sourcefilename = $sourcefilefullpath;  // "grande_sertao.txt";
$listfilename = $listfilefullpath; 		// "list_of_terms.txt";

$sourcefileinputstr = "";
$sourcefileinput_strlen = 0;
$sourcefiledata = array();
$listfileinputstr = "";
$listfiledata = array();
$untrimmedlistfiledata = array();
$sourcefiledatacount = 0;
$listfiledatacount = 0;
$untrimmedlistfiledatacount = 0;
$searchkeysfoundcount = 0;

// this function outputs whatever it is given to script in the main page
function echoToJS($string) {
	echo '<script>';
	echo $string;
	echo '</script>';
}

// *****
// Set initial values and settings as well as session variables
// *****
$exactmatch = 0; 	 		//exact (1) or partial (0=default) match
if ($_POST['exactmatch'] == "exactmatch" ) {
	 $exactmatch = 1;
	 $_SESSION['exactmatch'] == "exactmatch";
}

$split_on_spaces = 1;
$split_on_chars = 0;

// set source file splitting options
if ($_POST['split'] == "charsplit") {
	$split_on_spaces = 0;
	$split_on_chars = 1;
	$_SESSION['split'] = "charsplit";
}
else {
	$_SESSION['split'] = "spacesplit";
}

// set case sensitivity options
$case_sensitive = 0; 		//default = 0 (case insensitive)
if ($_POST['casesensitive'] == "casesensitive" ) {
	$case_sensitive = 1;
	$_SESSION['casesensitive'] = "casesensitive";
}
else {
	$_SESSION['casesensitive'] = '';
}

// show all steps option
$show_all_steps = 1; 		//default = 1 (on)
if ($_POST['showsteps'] == "showsteps" ) { $show_all_steps = 1; }

// vertical vs horizontal orientation
$vertical = 0;
if ($_POST['orientation'] == "vertical" ) {
	$vertical = 1;
	$_SESSION['orientation'] = "vertical";
}
else {
	$_SESSION['orientation'] = "horizontal";
}

// bar height frequency settings
$frequency = 0;
if ($_POST['frequency'] == "frequency") {
	$frequency = 1;
	$_SESSION['frequency'] = "frequency";
}
else {
	$_SESSION['frequency'] = '';
}

// right float settings for vertical display
$right2left = 0;
if ($_POST['right2left'] == "right2left") {
	$right2left = 1;
	$_SESSION['right2left'] = 'right2left';
}
else {
	$_SESSION['right2left'] = '';
}

$_SESSION['sourcefile'] = $sourcefilename;
$_SESSION['listfile'] = $listfilename;

echo "<br>Visual Text Explorer running...<br><br>";

// *** Set File Contents into Arrays and Split***

// Check and retrieve uploaded file data
$sourcefileinputstr = file_get_contents($sourcefilename);

// Read list file and split into array (1 element = 1 line)
$listfileinputstr = file_get_contents($listfilename);
$untrimmedlistfiledata = preg_split('/((\r(?!\n))|((?<!\r)\n)|(\r\n))/', $listfileinputstr);

// Count number of elements in list file => used for calculating bar color
$untrimmedlistfiledatacount = count($untrimmedlistfiledata);

// Remove gaps in list file => construct $listfiledata
$listfileindex = 0;
$stringreplace = array(); // array of strings that are getting replace + their replacements
$listfilereplacement = array(); // list file but with substitute characters for items with spaces

// creates characters to insert as replacement for list items with spaces
for($index=0;$index<$untrimmedlistfiledatacount;$index++) {
	if($untrimmedlistfiledata[$index] != '') {
		$item = $untrimmedlistfiledata[$index];
		$listfiledata[$listfileindex] = $item;


		if($split_on_spaces && strpos($item, ' ') !== false) {
			$stringreplace[$item] = '╬' . $listfileindex;
			$listfilereplacement[$listfileindex] = '╬' . $listfileindex;
		}
		else if($split_on_chars && mb_strlen($item) > 1){
			$stringreplace[$item] = '╬' . $listfileindex . '╬';
			$listfilereplacement[$listfileindex] = '╬' . $listfileindex. '╬';
		}
		else {
			$listfilereplacement[$listfileindex] = $item;
		}
		$listfileindex++;
	}
}

// Get total input file length (mb)
$sourcefileinput_strlen = mb_strlen($sourcefileinputstr);

// Split file input into array $filedata at CrLf/Cr/Lf

// Use this for elements in source file count
if ($split_on_spaces == 1) {
	$sourcefiledata = preg_split('/[\s,]+/', $sourcefileinputstr);
} else {
	if ($split_on_chars == 1) {
		$sourcefiledata = preg_split('//u', $sourcefileinputstr);
	} else {
		$sourcefiledata = preg_split('/((\r(?!\n))|((?<!\r)\n)|(\r\n))/', $sourcefileinputstr);
	}
}
$sourcefiledatacount = count($sourcefiledata);
$listfiledatacount = count($listfiledata);

echo "Elements in source file = ".$sourcefiledatacount."<br>";
echo "<script> var sourceelements = ".json_encode($sourcefiledatacount)."; </script>";
echo "Elements in list file = ".$listfiledatacount."<br><br>";

/* echo print_r($_SESSION); */

echo "<script> var listelements = ".json_encode($listfiledatacount)."; </script>";

$stringspaces = array_keys($stringreplace);

$replacementstring = str_replace($stringspaces,$stringreplace,$sourcefileinputstr);
if ($split_on_spaces == 1) {
	$sourcefiledata = preg_split('/[\s,]+/', $replacementstring);
} else {
	if ($split_on_chars == 1) {
		$sourcefiledata = preg_split('//u', $replacementstring);
		$sfdcount = count($sourcefiledata);
		$sfd = $sourcefiledata;
		for($i=0;$i<$sfdcount;$i++) {
			if($sfd[$i] == '╬'){
				$i++;
				while($sfd[$i] != '╬'){
					$sfd[$i-1]=$sfd[$i-1].$sfd[$i];
					array_splice($sfd,$i,1);
				}
				$sfd[$i-1]=$sfd[$i-1].$sfd[$i];
				$sfdcount = count($sfd);
			}
		}
		// this for loop shouldn't be necessary
		// return to it when finished and hopefully
		// remove it
		for($i=0;$i<$sfdcount;$i++) {
			if($sfd[$i] == '╬') {
				array_splice($sfd,$i,1);
				$sfdcount = count($sfd);
			}
		}
		$sourcefiledata = $sfd;
	} else {
		$sourcefiledata = preg_split('/((\r(?!\n))|((?<!\r)\n)|(\r\n))/', $replacementstring);
	}
}

// *******
// Main loop: Compare window string to every string of equal length in file, rinse & repeat
// *******

$sourcefiledatacount = count($sourcefiledata);

// Set up the two-dimensional output array, put all source file elements into [x][0], and fill [x][1] with 0
$vtoutput = array();
for ($vtocount=0;$vtocount<$sourcefiledatacount;$vtocount++) {
	$vtoutput[$vtocount][0] = $sourcefiledata[$vtocount];
	$vtoutput[$vtocount][1] = 0;
}

// Set $vtoutput[x][1] as list item #, $vtoutput[x][2] as list item string

$maxlen = 0;
$maxID = 0;
$maxword = '';

for ($vtoc=0;$vtoc<$sourcefiledatacount;$vtoc++) {

	$len = mb_strlen($vtoutput[$vtoc][0]);
	if($len > $maxlen) {
		$maxlen = $len;
		$maxID = $vtoc;
		$maxword = $vtoutput[$vtoc][0];
	 }

	if ($exactmatch = 0) {

		if ($case_sensitive = 0) {
			$searchkey = array_search(strtolower($vtoutput[$vtoc][0]), $listfiledata, false);  	//ignore case, not strict
			if ($searchkey !== false) {
				$vtoutput[$vtoc][1] = $searchkey;
				$vtoutput[$vtoc][2] = $listfiledata[$searchkey];
				$vtoutput[$vtoc][0] = $listfiledata[$searchkey];

				$colorindex = array_search($listfiledata[$searchkey],$untrimmedlistfiledata,true);
				$vtoutput[$vtoc][3] = $colorindex;

				$searchkeysfoundcount++;
			}

		} else {
			$searchkey = array_search($vtoutput[$vtoc][0], $listfiledata, false);  				//case sensitive, not strict
			if ($searchkey !== false) {
				$vtoutput[$vtoc][1] = $searchkey;
				$vtoutput[$vtoc][2] = $listfiledata[$searchkey];
				$vtoutput[$vtoc][0] = $listfiledata[$searchkey];

				$colorindex = array_search($listfiledata[$searchkey],$untrimmedlistfiledata,true);
				$vtoutput[$vtoc][3] = $colorindex;

				$searchkeysfoundcount++;
			}

		}

	} else {  //exact match

		if ($case_sensitive = 0 ) {
			$searchkey = array_search(strtolower($vtoutput[$vtoc][0]), $listfilereplacement, true);  	//ignore case, strict
			if ($searchkey !== false) {
				$vtoutput[$vtoc][1] = $searchkey;
				$vtoutput[$vtoc][2] = $listfiledata[$searchkey];
				$vtoutput[$vtoc][0] = $listfiledata[$searchkey];

				$colorindex = array_search($listfiledata[$searchkey],$untrimmedlistfiledata,true);
				$vtoutput[$vtoc][3] = $colorindex;

				$searchkeysfoundcount++;

			}

		} else {

			$searchkey = array_search($vtoutput[$vtoc][0], $listfilereplacement, true);  				//case sensitive, strict
			if ($searchkey !== false) {
				// $vtoutput[$votc][0] = $listfiledata[$searchkey];
				$vtoutput[$vtoc][1] = $searchkey;
				$vtoutput[$vtoc][2] = $listfiledata[$searchkey];
				$vtoutput[$vtoc][0] = $listfiledata[$searchkey];

				$colorindex = array_search($listfiledata[$searchkey],$untrimmedlistfiledata,true);
				$vtoutput[$vtoc][3] = $colorindex;
				$searchkeysfoundcount++;

			}

		}

	}

}

// *******
// Send counts to screen, output to file
// *******

echo "<b>Visual Text Explorer key detection finished.<br><br>Total matches found : ".$searchkeysfoundcount."</b><br><br>Rendering Visual Output...<br><br>";
echo '<div id="loadingArea">';
echo '<div id="loadingBar"><span id="loadingSpan"></span></div>';
echo '</div>';
echo '<span id="pdfLoadingNotice">Rendering PDF</span>';
echo '<div id="pdfLoadingArea">';
echo '<div id="pdfLoadingBar"><span id="pdfLoadingSpan"></span></div>';
echo '</div>';
echo "<script>totalmatches = ".json_encode($searchkeysfoundcount).";</script>";

$keyinfo = array();
$listinfolen = count($listfiledata);

$i = 0;
foreach($listfiledata as $word) {
	$keyinfo[$i][0] = $word;
	$keyinfo[$i][1] = $i;
	$keyinfo[$i][2] = $word;
	$keyinfo[$i][3] = array_search($word, $untrimmedlistfiledata, true);
	$i++;
}



// *** Send form settings to Javascript ***
$line_thickness = $_POST['numch1'];		//default = 1 (pixels)
$_SESSION['numch1'] = $line_thickness;
$row_width_set = $_POST['splitat'];
$_SESSION['splitat'] = $row_width_set;
$display_text = $_POST['displaytext'];

echo '<script>';
// send data to Javascript
echo 'var listdata = ' . json_encode($listfiledata) . ';'; // keep this part
echo 'var sourcedata = ' . json_encode($sourcefiledata) . ';'; // not really used
echo 'var vtout = ' . json_encode($vtoutput) . ';';
echo 'var listtotal = ' . json_encode($listfiledatacount) . ';';
// send form settings to Javascript
echo 'var numch_px = ' . json_encode($line_thickness) . ';';
echo 'var row_width = ' . json_encode($row_width_set) . ';';
echo 'var disp_text = ' . json_encode($display_text) . ';';
echo 'var keyinfo_data = ' . json_encode($keyinfo) . ';';
echo 'var untrimmedlisttotal = ' . json_encode($untrimmedlistfiledatacount) . ';';
echo 'var vert = ' . json_encode($vertical) . ';';
echo 'var freq = ' . json_encode($frequency) . ';';
echo 'var righttoleft = ' . json_encode($right2left) . ';';
echo 'var split_on_spaces = ' . json_encode($split_on_spaces) . ';';
echo 'console.log("php case_sensitive: " + ' . json_encode($case_sensitive). ');';
echo 'var case_sensitive = ' . json_encode($case_sensitive) . ';';
echo 'var max_ID = ' . json_encode($maxID) . ';';
echo 'var max_len = ' . json_encode($maxlen) . ';';
echo 'var max_word = ' . json_encode($maxword) . ';';

echo '</script>';

/*
foreach ($lfd in $listfiledata) {
	echo $lfd."<br>";
}
*/

// Run Visualization (D3)
//include("vte_d3output.php");

?>
