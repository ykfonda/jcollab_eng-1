<?php foreach ($ecommerces as $dossier): ?>
	<tr>
		<td nowrap=""><a class="traitercommande btn btn-danger btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'traiterecommerce',$dossier['Ecommerce']['id']]) ?>"><i class="fa fa-reply"></i> Traiter</a></td>
		<td nowrap=""><a class="getdetail" href="<?php echo $this->Html->url(['action'=>'ecommercedetails',$dossier['Ecommerce']['id']]) ?>"><?php echo h($dossier['Ecommerce']['barcode']); ?></a></td>
		<td nowrap=""><?php echo h($dossier['Ecommerce']['date']); ?></td>
		<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
		<td nowrap="" class="actions">
			<a class="getdetail btn btn-primary btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'ecommercedetails',$dossier['Ecommerce']['id']]) ?>"><i class="fa fa-eye"></i> Détails</a>
		</td>
	</tr>
<?php endforeach; ?>