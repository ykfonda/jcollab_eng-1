<div class="modal-header">
  <h4>Liste des ventes à synchroniser</h4>

  <!-- Check internet -->
    <?php
      // Vérifier la disponibilité de la connexion Internet
      if(checkdnsrr('google.com', 'A')){
        echo '<i class="fa fa-wifi green-icon" aria-hidden="true">
        <span class="message">La connexion Internet est disponible.</span></i>';
      } else {
        echo '<i class="fa fa-wifi red-icon" aria-hidden="true">
        <span class="message">La connexion Internet n\'est pas disponible.</span></i>';
      }
    ?>
    <!-- END Check internet -->
            
</div>
  <div class="modal-body">
    <div class="row">

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Reference</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($salepoints as $salepoint): ?>
      <tr>
        <td><?php echo $salepoint['Salepoint']['id']; ?></td>
        <td><?php echo $salepoint['Salepoint']['reference']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


        <br />
        <div class="alert alert-primary" role="alert">
        Dernière synchronisation : Date et heure
        </div>

      <br />
      <div class="modal-footer full-width">
                  
      <?= $this->Html->link('Appeler la fonction', ['controller' => 'Pos', 'action' => 'syncmanuel'], ['class' => 'btn btn-warning center']) ?>

          <button type="button" class="btn btn-secondary right" data-dismiss="modal">Fermer</button>
      </div>

      





    </div>
  </div>
