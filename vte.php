<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
<?php header('Content-Type:text/html; charset=UTF-8'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Visual Text Explorer</title>
<meta name="abstract" content="Visual Text Explorer">
<meta name="description" content="Visual Text Explorer">
<meta name="keywords" content="Visual Text Explorer">
<meta name="robots" content="noarchive">
<script src="js/jquery.min.js"></script>
<script src="js/d3.v3.min.js"></script>

<!-- PDF SCRIPTS -->
<script src="js/blob-stream.js"></script>
<script src="js/pdfkit.js"></script>
<script src="js/filesaver.min.js"></script>

<style type="text/css" media="screen">	@import "css/main_input.css";</style>
<!-- <script src="digitaledoc_jsfunctions.js"></script> -->

</head>

<body>
	<!-- <?php echo print_r($_SESSION); ?> -->
	<div id="wrapper">
		<form name="TextfilesInputForm" id="tfisForm" method="POST" action="vte.php" enctype="multipart/form-data">
			<div id="newheader">
				<div id="headerleft">
					<div id="vte_logo">
						VISUAL<br>
						TEXT<br>
						EXPLORER
					</div>
					<div id="vte_beta">
						(horizontal beta 0.8)
					</div>
				</div>
				<div id="headermiddle">
					<div class="headermiddle">
						<h1>FILES</h1>
						<h3>SOURCE:<input id="sourcefile" type="file" name="sourcefile" value="Browse..."></h3>
						<h3>LIST:<input type="file" name="listfile" value="Browse..."></h3>
					</div>
					<div class="headermiddle">
						<h1>DISPLAY</h1>
						<h3>LINE THICKNESS (pixels):
						<!-- 	The code below inserts the session variabe for line thickness.
									If the session variable is not set, then it will default to the original option display.
						-->
						<select name="numch1">
							<?php

							if(isset($_SESSION['numch1'])) {
								$pixels = intval($_SESSION['numch1']);
								$options = array(1,2,3,4,5,6,7,8,9,10,12,14,20,24,36);
								foreach($options as $x) {
										echo '<option value="'.$x.'"';
										if($x == $pixels) { echo ' selected ';}
										if($x == 10) { echo '>' . $x. ' (default)';}
										else { echo '>'.$x;}
										echo '</option>';
								}
							}
							else {
								echo
										'<option value="1">1</option>
						        <option value="2">2</option>
						        <option value="3">3</option>
						        <option value="4">4</option>
						        <option value="5">5</option>
						        <option value="6">6</option>
						        <option value="7">7</option>
						        <option value="8">8</option>
						        <option value="9">9</option>
						        <option value="10" selected="selected">10 (default)</option>
						        <option value="12">12</option>
						        <option value="14">14</option>
						        <option value="20">20</option>
						        <option value="24">24</option>
						        <option value="36">36</option>';
							}
							?>
			      </select></h3>
						<h3>DISPLAY WIDTH (pixels):
						<select name="splitat">
							<!-- This adds in the session variable for row width -->
							<?php

							if(isset($_SESSION['splitat'])) {
								$width = intval($_SESSION['splitat']);
								$options = array(100,500,1000,2000,3000,5000,10000,-1);
								foreach($options as $x) {
										echo '<option value="'.$x.'"';
										if($x == $width) { echo ' selected ';}
										if($x == 1000) { echo '>' . $x. ' (default)';}
										else if($x == -1) { echo '>∞ (show all)'; }
										else { echo '>'.$x;}
										echo '</option>';
								}
							}
							else {
								echo
										'<option value="100">100</option>
						        <option value="500">500</option>
						        <option value="1000" selected="selected">1000 (default)</option>
										<option value="2000">2000</option>
										<option value="3000">3000</option>
										<option value="5000">5000</option>
						        <option value="10000">10000</option>
										<option value="-1">∞ (show all)</option>';
							}
							?>

			      </select></h3>
					</div>
				</div>
				<!-- 	These are the basic options for you to choose from. They also incorportate
							session variables so that you can have persistent settings
				-->
				<div id="headerright">
					<button type="button" class="accordion acc0 active">BASIC OPTIONS</button>
					<div class="panel pan0 show">
						<table>
							<tr>
								<td><input type="radio" name="orientation" value="horizontal" <?php
									if(isset($_SESSION['orientation'])) {
										if($_SESSION['orientation'] == "horizontal") { echo 'checked="checked"'; }
									}
									else { echo 'checked="checked"'; }
									?>>Horizontal display</td>

									<td><input type="radio" name="split" value="spacesplit"
									<?php
										if(isset($_SESSION['split'])) {
											if($_SESSION['split'] == "spacesplit") { echo 'checked="checked"'; }
										}
										else { echo 'checked="checked"'; }
									?>>Split on Spaces</td>

									<td><input type="checkbox" name="casesensitive" value="casesensitive" <?php
										if(isset($_SESSION['casesensitive'])) {
											if($_SESSION['casesensitive'] == "casesensitive") { echo 'checked="checked"'; }
										}
									?>>Case Sensitive</td>
							</tr>
							<tr>
								<td><input type="radio" name="orientation" value="vertical" <?php
									if(isset($_SESSION['orientation'])) {
										if($_SESSION['orientation'] == "vertical") {echo 'checked="checked"'; }
									}
								?>>Vertical Display</td>

								<td><input type="radio" name="split" value="charsplit" <?php
									if(isset($_SESSION['split'])) {
										if($_SESSION['split'] == "charsplit") { echo 'checked="checked"'; }
									}
								?>>Split on Characters</td>
								<td><input type="checkbox" name="frequency" value="frequency" <?php
									if(isset($_SESSION['frequency'])) {
										if($_SESSION['frequency'] == "frequency") { echo 'checked="checked"'; }
									}
								?>>Bar Height Frequency</td>
							</tr>
							<tr>
								<td style="padding-right: 10px"><input type="checkbox" name="right2left" value="right2left" <?php
									if(isset($_SESSION['right2left'])) {
										if($_SESSION['right2left'] == "right2left") { echo 'checked="checked"'; }
									}
								?>>Orient Right-to-Left</td>
								<td><input type="checkbox" name="rempunct" value="rempunct" <?php
									if(isset($_SESSION['rempunct'])) {
										if($_SESSION['rempunct'] == "rempunct") { echo 'checked="checked"'; }
									}
								?> disabled>Remove Punctuation</td>

							</tr>

						</table>

					</div>
					<button type="button" class="accordion acc1 ">ADVANCED OPTIONS</button>
					<div class="panel pan1">
						<table>
							<tr>
								<td><input type="checkbox" name="utf8" value="UTF8" checked="checked">Unicode (UTF-8)</td>
								<td><input type="checkbox" name="exactmatch" value="exactmatch" disabled>Use Wildcards</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="displaytext" value="displaytext" checked="checked" >Display Text</td>
								<td><input type="checkbox" name="showsteps" value="showsteps" checked="checked">Show All Steps</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="outputcsv" value="outputcsv" disabled>Output as CSV</td>
								<td><input type="checkbox" name="nlp" value="nlp" disabled>NLP Parsing</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div id="newRunButton">
				<h1>
					<input type="submit" name="Run_button" value="RUN">
					<input class="disabled" type="button" name="PDF_button" value="PDF" disabled>
					<input id="info_button" type="button" name="Info_button" value="INFO" onclick="showInfoPanel();">
				</h1>
			</div>

		</form>

	    <!-- <div id="header">
    	<form name="TextfilesInputForm" id="tfisForm" method="POST" action="vte.php" enctype="multipart/form-data">
      <?php //include("vte_textfilesinputform.php"); ?>
      </form>
 	  </div> -->

	  <div id="content">
			<div id='key'>
				<!--	keyleft is the location for the list key and the output from the php
				-->
				<div id='keyLeft'>
					<?php include("vte_textfilesupload.php"); ?>
				</div>
				<!-- keyright is currently empty -->
				<div id='keyRight'>

				</div>

			</div>
			<div id="info_panel_backdrop">
			</div>

			<!--	The info panel contains a how-to guide as well as a demo for the VTE
						The guide is currently unfinished
			-->
			<div id="info_panel">
				<h1>Visual Text Explorer Info</h1>
				<h1 style="border: none">
					<button name='intro'>Intro</button>
					<button name='basic'>Basic/Display</button>
					<button name='advanced'>Advanced</button>
					<button name='future'>Future</button>
				</h1>
				<div id="intro" class="info_content">
					Welcome to the Visual Text Explorer!<br><br>
					The VTE allows you to search a text for a list of words or characters and then highlight the words within the text.
					To get started, upload the text you would like to search as the SOURCE file (the file must be in a text file/.txt format).
					Then upload the words, phrases, or characters you would like to search for as the LIST file (this must also be a text file).
					You can list as many words, phrases, or characters as you'd like; just make sure you list each term you would like to search for on a new line. After you have uploaded your files and selected a few options, hit the run button.
					<br><br>
					A few lines of text will pop up to give you updates on what step of the process the VTE is currently on. After a few steps a loading bar will appear and the rows will begin to render. Once the bar is at 100%, the rendering is complete. A List Key will also pop-up to show you how each of the terms in your list file will be highlighted.
					<br><br>
					If you would like a PDF of the output from the VTE, just hit the PDF button. Another loading bar will pop up and show you how far along the VTE is in the rendering process. Don't worry if the loading bar stops around 95%. This just means the VTE is in the final steps of preparing you PDF.
					<br><br>
					To try the VTE, download the two files below, load them into the VTE and hit run.
					<br><br>
					<a href='tcupload/Demo_Source.txt' download>SOURCE</a><br>
					<a href='tcupload/Demo_List.txt' download>LIST</a><br><br>
				</div>
				<div id="basic" class="info_content">
					<u><strong>Display Options</strong></u>
					<br>
					These options dictate how the VTE will display the output.<br><br>
					<strong>Line Thickness:</strong> This option controls how thick the output bars will be as well as determine the size of font, so if you choose a line thickness of 10 px, then the output bars will be 10px wide and the font will be 10px tall.
					<br><br>
					<strong>Display Width:</strong> This options will changes how wide the rows will be. If 1000px is chosen as the width, then display will be separated into increments that are 1000px wide.
					<br><br>
					<u><strong>Basic Options</strong></u>
					<br>
					The basic options are tools you can use to change how the VTE searches for and displays your search terms and your text.
					Here is a breakdown of the basic options available.
					<br><br>
					<strong>Horizontal/Vertical Display:</strong> This option dictates how the rows will be displayed. Horizontal rows will run from left to right, and then break once they reach the designated Display Width. Vertical rows run from the top of the screen to the bottom of the screen and break once the Display Width is reached.
					<br><br>
					<strong>Split on Spaces/Characters:</strong> This option changes how the source text is parsed. The VTE will search for the objects in the list file, but once that is done this option decides how the rest of the text is parsed. If splitting on spaces, the VTE would parse "Visual Text Explorer" like this...<br><br>
					Visual / Text / Explorer<br><br>
					If splitting on characters, the VTE would parse it like this...<br><br>
					V / i / s / u / a / l / T / e / x / t / E / x / p / l / o / r / e / r<br><br>
					<strong>Case Sensitive:</strong> If turned on, then the matching done by the VTE will be case sensitive. Without case sensitivity, if "vte" was on the list file then it would match with "VTE" in the source file. With case sensitivity, "vte" would not match up with "VTE".
					<br><br>
					<strong>Bar Height Frequency:</strong> If selected, then the height of the bars will be dependent on how frequently they are found in the text.
					<br><br>
					<strong>Orient Right-to-Left:</strong> This option only works when the Vertical Display option is selected. This option displays vertical rows from right to left.
					<br><br>
					<strong>Remove Punctuation:</strong> This feature will be added at a later date. When added, it will give the option to remove punctuation from a text before the VTE searches for the terms in the list file.
					<br><br>
				</div>
				<div id="advanced" class="info_content">
					<u><strong>Advanced Options</strong></u>
					<br>
					These options are more technical and advanced options.
					<br><br>
					<strong>UTF-8:</strong> The default character encoding is UTF-8. This allows the VTE to parse text from practically any language. Turning this off turns off the UTF-8 encoding and reverts the VTE to ASCII characters.
					<br><br>
					<strong>Display Text:</strong> If turned off, the VTE will no longer display the text in the rows.
					<br><br>
					<strong>Show All Steps:</strong>
					<br><br>
				</div>
				<div id="future" class="info_content">
					<u><strong>Future Additions</strong></u>
					<br>
					These are some additions that will be made in the future. Some of them have already been added as options in the VTE; however, they are currently disabled.
					<br><br>
					<strong>Output as CSV:</strong>
					<br><br>
					<strong>Use Wildcards:</strong> This options will allow you to include wildcards in terms in your list file. An example of this would be "jump*". This term would then match up with "jump", "jumps", "jumped", and any other words that use "jump" as the root word.
					<br><br>
					<strong>NLP Parsing:</strong> This will introduce Natural Language Processing into the VTE's text processing.
				</div>
			</div>
        <!-- <h1><i>Visual Text Explorer</h1> -->
        <!--<p class="overview" style="margin-top: 0pt; margin-bottom: 0pt;">-->
        <?php //include("vte_textfilesupload.php"); ?>
        <br><br>

		<style>

		.domain {
			display: none;
		}

		</style>

		<!--	The svgWrapper is used to contain the vertical svg rows in order to make
					sure the flow off the page instead of going down the page
		-->
		<div id="svgWrapper" style="float:left">
		</div>

		<script>

		// ***** UI JAVASCRIPT ****** //
		// javascript that enables interaction for dropdowns in menu bar
		var acc = document.getElementsByClassName("accordion");
		var i;
		// add event listeners to both dropdowns
		for(i=0; i<acc.length;i++) {
			acc[i].onclick = function() {
				this.classList.toggle('active');
				this.nextElementSibling.classList.toggle('show');

				if($(this).hasClass('acc0')) {
					$('.acc1').removeClass('active');
					$('.pan1').removeClass('show');
				}
				else {
					$('.acc0').removeClass('active');
					$('.pan0').removeClass('show');
				}

			}
		}

		// Get settings from Form submit		// Settings/options
		var numpx = numch_px;								// line thickness
		var rowwidth = parseInt(row_width);	// row width
		var disptext = disp_text;						// display text
		var ldata = listdata;								// array of objects in list file
		var ltotal = listtotal;							// total number of objects in trimmed list file
		var keyinfo = keyinfo_data;					// information for they key
		var ultotal = untrimmedlisttotal;		// total number of objects in untrimmed list file
		var vertical = vert;								// triggers vertical display
		var right2left = righttoleft;				// right to left display
		var frequency = freq;								// triggers bar height frequency
		var spacesplit = split_on_spaces;		// 1 = split on spaces / 0 = split on characters
		var casesensitive = case_sensitive; // triggers case sensitivity
		var maxID = max_ID;									// index of longest word in source file
		var maxlen = max_len;								// length of longest word in source file
		var maxword = max_word;							// longest word in source file
		var colorEnhance = 1;								// triggers color enhancement
		var data = vtout; 									// data output from VTE backend php
		var i,j;
		var wordlist = {};
		var freqtotal = 0;
		// console.log('ltotal: '+ltotal);
		// console.log('ultotal: '+ultotal);
		// console.log(keyinfo);
		// console.log(ldata);


		// this takes care of the 'infinite'/display all option
		if(rowwidth == -1) {
			rowwidth = data.length * numpx;
		}

		// converts the options to their session values in case they have not already
		// been converted
		if(vert) { $('input[value="vertical"]').prop('checked', true); }
		else { $('input[value="horizontal"]').prop('checked', true); }

		if(casesensitive) { $('input[value="casesensitive"]').prop('checked', true); }
		else { $('input[value="casesensitive"]').prop('checked', false); }

		if(spacesplit) { $('input[value="spacesplit"]').prop('checked',true); }
		else { $('input[value="charsplit"]').prop('checked',true); }

		if(frequency) { $('input[value="frequency"]').prop('checked',true); }
		else { $('input[value="frequency"]').prop('checked',false); }

		if(right2left) { $('input[value="right2left"]').prop('checked',true); }
		else { $('input[value="right2left"]').prop('checked',false); }

		$('select[name="numch1"]').val(numpx);
		$('select[name="splitat"]').val(rowwidth);

		var yscale = d3.scale.linear().domain([0,ldata.length-1]).range([0,150]);
		var hscale = d3.scale.linear().domain([0,ldata.length-1]).range([150,0]);

		// if bar height frequency is turned on, this calculates the frequency of the
		// list terms in the source file
		if(frequency){
			for(i=0;i<ldata.length;i++) {
				wordlist[ldata[i]] = 0;
			}

			for(i=0;i<data.length;i++) {
				for(j=0;j<ldata.length;j++) {
					if(data[i][0] == ldata[j]) {
						wordlist[ldata[j]] += 1;
						freqtotal += 1;
					}
				}
		}

		for(j=0;j<ldata.length;j++) {
			wordlist[ldata[j]] = wordlist[ldata[j]]/freqtotal;
		}}

		var freqList = Object.keys(wordlist).sort(function(a,b) {return wordlist[a] - wordlist[b]});
		// console.log(wordlist);
		freqList = freqList.reverse();
		// console.log(freqList);
		// console.log(freqtotal);

/* ------------===============------------ */

		// sets the color of the bars
		// for color use lt = total number of items w/ spaces
		// will hopefully be updated to feature color modulation option to allow for
		// more colors
		var barColor = (function(d, lt){
			if (d.length > 2){ //|| d[0] == listdata[0]) {
				var hue = (1 / Number(lt)) * Number(d[3]);
				var ccol = hsvToRgb(hue, 1, 1);
				var colx = "rgb(";
				for (cct=0;cct<3;cct++) {
					colstr = Math.round(ccol[cct]).toString();
					if (cct<2) {
						colx = colx + colstr + ",";
					} else {
						colx = colx + colstr;
					}
				}
				colx = colx+")";
			} else {
				var colx = '#D3D3D3';
			}
			return colx;
		});

		// function designed to find the pixel width of an element
		// useful for dynamically adjusting the width of a div to hold all of the contents
		$.fn.textWidth = function(text, font) {
		    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
		    $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
		    return $.fn.textWidth.fakeEl.width();
		};

		$.fn.textWidthSize = function(text, size) {
		    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
		    $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', this.css('font')).css('font-size', size);
		    return $.fn.textWidth.fakeEl.width();
		};


		console.log($('input[name="orientation"]:checked').val());

		// width, height, and other useful dimension variables
		var w = rowwidth + 20;
		var h = 200;    // Number(ltotal) * Number(numpx);
		var rectHeight = h - 20;
		var rectWidth = rowwidth;
		var barPadding = 0.02*numpx; // padding is dependent on the width of the bars
		var totalHeight;

		/* CREATE LIST KEY */

		var dataset = vtout;
		var dvsn = rectHeight/ltotal; // used to properly position svg bars in the key
		var long, longIndex, word;
		long = 0;
		longIndex = 0;

		// for length/height of bars use total number of items w/o spaces
		// this is used to find the longest word/element in the listfile
		// this is used to properly adjust the width of the key

		for(i=0;i<ltotal;i++){
			word = ldata[i];
			if($.fn.textWidth(word) > long) {
				long = $.fn.textWidthSize(word,numpx + 'px');
				longIndex = i;
			}
		}

		// initialize svg for key
		var keySVG = d3.select('#keyLeftDropdown')//d3.select('body')
					.append('svg')
					.attr('width', h + 30 + long)
					.attr('height', ltotal * 20);

		// create g for each bar
		var colorBar = keySVG.selectAll('g')
				.data(keyinfo)
				.enter()
				.append('g')
				.attr('transform', function(d,i) {console.log(d); return 'translate(' + (long + 40) + ',' + i * 20 + ')'});

		// add rectangles
		colorBar.append('rect')
				.attr('width' , function(d,i) {
					if(frequency) {
						word = d[0];
						freq = wordlist[word];
						return 30 + 150*freq;
					}
					return hscale(i) + 30;//rectHeight - (dvsn*i);//(keyData[ldata[i]] * 20);
				})
				.attr('height', 20 - 1)
				.attr('fill', function(d,i) {
					var hue = (1 / Number(ultotal)) * Number(d[3]);
					var ccol = hsvToRgb(hue, 1, 1);
					var colx = "rgb(";
					for (cct=0;cct<3;cct++) {
						colstr = Math.round(ccol[cct]).toString();
						if (cct<2) {
							colx = colx + colstr + ",";
						} else {
							colx = colx + colstr;
						}
					}
					colx = colx+")";

				return colx;
			});

			// append text to key
			colorBar.append('text')
					.attr('x',-5)
					.attr('y',10)
					.attr('dy', '.35em')
					.text(function(d) {return d[0]})
					.style('text-anchor', 'end')
					.attr('font-family', 'cyberbit');
			console.log('list key ended');
			/* END LIST KEY */

			/* CREATE ROWS */

			var i,newDataset,inc,j, long, longIndex, totalRows;
			inc = Math.floor(rowwidth/numpx); // how many bars to include per row
			totalRows = Math.ceil(dataset.length/inc);
			// console.log('totalRows: ' + totalRows);
			var svgWidth = rowwidth + 25;

			// finds the width of the longest word in the source file
			// this is then used to create the proper measurements for the SVG rows
			var trueLongest = $.fn.textWidthSize(data[maxID][0], numpx + 'px') + 20;

			// if vertical expand the svgWrapper to the proper width to make room for the
			// incoming SVGs
			if(vertical) {
				$('#svgWrapper').width((185 + trueLongest) * (Math.ceil(dataset.length/inc)));
			}

			i = 0;
			console.log('preparing to render rows');
			function renderRows() {
			  var rectangles, text, key, end;

			  if(isNaN(inc)){
			    inc = dataset.length;
			    rowwidth = numpx*dataset.length;
			    svgWidth = 25 + rowwidth;
			  }
			  newDataset = dataset.slice(i,i+inc);
			  currRange = [i];

			  // adjust the number of bars if the newDataset.length is shorter than the other rows
			  if(newDataset.length < inc) {
			    end = i + newDataset.length;
			  }
			  else {
			    end = i + inc;
			  }

			  var SVGSelect;
			  if(vertical) {
			    SVGSelect = d3.select('#svgWrapper');
			  }
			  else {
			    SVGSelect = d3.select("body");
			  }

				// create a new row SVG and flaot as necessary
			  var SVG = SVGSelect//d3.select("body")
			        .append("svg")
			        .attr("width", function() {
			          if(vertical) { return 185 + trueLongest; }
			          else { return svgWidth; }
			        })
			        .attr("height", function() {
			          if(vertical) { return svgWidth; }
			          else { return 185 + trueLongest; }
			        })
			        .style('float', function() {
			          if(right2left && vertical) {return 'right'; }
			          else if(vertical) { return 'left'; }
			          else { return 'none'; }
			        });

				// creates rectangles
			  rectangles = SVG.append('g')
			      .attr('class','rectangles')
			      .attr('height', rectHeight)
			      .attr('width', rowwidth)
			      .attr('transform', function() {
			        if(vertical) { return 'rotate(90) translate(20,-'+(185+trueLongest)+')'; }
			        else { return 'translate(20,0)';}
			      });

			  rectangles.selectAll("rect")
			     .data(newDataset)
			     .enter()
			     .append("rect")
			     .attr("x", function(d, i) { return i * (rowwidth / inc); })
			     .attr("width", rowwidth / inc - barPadding)
			     .attr("fill", function(d) { return barColor(d, ultotal); })  //"OrangeRed");
			     .attr("y", function(d) {
			       if(d.length == 2) {
			         return 150;
			       }
			       else {
			         if(frequency) { return yscale((1-wordlist[d[0]])*(ltotal - 1)); }
			         return yscale(d[1]);
			       } })
			     .attr("height", function(d) {

			       if(d.length == 2) {
			         return rectHeight - 150;
			       }
			       else {
			          if(frequency) { return 30 + hscale((1-wordlist[d[0]])*(ltotal - 1)); }
			          return hscale(d[1]) + 30;
			       }
			     });

			  if(newDataset.length < inc) {
			    rowwidth = (end - i)*(rowwidth / inc - barPadding);
			  }

				// create text axis
			  var x = d3.scale.linear()
			          .domain([i,end])
			          .range([0,rowwidth]);

			  var xAxis = d3.svg.axis()
			      .scale(x)
			      .ticks(newDataset.length)
			      .tickFormat(function(d) { if(d != end) return dataset[d][0]; else return null;});

			  var axisg = SVG.append('g')
			    .attr('transform', function() {
			      if(vertical) { return 'rotate(90) translate(25,-' +(trueLongest-7) + ')'; }
			      else { return 'translate('+( 20 + numpx/2) + ',190)';}
			    });

			  key = SVG.selectAll('text')
			        .data(currRange)
			        .enter()
			        .append('text');

			  axisg.append('g')
			      .attr('class', 'x axis')
			      .attr('transform', 'translate(0,0)')
			      .call(xAxis)
			      .selectAll('text')
			      .attr('y',0)
			      .attr('x',9)
			      .attr('dy', '.35em')
						.attr('font-family', 'cyberbit')
			      .attr('transform','rotate(270)')
			      .style('text-anchor', 'end')
			      .style('font-size', numpx + 'px')
			      .style('text-align', 'right');


			  key.attr('x','-130')
			      .attr('y', '13')
			      .attr('font-size', '15px')
			      .attr('font-family', 'sans-serif')
			      .attr('fill','black')
			      .text(function(d) {return '' + (i+1) + '-' + end} )
			      .attr('transform', function() {
			        if(vertical) { return 'rotate(0) translate(250)';}
			        else { return 'rotate(270)'; }
			      })
						.attr('font-family', 'cyberbit');

				// show render loading bar
			  var bar = document.getElementById('loadingBar');
				var percent = end/dataset.length *100;

			  bar.style.width = percent + '%';

				// if percent is < 8% do not show the percentage
				if(percent < 8) {
					$('#loadingSpan').hide();
				}
				else {
					$('#loadingSpan').text(Math.round(percent) + '%');
					$('#loadingSpan').show();
				}

			  i += inc;

			  if(i<dataset.length) { window.setTimeout(renderRows, 0); }
				else { $('input[name=PDF_button]').prop('disabled', false).removeClass('disabled'); }
			}

			renderRows();

			// generates a new PDF
			function newPDF(x,y) {
				$('#pdfLoadingNotice').show();
				$('#pdfLoadingArea').show();
				var doc, stream, blob, h, w, margin, svgs, row, xml, arrayBuffer, keyWidth, keyHeight, key, totalX, totalY, rowHeight;

				// establish variables for page size
				key = $('#keyLeftDropdown');
				keyWidth = key.width();

				margin = 72;
				keyHeight = parseInt($('#keyLeftDropdown svg').attr('height')) + 2*margin;
				rowHeight = (y*totalRows + 2*margin);
				// console.log('row height: ' + rowHeight);
				// console.log('key height: ' + keyHeight);
				// console.log('max height: ' + Math.max(rowHeight, keyHeight));
				// console.log('key width: ' + keyWidth);

				if(vert) {
					w = keyWidth + x*totalRows + 3*margin;
					h = Math.max(y, keyHeight) + 2*margin;
				}
				else {
					w = x + keyWidth + 3*margin;
					h = Math.max(y*totalRows + 2*margin, keyHeight + 2*margin);
				}

				// totalX, totalY are used to track how the doc is shifted throughout the process
				totalX = 0;
				totalY = 0;
				console.log('this document is ' + (w/72) + ' inches wide and ' + (h/72) + ' inches tall');
				console.log('this document is ' + w + ' px wide and ' + h + ' px tall');

				// returns all svgs. first row is at svgs[1]
				svgs = d3.selectAll('svg')[0];

				// create PDF and blob stream
				doc = new PDFDocument({size: [w,h], margin: margin});
				stream = doc.pipe(blobStream());

				// register font /css/Cyberbit.ttf
				xml = new XMLHttpRequest;
				xml.open('GET', 'css/ARIALUNI.TTF', true);
				xml.responseType = "arraybuffer";
				xml.onload = function(event) {
					arrayBuffer = xml.response;
					if(arrayBuffer) {
						doc.registerFont('Cyberbit', arrayBuffer);
					}
				};
				xml.send(null);

				setTimeout(function() {
					// convert SVG rows
					var rectangles, axis, index, xShift, i, j, rect, rectx, recty, recth, rectw, fill, tick, text, textx, fontSize, keyGs;

					key = svgs[0];

					keyGs = $(key).children();

					xShift = $(keyGs[0]).attr('transform').split(',')[0];
					xShift = +xShift.replace('translate(', '') + margin;
					console.log('xShift[0]: ' + xShift);

					doc.translate(xShift,100);
					totalX += xShift;
					totalY += 100;
					j = 1;
					i = 0;
					function keyRender() {
						row = keyGs[i];
						rect = $(row).children()[0];
						rectw = $(rect).attr('width');
						recth = $(rect).attr('height');
						fill = $(rect).attr('fill');

						text = $(row).children()[1].innerHTML;
						textx = +$.fn.textWidth(text) + 50;

						doc.rect(0,20*i,rectw,19).fill(splitRGB(fill));
						doc.fill('black').font('Cyberbit').text(text,-textx-10,20*i+5,{width:textx, align:'right'});
						i++;

						var bar = document.getElementById('pdfLoadingBar');
						var percent;

						percent = i/keyGs.length * 10;
						bar.style.width = percent + '%';

						if(percent < 8) {
							$('#pdfLoadingSpan').hide();
						}
						else {
							$('#pdfLoadingSpan').text(Math.round(percent) + '%');
							$('#pdfLoadingSpan').show();
						}

						if(i<keyGs.length) { setTimeout(function() { keyRender(); }, 0); }
						else {
							doc.translate(-xShift,-100);
							totalY -= 100;
							totalX += -xShift;
							doc.translate(keyWidth,0);
							totalX += keyWidth;

							if(vert) {
								doc.translate(margin + keyWidth, margin);
								totalX += margin + keyWidth;
								totalY += margin;
								doc.rotate(90);
							}

							rowRender();
					 }
					}

					keyRender();

					function rowRender() {
						console.log('rowRender '+j);
						row = $(svgs[j]).children();
						rectangles = $(row[0]).children();
						axis = $($(row[1]).children()[0]).children();
						index = row[2];

						// rectangles
						xShift = $(rectangles[1]).attr('x') - $(rectangles[0]).attr('x');

						if(vert) {
							if(j != 1) doc.translate(0,-x);
							totalY -= x;
						}
						else {
							doc.translate(100,75+(j-1)*y);//.scale(0.8);
							totalY += 75+(j-1)*y;
							totalX += 100;
						}

						for(i=0;i<rectangles.length;i++) {
							rect = rectangles[i];
							rectx = $(rect).attr('x');
							recty = $(rect).attr('y');
							rectw = $(rect).attr('width');
							recth = $(rect).attr('height');
							fill = $(rect).attr('fill');
							if(!fill.includes('#')) { fill = splitRGB(fill); }
							doc.rect(rectx,recty,rectw,recth).fill(fill);
						}

						fontSize = parseInt($($(axis[0]).children()[1]).css('font-size'),10);
						doc.fontSize(fontSize).fill('black');

						for(i=0;i<rectangles.length;i++) {
							tick = $(axis[i]).children()[1];
							text = $(tick).text();
							if(fontSize > 12) {
								textx = +$.fn.textWidthSize(text, numpx + 'px')  + 70;
							}
							else {
								textx = +$.fn.textWidth(text) + 70;
							}
							if(i) {
								doc.translate(xShift,0);
								totalX += xShift;
							}
							doc.rotate(270);
							doc.translate(-183-textx,0);
							totalX += 0;
							totalY += 183+textx;
							doc.text(text,0,0,{width: textx, align: 'right'});
							doc.translate(183+textx,0);
							totalX += 0;
							totalY -= 183 + textx;
							doc.rotate(-270);

						}

						doc.translate(-(rectangles.length - 1)*xShift,0);
						totalX -= (rectangles.length - 1)*xShift;
						totalY += 0;
						doc.rotate(270);
						console.log($(index).text());
						doc.text($(index).text(),-130,-40);
						doc.rotate(-270);

						if(vert) {

						}
						else {
							doc.translate(-100, -75-(j-1)*y);//x -100
							totalX -= 100;
						}

						j++;

						var percent = 10 + j/svgs.length * 85;
						var loadingBar = document.getElementById('pdfLoadingBar');

						loadingBar.style.width = percent + '%';
						$('#pdfLoadingSpan').text(Math.round(percent) + '%');
						console.log(percent);

						if(j<svgs.length) { setTimeout(function() {rowRender();}, 10); }
						else {
							doc.end();
						}
					}

				}

				, 2000);

				stream.on('finish', function() {
					blob = stream.toBlob('application/pdf');
					saveAs(blob,'vte.pdf');
					document.getElementById('pdfLoadingBar').style.width = '100%';
					$('#pdfLoadingSpan').text(Math.round(percent) + '%');
				});

			}

			function splitRGB(color) {
				var i;
				color = color.split(',');
				for(i=0;i<3;i++) {
					color[i] = color[i].replace(/\D/g, '');
				}
				return color;
			}

		function hsvToRgb(h, s, v){
			var r, g, b;
			var i = Math.floor(h * 6);
			var f = h * 6 - i;
			var p = v * (1 - s);
			var q = v * (1 - f * s);
			var t = v * (1 - (1 - f) * s);
			switch(i % 6){
				case 0: r = v, g = t, b = p; break;
				case 1: r = q, g = v, b = p; break;
				case 2: r = p, g = v, b = t; break;
				case 3: r = p, g = q, b = v; break;
				case 4: r = t, g = p, b = v; break;
				case 5: r = v, g = p, b = q; break;
			}
			return [r * 255, g * 255, b * 255];
		}


		$('input[name=PDF_button]').click(function() {
			console.log('PDF button clicked');
			// w and h are the width and height of each row
			// newPDF will format the PDF around those two variables
			var w, h;
			if(vert) {
				w = 185 + trueLongest;
				h = svgWidth;
			}
			else {
				w = svgWidth;
				h = 185 + trueLongest;
			}

			newPDF(w,h);
		});

		$('#keyLeftButton').click(function() {
			var ddwidth = $('#keyLeftDropdown svg').width();
			var ddheight = $('#keyLeftDropdown svg').height() + 40;
			console.log($('#keyLeftButton').hasClass('active'));
			if(!$('#keyLeftButton').hasClass('active')) {
				$('#keyLeftButton').width(ddwidth-12);
				$('#keyLeftButton').addClass('active');
				$('#keyLeftDropdown').css('height',ddheight);
				$('#keyLeftDropdown').css('max-height',ddheight);
				$('#keyLeftDropdown').addClass('show');
			}
			else {
				$('#keyLeftButton').width(236);
				$('#keyLeftButton').removeClass('active');
				$('#keyLeftDropdown').css('height',0);
				$('#keyLeftDropdown').removeClass('show');

			}

		});

		function showInfoPanel() {
			console.log('showInfoPanel');
			var panel = $('#info_panel');
			var backdrop = $('#info_panel_backdrop');

			$('#info_panel button').removeClass('selected')

			$($('#info_panel button')[0]).addClass('selected');

			if(panel.css('display') == 'none') {
				panel.show();
				backdrop.show();
				$('.info_content').hide();
				$('.info_content').height(panel.height() - $('#info_panel h1').height()*2 - 22);
				$('#intro').show();
			}

			$(backdrop).click(function() {
				panel.hide();
				backdrop.hide();
			})

			$("#info_panel button").click(function() {
				var name = $(this).attr('name');
				$('#info_panel button').removeClass('selected')
				$('.info_content').hide();
				$('#info_panel button[name='+name+']').addClass('selected');
				$('#' + name).show();

			})
		}



		</script>

    </div>

<!--
		<div id="footer">
				<p><a href="http://edoc.uchicago.edu/vte/vte.php">Visual Text Explorer</a> hosted by <a href="http://rcc.uchicago.edu/">The University of Chicago</a> Research Computing Center<br>
				<a href="mailto:webmaster@edoc.uchicago.edu">Contact Webmaster:</a> webmaster@edoc.uchicago.edu</a><br>
				© 2016 All Rights Reserved</p>
		</div>
-->

	</div>

<!-- google analytics tracker -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36664665-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- end google analytics -->
</body>
