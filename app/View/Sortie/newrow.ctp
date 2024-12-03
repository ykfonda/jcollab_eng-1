<tr class="child">
    <td style="width: 40%;text-align: left;">
    	<?php echo $this->Form->input('MouvementDetail.'.$count.'.produit_id',['class'=>'produit_id form-control select2','label'=>false,'required'=>true,'default'=>$produit_id,'empty'=>'--Produit']) ?>
    </td>
    <td style="width: 20%;">
		<?php echo $this->Form->input('MouvementDetail.'.$count.'.stock',['class'=>'stock form-control','label'=>false,'disabled'=>true,'min'=>0,/* 'default'=>0 */'default'=>$stock]) ?>
    </td>
    <td style="width: 20%;">
		<?php echo $this->Form->input('MouvementDetail.'.$count.'.stock_source',['class'=>'stock_source form-control','label'=>false,'required'=>true,/* 'default'=>1 */'max'=>$stock,'default'=>$quantite_sortie]) ?>
    </td>
    <td style="width: 20%;">
        <?php echo $this->Form->input('MouvementDetail.'.$count.'.num_lot',['class'=>'num_lot form-control','label'=>false,'type'=>'text']) ?>
    </td>
    <td style="width: 20%;" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Supprimer</a>
    </td>                                    
</tr>