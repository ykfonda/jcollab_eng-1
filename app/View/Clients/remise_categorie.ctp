<div class="table-responsive" style="min-height:250px;">
  <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
         
          <th nowrap="">Categorie</th>
          <th nowrap="">Pourcentage</th>
          <th nowrap="" class="actions">
          	<a href="<?php echo $this->Html->url(['action' => 'editremisecategorie', 0, $client_id]) ?>" class="edit"><i class="fa fa-plus"></i> Nouveau prix</a>
          </th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($remises as $tache): ?>
         <tr>
         
          <td nowrap=""><?php echo  $tache['Categorieproduit']['libelle']; ?></td>
          <td nowrap=""><?php echo  $tache['Remiseclient']['montant']; ?></td>
          <td class="actions">
              <?php if ($globalPermission['Permission']['m1']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'editremisecategorie', $tache['Remiseclient']['id'], $client_id]) ?>" class="edit"><i class="fa fa-edit"></i></a>
              <?php endif ?>
              <?php if ($globalPermission['Permission']['s']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'deleteremise', $tache['Remiseclient']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
              <?php endif ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>