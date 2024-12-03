<?php echo $this->Form->create('User',['id' => 'UserEditForm','class' => 'form-horizontal']); ?>
<?php echo $this->Form->input('username',['class'=>'form-control','label'=>false,'placeholder'=>'USERNAME','required'=>true]); ?>
<?php echo $this->Form->input('password',['class'=>'form-control','label'=>false,'type'=>"password",'placeholder'=>'PASSWORD','required'=>true]); ?>
<div class="button-row">
	<?php echo $this->Form->submit('LOGIN',array('div' => false,'form' => 'UserEditForm','class' => 'sign-in btn btn-block btn-success','id'=>'SaveAssureNormal')) ?>
	<div class="clear"></div>
</div>
<?php echo $this->Form->end(); ?>