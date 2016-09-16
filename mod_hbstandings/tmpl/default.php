<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::stylesheet('mod_hbstandings/default.css', array(), true);

//echo "<p>".JText::_('DESC_MODULE')."</p>";

if (count($standings)>0)
{
	echo '<div class="hbstandings">';
	
	echo (!empty($headline)) ?  '<h3>'.$headline.'</h3>'."\n\n" : '';
	?>
<div class="team-table">
<?php
	if ($posLeague == 'above') {
		echo '<p>'.JText::_('MOD_HBSTANDINGS_LEAGUE').': '.
				$team->liga.' ('.$team->ligaKuerzel.')</p>';
	}
	
	?>
	<table>
		<thead>
			<tr>
				<th><?php echo JText::_('MOD_HBSTANDINGS_RANK');?></th>
				<th><?php echo JText::_('MOD_HBSTANDINGS_TEAM');?></th>
				<th><?php echo JText::_('MOD_HBSTANDINGS_GAMES');?></th>
				<th><?php echo JText::_('MOD_HBSTANDINGS_WINS');?></th>
				<th><?php echo JText::_('MOD_HBSTANDINGS_TIES');?></th>
				<th><?php echo JText::_('MOD_HBSTANDINGS_LOSSES');?></th>
				<th colspan="3"><?php echo JText::_('MOD_HBSTANDINGS_GOALS');?></th>
				<th><?php echo JText::_('MOD_HBSTANDINGS_GOALDIFFERENCE');?></th>
				<th colspan="3"><?php echo JText::_('MOD_HBSTANDINGS_POINTS');?></th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			foreach ($standings as $row) {
				?>
				<tr class="<?php echo ($row->heimVerein) ? ' highlighted' :'';?>">
					<td><?php echo $row->platz;?></td>
					<td><?php echo $row->mannschaft?></td>
					<td><?php echo $row->spiele?></td>
					<td><?php echo $row->s?></td>
					<td><?php echo $row->u?></td>
					<td><?php echo $row->n?></td>
					<td><?php echo $row->tore?></td>
					<td>:</td>
					<td><?php echo $row->gegenTore?></td>
					<td><?php echo $row->torDiff?></td>
					<td><?php echo $row->punkte?></td>
					<td>:</td>
					<td><?php echo $row->minusPunkte?></td>
				</tr>
				<?php
			}
		?>
		</tbody>
	</table>

<?php
	if ($posLeague == 'underneath') {
		echo '<p>'.JText::_('MOD_HBSTANDINGS_LEAGUE').': '.
				$team->liga.' ('.$team->ligaKuerzel.')</p>';
	}
	
	echo '</div>';
echo '</div>';
}
?>
