<div class="table-scrollable" style="height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Magasin</th>
				<th nowrap="">Caisse</th>
				<th nowrap="">Ticket</th>
				<th nowrap="">Date</th>
				<th nowrap="">Heure</th>
				<th nowrap="">Mnt(HT)</th>
				<th nowrap="">Taxe</th>
				<th nowrap="">Mnt(TTC)</th>
				<th nowrap="">Mode 1</th>
				<th nowrap="">Montant 1</th>
				<th nowrap="">Mode 2</th>
				<th nowrap="">Montant 2</th>
				<th nowrap="">Remise</th>
				
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $dossier): ?>
			<tr>
				<td nowrap="" style="
    color: #7367F0;
    text-decoration: none;
    background-color: transparent;    text-shadow: none;
    font-size: 14px;
    font-weight: 500;">
				
						<?php echo h($dossier['Store']['libelle']); ?>
					
				</td>
				<td nowrap="" ><?php echo h($dossier['Caisse']['libelle']); ?></td>
				<td nowrap=""><a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Salepoint']['id']]) ?>"><?php echo h($dossier['Salepoint']['reference']); ?></a></td>
				
				<td nowrap=""><?php echo h(date('d-m-Y', strtotime($dossier['Salepoint']['date']))); ?></td>
				<td nowrap=""><?php echo h(date('H:i:s', strtotime($dossier['Salepoint']['date']))); ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h($dossier['Salepoint']['total_a_payer_ht']); ?></td>
				
				<td nowrap="" class="text-right total_number"><?php echo number_format($dossier['Salepoint']['montant_tva'], 2, ',', ' '); ?></td>
				<td nowrap="" class="text-right total_number"><?php echo number_format($dossier['Salepoint']['total_apres_reduction'], 2, ',', ' '); ?></td>
				<td nowrap="" class="text-right"><?php echo ($dossier['Avance'][0]['montant'] != "0.00") ? $dossier['Avance'][0]['mode'] : "" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo ($dossier['Avance'][0]['montant'] != "0.00") ? number_format($dossier['Avance'][0]['montant'], 2, ',', ' ') : ""; ?></td>
				<td nowrap="" class="text-right total_number"><?php echo ($dossier['Avance'][1]['montant'] != "0.00") ? $dossier['Avance'][1]['mode'] : ""  ?></td>
				<td nowrap="" class="text-right total_number"><?php echo ($dossier['Avance'][1]['montant'] != "0.00") ? number_format($dossier['Avance'][1]['montant'], 2, ',', ' ') : ""; ?></td>
				<td nowrap="" class="text-right total_number"><?php echo number_format($dossier['Salepoint']['remise'], 2, ',', ' '); ?></td>
				
				<td nowrap="" class="actions">
					<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Salepoint']['id']]) ?>"><i class="fa fa-eye"></i></a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
			<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.'))); ?>
		</div>
	</div>
	<div class="col-md-7 col-sm-12">
		<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
			<ul class="pagination">
				<?php 
				    echo $this->Paginator->prev( '<', array( 'class' => 'page-link', 'tag' => 'li' ), null,  array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				    echo $this->Paginator->numbers( array( 'class' => 'page-link', 'tag' => 'li', 'separator' => '', 'currentClass' => 'page-link active', 'currentTag' => 'a' ) );
				    echo $this->Paginator->next( '>', array( 'class' => 'page-link', 'tag' => 'li' ), null, array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				?>
			</ul>
		</div>
	</div>
</div>