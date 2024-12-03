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
		
	</div>
	
</div>






<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Activation des permissions
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(array('action' => 'index')) ?>" class="btn btn-primary" style="width : 6rem"><i class="fa fa-angle-left"></i> Retour</a>
			<button type="submit" class="sub btn btn-primary btn-sm"><i class="fa fa-save"></i> Enregister</button>
		</div>
	</div>
	</div>
	
	
			<table class="table table-bordered">
			  <thead>
				<tr class="table-active">
					<th scope="col"  style="width : 30%">Module</th>
					<th scope="col">Permission</th>
					
				</tr>
			  </thead>
			  <?php echo $this->Form->create('Permissionpos',['id' => 'PermissionposForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
			  <?php echo $this->Form->hidden('role',["value" => $role]); ?> 
			  <tbody>
			  
				<tr>
				
					<td style="font-weight : bold;text-align: left;"> Remise</td>
					<td data-col="1">
					 
					<?php echo $this->Form->input('Remise', ['type' => 'checkbox','checked'=>$perm["Remise"],"id" => "Remise","value" => "Remise",'label' => false] ); ?>	
					</td>
					
                </tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Remise ticket</td>
				<td  >
				<?php echo $this->Form->input('Remise ticket', ['type' => 'checkbox',"id" => "Remise ticket",'checked'=>$perm["Remise ticket"],"value" => "Remise ticket",'label' => false] ); ?>	
				
					</td>	
			</tr>
			<tr>
				
					<td style="font-weight : bold;text-align: left;"> Offert</td>
					<td data-col="1">
					 
					<?php echo $this->Form->input('Offert', ['type' => 'checkbox','checked'=>$perm["Offert"],"id" => "Offert","value" => "Offert",'label' => false] ); ?>	
					</td>
					
                </tr>
				<tr>
				
					<td style="font-weight : bold;text-align: left;"> Annuler ticket</td>
					<td data-col="1">
					 
					<?php echo $this->Form->input('Annuler ticket', ['type' => 'checkbox','checked'=>$perm["Annuler ticket"],"id" => "Annuler ticket","value" => "Annuler ticket",'label' => false] ); ?>	
					</td>
					
                </tr>
				<tr>
				
					<td style="font-weight : bold;text-align: left;"> Cloture caisse</td>
					<td data-col="1">
					 
					<?php echo $this->Form->input('Cloture caisse', ['type' => 'checkbox','checked'=>$perm["Cloture caisse"],"id" => "Cloture caisse","value" => "Cloture caisse",'label' => false] ); ?>	
					</td>
					
                </tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Activation chèque cadeau</td>
				<td data-col="1">
				<?php echo $this->Form->input('Activation cheque cadeau', ['type' => 'checkbox','checked'=>$perm["Activation cheque cadeau"],"id" => "Activation cheque cadeau","value" => "Activation cheque cadeau",'label' => false] ); ?>	
				
					</td>	
			</tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Activation bon d'achat</td>
				<td data-col="1">
				<?php echo $this->Form->input('Activation bon d\'achat', ['type' => 'checkbox',"id" => "Activation bon d'achat",'checked'=>$perm["Activation bon d'achat"],"value" => "Activation bon d'achat",'label' => false] ); ?>	
			
					</td>	
			</tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Activation carte client</td>
				<td data-col="1">
				<?php echo $this->Form->input('Activation carte client', ['type' => 'checkbox',"id" => "Activation carte client","value" => "Activation carte client",'checked'=>$perm["Activation carte client"],'label' => false] ); ?>	
			
					</td>	
			</tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Correction mode paiement</td>
				<td data-col="1">
				<?php echo $this->Form->input('Correction mode paiement', ['type' => 'checkbox',"id" => "Correction mode paiement",'checked'=>$perm["Correction mode paiement"],"value" => "Correction mode paiement",'label' => false] ); ?>	
			
					</td>	
			</tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Retour produit</td>
				<td data-col="1">
				<?php echo $this->Form->input('Retour produit', ['type' => 'checkbox',"id" => "Retour produit",'checked'=>$perm["Retour produit"],"value" => "Retour produit",'label' => false] ); ?>	
		
					</td>	
			</tr>
				<tr>
				<td  style="text-align: left;font-weight : bold;"> Réimpression facture ou ticket</td>
				<td data-col="1">
				<?php echo $this->Form->input('Reimpression facture ou ticket', ['type' => 'checkbox',"id" => "Reimpression facture ou ticket",'checked'=>$perm["Reimpression facture ou ticket"],"value" => "Reimpression facture ou ticket",'label' => false] ); ?>	
		
					</td>
						
			</tr>
			</tbody>
                </table>
					


				<?php echo $this->Form->end(); ?>
		
	



<?php $this->start('js'); ?>

<script>
	$(function(){

	/* $('.myBox  input:checkbox').change(function(){
		
      var tempValue='';
      tempValue=$('.myBox  input:checkbox').map(function(n){
          if(this.checked){
                return  this.value;
              };
       }).get().join(',');
	  
       
    }); */
	$('.sub').on("click", function () {
		$('#PermissionposForm').submit();
	});
	
})
</script>

<?php $this->end(); ?>
