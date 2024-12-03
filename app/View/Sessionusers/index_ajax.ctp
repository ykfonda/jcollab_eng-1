<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Reference</th>
				<th nowrap="">Date Debut</th>
                <th nowrap="">Date fin</th>
                <th nowrap="">User</th>
                <th nowrap="">Site</th>
                <th nowrap="">Caisse</th>
                <th nowrap="">Chiffre Affaire</th>
                <th nowrap="">Actions</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
            <?php $i = 0 ?>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap="" style="
    color: #7367F0;
    text-decoration: none;
    background-color: transparent;    text-shadow: none;
    font-size: 15px;
    font-weight: 500;"><?php echo h($tache['Sessionuser']['reference']); ?></td>
					<td nowrap=""><?php echo h($tache['Sessionuser']['date_debut']); ?></td>
                    <td nowrap=""><?php echo h($tache['Sessionuser']['date_fin']); ?></td>
                    <td nowrap=""><?php echo h($tache['User']["nom"] . " " . $tache['User']["prenom"]); ?></td>
                    <td nowrap=""><?php echo h($tache['Site']["libelle"]); ?></td>
                    <td nowrap=""><?php echo h($tache['Caisse']["libelle"]); ?></td>
                    <?php if(!empty($chiffre_affaires[$i])): ?>
					<td nowrap=""><?php echo h($chiffre_affaires[$i]); ?></td>
					<?php else : ?>
						<td nowrap=""><?php echo "0.00"; ?></td>
					<?php endif ?>
					<td nowrap="" class="actions">
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Sessionuser']['id']]) ?>" class="view"><i class="fa fa-eye"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s'] ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Sessionuser']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
						<?php endif ?>
					</td>
				</tr>
                <?php $i = $i +1 ?>
			<?php endforeach; ?>
		</tbody>
	</table>
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