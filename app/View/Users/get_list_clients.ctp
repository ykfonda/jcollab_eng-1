<table class="table table-striped table-bordered  table-hover">
	<thead>
		<tr>
			<th nowrap="">Matricule</th>
			<th nowrap="">Nom & Prénom</th>
			<th nowrap="">Echelle</th>
			<th nowrap="">Catégorie</th>
			<th nowrap="">Sous catégorie</th>
			<th nowrap="">Statut</th>
			<th class="actions">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($clients as $client): ?>
			<tr>
				<td>
					<a href="<?php echo $this->Html->url(['controller'=>'clients','action' => 'view', $client['Client']['id']]) ?>"><?php echo h($client['Client']['matricule']); ?></a>
				</td>
				<td>
					<a href="<?php echo $this->Html->url(['controller'=>'clients','action' => 'view', $client['Client']['id']]) ?>"><?php echo h($client['Client']['nom_complet']); ?></a>
				</td>
				<td><?php echo h($client['Client']['echelleclient_id']); ?>&nbsp;</td>
				<td><?php echo h($client['Client']['categorieclient_id']); ?>&nbsp;</td>
				<td><?php echo h($client['Client']['souscategorieclient_id']); ?>&nbsp;</td>
				<td><?php echo h($client['Client']['statutclient_id']); ?>&nbsp;</td>
				<td class="actions">
					<a href="<?php echo $this->Html->url(['controller'=>'clients','action' => 'view', $client['Client']['id']]) ?>"><i class="fa fa-eye"></i></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
