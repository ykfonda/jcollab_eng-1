<?php if ( empty( $produits ) ): ?>
  <div class="col-lg-12 height-50">
    <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
      <div class="alert-body">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info mr-50 align-middle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
          </svg>
          <span><strong>Attention</strong>. Aucune résultats trouvée .</span>
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