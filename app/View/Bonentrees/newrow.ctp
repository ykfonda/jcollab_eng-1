<tr class="child">
    <td style="width: 30%;text-align: left;">
    	<?php echo $this->Form->input('Bonentreedetail.'.$count.'.produit_id',['class'=>'produit_id form-control select2','label'=>false,'required'=>true,'default'=>$produit_id,'empty'=>'--Produit','form'=>'BonentreeMultiEntree']) ?>
    </td>
    <td style="width: 15%;">
		<?php echo $this->Form->input('Bonentreedetail.'.$count.'.stock_source',['class'=>'stock_source form-control','label'=>false,'required'=>true,'min'=>0,'step'=>'any','default'=>$stock_source,'type'=>'number','form'=>'BonentreeMultiEntree']) ?>
    </td>
    <td style="width: 15%;">
		<?php echo $this->Form->input('Bonentreedetail.'.$count.'.prix_achat',['class'=>'prix_achat form-control','label'=>false,'required'=>true,'min'=>0,'step'=>'any','default'=>$prix_achat,'type'=>'number','form'=>'BonentreeMultiEntree']) ?>
    </td>
    <td style="width: 15%;">
		<?php echo $this->Form->input('Bonentreedetail.'.$count.'.valeur',['class'=>'valeur form-control','label'=>false,'disabled'=>true,'min'=>0,'step'=>'any','default'=>$valeur,'type'=>'number','form'=>'BonentreeMultiEntree']) ?>
    </td>
    <td style="width: 15%;">
        <?php echo $this->Form->input('Bonentreedetail.'.$count.'.num_lot',['class'=>'num_lot form-control','label'=>false,'required'=>false,'form'=>'BonentreeMultiEntree']) ?>
    </td>
    <td style="width: 5%;" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Supprimer</a>
    </td>                                    
</tr>