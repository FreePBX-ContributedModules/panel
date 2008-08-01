<?php
//Copyright (C) 2008 ATL Telecom Ltd
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

$numbuttonsx = 4;
$numbuttonsy = 20;

$itemnames = array(legend,startpos,stoppos,color1,color2);
$buttontypes = array(extension,trunk,queue,conference,parking);

foreach ($_REQUEST as $key => $value) {${$key} = $value;}

//if submitting form, update database

if (isset($Add)) {
list($action,$id) = explode(" ",$Add);
$legend = ucfirst($id);
$sql="INSERT INTO `panel` ( `id` , `legend` , `startpos` , `stoppos` , `color1` , `color2` ) VALUES ('$id', '$legend' , 29, 52, '777777', '777777');";
sql($sql);
}
if (isset($Delete)) {
list($action,$id) = explode(" ",$Delete);
$sql="DELETE FROM `panel` WHERE id = '$id';";
sql($sql);
}

if (isset($Submit)) {

$sql = "SELECT id FROM panel";
$panelids = $db->getAll($sql);
if(DB::IsError($panelrows)) {
die($panelrows->getMessage());
}

foreach ($panelids as $panelid) {
	$startpos = ${$panelid[0]."-startpos"};
	$stoppos = ${$panelid[0]."-stoppos"};
	if (($startpos > $numbuttonsx*$numbuttonsy) || ($startpos <= 0)) {die("ERROR: Start-Position out of range in '{$panelid[0]}' ");}
	if (($stoppos > $numbuttonsx*$numbuttonsy) || ($stoppos <= 0)) {die("ERROR: Stop-Position out of range in '{$panelid[0]}' ");}
	if ( ($startpos-1)%$numbuttonsy > ($stoppos-1)%$numbuttonsy ) {die("ERROR: Negative vertical size in '{$panelid[0]}' ");}
	if ( $startpos > $stoppos ) {die("ERROR: Negative horizontal size in '{$panelid[0]}' ");}
	$sql = "UPDATE panel SET ";
	foreach ($itemnames as $itemname) { $key = $panelid[0]."-".$itemname; $sql .= " $itemname = '${$key}',";}
	$sql = substr($sql,0,-1);
	$sql .= " WHERE id = '$panelid[0]'";
	sql($sql);
}
	//indicate 'need reload' link in header.php
	needreload();
}

//get all rows relating to selected account
$sql = "SELECT * FROM panel ORDER BY startpos";
$panelrows = $db->getAll($sql);
if(DB::IsError($panelrows)) {
die($panelrows->getMessage());
}


?>

<form name="panel" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">


<h2><?php echo _("Operator Panel Layout")?></h2>
<p>
<?php
foreach ($buttontypes as $buttontype) {
	$action = "Add";
	foreach ($panelrows as $panelrow) {
		if ($panelrow[0] == $buttontype) {$action = "Delete";}
	}
	echo "<input name='$action' type='submit' value='$action $buttontype area'/>\n";
}
?>
</p>
<table>
<tr><td>&nbsp;</td><td>Legend</td><td>Start Position</td><td>Stop Position</td><td>Main Color</td><td>Gradient Color</td></tr>
<?php
foreach ($panelrows as $panelrow) {
	$rowheading = array_shift($panelrow);
	echo "<tr><td>". ucfirst($rowheading) . "</td>";
	$i=0;
	foreach ($panelrow as $panelitem) {
		echo "<td><input name='$rowheading-${itemnames[$i++]}' type='text' value='$panelitem'/></td>\n";
	}
}
?>
</table>
<h6>
	<input name="Submit" type="submit" value="<?php echo _("Submit Changes")?>">
</h6>
<h5><?php echo _("Layout Preview")?></h5>
<table  border='1'>
<?php
for($i=0;$i<$numbuttonsy;$i++) {
	echo "<tr>";
	for($j=0;$j<$numbuttonsx;$j++) {
		$num = 1 + $i + $numbuttonsy*$j;
		$allocation = "";
		foreach ($panelrows as $panelrow) {
			$legend = $panelrow[1];
			$startpos = $panelrow[2];
			$stoppos = $panelrow[3];
			$button = ucfirst($panelrow[0]) . " button";
			$startx = ($startpos-1)%$numbuttonsy;
			$stopx = ($stoppos-1)%$numbuttonsy;
			$starty = floor(($startpos-1)/$numbuttonsy);
			$stopy = floor(($stoppos-1)/$numbuttonsy);
			if ($num == $startpos) {$allocation .= "<br /><strong>\"$legend\"</strong>";}
			elseif (($startx <= $i) && ($stopx >= $i) && ($starty <= $j) && ($stopy >= $j)) {$allocation.= "<br /><strong>$button</strong>";}

		}
		if ($allocation == "") {$allocation = "<br />Unused";}
		echo "<td align='center' width='200'>Position $num $allocation</td>";
	}
	echo "</tr>";
}
?>

</table>

</form>

