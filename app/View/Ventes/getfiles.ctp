<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th nowrap="">Nom document</th>
			<th nowrap="">Créateur</th>
			<th nowrap="">Date création</th>
			<th class="actions">Actions</th>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($files as $dossier): ?>
				<tr>
					<td><?php echo h($dossier['Piece']['filename']); ?></td>
					<td><?php echo h($dossier['Creator']['nom']); ?> <?php echo h($dossier['Creator']['prenom']); ?></td>
					<td><?php echo h($dossier['Piece']['date_c']); ?></td>
					<td class="actions" style="text-align: left;">
						<a href="<?php echo $this->Html->url(['action' => 'download', $dossier['Piece']['id']]) ?>"><i class="fa fa-download"></i></a>
						<?php if ($globalPermission['Permission']['s'] AND empty( $dossier['Piece']['boncommande_id'] )): ?>
							<a href="<?php echo $this->Html->url(['action' => 'deletefile', $dossier['Piece']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>