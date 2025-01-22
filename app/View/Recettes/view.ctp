<div class="hr"></div>
<div class="card">
  <div class="card-header">
      <h4 class="card-title">Fiche recette</h4>
      <div class="heading-elements">
          <ul class="list-inline mb-0">
              <li>
                <a href="<?php echo $this->Html->url(['action'=>'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste</a>
              </li>
              <li>
                <button type="submit" class="btn btn-sm btn-primary" form="ProduitEditForm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer </button>
              </li>
          </ul>
      </div>
  </div>
  <div class="card-body">
    <?php echo $this->Form->create('Produit',['id' => 'ProduitEditForm','class' => 'form-horizontal','type'=>'file','autocomplete'=>'off']); ?>
    <div class="row">
      <?php echo $this->Form->input('id'); ?>
      <div class="col-md-10">
        <div class="form-group row">
          <label class="control-label col-md-2">Référence</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('reference',['class' => 'form-control','label'=>false,'readonly' => true]); ?>
          </div>
          <label class="control-label col-md-2">Date création</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'type'=>'text','default'=>date("d-m-Y")]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Libellé</label>
          <div class="col-md-8">
            <?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Prix d'achat</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('prixachat',['class' => 'prixachat form-control','label'=>false,'required' => true ,'min' =>0,'step'=>'any']); ?>
          </div>
          <label class="control-label col-md-2">Prix de vente</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('prix_vente',['class' => 'prix_vente form-control','label'=>false,'required' => true ,'min' =>0,'step'=>'any']); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">TVA achat</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('tva_achat',['class' => 'form-control','label'=>false,'empty'=>"--TVA achat",'options'=>$this->App->getTVA(),'required' => true ]); ?>
          </div>
          <label class="control-label col-md-2">TVA vente</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('tva_vente',['class' => 'form-control','label'=>false,'empty'=>"--TVA vente",'options'=>$this->App->getTVA(),'required' => true ]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Image</label>
          <div class="col-md-8">
            <?php echo $this->Form->input('image',['class' => 'form-control','label'=>false,'type'=>'file','accept'=>"image/*"]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Actif</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('active',['class' => 'form-control','label'=>false,'required' => true,'options'=>$this->App->OuiNon()]); ?>
          </div>
          <label class="control-label col-md-2">Afficher sur</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('display_on',['class' => 'form-control','label'=>false,'required' => true,'empty'=>"--Afficher sur",'options'=>$this->App->getNatureProduit() ]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Catégorie</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('categorieproduit_id',['class' => 'form-control','label'=>false,'empty'=>"--Catégorie"]); ?>
          </div>
          <label class="control-label col-md-2">Unité</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('unite_id',['class' => 'form-control','label'=>false,'empty'=>"--Unité"]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Description</label>
          <div class="col-md-8">
            <?php echo $this->Form->input('description',['class' => 'form-control','label'=>false]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Code à barre</label>
          <div class="col-md-8">
            <?php echo $this->Form->input('code_barre',['class' => 'form-control','label'=>false]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Coût d'achat</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('cout_achat',['class' => 'form-control','label'=>false,'readonly'=>true]); ?>
          </div>
          <label class="control-label col-md-2">PMP</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('pmp',['class' => 'form-control','label'=>false,'readonly'=>true]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Compte Achat</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('cpt_achat',['class' => 'form-control','label'=>false,'maxlength'=>8]); ?>
          </div>
          <label class="control-label col-md-2">Compte Vente</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('cpt_vente', ['class' => 'form-control','label'=>false,'maxlength'=>8]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Compte Stock</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('cpt_stock' , ['class' => 'form-control','label'=>false,'maxlength'=>8]); ?>
          </div>
          <label class="control-label col-md-2"></label>
          <div class="col-md-3">
            <?php echo $this->Form->input('pese', ['class' => 'uniform form-control', 'label'=>'Pesé', 'type'=>'checkbox']); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Type OF</label>
          <div class="col-md-3">
            <?php echo $this->Form->input('type_of', ['class' => 'form-control','label'=>false,'required' => true,'options'=>['auto'=> 'Automatique', 'man'=> 'Manuelle']]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Type Conditionnement</label>
          <div class="col-md-8">
            <?php echo $this->Form->input('type_conditionnement', ['class' => 'form-control','label'=>false,'empty'=>"--Type Cond",'options'=>$condtionnements,'required' => true ]); ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2">Option</label>
          <div class="col-md-8">
            <?php echo $this->Form->input('options', ['class' => 'form-control','label'=>false,'empty'=>"--Option",'options'=>$options,'required' => true ]); ?>
          </div>
        </div>
      </div>
      <div class="col-lg-2"><br/>
        <?php if ( !empty( $this->data['Produit']['image'] ) AND file_exists( WWW_ROOT."uploads/articles_images/".$this->data['Produit']['image'] ) ): ?>
          <a target="_blank" href="<?php echo $this->Html->url("../uploads/articles_images/".$this->data['Produit']['image']) ?>">
            <img class="img-thumbnail" src="<?php echo $this->Html->url("../uploads/articles_images/".$this->data['Produit']['image']) ?>" style="width: 50%;" />
          </a>    
        <?php else: ?>
          <a target="_blank" href="<?php echo $this->Html->url("../img/no-image.png"); ?>">
          <img class="img-thumbnail" src="<?php echo $this->Html->url("../img/no-image.png"); ?>" style="width: 50%;" /></a>
        <?php endif ?>
      </div>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="dashboard-stat dashboard-stat-v2 red" >
          <div class="visual">
              <i class="fa fa-bar-chart-o"></i>
          </div>
          <div class="details">
              <div class="number">
                  <span data-counter="counterup" data-value="<?php echo $quantite_general ?>"><?php echo $quantite_general ?> Unité(s)</span>
              </div>
              <div class="desc"> Stock actuel </div>
          </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="dashboard-stat dashboard-stat-v2 blue" >
          <div class="visual">
              <i class="fa fa-bar-chart-o"></i>
          </div>
          <div class="details">
              <div class="number">
                  <span data-counter="counterup" data-value="<?php echo $total_stock ?>"><?php echo number_format($total_stock, 2, ',', ' ') ?> Dhs</span>
              </div>
              <div class="desc"> Valeur du stock </div>
          </div>
      </div>
    </div>
</div>

<div class="card">
  <div class="card-header">
      <h4 class="card-title">Détail recette</h4>
  </div>
  <div class="card-body">
    
      <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
          <li class="nav-item">
              <a class="nav-link active" id="home-tab-justified" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just" aria-selected="false">Stock par dépôt</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="profile-tab-justified" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just" aria-selected="false">Historique des entrées</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="messages-tab-justified" data-toggle="tab" href="#messages-just" role="tab" aria-controls="messages-just" aria-selected="false">Historique des sorties</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="societe-tab-justified" data-toggle="tab" href="#societe-just" role="tab" aria-controls="societe-just" aria-selected="true">PV par société</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="fournisseur-tab-justified" data-toggle="tab" href="#fournisseur-just" role="tab" aria-controls="fournisseur-just" aria-selected="true">PA par fournisseur</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="settings-tab-justified" data-toggle="tab" href="#settings-just" role="tab" aria-controls="settings-just" aria-selected="true">Ingrédients</a>
          </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content pt-1">

        <div class="tab-pane active" id="home-just" role="tabpanel" aria-labelledby="home-tab-justified">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive" style="min-height:250px;">
                <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
                  <thead>
                      <tr>
                        <th nowrap="">Dépôt</th>
                        <th nowrap="">Date</th>
                        <th nowrap="">Quantité</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($depotproduits as $tache): ?>
                      <tr>
                        <td><?php echo  (isset( $tache['Depot']['libelle'] )) ? $tache['Depot']['libelle'] : '' ; ?></td>
                        <td><?php echo (isset( $tache['Depotproduit']['date'] )) ? $tache['Depotproduit']['date'] : '' ; ?></td>
                        <td><?php echo (isset( $tache['Depotproduit']['quantite'] )) ? $tache['Depotproduit']['quantite'] : '' ; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

        <div class="tab-pane" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-justified">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive" style="min-height:250px;">
                <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
                  <thead>
                      <tr>
                        <th nowrap="">Date</th>
                        <th nowrap="">Référence</th>
                        <th nowrap="">Numéro du lot</th>
                        <th nowrap="">Dépôt source</th>
                        <th nowrap="">Opération</th>
                        <th nowrap="">Quantité</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($mouvements as $tache): ?>
                      <tr>
                        <td nowrap=""><?php echo h($tache['Mouvement']['date']); ?></td>
                        <td nowrap=""><?php echo h($tache['Mouvement']['reference']); ?></td>
                        <td nowrap=""><?php echo h($tache['Mouvement']['num_lot']); ?></td>
                        <td nowrap=""><?php echo h($tache['DepotSource']['libelle']) ?></td>
                        <td nowrap=""><?php echo $this->App->getTypeOperation($tache['Mouvement']['operation']); ?></td>
                        <td nowrap="" class="text-right"><?php echo h($tache['Mouvement']['stock_source']); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

        <div class="tab-pane" id="messages-just" role="tabpanel" aria-labelledby="messages-tab-justified">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive" style="min-height:250px;">
                <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
                  <thead>
                      <tr>
                        <th nowrap="">Date</th>
                        <th nowrap="">Référence</th>
                        <th nowrap="">Numéro du lot</th>
                        <th nowrap="">Dépôt source</th>
                        <th nowrap="">Opération</th>
                        <th nowrap="">Quantité</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sortie as $tache): ?>
                      <tr>
                        <td nowrap=""><?php echo h($tache['Mouvement']['date']); ?></td>
                        <td nowrap=""><?php echo h($tache['Mouvement']['reference']); ?></td>
                        <td nowrap=""><?php echo h($tache['Mouvement']['num_lot']); ?></td>
                        <td nowrap=""><?php echo h($tache['DepotSource']['libelle']) ?></td>
                        <td nowrap=""><?php echo $this->App->getTypeOperation($tache['Mouvement']['operation']); ?></td>
                        <td nowrap="" class="text-right"><?php echo h($tache['Mouvement']['stock_source']); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

        <div class="tab-pane" id="societe-just" role="tabpanel" aria-labelledby="societe-tab-justified">
          <div id="societeprices"></div>
        </div>

        <div class="tab-pane" id="fournisseur-just" role="tabpanel" aria-labelledby="fournisseur-tab-justified">
          <div id="fournisseurprices"></div>
        </div>

        <div class="tab-pane" id="settings-just" role="tabpanel" aria-labelledby="settings-tab-justified">
          <div id="ingredients"></div>
        </div>

    </div>
    <!-- Tab panes -->
  </div>
</div>

<?php $this->start('js') ?>
<script>
  
  var Init = function(){
    $('.select2').select2();
    $('.uniform').uniform();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('change','#ProduitingredientIngredientId',function () {
    var ingredient_id = $(this).val();
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action'=>'getingredient']) ?>/"+ingredient_id,
      success: function(dt){
        $('#ProduitingredientPrixAchat').val(dt.prixachat);
        $('#ProduitingredientPourcentagePerte').val(dt.pourcentage_perte);
      }
    });
  });

</script>
<?php echo $this->element('page-script'); ?>
<?php if ( isset($this->data['Produit']['id']) ): ?>
<?php $url_societe = $this->Html->url(['action'=>'societeprices',$this->data['Produit']['id']]) ?>
<?php echo $this->element('ajax-page-script',['element' => 'societeprices' , 'form' => "ProduitpriceSociete" ,'url' =>  $url_societe]); ?>

<?php $url_fournisseur = $this->Html->url(['action'=>'fournisseurprices',$this->data['Produit']['id']]) ?>
<?php echo $this->element('ajax-page-script',['element' => 'fournisseurprices' , 'form' => "ProduitpriceFournisseur" ,'url' =>  $url_fournisseur]); ?>

<?php $url_ingredients = $this->Html->url(['action'=>'ingredients',$this->data['Produit']['id']]) ?>
<?php echo $this->element('ajax-page-script',['element' => 'ingredients' , 'form' => "ProduitIngredient" ,'url' =>  $url_ingredients]); ?>
<?php endif ?>

<?php $this->end() ?>