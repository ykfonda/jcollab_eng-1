<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Réinitialisation systéme
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">

        <h2>Gestion du stock</h2>
        <div class="table-scrollable">
          <table class="table table-bordered table-striped table-hover tableHeadInformation">
            <thead>
              <tr>
                <th nowrap="">Déscription</th>
                <th nowrap="">Action</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td nowrap="">Réinitialisation de la liste des produits</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','produits']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation du stock</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','depotproduits']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des entrées/sorties</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','mouvements']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons entrées</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','bonentrees']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons de transfert</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','bontransferts']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

        <h2>Vente</h2>
        <div class="table-scrollable">
          <table class="table table-bordered table-striped table-hover tableHeadInformation">
            <thead>
              <tr>
                <th nowrap="">Déscription</th>
                <th nowrap="">Action</th>
              </tr>
            </thead>
            <tbody>

             <tr>
                <td nowrap="">Réinitialisation de la liste des devis</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','devis']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons de livraison</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','bonlivraisons']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des factures</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','factures']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons de retours</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','bonretours']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons d'avoir</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','bonavoirs']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

        <h2>Achat</h2>
        <div class="table-scrollable">
          <table class="table table-bordered table-striped table-hover tableHeadInformation">
            <thead>
              <tr>
                <th nowrap="">Déscription</th>
                <th nowrap="">Action</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons de commande </td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','boncommandes']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des bons de réception </td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','bonreceptions']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

        <h2>Général</h2>
        <div class="table-scrollable">
          <table class="table table-bordered table-striped table-hover tableHeadInformation">
            <thead>
              <tr>
                <th nowrap="">Déscription</th>
                <th nowrap="">Action</th>
              </tr>
            </thead>
            <tbody>

             <tr>
                <td nowrap="">Réinitialisation de la liste des avances</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','avances']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

             <tr>
                <td nowrap="">Réinitialisation de la liste des dépences</td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','depences']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des clients </td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','clients']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

              <tr>
                <td nowrap="">Réinitialisation de la liste des fournisseurs </td>
                <td nowrap="">
                  <a href="<?php echo $this->Html->url(['action' => 'reset','fournisseurs']) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-remove"></i> Réinitialiser </a>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){

  $('.action').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
        $('.action').attr("disabled", true);
        $.ajax({
          url: url,
          success: function(dt){
            toastr.success("La mise à jour a été effectué avec succès.");
          },
          error: function(dt){
            toastr.error("Il y a un problème")
          },
          complete : function(){
            $('.action').attr("disabled", false);
          },
        });

      }
    });
  });

});
</script>
<?php $this->end() ?>