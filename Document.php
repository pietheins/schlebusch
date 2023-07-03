<?
if (isset($_GET['pic'])) {
	thumb ($_GET['pic']);
}
else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<!--
******************************************************************************
* Daaw Services (c) 2004 Michiel van den Berg                                *
* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^                                *
* This program is free software. You can redistribute it and/or modify       *
* it under the terms of the GNU General Public License as published by       *
* the Free Software Foundation; either version 2 of the License.             *
* ========================================================================== *
-->
<head>
<title>PHP Howto, Html voorbeeld</title>
</head>
<body bgcolor='#cc4444'>
<table border='0' width='100%'>
<tr>
<td rowspan='3' width='100'>&nbsp;</td>
<td id='head' align='center'>[ Logo Hier ]<br><br></td>
<td rowspan='3' width='100'>&nbsp;</td></tr>
<tr><td id='content' bgcolor='#cccccc'>

<!-- Tabel met 2 kolommen -->
<table border='0'>
<tr><td id='links' width='80'>
<table border='1' width='80' bgcolor='#44cc44'><tr><td>
* Link 1<br>
* Link 2<br>
* Link 3<br>
* Link 4<br>
</td></tr></table>
</td>
<td id='main' width='100%' align='center'>

<?
// Open de directory met de plaatjes
if ($handle = opendir('.')) {
  //Zolang er bestanden in de directory staan (true) lees deze uit
  // en gooi ze in de $file variabele
  while (false !== ($file = readdir($handle))) {
    // controleer of de extentie jpg, png of gif is.
    if (substr(strtolower($file),-3) == 'jpg' || substr(strtolower($file),-4) == 'jpeg' ||
		substr(strtolower($file),-3) == 'png' || substr(strtolower($file),-3) == 'gif') {
      // maak een array.
      $FileArray[]=$file;
    }
  }
  // Sluit de directory.
  closedir($handle);
}

echo "<table border='1'>";
$Table = 1;
for ($i=0;$i<count($FileArray);$i++) {
	if ($Table == 1) {
		echo "<tr><td>";
		$Table++;
	}
	elseif ($Table == 3) {
		echo "</td></tr>\n<tr><td>";
		$Table = 2;
	}
	else {
		echo "</td>\n<td>";
		$Table++;
	}
	echo "<a href='images/$FileArray[$i]' border='0'><img src='$PHP_SELF?pic=$FileArray[$i]'></a><br>";
}
echo "</td></tr></table>";
?>

</td></tr>
</table>
</td></tr>
<tr><td id='foot' align='center'> php tutorial (c) Michiel van den Berg en daaw.org 2004 </td></tr>
</table>
</body>
</html>

<?
}
function thumb ($plaatje) {
	$plaatje = 'images/' .$plaatje;
	$grootte = 150;

	// Laad het plaatje in het geheugen.
	if(substr(strtolower($plaatje),-3) == 'jpg' || substr(strtolower($plaatje),-4) == 'jpeg'){
		$InputPlaatje = @imageCreateFromJpeg($plaatje);
		$plaatje_extensie='jpg';
	}
	elseif(substr(strtolower($plaatje),-3) == 'gif'){
		$InputPlaatje = @imageCreateFromGIF($plaatje);
		$plaatje_extensie='gif';
	}
	elseif(eregi("png",$plaatje)){
		$InputPlaatje = @imageCreateFromPNG($plaatje);
		$plaatje_extensie='png';
	}

	// Als $InputPlaatje leeg is is er een fout opgetreden bij het inladen (foto beschadigd???) maak een plaatje met foutmelding.
	if (!$InputPlaatje) {
		$OutputPlaatje  = imagecreatetruecolor($grootte, $grootte); /* Create a blank image */
		$Achtergrond = imagecolorallocate($OutputPlaatje, 255, 255, 255);
		$Voorgrond  = imagecolorallocate($OutputPlaatje, 0, 0, 0);
		imagefilledrectangle($OutputPlaatje, 0, 0, $grootte, $grootte, $Achtergrond);
		imagestring($OutputPlaatje, 2, 10, 10, "Fout bij laden", $Voorgrond);
		imagestring($OutputPlaatje, 2, 10, 20, "Plaatje:", $Voorgrond);
		imagestring($OutputPlaatje, 2, 10, 30, "$plaatje", $Voorgrond);
		$plaatje_extensie='png';
	}

	// Als $InputPlaatje gevult is kunnen we het plaatje aanpassen.
	else {
		$PlaatjeGrootte = getimagesize($plaatje);
		$PlaatjeRatio = $PlaatjeGrootte[0]/$PlaatjeGrootte[1]; //Belangrijk om het plaatje niet uit te rekken.

		if ($PlaatjeGrootte[0] < $grootte && $PlaatjeGrootte[1] < $grootte) {
			// Als het input plaatje kleiner is dan $grootte, niet aanpassen
			$OutputPlaatje = $InputPlaatje;
		}
		else {
			if ($PlaatjeRatio > 1){
				$NieuweHoogte = $grootte;
				$NieuweBreedte = $grootte/$PlaatjeRatio;
			}

			else{
				$NieuweBreedte = $grootte;
				$NieuweHoogte = $grootte*$PlaatjeRatio;
			}

			$OutputPlaatje = imageCreateTrueColor($NieuweHoogte,$NieuweBreedte);
			@imageCopyResampled($OutputPlaatje, $InputPlaatje, 0, 0, 0, 0,$NieuweHoogte,$NieuweBreedte,$PlaatjeGrootte[0],$PlaatjeGrootte[1]);
		}
	}

	if($plaatje_extensie=='jpg'){
		header("Content-type: image/jpeg");
		imageJpeg($OutputPlaatje,'',80);
	}

	elseif($plaatje_extensie=='gif'){
		header("Content-type: image/gif");
		imageGIF($OutputPlaatje,'',80);
	}

	elseif($plaatje_extensie=='png'){
		header("Content-type: image/png");
		imagePNG($OutputPlaatje,'',80);
	}
}
?>
