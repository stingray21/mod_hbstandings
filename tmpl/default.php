<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hbstandings/css/default.css');

//echo "<p>".JText::_('DESC_MODULE')."</p>";

// Headline
if (!empty($headline)){
	echo '<h3>'.$headline.'</h3>';
}

if ($posLeague == 'above') {
	echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
}

echo "<table class=\"HBstandings HBhighlight\">";
echo "<thead>";
echo "<tr><th>Platz</th><th class=\"textteam\">Mannschaft</th>"
	. "<th>Sp.</th><th>S</th><th>U</th><th>N</th><th colspan=\"3\">Tore</th>"
	. "<th>Diff.</th><th colspan=\"3\">Punkte</th></tr>";
echo "</thead>\n";

echo "<tbody>";
	foreach ($standings as $row) {
		// row in HBtabelle table
		echo "<tr class=\"{$row->background}";
		if ($row->heimVerein) echo ' heim';
		echo "\">";
		echo "<td>{$row->platz}</td><td class=\"textteam\"><strong>{$row->mannschaft}</strong></td>";
		echo "<td>{$row->spiele}</td><td>{$row->siege}</td><td>{$row->unentschieden}</td><td>{$row->niederlagen}</td>";
		echo "<td>{$row->tore}</td><td>:</td><td>{$row->gegenTore}</td>";
		echo "<td>{$row->torDifferenz}</td>";
		echo "<td><strong>{$row->punkte}</strong></td><td>:</td><td><strong>{$row->minusPunkte}</strong></td></tr>\n";
	}
echo "</tbody>";
echo "</table>\n";

// DETAILED standings
echo "<table class=\"HBstandings HBhighlight\">";
echo "<thead>";
echo "<tr><th>Platz</th><th class=\"textteam\">Mannschaft</th>"
	. "<th>Sp.</th><th>S-U-N</th><th>S-U-N(H)</th><th>S-U-N(A)</th><th colspan=\"3\">Tore</th>"
	. "<th>Diff.</th><th colspan=\"3\">Punkte</th></tr>";
echo "</thead>\n";

echo "<tbody>";
	foreach ($detailedStandings as $row) {
		// row in HBtabelle table
		echo "<tr class=\"{$row->background}";
		if ($row->heimVerein) echo ' heim';
		echo "\">";
		echo "<td>{$row->platz}</td><td class=\"textteam\"><strong>{$row->mannschaft}</strong></td>";
		echo "<td>{$row->spiele}</td>";
		echo "<td>{$row->siege}-{$row->unentschieden}-{$row->niederlagen}</td>";
		echo "<td>{$row->siegeH}-{$row->unentschiedenH}-{$row->niederlagenH}</td>";
		echo "<td>{$row->siegeA}-{$row->unentschiedenA}-{$row->niederlagenA}</td>";
		echo "<td>{$row->tore}</td><td>:</td><td>{$row->gegenTore}</td>";
		echo "<td>{$row->torDifferenz}</td>";
		echo "<td><strong>{$row->punkte}</strong></td><td>:</td><td><strong>{$row->minusPunkte}</strong></td></tr>\n";
	}
echo "</tbody>";
echo "</table>\n";



if ($posLeague == 'underneath') {
	echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
}
