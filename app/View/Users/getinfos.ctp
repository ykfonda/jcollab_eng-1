<?php if (  isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['id'] ) ): ?>

	<div class="row">
		<div class="col-md-4">
      		<?php if ( !empty( $produit['Produit']['image'] ) AND file_exists( WWW_ROOT."uploads/articles_images/".$produit['Produit']['image'] ) ): ?>
	            <img class="img-thumbnail" src="<?php echo $this->Html->url("../uploads/articles_images/".$produit['Produit']['image']) ?>" style="width: 100%;" />
	        <?php else: ?>
	          	<img class="img-thumbnail" src="<?php echo $this->Html->url("../img/no-image.png"); ?>" style="width: 100%;" />
	        <?php endif ?>
		</div>
		<div class="col-md-8">
			<h3><strong><?php echo $produit['Produit']['libelle'] ?></strong></h3>
			<p><strong>Prix d'achat : </strong><?php echo ( isset( $produit['Produit']['prixachat'] ) AND !empty( $produit['Produit']['prixachat'] ) ) ? $produit['Produit']['prixachat'] : 'Non-définie' ; ?></p>
			<p><strong>Prix de vente : </strong><?php echo ( isset( $produit['Produit']['prix_vente'] ) AND !empty( $produit['Produit']['prix_vente'] ) ) ? $produit['Produit']['prix_vente'] : 'Non-définie' ; ?></p>
			<p><strong>Code à barre : </strong><?php echo ( isset( $produit['Produit']['code_barre'] ) AND !empty( $produit['Produit']['code_barre'] ) ) ? $produit['Produit']['code_barre'] : 'Non-définie' ; ?></p>
			<p><strong>Catégorie : </strong><?php echo ( isset( $produit['Categorieproduit']['libelle'] ) AND !empty( $produit['Categorieproduit']['libelle'] ) ) ? $produit['Categorieproduit']['libelle'] : 'Non-définie' ; ?></p>
			<p><strong>Stock actuel : </strong><?php echo ( isset( $produit['Produit']['stockactuel'] ) AND !empty( $produit['Produit']['stockactuel'] ) ) ? $produit['Produit']['stockactuel'] : '0' ; ?> Unité(s)</p>
		</div>
	</div>

<?php else: ?>
	<div class="alert alert-danger" role="alert">
	  Aucune information trouvé !
	</div>
<?php endif ?>

