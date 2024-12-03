<div class="table-responsive" style="min-height:250px;">
  <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
          <th nowrap="">Réf</th>
          <th nowrap="">Recette</th>
          <th nowrap="">Quantité</th>
          <th nowrap="" class="actions"></th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($recettes as $tache): ?>
         <tr>
          <td nowrap=""><?php echo  $tache['Produitingredient']['reference']; ?></td>
          <td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller'=>'produits','action' => 'view', $tache['Produit']['id'] ]) ?>"><?php echo  $tache['Produit']['libelle']; ?></a></td>
          <td nowrap="" class="text-right"><?php echo $tache['Produitingredient']['quantite']; ?></td>
          <td class="actions">
            <a target="_blank" href="<?php echo $this->Html->url(['controller'=>'produits','action' => 'view', $tache['Produit']['id'] ]) ?>"><i class="fa fa-eye"></i> Voir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>