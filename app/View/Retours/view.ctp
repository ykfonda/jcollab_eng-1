<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset( $this->data['Retour']['id'] ) AND !empty( $this->data['Retour']['id'] ) ): ?>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information retour
    </div>
    <div class="actions">
      <?php if ( isset( $this->data['Retour']['id'] ) AND $this->data['Retour']['etat'] == 1 ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Retour']['id'],3 ]) ?>" class="changestate btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i> Clôturer</a>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Retour']['id'],2 ]) ?>" class="changestate btn btn-success btn-sm"><i class="fa fa-check-square-o"></i> Valider</a>
      <?php endif ?>
      <?php if ( isset( $this->data['Retour']['id'] ) AND $this->data['Retour']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Retour']['id'],1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
      <?php endif ?>
      <?php if ( isset( $this->data['Avoir']['id'] ) AND $globalPermission['Permission']['i'] ): ?>
        <a target="_blank" href="<?php echo $this->Html->url(['controller'=>'avoirs','action'=>'pdf',$this->data['Avoir']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer avoir</a>
      <?php endif ?>
      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;">
          <table class="table table-bordered tableHeadInformation">
            <tbody>
              <tr>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Retour']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap=""> 
                  <?php echo $this->data['Retour']['date'] ?>
                </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="" >
                  <?php echo $this->data['Client']['designation'] ?>
                </td>
                <td class="tableHead" nowrap="">Etat</td>
                <td nowrap="" >
                  <?php if ( !empty( $this->data['Retour']['etat'] ) ): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatRetourColor($this->data['Retour']['etat']); ?>">
                      <?php echo $this->App->getEtatRetour($this->data['Retour']['etat']); ?>
                    </span>
                  <?php endif ?>
                </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Vendeur</td>
                <td nowrap="" colspan="3">
                  <?php if ( isset( $this->data['User']['id'] ) ): ?>
                    <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
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
<?php endif ?>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Liste des produits
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Retour']['id'] ) AND $this->data['Retour']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Retour']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter produit</a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Désignation</th>
                <th nowrap="">Déclaration</th>
                <th nowrap="">Quantité</th>
                <?php if ( $this->data['Retour']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php $total = 0;$total_ttc = 0;$total_qte = 0; ?>
              <?php foreach ($details as $tache): ?>
                <?php $total = $total + $tache['Retourdetail']['total']; ?>
                <?php $total_ttc = $total_ttc + $tache['Retourdetail']['ttc']; ?>
                <?php $total_qte = $total_qte + $tache['Retourdetail']['qte']; ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?> </td>
                  <td nowrap=""><?php echo ( !empty( $tache['Retourdetail']['declaration'] ) ) ? $this->App->getDeclaration($tache['Retourdetail']['declaration']) : ''; ?></td>
                  <td nowrap=""><?php echo h($tache['Retourdetail']['qte']); ?></td>
                  <?php if ( $this->data['Retour']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Retourdetail']['id'], $tache['Retourdetail']['retour_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Retourdetail']['id'], $tache['Retourdetail']['retour_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
                      <?php endif ?>
                  </td>
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

<?php $this->start('js') ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;
  var categorieclient_id = <?php echo ( isset( $this->data['Client']['categorieclient_id'] ) AND !empty( $this->data['Client']['categorieclient_id'] ) ) ? (int) $this->data['Client']['categorieclient_id'] : 1 ; ?>;

  function getProduit(produit_id,categorieclient_id) {
    $.ajax({
      dataType:'JSON',
      url: "<?php echo $this->Html->url(['action' => 'getProduit']) ?>/"+produit_id+'/'+categorieclient_id,
      success: function(dt){
          var prix_vente = parseFloat(dt.prix_vente);
          var tva = parseFloat(dt.tva);
          $('#Total').val(0);
          $('#TotalTVA').val(0);
          $('#PrixAchat').val(prix_vente);
          $('#TVA').val(tva);
          calculeTotal();
      },
      error: function(dt){
        $('#Total').val('');
        $('#PrixAchat').val('');
        toastr.error("Il y a un probléme");
      },
      complete: function(){

      }
    });
  }

  $('.PrintThisPage').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      dataType:'JSON',
      success : function(dt){
        var lien = dt.url;
        window.open('https://docs.google.com/viewer?url='+lien+'&embedded=true', '_blank', 'location=yes'); 
      }
    });
  });

  var loadIndexAjax = function(url){
    $.ajax({
      url: url,
      success : function(dt){
        $('#PieceJointes').html(dt);
      }
    });
  }
  
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });

    var categorieproduit_id = $('#CategorieID').val();
    loadproduits(categorieproduit_id);
    
  }

  Init();

  function loadproduits(categorieproduit_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadproduits',$this->data['Retour']['id'] ]) ?>/"+categorieproduit_id,
      success: function(dt){
        var value = $('#ArticleID').val();
        $('#ArticleID').empty();
        $('#ArticleID').append($('<option>').text('-- Votre choix').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#ArticleID').append($('<option>').text(obj).attr('value', i));
        });
        $('#ArticleID').val( value ).trigger('change');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }

  $('#edit').on('change','#CategorieID',function(e){
    var categorieproduit_id = $(this).val();
    loadproduits(categorieproduit_id);
  });

  $('#edit').on('input','#QteChange',function(e){
    calculeTotal();
  });
  
  function calculeTotal() {
    var qte = $('#QteChange').val();
    var prix_vente = $('#PrixAchat').val();
    var tva = $('#TVA').val();;

    if( qte == '' ) qte = 0; 
    if( prix_vente == '' ) prix_vente = 0; 
    if( tva == '' ) tva = 20;

    var total = qte * prix_vente;
    $('#Total').val( total.toFixed(2) );
    var totaltva =  total * ( 1 + tva/100 );
    $('#TotalTVA').val( totaltva.toFixed(2) );
  }

  $('#edit').on('change','#ArticleID',function(e){
    var produit_id = $(this).val();
    if ( produit_id == '' ) {
      $('#Total').val(0);
      $('#TotalTVA').val(0);
      $('#PrixAchat').val(0);
    }
    getProduit(produit_id,categorieclient_id);
  });

  $('#edit').on('submit','form',function(e){
    $('.saveBtn').attr('disabled',true);
  });

  $('#indexAjax').on('click','.edit',function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });
  
  $('.edit').on('click',function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });

  $('.changestate').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });

  $('.btnFlagDelete').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });

});
</script>
<?php $this->end() ?>