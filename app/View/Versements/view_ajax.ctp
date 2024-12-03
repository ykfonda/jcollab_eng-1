<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Client</th>
				<th nowrap="">Référence</th>
				<th nowrap="">Vente</th>
				<th nowrap="">Date</th>
				<th nowrap="">Montant</th>
				<th nowrap="">Statut</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($avances as $tache): ?>
				<tr>
					<td nowrap=""><?php echo h($tache['Client']['designation']); ?></td>
					<td nowrap=""><?php echo h($tache['Avance']['reference']); ?></td>
					<td nowrap=""><?php echo h($tache['Vente']['reference']); ?></td>
					<td nowrap="">
						<?php echo h($tache['Avance']['date']); ?>
						<?php echo $this->Form->input('Avance.'.$tache['Avance']['id'].'.id',['type'=>'hidden','value'=>$tache['Avance']['id']]); ?>
					</td>
					<td nowrap="">
						<?php echo $this->Form->input('Avance.'.$tache['Avance']['id'].'.montant',['type'=>'hidden','value'=>$tache['Avance']['montant']]); ?>
						<?php echo h($tache['Avance']['montant']); ?>
					</td>
					<td nowrap="">
						<span class="badge badge-default" style="width: 100%;font-weight: bold;background-color: <?php echo $this->App->getStatutAvanceColor($tache['Avance']['verse']); ?>"> 
							<?php echo $this->App->getStatutAvance($tache['Avance']['verse']); ?> 
						</span>
					</td>
					<td class="actions">
						<?php if ( $tache['Versement']['etat'] == -1 ): ?>
						<?php $checked = ( $tache['Avance']['verse'] == 1 ) ? true : false ; ?>
						<?php echo $this->Form->input('Avance.'.$tache['Avance']['id'].'.ckeck',['type'=>'checkbox','checked'=>$checked,'class'=>'mt-checkbox','label'=>'Verser']); ?>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>