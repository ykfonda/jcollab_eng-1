<tr class="child">
    <td style="width: 40%;">
    	<?php echo $this->Form->input('MouvementDetail.'.$count.'.produit_id',['class'=>'produit_id form-control select2','label'=>false,'required'=>true,'empty'=>'--Produit']) ?>
    </td>
    <td style="width: 20%;">
		<?php echo $this->Form->input('MouvementDetail.'.$count.'.stock_source',['class'=>'stock_source form-control','label'=>false,'required'=>true,'min'=>1,'default'=>1,'type'=>'number']) ?>
    </td>
    <td style="width: 20%;" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Supprimer</a>
    </td>                                    
</tr>