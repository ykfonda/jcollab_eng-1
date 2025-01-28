<div class="hr"></div>
<?php if ( isset( $this->data['Production']['id'] ) AND !empty( $this->data['Production']['id'] ) ): ?>

<?php if ( !empty( $this->data['Production']['statut'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Production']['statut'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getValideEntreeColor( $this->data['Production']['statut'] ) ?>">
        <strong>Statut fiche production &ensp; : &ensp;</strong>  <?php echo $this->App->getValideEntree( $this->data['Production']['statut'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="card">
  <div class="card-header">
      <h4 class="card-title">Fiche production</h4>
      <div class="heading-elements">
      <?php echo $this->Form->create('Production',['id' => 'ProductionEditForm','class' => 'form-horizontal','url' => ['controller' => 'Productions','action' => 'updateProduction']]); ?>
      <?php echo $this->Form->hidden('id'); ?>   
      <ul class="list-inline mb-0">
              <li>

              <a href="<?php echo $this->Html->url(['action'=>'generateProductionPdf',$this->data['Production']['id'],1 ]) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i> Fiche OF</a>

              <a href="<?php echo $this->Html->url(['action' => 'editall']) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i> Étiquettes </a>

                <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
                <?php if ( $this->data['Production']['statut'] == -1 ): ?>
                  <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Production']['id'],1 ]) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i> Valider & Terminer</a>
                  <?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ProductionEditForm','class' => 'saveBtn btn btn-success')) ?>
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
                  <td class="tableHead" nowrap="">Référence OF</td>
                  <td nowrap="">
                    <?php echo $this->data['Production']['reference'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Date</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Production']['date'] ?>
                  </td>
                </tr>
                <tr>
                  <td class="tableHead" nowrap="">Objet</td>
                  <td nowrap="">
                    <?php echo $this->data['Production']['libelle'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Responsable</td>
                  <td nowrap=""> 
                    <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
                  </td>
                </tr>
                <tr>
                  <td class="tableHead" nowrap="">Produit</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Produit']['libelle'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Dépot</td>
                  <td nowrap="">
                    <?php echo $this->data['Depot']['libelle'] ?>
                  </td>
                  
                </tr>
                <tr>
                <td class="tableHead" nowrap="">Quantité à produire</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Production']['quantite'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Prix Theo</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Production']['prix_theo'] ?>
                  </td>
                  
                </tr>
                <tr>
                
                  <td class="tableHead" nowrap="">Quantité produite</td>
                  <td nowrap="">
                  
                  <?php if($this->data['Production']['statut'] == 1 ) echo $this->Form->input('quantite_prod',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'min'=>0,'default' => $this->data['Production']['quantite_prod'],'step'=>'any']);
                  else echo $this->Form->input('quantite_prod',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'default' => $this->data['Production']['quantite_prod'],'step'=>'any']); ?>  
                  </td>
                  <?php echo $this->Form->end(); ?>
                  <td class="tableHead" nowrap="">Prix Prod</td>
                  <td nowrap="">
                  <?php echo $this->data['Production']['prix_prod'] ?>
                  </td>
                </tr>
                <tr>
                <td class="tableHead" nowrap="">Statut</td>
                  <td nowrap="">
                    <?php if ( !empty( $this->data['Production']['statut'] ) ): ?>
                      <div class="badge badge-default" style="width: 100%;color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Production']['statut'] ) ?>;"><?php echo $this->App->getValideEntree( $this->data['Production']['statut'] ) ?></div>
                    <?php endif ?>
                  </td>
                    <td class="tableHead" nowrap="">Num lot</td>
                    <td nowrap="">
                     <?php echo $this->data['Production']['numlot'] ?>
                    </td>  
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
    <h4 class="card-title">Détail production</h4>
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
                  <th nowrap="">Désignation</th>
                  <th nowrap="">Qté théo</th>
                  <th nowrap="">Qté Consommée</th>
                  <th nowrap="">Unité</th>
                  <th nowrap="">Prix</th>
                  <th nowrap="">Total Théo</th>
                  <th nowrap="">Total Réel</th>
                  <?php if (isset($this->data['Production']['statut']) AND $this->data['Production']['statut'] == -1  ): ?>
                  <th class="actions" nowrap="">Actions</th>
                  <?php endif ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $tache): ?>
                <tr>
                  <th nowrap=""><?php echo $tache['Produit']['libelle'] ?></th>
                  <th nowrap="" class="text-right"><?php echo $tache['Productiondetail']['quantite_theo'] ?></th>
                  <th nowrap="" class="text-right"><?php echo $tache['Productiondetail']['quantite_reel'] ?></th>
                  <th nowrap=""><?php echo ( isset($tache['Produit']['Unite']['id']) ) ? $tache['Produit']['Unite']['libelle'] : 'Non-définie' ; ?></th>
                  <th nowrap="" class="text-right">
                  <?php echo number_format($tache['Productiondetail']['prix_achat'], 2, ',', ' ') ?></th>
                  <th nowrap="" class="text-right"><?php echo number_format($tache['Productiondetail']['prix_achat']*$tache['Productiondetail']['quantite_theo'], 2, ',', ' ') ?></th>
                  <th nowrap="" class="text-right"><?php echo number_format($tache['Productiondetail']['prix_achat']*$tache['Productiondetail']['quantite_reel'], 2, ',', ' ') ?></th>
                  <?php if (isset($this->data['Production']['statut']) AND $this->data['Production']['statut'] == -1  ): ?>
                  <th class="actions" nowrap="">
                    <?php if ($globalPermission['Permission']['m1']): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Productiondetail']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                    <?php endif ?>
                    <?php if ($globalPermission['Permission']['s']): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Productiondetail']['id']]) ?>" class="action"><i class="fa fa-trash-o"></i></a>
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