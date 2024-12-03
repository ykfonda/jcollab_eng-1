<div class="hr"></div>
<?php if ( isset( $this->data['Transformation']['id'] ) AND !empty( $this->data['Transformation']['id'] ) ): ?>

<?php if ( !empty( $this->data['Transformation']['statut'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Transformation']['statut'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getValideEntreeColor( $this->data['Transformation']['statut'] ) ?>">
        <strong>Statut fiche transformation &ensp; : &ensp;</strong>  <?php echo $this->App->getValideEntree( $this->data['Transformation']['statut'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="card">
  <div class="card-header">
      <h4 class="card-title">Fiche transformation</h4>
      <div class="heading-elements">
          <ul class="list-inline mb-0">
              <li>
                <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
                <?php if ( $this->data['Transformation']['statut'] == -1 ): ?>
                  <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Transformation']['id'],1 ]) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i> Valider & Terminer</a>
                <?php endif ?>
              </li>
          </ul>
      </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-scrollable">
            <table class="table table-bordered tableHeadInformation">
              <tbody>
                <tr>
                  <td class="tableHead" nowrap="">Référence</td>
                  <td nowrap="">
                    <?php echo $this->data['Transformation']['reference'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Date</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Transformation']['date'] ?>
                  </td>
                </tr>
                <tr>
                  <td class="tableHead" nowrap="">Objet</td>
                  <td nowrap="">
                    <?php echo $this->data['Transformation']['libelle'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Responsable</td>
                  <td nowrap=""> 
                    <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
                  </td>
                </tr>
                <tr>
                  <td class="tableHead" nowrap="">Dépot</td>
                  <td nowrap="">
                    <?php echo $this->data['Depot']['libelle'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Statut</td>
                  <td nowrap="">
                    <?php if ( !empty( $this->data['Transformation']['statut'] ) ): ?>
                      <div class="badge badge-default" style="width: 100%;color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Transformation']['statut'] ) ?>;"><?php echo $this->App->getValideEntree( $this->data['Transformation']['statut'] ) ?></div>
                    <?php endif ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Détail transformation</h4>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li></li>
      </ul>
    </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
            <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
              <thead>
                <tr>
                  <th nowrap="">Produit à transformer</th>
                 
                  <th nowrap="">Quantité</th>
                  <th nowrap="">Prix</th>
                  <th nowrap="">Produit transformé</th>
                  <th nowrap="">Quantité</th>
                  <?php if (isset($this->data['Transformation']['statut']) AND $this->data['Transformation']['statut'] == -1  ): ?>
                  <th class="actions" nowrap="">Actions</th>
                  <?php endif ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $tache): ?>
                <tr>
                  <th nowrap=""><?php echo $tache['ProduitATransformer']['libelle'] ?></th>
                  
                  <th nowrap="" class="text-right"><?php echo $tache['Transformationdetail']['quantite_a_transformer'] ?></th>
                  <th nowrap=""><?php echo $tache['ProduitATransformer']['prixachat'] ?></th>
                  <th nowrap=""><?php echo $tache['ProduitTransforme']['libelle'] ?></th>
                  <th nowrap="" class="text-right"><?php echo $tache['Transformationdetail']['quantite_transforme'] ?></th>
                  <?php if (isset($this->data['Transformation']['statut']) AND $this->data['Transformation']['statut'] == -1  ): ?>
                  <th class="actions" nowrap="">
                    <?php if ($globalPermission['Permission']['m1']): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Transformationdetail']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                    <?php endif ?>
                    <?php if ($globalPermission['Permission']['s']): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Transformationdetail']['id']]) ?>" class="action"><i class="fa fa-trash-o"></i></a>
                    <?php endif ?>
                  </th>
                  <?php endif ?>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php endif ?>

<?php $this->start('js') ?>
<script>
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }
</script>
<?php echo $this->element('view-script'); ?>
<?php $this->end() ?>