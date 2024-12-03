<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
            Générateur étiquette
		</div>
    </div>

<?php

    echo $this->Form->create(null, array('class' => 'form-horizontal'));

    echo '<div class="form-row">';
        echo '<div class="form-group col-md-6">';
        echo $this->Form->input('produit_id', array(
            'options' => $produits,
            'class' => 'form-control select2'
        ));
        echo '</div>';
    echo '</div>';

    echo '<div class="form-row">';
        echo '<div class="form-group col-md-3">';
            echo $this->Form->input('dlcjour', array(
                'class' => 'form-control',
                'label' => 'DLC : Nombre de jour',
                'placeholder' => 'jour',
            ));
        echo '</div>';

        echo '<div class="form-group col-md-3">';
        echo $this->Form->input('dlcheure', array(
            'class' => 'form-control',
            'label' => 'DLC : Nombre d\'heure ',
            'placeholder' => 'heure',
        ));
        echo '</div>';
    echo '</div>';


    echo '<div class="form-row">';
        echo '<div class="form-group col-md-2">';
            echo $this->Form->input('lot', array(
                'class' => 'form-control',
                'label' => 'Numéro de lot',
                'placeholder' => 'lot',
            ));
        echo '</div>';

        echo '<div class="form-group col-md-2">';
            echo $this->Form->input('quantite', array(
                'class' => 'form-control',
                'label' => 'Quantité',
                'placeholder' => 'quantité',
            ));
        echo '</div>';

        echo '<div class="form-group col-md-2">';
            echo $this->Form->input('qnttype', array(
                'options' => array('KG', 'Pièce'),
                'class' => 'form-control select2',
                'label' => 'Unité de mesure',
            ));
        echo '</div>';
    echo '</div>';


    echo '<div class="form-row">';
        echo '<div class="form-group col-md-3">';
            echo $this->Form->input('dateprod', array(
                'label' => 'Production - Date et heure',
                'type' => 'datetime-local',
                'class' => 'form-control',
                'id' => 'datetimeprod' // Identifiant du champ d'entrée
            ));
        echo '</div>';

    echo '</div>';


    echo '<div class="form-row">';
        echo '<div class="form-group col-md-6">';
        echo $this->Form->input('codebarre', array(
            'class' => 'form-control',
            'disabled' => true,
        ));
        echo '</div>';
    echo '</div>';


    echo '<div class="form-row">';
        echo '<div class="form-group col-md-6">';
        echo $this->Form->end(array('label' => 'Confirmer', 'class' => 'btn btn-primary'));
        echo '</div>';
    echo '</div>';
    
    debug($formData);
?>

    <?php 
        if (isset($formData) AND !empty($formData)) {
    ?>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailGenerator">
            Imprimer
        </button>

    <?php 
        }  
    ?>

<!-- Modal -->


  <?php 
      // initialisation et préparation des variables
      $dateprod = $formData['Generateurticket']['dateprod'];
      // $datedlc  = $formData['Generateurticket']['datedlc'] ;

      $dlcjour    = $formData['Generateurticket']['dlcjour'] ;
      $dlcheure   = $formData['Generateurticket']['dlcheure'] ;

      // Séparation de la date et de l'heure pour $dateprod
      $dateprodArray = explode('T', $dateprod);
      $dateprodDate = $dateprodArray[0]; // Récupère la date
      $dateprodHeure = $dateprodArray[1]; // Récupère l'heure


      // Calculer les infos FULL DATE DLC

        // Ajout du nombre de jours et d'heures à $dateprod
        $dateprodTimestamp = strtotime($dateprod);
        $dlcTimestamp = $dateprodTimestamp + ($dlcjour * 24 * 60 * 60) + ($dlcheure * 60 * 60);

        // Conversion du timestamp en format de date et heure
        $dlcDateHeure = date('Y-m-d\TH:i', $dlcTimestamp);

        // Séparation de la date et de l'heure pour la DLC cumulée
        $dlcArray = explode('T', $dlcDateHeure);
        $dlcDate = $dlcArray[0]; // Récupère la date
        $dlcHeure = $dlcArray[1]; // Récupère l'heure

        // DLC CALCULE - ignorer ce script
        // Séparation de la date et de l'heure pour $datedlc
        // $datedlcArray = explode('T', $datedlc);
        // $datedlcDate = $datedlcArray[0]; // Récupère la date
        // $datedlcHeure = $datedlcArray[1]; // Récupère l'heure

  ?>


<div class="modal fade" id="detailGenerator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Détails</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <style>
    #detailGenerator{
        color: #000 !important;
    }
    td {
        color: #000 !important;
    }
    th {
        color: #000 !important;
    }

    @media print {
        .container {
            width: auto;
        }
    }

    </style>


  <div class="modal-body" id="modal-body">

    <table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">Libelle</th>
        <th scope="col">N° lot</th>
        <th scope="col">Quantité</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td><?php echo $libelle ?></td>
        <td><?php echo $formData['Generateurticket']['lot'] ?></td>
        <td>
            <?php 
                // Quantité 
                echo $formData['Generateurticket']['quantite'];
                // Type
                $qnttype = $formData['Generateurticket']['qnttype'];
                if ($qnttype == 0) {
                    echo " [KG] ";
                }else {
                    echo "[Pièce]";
                }
            ?>
            </td>
        </tr>
    </tbody>
    </table>


    <table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">Date - PROD</th>
        <th scope="col">Date - DLC</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>
          <?php 
                echo $dateprodDate . "<br>";
                echo $dateprodHeure . "<br>";
          ?>
        </td>
        <td>
          <?php 
                echo $dlcDate . "<br>";
                echo $dlcHeure . "<br>";       
          ?>
        </td>
        </tr>
    </tbody>
    </table>


        <?php
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($codeBarre, $generator::TYPE_CODE_128)).'">';

            echo '<p class="text-center font-weight-bold">'.$codeBarre.'</p>';
        ?>
      </div>
      <div class="modal-footer">

      <button onclick="printDiv('modal-body')">Imprimer</button>


      <script>
function printDiv(divId) {
  var printContents = document.getElementById(divId).innerHTML;
  var originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;

  // Appliquer les styles pour l'impression
  document.body.style.width = "80mm";
  document.body.style.height = "80mm";

  // Ajouter la classe d-print-block pour l'impression
  document.body.classList.add('d-print-block');

  window.print();

  // Retirer la classe d-print-block après l'impression
  document.body.classList.remove('d-print-block');

  document.body.innerHTML = originalContents;
}
</script>



        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Save changes</button>

      </div>
    </div>
  </div>
</div>






<br /><br />
<p class="text-info">Ce module n'est pas conçu pour enregistrer les données du formulaire. Son but principal est de générer des codes-barres et de les imprimer.</p>


</div>





















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
  
  async function loadDepots(produit_id) {
    await $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loaddepots']) ?>/"+produit_id,
      success: function(dt){
        $('#DepotID').empty();
        $('#DepotID').append($('<option>').text('-- Votre choix --').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#DepotID').append($('<option>').text(obj).attr('value', i));
        });
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }

  async function loadproduit(produit_id,depot_id) {
    await $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id+"/"+depot_id,
      success: function(dt){
        $('#BlockProduit').hide();
        $('#ProduitImage').attr('src','/img/no-avatar.jpg');
        $('#ProduitInfo').html('');
        $('.stock').val(0);
        $('.stock_source').attr('max',0);
        if ( typeof dt.Produit != 'undefined' && typeof dt.Produit.id != 'undefined' ) {
          $('#BlockProduit').show();
          $('#ProduitImage').attr('src',dt.Produit.image);
          $('#ProduitInfo').html('<b>Libellé :</b> '+dt.Produit.libelle+'<br/><b>Référence :</b> '+dt.Produit.reference+'<br/><b>Code à barre :</b> '+dt.Produit.code_barre+'<br/><b>Qté en stock :</b> '+dt.Produit.stock+' '+dt.Produit.unite);
          $('.stock').val(dt.Produit.stock);
          $('.stock_source').attr('max',dt.Produit.stock);
        }
      },
      error: function(dt){
        $('#BlockProduit').hide();
        $('#ProduitImage').attr('src','/img/no-avatar.jpg');
        $('#ProduitInfo').html('');
        $('.stock').val(0);
        $('.stock_source').attr('max',0);
        toastr.error("Il y a un problème");
      }
    }); 
  }

  $('#edit').on('change','#ProduitId',function(e){
    var depot_id = $('#DepotID').val();
    var produit_id = $('#ProduitId').val();
    loadDepots( produit_id );
    loadproduit( produit_id , depot_id );
  });

  $('#edit').on('change','#DepotID',function(e){
    var depot_id = $('#DepotID').val();
    var produit_id = $('#ProduitId').val();
    loadproduit( produit_id , depot_id );
  });
  /* $('.saveBtn').on('click',function(e){
    e.preventDefault();
    var  url = $(this).attr('href');
	alert("1");
	}); */
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>