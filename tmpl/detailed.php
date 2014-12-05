<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hbstandings/css/default.css');

//echo "<p>".JText::_('DESC_MODULE')."</p>";

if (count($standings)>0)
{

	// Headline
	if (!empty($headline)){
		echo '<h3>'.$headline.'</h3>';
	}

	if ($posLeague == 'above') {
		echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
	}

	// DETAILED standings
		echo "<table class=\"HBstandings HBhighlight\">";
		echo "<thead>";
		echo "<tr><th>Platz</th><th class=\"textteam\">Mannschaft</th>"
			. "<th>Sp.</th><th>S-U-N</th><th>S-U-N(H)</th><th>S-U-N(A)</th><th colspan=\"3\" class=\"goals\">Tore</th>"
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
				echo "<td>{$row->s}-{$row->u}-{$row->n}</td>";
				echo "<td>{$row->sH}-{$row->uH}-{$row->nH}</td>";
				echo "<td>{$row->sA}-{$row->uA}-{$row->nA}</td>";
				echo "<td class=\"goals\">{$row->tore}</td><td class=\"sepaDots\">:</td><td class=\"goalsCon\">{$row->gegenTore}</td>";
				echo "<td>{$row->torDiff}</td>";
				echo "<td class=\"points\"><strong>{$row->punkte}</strong></td><td class=\"sepaDots\">:</td><td class=\"negPoints\"><strong>{$row->minusPunkte}</strong></td></tr>\n";
			}
		echo "</tbody>";
		echo "</table>\n";
	



	if ($posLeague == 'underneath') {
		echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
	}
}
