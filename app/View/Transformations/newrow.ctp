<tr class="child">
    <td style="width: 30%;text-align: left;">
    	<?php echo $this->Form->input('Transformationdetail.'.$count.'.produit_a_transformer_id',['class'=>'produit_a_transformer_id form-control select2','label'=>false,'required'=>true,'empty'=>'--Produit','form'=>'TransformationMasse','options'=>$produits]) ?>
    </td>
    <td style="width: 10%;">
		<?php echo $this->Form->input('Transformationdetail.'.$count.'.quantite_a_transformer',['class'=>'quantite_a_transformer form-control','label'=>false,'required'=>true,'min'=>0,'step'=>'any','type'=>'number','form'=>'TransformationMasse']) ?>
    </td>
    <td style="width: 30%;text-align: left;">
        <?php echo $this->Form->input('Transformationdetail.'.$count.'.produit_transforme_id',['class'=>'produit_transforme_id form-control select2','label'=>false,'required'=>true,'empty'=>'--Produit','form'=>'TransformationMasse','options'=>$produits]) ?>
    </td>
    <td style="width: 10%;">
        <?php echo $this->Form->input('Transformationdetail.'.$count.'.quantite_transforme',['class'=>'quantite_transforme form-control','label'=>false,'required'=>true,'min'=>0,'step'=>'any','type'=>'number','form'=>'TransformationMasse']) ?>
    </td>
    <td style="width: 10%;" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Supprimer</a>
    </td>                                    
</tr>