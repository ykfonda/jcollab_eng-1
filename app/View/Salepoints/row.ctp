<tr class="child">
    <td width="20%">
    	<?php echo $this->Form->input('Detail.'.$count.'.produit_id',['class'=>'produit_id form-control select2','label'=>false,'required'=>true,'empty'=>'--Produit','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
		<?php echo $this->Form->input('Detail.'.$count.'.stock_source',['class'=>'stock_source form-control','label'=>false,'disabled'=>true,'min'=>0,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
        <?php echo $this->Form->input('Detail.'.$count.'.prix_vente',['class'=>'prix_vente form-control','label'=>false,'readonly'=>true,'min'=>0,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
        <?php echo $this->Form->input('Detail.'.$count.'.paquet',['class'=>'paquet form-control','label'=>false,'required'=>true,'min'=>1,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
		<?php echo $this->Form->input('Detail.'.$count.'.qte',['class'=>'qte form-control','label'=>false,'required'=>true,'min'=>1,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
		<?php echo $this->Form->input('Detail.'.$count.'.total_unitaire',['class'=>'total_unitaire form-control','label'=>false,'readonly'=>true,'min'=>0,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
        <?php echo $this->Form->input('Detail.'.$count.'.total',['class'=>'total form-control','label'=>false,'readonly'=>true,'min'=>0,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%">
        <?php echo $this->Form->input('Detail.'.$count.'.ttc',['class'=>'ttc form-control','label'=>false,'readonly'=>true,'min'=>0,'default'=>0,'type'=>'number','style'=>'text-align:right','form' => 'FormMultipleRow']) ?>
    </td>
    <td width="11%" class="actions">
    	<a href="#" class="deleteRow btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
    </td>                                    
</tr>