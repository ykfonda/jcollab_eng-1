<tr class="child">
    <td style="width: 30%;text-align: left;">
    	<?php echo $this->Form->input('Productiondetail.'.$count.'.produit_id',['class'=>'produit_id form-control select2','label'=>false,'required'=>true,'empty'=>'--Produit','form'=>'ProductionMasse']) ?>
    </td>
    <td style="width: 15%;">
		<?php echo $this->Form->input('Productiondetail.'.$count.'.quantite',['class'=>'quantite form-control','label'=>false,'required'=>true,'min'=>0,'step'=>'any','type'=>'number','form'=>'ProductionMasse']) ?>
    </td>
    <td style="width: 5%;" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Supprimer</a>
    </td>                                    
</tr>