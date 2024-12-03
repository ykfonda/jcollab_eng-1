<div class="table-responsive" style="min-height:250px;">
  <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
        <th nowrap="">Montant ticket</th>
          <th nowrap="">Pourcentage</th>
          <?php if (!isset($remises[0]['Remiseclient']['montant'])) : ?>
          <th nowrap="" class="actions">
          
          	<a href="<?php echo $this->Html->url(['action' => 'editremiseglobale', 0, $client_id]); ?>" class="edit"><i class="fa fa-plus"></i> Nouveau prix</a>
            
          </th>
          <?php else : ?>
              <a><th nowrap="">Actions</th></a>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($remises as $tache): ?>
         <tr>
          <td nowrap=""><?php echo  $tache['Remiseclient']['montant_ticket']; ?></td>
          <td nowrap=""><?php echo  $tache['Remiseclient']['montant']; ?></td>
          <td class="actions">
              <?php if ($globalPermission['Permission']['m1']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'editremiseglobale', $tache['Remiseclient']['id'], $client_id]); ?>" class="edit"><i class="fa fa-edit"></i></a>
              <?php endif; ?>
            
              <?php if ($globalPermission['Permission']['s']): ?>
                <a href="<?php echo $this->Html->url(['action' => 'deleteremise', $tache['Remiseclient']['id']]); ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
              <?php endif; ?>
           
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>