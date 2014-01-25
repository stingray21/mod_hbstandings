<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hbstandings/css/default.css');

if ($tabelleTableExists)
{
	
	//echo "<p>".JText::_('DESC_MODULE')."</p>";
	
	// Headline
	echo '<h3>';
	switch ($headline)
	{
		case 'title':
			echo 'Tabelle';
			break;
		case 'not':
			break;
		case 'title':
		default:
			echo 'Tabelle - '.$mannschaft->mannschaft;
			break;
	}
	echo '</h3>';
	
	if ($posLeague == 'above') echo '<p>Spielklasse: '.$mannschaft->liga.' ('.$mannschaft->ligaKuerzel.')</p>';
	
	$background = false;
	echo "<table class=\"HBstandings HBhighlight\">";
	echo "<thead>";
	echo "<tr><th>Platz</th><th class=\"textteam\">Mannschaft</th><th>Sp.</th><th>S</th><th>U</th><th>N</th><th colspan=\"3\">Tore</th><th>Diff.</th><th colspan=\"3\">Punkte</th></tr>";
	echo "</thead>\n";
	
	echo "<tbody>";
		foreach ($rows as $row) {
			// switch color of background
			if (!empty($row->Platz)) $background = !$background;
			// check value of background
			switch ($background) {
				case true: $backgroundColor = 'odd'; break;
				case false: $backgroundColor = 'even'; break;
			}
			// row in HBtabelle table
			echo "<tr class=\"{$backgroundColor}";
			if ($highlightHomeTeam) echo markHeimInTabelle($row->Verein, $mannschaft->name);
			echo "\">";
			echo "<td>{$row->Platz}</td><td class=\"textteam\"><strong>{$row->Verein}</strong></td>";
			echo "<td>{$row->Spiele}</td><td>{$row->Siege}</td><td>{$row->Unentschieden}</td><td>{$row->Niederlagen}</td>";
			echo "<td>{$row->Plustore}</td><td>:</td><td>{$row->Minustore}</td>";
			$tordifferenz = $row->Plustore-$row->Minustore;
			echo "<td>{$tordifferenz}</td>";
			echo "<td><strong>{$row->Pluspunkte}</strong></td><td>:</td><td><strong>{$row->Minuspunkte}</strong></td></tr>\n";
		}
	echo "</tbody>";
	echo "</table>\n";
	
	if ($posLeague == 'underneath') echo '<p>Spielklasse: '.$mannschaft->liga.' ('.$mannschaft->ligaKuerzel.')</p>';
	
		echo $data;
	
	
}