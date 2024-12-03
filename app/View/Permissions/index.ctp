<div class="hr"></div>


<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Permission
		</div>
		<div class="actions">
		</div>
	</div>
	<div class="portlet-body">

<div class="row">
<?php echo $this->Form->create('Permission',['action' => 'index']) ?>
<div class="col-sm-3">
	<?php echo $this->Form->input('Site',['label' => false,'class' => 'form-control']) ?>
</div>
<div class="col-sm-3">
	<?php echo $this->Form->input('Role',['label' => false,'class' => 'form-control']) ?>
</div>
<div class="col-sm-2 col-sm-offset-4">
	<input type="submit" value="Rechercher" class="btn btn-primary">
</div>
<?php echo $this->Form->end() ?>
</div>

	</div>
</div>