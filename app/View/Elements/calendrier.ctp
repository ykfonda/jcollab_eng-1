<?php 
function createDateRangeArray($strDateFrom,$strDateTo){
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $array[] = $date->format($format); 
    }

    return $array;
}

?>
<!-- ############################################################################################### -->
<?php 
	$year_start 	= 2016 ;
	$month_start 	= 1 ;
	$day_start 		= 1 ;

	//$date_start 	= $year_start.'-'.$month_start.'-'.$day_start;
	//$date_end = date('Y-m-d', strtotime('+12 months -1 days', strtotime($date_start)) );

	$date_start 	= date('Y-m-d', strtotime($this->data['Filter']['date1']));
	$date_end 	= date('Y-m-d', strtotime($this->data['Filter']['date2']));

	$dates = getDatesFromRange($date_start, $date_end);
	//debug( $date_start );
	//debug( $date_end );

	$months = getDatesFromRange($date_start, $date_end, '01-m-Y');
	//debug($months);
	$months = array_count_values($months);
	//debug($months);

	$jours = array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam');
	$mois = array(
		'01' => 'Janvier',
		'02' => 'Février',
		'03' => 'Mars',
		'04' => 'Avril',
		'05' => 'Mai',
		'06' => 'Juin',
		'07' => 'Juillet',
		'08' => 'Août',
		'09' => 'Septembre',
		'10' => 'Octobre',
		'11' => 'Novembre',
		'12' => 'Décembre'
	);

?>
<table id="example" border="1" >
	<thead>
		<tr>
			<th rowspan="3" style="text-align:center;padding:4px;">Calendrier</th>
			<?php foreach ($months as $k => $v): ?>
				<th class="month" colspan="<?php echo $v ?>" style="text-align:center;padding:4px;background-color: #e6e6e6;">
					<?php echo $mois[ date('m', strtotime($k)) ]. ' ' . date('Y', strtotime($k)); ?>
				</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<!-- <th nowrap="">Jour</th> -->
			<?php foreach ($dates as $k => $v): ?>
				<?php if ($v == date('Y-m-d')): ?>
					<th class="today" style="text-align:center;padding:4px;">
				<?php else: ?>
					<th style="text-align:center;padding:4px;">
				<?php endif ?>
						<?php echo $jours[date('w', strtotime($v))]; ?>
					</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<!-- <th nowrap="">Employé</th> -->
			<?php foreach ($dates as $k => $v): ?>
				<?php if ($v == date('Y-m-d')): ?>
					<th class="today" style="text-align:center;center;padding:4px;">
				<?php else: ?>
					<th style="text-align:center;padding:4px;">
				<?php endif ?>
						<?php echo date('d', strtotime($v)); ?>
					</th>
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $kTier => $tier): ?>
			<tr>
				<td class="headcol name" nowrap style="text-align:left;center;padding:5px;background-color:#d5e3f2">
					<?php echo String::truncate($tier['name'], 19); ?>
				</td>
				<?php foreach ($dates as $kDate => $date): ?>
					<?php $column = null; $url = null; $text = ''; ?>
					<?php if (date('w', strtotime($date)) == 0): ?>
						<td class="cell weekend" style="text-align:center;center;padding:2px;"> - </td>
					<?php else: ?>
						<td class="cell hovered" nowrap style="text-align:center;center;padding:2px;">
							<?php foreach ($tier['values'] as $abs): ?>
								<?php $from = date('Y-m-d', strtotime($abs['from'])); $to = date('Y-m-d', strtotime($abs['to'])); ?>
								<?php if ($date >= $from && $date <= $to): ?>
									<?php $column = $abs['customClass']; $url = $abs['dataUrl']; $text = $abs['text']; $title = $abs['title']; ?>		
									<a href="<?php echo $url ?>"><span><i class="popovers fa fa-circle <?php echo $column ?>" data-trigger="hover" data-container="body" data-placement="top" data-original-title="<?php echo $title ?>" data-content="<?php echo $text ?>"></i></span></a>									
								<?php endif ?>
							<?php endforeach ?>
							<?php if ( empty($column) ): ?>
								<span> - </span>
							<?php endif ?>
						</td>
					<?php endif ?>
				<?php endforeach ?>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>