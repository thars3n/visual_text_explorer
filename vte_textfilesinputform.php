<?php session_start(); ?>

			<table width="1125" border="0">

      <tr><td style="width:75px; height:14px; vertical-align:text-top; text-align:center;"></td>
      <td style="width:700px; height:20px;"><h3><b><i><big>Visual Text Explorer (Horizontal beta 0.5)</big></i></b></h3></td>
      <td style="width:700px; height:20px;"><h3><b><i><big><a href="../vte/index.html">Vertical</a></big></i></b></h3></tr>

      <tr><td style="width:100px; height:6px; vertical-align:text-top; text-align:center;"></td></tr>

      <tr><td style="width:100px; height:14px; vertical-align:text-top; text-align:center;" colspan="4">
      <h3>&nbsp;&nbsp;Source File:&nbsp;&nbsp;
      <input type="file" name="sourcefile" id="sourcefile" value="Browse..." style="width:800px; font-weight:bold; border:0; resize:none;"></td>
      </tr>

      <tr><td style="width:100px; height:14px; vertical-align:text-top; text-align:center;" colspan="4">
      <h3>&nbsp;&nbsp;List File:&nbsp;&nbsp;
      <input type="file" name="listfile" id="listfile" value="Browse..." style="width:800px; font-weight:bold; border:0; resize:none;"></td>
      </tr>

      <tr><td style="width:100px; height:14px; vertical-align:text-top; text-align:center;" colspan="2">
      <input type="checkbox" name="utf8" value="UTF8" checked="checked"><b>Unicode (UTF-8)</b></td>
      <td style="width:850px; height:14px; vertical-align:text-top; text-align:right;"></td>
      </tr>

      <tr><td style="width:400px; height:6px; vertical-align:text-top; text-align:left;" colspan="5"></td></tr>

      <tr><td style="width:400px; height:14px; vertical-align:text-top; text-align:left;">
      <h3>Line thickness (in pixels) :&nbsp;&nbsp;
      <select name="numch1">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10" selected="selected">10</option>
        <option value="12">12</option>
        <option value="14">14</option>
        <option value="20">20</option>
        <option value="24">24</option>
        <option value="36">36</option>
      </select></h3></td>
	  <td style="width:300px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="displaytext" value="displaytext"  checked="checked">
      Display text</h3></td>
      <td style="width:300px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="exactmatch" value="exactmatch">
      Exact matching</h3></td>
      <td style="width:450px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="spacesplit" value="spacesplit" checked="checked">
      Split on spaces</h3></td>
      <td style="width:450px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="charsplit" value="charsplit">
      Split on characters</h3></td>
      </tr>

      <tr><td style="width:400px; height:6px; vertical-align:text-top; text-align:left;" colspan="5"></td></tr>

      <tr><td style="width:400px; height:14px; vertical-align:text-top; text-align:left;">
      <h3>Row width (in pixels) :&nbsp;&nbsp;
      <select name="splitat" disabled>
        <option value="100">100</option>
        <option value="500">500</option>
        <option value="1000" selected="selected">1000</option>
        <option value="10000">10000</option>
      </select></h3></td>
      <td style="width:300px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="outputcsv" value="outputcsv" disabled>
      Output as CSV file</h3></td>
      <td style="width:300px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="casesensitive" value="casesensitive">
      Case Sensitive</h3></td>
      <td style="width:300px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="rempunct" value="rempunct">
      Remove punctuation</h3></td>
      <td style="width:300px; height:14px; vertical-align:text-top; text-align:left;">
      <h3><input type="checkbox" name="showsteps" value="showsteps" checked="checked">
      Show all steps</h3></td>
      </tr>

      <tr><td style="height:10px;"></td></tr>
      <tr><td style="height:10px;"></td><td style="width:1050px; height:14px; vertical-align:text-top; text-align:left;" colspan="4">
      <input type="submit" name="Run_button" value="Run Visual Text Explorer..." style="font-weight:bold; font-size:16px; width:400px;"></td></tr>

      </table>
