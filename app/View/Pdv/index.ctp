<div class="hr"></div>
<style type="text/css">
  #pills-tab{
    white-space: nowrap !important;
    overflow-x: visible !important;
    overflow-y: hidden !important;
    width: 500% !important;
  }
  #pills-tab>.nav-item{
    border: 1px solid #e5e5e5;border-radius: 5px;margin: 2px;
  }
  @media (min-width: 1200px) {
    .col-xl-2 {
      max-width: 15.66667%;
      margin-right: 10px;
    }
  }
  .table th, .table td{
    padding: 0.4rem;
  }
</style>
<div class="row" style="margin-right: 1px;margin-left: 1px;background-color: white;">

  <div class="col-md-4" style="border:1px solid #e5e5e5;min-height: 750px;border-radius: 5px;">
    
    <div class="row">
      <!-- Inputs -->
      <div class="col-lg-12 mb-1 mt-1">
        <div class="input-group input-group-merge">
          <?php echo $this->Form->input('client_id',['id'=>'client_id','class'=>'select2 form-control','label'=>false,'required'=>false,'type'=>'select','placeholder'=>'Client...','div'=>false]); ?>
        </div>
      </div>
      <!-- Inputs -->
    </div>

    <div class="row">
      <!-- Inputs -->
      <div class="col-lg-12 mb-1">
        <?php echo $this->Form->create('Produit',['id' => 'ProduitScanCode','autocomplete'=>'off','id'=>'scan-product']); ?>
        <div class="input-group">
          <div class="input-group input-group-merge">
            <div class="input-group-append">
              <button class="btn btn-default btn-reset" type="button"><i class="fa fa-eraser"></i></button>
            </div>
            <?php echo $this->Form->input('code_barre',['id'=>'code_barre','class'=>'form-control pl-2','label'=>false,'required'=>true,'type'=>'text','placeholder'=>'Scanner code à barre...','div'=>false]); ?>
            <div class="input-group-append scan-loading" style="display: none;">
              <button class="btn btn-default" type="button" disabled="disabled">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              </button>
            </div>
            <div class="input-group-append">
              <button class="btn btn-default btn-scan" type="submit"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
      <!-- Inputs -->
    </div>
      
    <div class="row" id="BlockDetails">
      <!-- Details -->
      <div class="col-md-12">
        <div class="table-responsive" style="max-height: 350px;min-height: 350px;overflow-y: scroll;overflow-x: scroll;">
          <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Produit</th>
                <th nowrap="">Qte</th>
                <th nowrap="">Prix</th>
                <th nowrap="">Total</th>
                <th nowrap=""></th>
              </tr>
            </thead>
            <tbody id="tbodyParent">
              <?php $total = 0; ?>
              <?php foreach ($details as $k => $v): ?>
              <?php $total = $total+$v['Salepointdetail']['ttc']; ?>
              <tr class="rowParent">
                <td nowrap="" style="width: 35%;"><?php echo $this->Text->truncate($v['Produit']['libelle'],25) ?></td>
                <td nowrap="" class="smallFormView" style="width: 10%;">
                  <?php echo $v['Salepointdetail']['qte'] ?>
                  <!-- <div class="input-group">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-circle change-quantity"  type="button"><i class="fa fa-minus"></i></button>
                    </div>
                    <input type="text" class="form-control text-center" value="<?php echo $v['Salepointdetail']['qte'] ?>"/>
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-circle change-quantity"  type="button"><i class="fa fa-plus"></i></button>
                    </div>
                  </div> -->
                </td>
                <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['prix_vente'], 2, ',', ' ') ?></td>
                <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['ttc'], 2, ',', ' ') ?></td>
                <td nowrap="" style="width: 5%;">
                  <a href="<?php echo $this->Html->url(['action'=>'deleteline',$v['Salepointdetail']['id']]); ?>" class="btn btn-danger btn-xs btn-circle btn-delete"><i class="fa fa-ban"></i> Annuler</a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Details -->

      <!-- Totals -->
      <div class="col-md-12">
        <div class="table-responsive" style="max-height: 90px;min-height: 90px;">
          <table class="table table-bordered ">
            <tbody>
              <tr>
                <td class="tableHead" nowrap="">Net à payer</td>
                <td nowrap="" class="text-right bold"><?php echo number_format($total, 2, ',', ' ') ?></td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap="" class="text-right bold"><?php echo date('d-m-Y') ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Totals -->

      <!-- Actions -->
      <div class="col-md-12">
        <div class="row mb-1">
          <div class="col-lg-6 col-md-12">
            <a href="<?php echo $this->Html->url(['action'=>'holdon']); ?>" class="btn btn-warning btn-block waves-effect waves-float waves-light btn-lg btn-holdon"><i class="fa fa-hand-paper-o"></i> Hold</a>
          </div>
          <div class="col-lg-6 col-md-12">
            <a href="<?php echo $this->Html->url(['action'=>'onhold']); ?>" class="btn btn-secondary btn-block waves-effect waves-float waves-light btn-lg btn-onhold"><i class="fa fa-list-ol"></i> Hold list (<?php echo $onhold ?>) </a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <a href="<?php echo $this->Html->url(['action'=>'cancel']); ?>" class="btn btn-danger btn-block waves-effect waves-float waves-light btn-lg btn-cancel"><i class="fa fa-ban"></i> Annuler</a>
          </div>
          <div class="col-lg-6 col-md-12">
            <a href="<?php echo $this->Html->url(['action'=>'paiement']); ?>" class="btn btn-success btn-block waves-effect waves-float waves-light btn-lg btn-payment"><i class="fa fa-dollar"></i> Paiement</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 height-50"></div>
        </div>
      </div>
      <!-- Actions -->
    </div>

  </div>
  <div class="col-md-8" style="border:1px solid #e5e5e5;min-height: 750px;border-radius: 5px;">

    <div class="row">
      <!-- Navigation  -->
      <div class="col-lg-12 mb-1 mt-1">
        <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">        
          <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a data-categorie="" class="categorieClick nav-link active" id="categorie0-tab-justified" data-toggle="pill" href="#categorie0" role="tab" aria-controls="categorie0" aria-selected="true"><i class="fa fa-home mr-0"></i>&ensp;&ensp;<span class="badge badge-danger"><?php echo count($produits) ?></span></a>
            </li>
            <?php foreach ($categorieproduits as $key => $value): ?>
              <?php $count = ( isset( $data[$key]['produits'] ) AND !empty( $data[$key]['produits'] ) ) ? count($data[$key]['produits']) : 0 ; ?>
              <li class="nav-item">
                <a data-categorie="<?php echo $key ?>" class="categorieClick nav-link" id="categorie<?php echo $key ?>-tab-justified" data-toggle="pill" href="#categorie<?php echo $key ?>" role="tab" aria-controls="categorie<?php echo $key ?>" aria-selected="true"><?php echo $value ?>&ensp;&ensp;<span class="badge badge-danger"><?php echo $count ?></span></a>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      <!-- Navigation  -->
    </div>

    <div class="row">
      <!-- Search  -->
      <div class="col-lg-12 mb-1">
        <?php echo $this->Form->create('Produit',['id' => 'ProduitRecherche','autocomplete'=>'off','id'=>'search-product']); ?>
        <div class="input-group">
          <div class="input-group-append">
            <button class="btn btn-default btn-refresh" type="button"><i class="fa fa-refresh"></i></button>
          </div>
          <?php echo $this->Form->input('libelle',['id'=>'libelle','class'=>'form-control','label'=>false,'required'=>false,'type'=>'text','placeholder'=>'Recherche produit...','div'=>false]); ?>
          <?php echo $this->Form->hidden('categorieproduit_id',['id' => 'categorieproduit_id']); ?>
          <div class="input-group-append loading" style="display: none;">
            <button class="btn btn-default" type="button" disabled="disabled">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
          </div>
          <div class="input-group-append">
            <button class="btn btn-default btn-search" type="submit"><i class="fa fa-search"></i></button>
          </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
      <!-- Search  -->
    </div>

    <div class="row">
      <!-- Tabs  -->
      <div class="col-lg-12">
        <div class="tab-content">

          <!-- Tab -->
          <div role="tabpanel" class="tab-pane active" id="categorie0"  aria-labelledby="categorie0-tab-justified" aria-expanded="true">
            <div class="row parent-row rowList-0" style="overflow-y: scroll;overflow-x: hidden;max-height: 600px;padding: 0px;margin: 0px;">
              <?php if ( empty( $produits ) ): ?>
                <div class="col-lg-12 height-50">
                  <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                    <div class="alert-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info mr-50 align-middle">
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="16" x2="12" y2="12"></line>
                          <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span><strong>Remarque</strong>. Aucun produits trouvée .</span>
                    </div>
                  </div>
                </div>
              <?php endif ?>
              <?php foreach ($produits as $k => $v): ?>
                <a href="javascript:void(0)" class="item col-xl-2 col-md-4 col-sm-6 col-xs-12 bg-default colors-container rounded text-white shadow flat-box waves-effect waves-block mt-1" style="padding: 0px;border:1px solid #e5e5e5;" data-product="<?php echo $v['Produit']['code_barre']; ?>" data-categorie="<?php echo $v['Produit']['categorieproduit_id']; ?>">
                  <figure class="figure" style="width: 100%;height: 100%;margin:0px;padding: 0px;position: relative;">
                    <?php if ( !empty( $v['Produit']['image'] ) AND file_exists( WWW_ROOT."uploads/articles_images/".$v['Produit']['image'] ) ): ?>
                      <img src="<?php echo $this->Html->url("../uploads/articles_images/".$v['Produit']['image']) ?>" style="width: 100%;height: 145px;opacity: 0.5;" class="figure-img img-fluid rounded img-responsive" />
                    <?php else: ?>
                      <img src="<?php echo $this->Html->url("../img/no-image-old.png"); ?>" style="width: 100%;height: 145px;opacity: 0.5;" class="figure-img img-fluid rounded img-responsive">
                    <?php endif ?>
                    <figcaption class="figure-caption" style="color: black;white-space: nowrap;position: absolute;top: 70%;left: 5%;"> 
                      <b><?php echo $this->Text->truncate($v['Produit']['libelle'],20); ?></b><br/>
                      <small><?php echo $v['Produit']['prix_vente']; ?> MAD</small>
                    </figcaption>
                  </figure>
                </a>
              <?php endforeach ?>
              <div class="col-lg-12 height-50"></div>
            </div>
          </div>

          <?php foreach ($categorieproduits as $key => $value): ?>
            <div role="tabpanel" class="tab-pane" id="categorie<?php echo $key ?>"  aria-labelledby="categorie<?php echo $key ?>-tab-justified" aria-expanded="true">
              <div class="row parent-row rowList-<?php echo $key ?>" style="overflow-y: scroll;overflow-x: hidden;max-height: 600px;padding: 0px;margin: 0px;">
                <?php if ( empty( $data[$key]['produits'] ) ): ?>
                  <div class="col-lg-12 height-50">
                    <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                      <div class="alert-body">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info mr-50 align-middle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                          </svg>
                          <span><strong>Remarque</strong>. Aucun produits trouvée .</span>
                      </div>
                    </div>
                  </div>
                <?php endif ?>
                <?php if ( isset( $data[$key]['produits'] ) AND !empty( $data[$key]['produits'] ) ): ?>
                  <?php foreach ($data[$key]['produits'] as $k => $v): ?>
                    <a href="javascript:void(0)" class="item col-xl-2 col-md-4 col-sm-6 col-xs-12 bg-default colors-container rounded text-white shadow flat-box waves-effect waves-block mt-1" style="padding: 0px;border:1px solid #e5e5e5;" data-product="<?php echo $v['Produit']['code_barre']; ?>" data-categorie="<?php echo $v['Produit']['categorieproduit_id']; ?>">
                      <figure class="figure" style="width: 100%;height: 100%;margin:0px;padding: 0px;position: relative;">
                        <?php if ( !empty( $v['Produit']['image'] ) AND file_exists( WWW_ROOT."uploads/articles_images/".$v['Produit']['image'] ) ): ?>
                          <img src="<?php echo $this->Html->url("../uploads/articles_images/".$v['Produit']['image']) ?>" style="width: 100%;height: 145px;opacity: 0.5;" class="figure-img img-fluid rounded img-responsive" />
                        <?php else: ?>
                          <img src="<?php echo $this->Html->url("../img/no-image-old.png"); ?>" style="width: 100%;height: 145px;opacity: 0.5;" class="figure-img img-fluid rounded img-responsive">
                        <?php endif ?>
                        <figcaption class="figure-caption" style="color: black;white-space: nowrap;position: absolute;top: 70%;left: 5%;"> 
                          <b><?php echo $this->Text->truncate($v['Produit']['libelle'],20); ?></b><br/>
                          <small><?php echo $v['Produit']['prix_vente']; ?> MAD</small>
                        </figcaption>
                      </figure>
                    </a>
                  <?php endforeach ?>
                <?php endif ?>
                <div class="col-lg-12 height-50"></div>
              </div>
            </div>
          <?php endforeach ?>
          <!-- Tab -->
        </div>
      </div>
      <!-- Tabs  -->
    </div>

    </div>
  </div>

</div>

<?php $this->start('js') ?>
<script>
  var Init = function(){
    $('.select2').select2();
    // $('.date-picker').flatpickr({
    //   altFormat: "DD-MM-YYYY",
    //   dateFormat: "d-m-Y",
    //   allowInput: true,
    //   locale: "fr",
    // });
  }
</script>
<?php echo $this->element('pos-script'); ?>
<?php $this->end() ?>