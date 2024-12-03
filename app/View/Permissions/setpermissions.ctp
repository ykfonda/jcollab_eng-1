<style type="text/css">
	#tablePermission td , tr , th {
		border: 1px solid silver;
		width: 14% !important;
		white-space: nowrap;
	}
	.checkbox>label{
		cursor: pointer !important;
		text-align: center;
		font-weight: bold;
		margin-left: 5px;
	}
</style>
<div class="hr"></div>
<?php if ($globalPermission['Permission']['m1']): ?>
	<?php $disabled = '' ?> 
<?php else: ?>
	<?php $disabled = 'disabled' ?> 
<?php endif ?>

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
			<div class="col-lg-12">
				<?php echo $this->Form->create('Permission',['action' => 'index']) ?>
				<div class="form-group row">
					<div class="col-lg-4">
						<?php echo $this->Form->input('Role',['label' => false,'value' => $role, 'title' => '', 'class' => 'select2 form-control']) ?>
					</div>
					<div class="col-lg-4">
						<?php echo $this->Form->input('Module',['label' => false,'value' => $module, 'empty' => '--Module','class' => 'select2 form-control']) ?>
					</div>
					<div class="col-lg-4">
						<input type="submit" value="Rechercher" class="btn btn-primary btn-block btn-sm" />
					</div>
				</div>
				<?php echo $this->Form->end() ?>
			</div>
		</div>

	</div>
</div>

<?php if (empty($role)): ?>

	<?php foreach ($data as $key => $role): ?>
		<?php echo $this->Html->link($role['Role']['libelle'],array('action'=>'setpermissions',$role['Role']['id'])) ?><br>
	<?php endforeach ?>

<?php elseif(empty($site)): ?>

	<?php foreach ($data as $key => $site): ?>
		<?php echo $this->Html->link($site['Site']['designation'],array('action' => 'setpermissions',$role,$site['Site']['id'])) ?><br>
	<?php endforeach ?>

<?php elseif(empty($module)): ?>
	<table class="table table-bordered table-striped">
	<tbody>
	<?php foreach ($data as $key => $val): ?>
		<tr><td>
			&nbsp; -- <?php echo $this->Html->link($val['Module']['libelle'],array('action' => 'setpermissions',$role,$site,$val['Module']['id'])) ?><br>
		</td></tr>
		<?php foreach ($val['children'] as $ke => $va): ?>
			<tr><td>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<i class="fa fa-angle-right"></i> <?php echo $this->Html->link($va['Module']['libelle'],array('action' => 'setpermissions',$role,$site,$va['Module']['id'])) ?><br>
			</td></tr>
			<?php foreach ($va['children'] as $k => $v): ?>
			<tr><td>
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<i class="fa fa-angle-right"></i> <?php echo $this->Html->link($v['Module']['libelle'],array('action' => 'setpermissions',$role,$site,$v['Module']['id'])) ?><br>
			</td></tr>
			<?php endforeach ?>
		<?php endforeach ?>
	<?php endforeach ?>
	</tbody>
	</table>

<?php else: ?>

<?php echo $this->Form->create('Permission') ?>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Activation des permissions
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'setpermissions',$role,$site,$lastparent]) ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i> Retour</a>
			<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Enregister</button>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">
			<table class="table" id="tablePermission">
			  <thead>
				<tr>
					<th nowrap="">Module</th>
					<th nowrap="">Consulter</th>
					<th nowrap="">Ajouter</th>
					<th nowrap="">Modifier</th>
					<th nowrap="">Valider</th>
					<th nowrap="">Supprimer</th>
					<th nowrap="">Imprimer</th>
					<th nowrap="">Exporter</th>
					<!-- <th nowrap="">Help</th> -->
					<th nowrap="">&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
				<tr data-row="0">
					<?php $Permission = array('Permission' => array('module_id' => $module,'c' => 0,'a' => 0,'m1' => 0,'m2' => 0,'m3' => 0,'m4' => 0,'v' => 0,'s' => 0,'h' => 0,'i' => 0,'e' => 0)) ?>
					<?php foreach ($getPermissions as $k => $v) {
						if($v['Permission']['module_id'] == $module)
							$Permission = $getPermissions[$k];
					} ?>
					<td nowrap="" style="text-align: left;"> -- <strong><?php echo $data['Module']['libelle'] ?></strong></td>
					<td data-col="1">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('c', $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.c', array('label'=>' Activer ','checked' => $Permission['Permission']['c'])); ?>
					<?php endif ?>
					</td>
					<td data-col="2">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('a', $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.a', array('label'=>' Activer ','checked' => $Permission['Permission']['a'])); ?>
					<?php endif ?>
					</td>
					
					<?php for($n=1;$n<=$data['Module']['niveau'];$n++): ?>
					<td data-col="<?php echo $n+10 ?>">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('m'.$n, $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.m'.$n, array('label'=>' Activer ','checked' => $Permission['Permission']['m'.$n])); ?>
					<?php endif ?>
					</td>
					<?php endfor ?>

					<td data-col="3">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('v', $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.v', array('label'=>' Activer ','checked' => $Permission['Permission']['v'])); ?>
					<?php endif ?>
					</td>

					<td data-col="4">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('s', $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.s', array('label'=>' Activer ','checked' => $Permission['Permission']['s'])); ?>
					<?php endif ?>
					</td>
					<td data-col="5">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('i', $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.i', array('label'=>' Activer ','checked' => $Permission['Permission']['i'])); ?>
					<?php endif ?>
					</td>
					<td data-col="6">
					<?php if ( !isset($modulesPermissions[$data['Module']['id']]) || in_array('e', $modulesPermissions[$data['Module']['id']]) ): ?>
						<?php echo $this->Form->input('0.e', array('label'=>' Activer ','checked' => $Permission['Permission']['e'])); ?>
					<?php endif ?>
					</td>
					<!-- <td data-col="7"><?php echo $this->Form->input('0.h', array('label'=>' Activer ','checked' => $Permission['Permission']['h'])); ?></td> -->
					<td><button type="button" class="allBtn btn btn-xs btn-block blue">Tous</button></td>
				</tr>
				<?php echo $this->Form->hidden('0.role_id',array('value' => $role)) ?>
				<?php echo $this->Form->hidden('0.site_id',array('value' => $site)) ?>
				<?php echo $this->Form->hidden('0.module_id',array('value' => $module)) ?>
				<?php $i = 1 ?>
				<?php foreach ($moduleChilds as $k => $v): ?>
				<?php
					$Permission = array('Permission' => array('module_id' => $v['Module']['id'],'c' => 0,'a' => 0,'m1' => 0,'m2' => 0,'m3' => 0,'m4' => 0,'v' => 0,'s' => 0,'h' => 0,'i' => 0,'e' => 0));
					foreach ($getPermissions as $key => $val) {
						if($val['Permission']['module_id'] == $v['Module']['id'])
							$Permission = $getPermissions[$key];
					}
				?>
					<tr>
						<td style="text-align: left;">
						&nbsp; &nbsp;
						<i class="fa fa-angle-right"></i> 
						<?php if ($v['Module']['children']): ?>
							<?php echo $this->Html->link($v['Module']['libelle'],array('action' => 'setpermissions',$role,$site,$v['Module']['id'])) ?>
						<?php else: ?>
							<?php echo $v['Module']['libelle'] ?>
							<?php //echo $v['Module']['libelle'].' ('.$v['Module']['id'].')' ?>
						<?php endif ?>
						</td>
						<td data-col="1">
						<?php if ( !$v['Module']['children'] && (!isset($modulesPermissions[$v['Module']['id']]) || in_array('c', $modulesPermissions[$v['Module']['id']])) ): ?>
							<?php echo $this->Form->input($i.'.c', array('label'=>' Activer ','checked' => $Permission['Permission']['c'])); ?>
						<?php endif ?>
						</td>
						<td data-col="2">
						<?php if ( !$v['Module']['children'] && (!isset($modulesPermissions[$v['Module']['id']]) || in_array('a', $modulesPermissions[$v['Module']['id']])) ): ?>
							<?php echo $this->Form->input($i.'.a', array('label'=>' Activer ','checked' => $Permission['Permission']['a'])); ?>
						<?php endif ?>
						</td>

						<?php for($n=1;$n<=$data['Module']['niveau'];$n++): ?>
							<?php if ($v['Module']['niveau'] > $n - 1): ?>
							  <td data-col="<?php echo 10 + $n ?>">
							  	<?php if ( !$v['Module']['children'] && (!isset($modulesPermissions[$v['Module']['id']]) || in_array('m'.$n, $modulesPermissions[$v['Module']['id']])) ): ?>
									<?php echo $this->Form->input($i.'.m'.$n, array('label'=>' Activer ','checked' => $Permission['Permission']['m'.$n])); ?>
							  	<?php endif ?>
							  </td>
							<?php else: ?>
								<td></td>
							<?php endif ?>
						<?php endfor; ?>


						<td data-col="3">
						<?php if ( !isset($modulesPermissions[$v['Module']['id']]) || in_array('v', $modulesPermissions[$v['Module']['id']]) ): ?>
							<?php echo $this->Form->input($i.'.v', array('label'=>' Activer ','checked' => $Permission['Permission']['v'])); ?>
						<?php endif ?>
						</td>

						<td data-col="4">
						<?php if ( !$v['Module']['children'] && (!isset($modulesPermissions[$v['Module']['id']]) || in_array('s', $modulesPermissions[$v['Module']['id']])) ): ?>
							<?php echo $this->Form->input($i.'.s', array('label'=>' Activer ','checked' => $Permission['Permission']['s'])); ?>
						<?php endif ?>
						</td>

						<td data-col="5">
						<?php if ( !$v['Module']['children'] && (!isset($modulesPermissions[$v['Module']['id']]) || in_array('i', $modulesPermissions[$v['Module']['id']])) ): ?>
							<?php echo $this->Form->input($i.'.i', array('label'=>' Activer ','checked' => $Permission['Permission']['i'])); ?>
						<?php endif ?>
						</td>
						
						<td data-col="6">
						<?php if ( !$v['Module']['children'] && (!isset($modulesPermissions[$v['Module']['id']]) || in_array('e', $modulesPermissions[$v['Module']['id']])) ): ?>
							<?php echo $this->Form->input($i.'.e', array('label'=>' Activer ','checked' => $Permission['Permission']['e'])); ?>
						<?php endif ?>
						</td>
						<!-- <td data-col="7"><?php echo $this->Form->input($i.'.h', array('label'=>' Activer ','checked' => $Permission['Permission']['h'])); ?></td> -->
						<td>
						<?php if ( !$v['Module']['children'] ): ?>
							<button class="allBtn btn btn-xs btn-block blue">Tous</button>
						<?php endif ?>
						</td>
					</tr>
					<?php if (!$v['Module']['children']): ?>
					<?php echo $this->Form->hidden($i.'.role_id',array('value' => $role)) ?>
					<?php echo $this->Form->hidden($i.'.site_id',array('value' => $site)) ?>
					<?php echo $this->Form->hidden($i.'.module_id',array('value' => $Permission['Permission']['module_id'])) ?>
					<?php endif ?>
				<?php $i++ ?>
				<?php endforeach ?>
			  </tbody>
			</table>

<?php endif ?>

		</div>
	</div>
</div>

<?php echo $this->Form->end() ?>

<?php $this->start('js'); ?>

<script>
	$(function(){

		$('.select2').select2();

		// var checkedLine = function(thisElement){
		// 	var $check = thisElement.parent().parent().parent().parent().find("td:not([data-col='1']) input[type='checkbox']");
		// 	if(!thisElement.prop('checked')){
		// 		$check.prop('disabled',true);
		// 	}else{
		// 		$check.prop('disabled',false);
		// 	}
		// }

		// var eachLine = function(){
		// 	$("tr>td[data-col='1'] input[type='checkbox']").each(function(){
		// 		checkedLine($(this));
		// 	});
		// };

		var enableDisableAll = function(thisElement){
			var Table = $('#tablePermission');
			if(thisElement.prop('checked')){
				Table.find("tr[data-row='0'] input[type='checkbox'],td[data-col='1'] input[type='checkbox']").prop('disabled',false);

			}else{
				Table.find("input[type='checkbox']").prop('disabled',true);
			}
			$.uniform.update();
			Table.find("tr[data-row='0']>td[data-col='1'] input[type='checkbox']").prop('disabled',false);
		}

		// enableDisableAll($("tr[data-row='0']>td[data-col='1'] input[type='checkbox']"));
		// eachLine();
		// $.uniform.update();

		$("tr[data-row='0']>td[data-col='1'] input[type='checkbox']").change(function(){
			enableDisableAll($(this));
			$.uniform.update();
		});

		// $("tr[data-row='0']>td:not([data-col='1']) input[type='checkbox']").change(function(){
		// 	var dataCol = $(this).parent().parent().parent().attr('data-col');
		// 	$check = $('#tablePermission').find("tr:not([data-row='0'])>td[data-col='"+dataCol+"'] input[type='checkbox']");
		// 		if($(this).prop('checked')){
		// 			$check.prop('checked',true);
		// 		}else{
		// 			$check.prop('checked',false);
		// 		}
		// 	$.uniform.update();
		// });

		// $("tr>td[data-col='1'] input[type='checkbox']").change(function(){
		// 	checkedLine($(this));
		// 	$.uniform.update();
		// });

		// $("#resetBtn").click(function(e){
		// 	e.preventDefault();
		// 	$("#PermissionSetpermissionsForm").get(0).reset();
		// 	enableDisableAll($("tr[data-row='0']>td[data-col='1'] input[type='checkbox']"));
		// 	eachLine();
		// 	$.uniform.update();
		// });

		$(".allBtn").click(function(e){
			e.preventDefault();
			var Table = $('#tablePermission');
			if($(this).parent().parent().attr('data-row') === '0'){
				Table.find("input[type='checkbox']").prop('disabled',false);
				Table.find("input[type='checkbox']").prop('checked',true);
			}else{
				var Line = $(this).parent().parent().find("td input[type='checkbox']");
				Table.find("tr[data-row='0'] td[data-col='1'] input[type='checkbox']").prop('checked',true);
				Line.prop('disabled',false);
				Line.prop('checked',true);
			} 
			$.uniform.update();
		});
	})
</script>

<?php $this->end(); ?>