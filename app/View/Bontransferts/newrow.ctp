<tr class="child">
    <td nowrap="" style="width: 30%;">
    	<?php echo $this->Form->input('Bontransfertdetail.'.$count.'.produit_id',['class'=>'produit_id form-control select2','label'=>false,'default'=>$produit_id,'required'=>true,'empty'=>'--Produit']) ?>
    </td>
    <td nowrap="" style="width: 14%;">
		<?php echo $this->Form->input('Bontransfertdetail.'.$count.'.stock',['class'=>'stock form-control','label'=>false,'value' => $stock, 'disabled'=>true,'min'=>1,'default'=>0,'type'=>'number']) ?>
    </td>
    <td nowrap="" style="width: 14%;">
        <?php echo $this->Form->input('Bontransfertdetail.'.$count.'.stock_source',['class'=>'stock_source form-control','value' => $stock_source,'label'=>false,'required'=>true,'default'=>0]) ?>
    </td>
    <td nowrap="" style="width: 14%;">
		<?php echo $this->Form->input('Bontransfertdetail.'.$count.'.prix_achat',['class'=>'prix_achat form-control','label'=>false,'value' => $prix_achat, 'required'=>true,'min'=>1,'default'=>0]) ?>
    </td>
    <td nowrap="" style="width: 14%;">
		<?php echo $this->Form->input('Bontransfertdetail.'.$count.'.valeur',['class'=>'valeur form-control','label'=>false,'value' => $valeur,'disabled'=>true,'default'=>0]) ?>
    </td>
    <td nowrap="" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Supprimer</a>
    </td>                                    
</tr>