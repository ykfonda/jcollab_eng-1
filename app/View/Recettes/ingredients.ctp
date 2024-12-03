<div class="table-responsive" style="min-height:250px;">
  <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
          <th nowrap="">Réf</th>
          <th nowrap="">Ingrédient</th>
          <th nowrap="">Prix d'achat</th>
          <th nowrap="">Taux de perte</th>
          <th nowrap="">Quantité</th>
          <th nowrap="" class="actions">
          	<a href="<?php echo $this->Html->url(['action' => 'editingredient', 0, $produit_id]) ?>" class="edit"><i class="fa fa-plus"></i> Nouveau ingredient</a>
          </th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($ingredients as $tache): ?>
         <tr>
          <td nowrap=""><?php echo  $tache['Produitingredient']['reference']; ?></td>
          <td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller'=>'ingredients','action' => 'view',$tache['Ingredient']['id'] ]) ?>"><?php echo  $tache['Ingredient']['libelle']; ?></a></td>
          <td nowrap="" class="text-right"><?php echo  $tache['Produitingredient']['prix_achat']; ?></td>
          <td nowrap="" class="text-right"><?php echo  $tache['Produitingredient']['pourcentage_perte']; ?>%</td>
          <td nowrap="" class="text-right"><?php echo $tache['Produitingredient']['quantite']; ?></td>
          <td class="actions">
              <?php if ($globalPermission['Permission']['m1']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'editingredient', $tache['Produitingredient']['id'], $produit_id ]) ?>" class="edit"><i class="fa fa-edit"></i></a>
              <?php endif ?>
              <?php if ($globalPermission['Permission']['s']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'deleteingredient', $tache['Produitingredient']['id'],$produit_id ]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
              <?php endif ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>