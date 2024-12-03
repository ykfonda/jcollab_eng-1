<br/>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    	<div class="dashboard-stat dashboard-stat-v2 blue">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo count( $visites ) ?>"><?php echo count( $visites ) ?> visite(s)</span>
                </div>
                <div class="desc"> Nombre total </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive" style="min-height: auto;">
			<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th nowrap="">Référence</th>
						<th nowrap="">Vendeur</th>
						<th nowrap="">Client</th>
						<th nowrap="">Date</th>
						<th nowrap="">Motif</th>
						<th nowrap="">Commentaire</th>
						<th class="actions" nowrap="">
					</tr>
				</thead>
				<tbody>
					<?php foreach ($taches as $tache): ?>
						<tr>
							<td nowrap="">
								<a href="<?php echo $this->Html->url(['action'=>'view',$tache['Visite']['id']]) ?>"><?php echo h($tache['Visite']['reference']); ?></a>
							</td>
							<td nowrap="">
								<?php echo h($tache['User']['nom']); ?> <?php echo h($tache['User']['prenom']); ?>
							</td>
							<td nowrap=""><?php echo h($tache['Client']['designation']); ?></td>
							<td nowrap=""><?php echo h($tache['Visite']['date']); ?></td>
							<td nowrap=""><?php echo $this->App->convertToList($tache['Motifvisite'],'libelle'); ?></td>
							<td nowrap=""><?php echo h($tache['Visite']['libelle']); ?></td>
							<td class="actions">
								<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Visite']['id']]) ?>"><i class="fa fa-eye"></i></a>
								<?php if ($globalPermission['Permission']['m1']): ?>
									<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Visite']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
								<?php endif ?>
								<?php if ($globalPermission['Permission']['s']): ?>
									<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Visite']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
    </div>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite"><?php
		echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.')
		)); ?></div>
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