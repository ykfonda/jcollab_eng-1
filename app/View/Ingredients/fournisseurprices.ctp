<div class="table-responsive" style="min-height:250px;">
  <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
          <th nowrap="">Réf</th>
          <th nowrap="">Fourniseeur</th>
          <th nowrap="">Prix d'achat HT</th>
          <th nowrap="">TVA(%)</th>
          <th nowrap="">Fourniseeur par défault</th>
          <th nowrap="" class="actions">
          	<a href="<?php echo $this->Html->url(['action' => 'editfournisseurprice', 0, $produit_id]) ?>" class="edit"><i class="fa fa-plus"></i> Nouveau prix</a>
          </th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($prices as $tache): ?>
         <tr>
          <td nowrap=""><?php echo  $tache['Produitprice']['reference']; ?></td>
          <td nowrap=""><?php echo  $tache['Fournisseur']['designation']; ?></td>
          <td nowrap="" class="text-right"><?php echo $tache['Produitprice']['prix_achat']; ?></td>
          <td nowrap="" class="text-right"><?php echo $tache['Produitprice']['tva']; ?>%</td>
          <td nowrap=""><?php echo $this->App->OuiNon($tache['Produitprice']['default_frs']); ?></td>
          <td class="actions">
              <?php if ($globalPermission['Permission']['m1']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'editfournisseurprice', $tache['Produitprice']['id'], $produit_id]) ?>" class="edit"><i class="fa fa-edit"></i></a>
              <?php endif ?>
              <?php if ($globalPermission['Permission']['s']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'deleteprice', $tache['Produitprice']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
              <?php endif ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>