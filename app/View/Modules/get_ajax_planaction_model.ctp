<div class="modal-header">
	
	<h4 class="modal-title">Plan d'action</h4>
</div>
<div class="modal-body">

	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered tableHeadInformation tableHead120">
			<thead>
				<tr>
					<th nowrap="">Numero</th>
					<th nowrap="">Date</th>
					<th nowrap="">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($data as $k => $v): ?>
				<tr>
					<td><?php echo $v['Planaction']['id'] ?></td>
					<td><?php echo date('d-m-Y', strtotime($v['Planaction']['date_c']) ) ?></td>
					<td>
						<a href=" <?php echo $this->Html->url(['controller' => 'planactions', 'action' => 'initialization', $v['Planaction']['id']]) ?>"><i class="fa fa-eye"></i></a>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
			</table>
		</div>
	</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>