<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


JHtml::stylesheet('mod_hbstandings/default.css', array(), true);

//echo "<p>".JText::_('DESC_MODULE')."</p>";

if (count($standings)>0)
{
	echo '<div class="hbstandings">';
	
	// Headline
	if (!empty($headline)){
		echo '<h3>'.$headline.'</h3>';
	}
	?>
<div class="team-table">
	<?php
	if ($posLeague == 'above') {
		echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
	}

	// DETAILED standings
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>Platz</th><th class=\"textteam\">Mannschaft</th>"
			. "<th>Sp.</th><th>S-U-N</th><th class=\"less4mobile\">S-U-N(H)</th><th class=\"less4mobile\">S-U-N(A)</th><th colspan=\"3\" class=\"goals\">Tore</th>"
			. "<th class=\"less4mobile\">Diff.</th><th colspan=\"3\">Punkte</th></tr>";
		echo "</thead>\n";

		echo "<tbody>";
			foreach ($detailedStandings as $row) {
				// row in HBtabelle table
				echo "<tr class=\"{$row->background}";
				if ($row->heimVerein) echo " highlighted";
				echo "\">";
				echo "<td>{$row->platz}</td><td class=\"textteam\"><strong>{$row->mannschaft}</strong></td>";
				echo "<td>{$row->spiele}</td>";
				echo "<td>{$row->s}-{$row->u}-{$row->n}</td>";
				echo "<td class=\"less4mobile\">{$row->sH}-{$row->uH}-{$row->nH}</td>";
				echo "<td class=\"less4mobile\">{$row->sA}-{$row->uA}-{$row->nA}</td>";
				echo "<td class=\"goals\">{$row->tore}</td><td class=\"sepaDots\">:</td><td class=\"goalsCon\">{$row->gegenTore}</td>";
				echo "<td class=\"less4mobile\">{$row->torDiff}</td>";
				echo "<td class=\"points\"><strong>{$row->punkte}</strong></td><td class=\"sepaDots\">:</td><td class=\"negPoints\"><strong>{$row->minusPunkte}</strong></td></tr>\n";
			}
		echo "</tbody>";
		echo "</table>\n";

	if ($posLeague == 'underneath') {
		echo '<p>Spielklasse: '.$team->liga.' ('.$team->ligaKuerzel.')</p>';
	}
	echo '</div>';
}
?>
</div>