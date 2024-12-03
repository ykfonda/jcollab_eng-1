<?php if (isset($data['Tuto']['id'])): ?>

<div class="modal-header">
	
	<h4 class="modal-title"> <?php echo $data['Tuto']['libelle'] ?> </h4>
</div>
<div class="modal-body">

	<div class="row">
		<div class="col-md-12" style="text-align: center;">
			<?php if (isset($data['Tuto']['youtube']) && !empty($data['Tuto']['youtube'])): ?>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $data['Tuto']['youtube'] ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			<?php else: ?>
			<?php echo $data['Tuto']['embed'] ?>
			<?php endif ?>
		</div>
	</div>

</div>

<?php else: ?>

<div class="modal-header">
	
	<h4 class="modal-title">  </h4>
</div>
<div class="modal-body">

	<div class="row">
		<div class="col-md-12" style="text-align: center;">
		</div>
	</div>

</div>

<?php endif ?>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>