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
		echo "<td>{$row->platz}</td><td class=\"textteam\"><strong>{$row->verein}</strong></td>";
		echo "<td>{$row->spiele}</td><td>{$row->siege}</td><td>{$row->unentschieden}</td><td>{$row->niederlagen}</td>";
		echo "<td>{$row->plustore}</td><td>:</td><td>{$row->minustore}</td>";
		$tordifferenz = $row->plustore-$row->minustore;
		echo "<td>{$tordifferenz}</td>";
		echo "<td><strong>{$row->pluspunkte}</strong></td><td>:</td><td><strong>{$row->minuspunkte}</strong></td></tr>\n";
	}
echo "</tbody>";
echo "</table>\n";


echo "<table class=\"HBstandings HBhighlight\">";
echo "<thead>";
echo "<tr><th>Platz</th><th class=\"textteam\">Mannschaft</th>"
	. "<th>Sp.</th><th>S</th><th>U</th><th>N</th><th colspan=\"3\">Tore</th>"
	. "<th>Diff.</th><th colspan=\"3\">Punkte</th></tr>";
echo "</thead>\n";

echo "<tbody>";
	foreach ($ranking as $index => $row) {
		// row in HBtabelle table
		echo "<tr";// class=\"{$row->background}";
		//if ($row->heimVerein) echo ' heim';
		echo "\">";
		echo "<td>{$index}</td><td class=\"textteam\"><strong>{$row->mannschaft}</strong></td>";
		echo "<td>{$row->spiele}</td><td>{$row->s}</td><td>{$row->u}</td><td>{$row->n}</td>";
		echo "<td>{$row->tore}</td><td>:</td><td>{$row->gegenTore}</td>";
		echo "<td>{$row->diff}</td>";
		echo "<td><strong>{$row->punkte}</strong></td><td>:</td><td><strong>{$row->nPunkte}</strong></td></tr>\n";
	}
echo "</tbody>";
echo "</table>\n";

if ($posLeague == 'underneath') {
	echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
}
