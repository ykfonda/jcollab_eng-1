<?php echo $this->Html->css('/app-assets/plugins/jquery-multi-select/css/multi-select.css') ?>
<style type="text/css">
  #ms-my_multi_select1{ width: 100% !important; }
  .ms-container .ms-list{ height: 350px !important; }
</style>
<div class="hr"></div>
<?php if ( isset( $this->data['Kitchensystem']['id'] ) AND !empty( $this->data['Kitchensystem']['id'] ) ): ?>
<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information KDS 
    </div>
    <div class="actions">
      <a href="<?php echo $this->Html->url(['action'=>'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
      <?php if ($globalPermission['Permission']['m1']): ?>
       <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Kitchensystem']['id'] ]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier kds </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">

        <div class="table-scrollable">
          <table class="table table-bordered tableHeadInformation">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Libellé</td>
                <td nowrap="">
                  <?php echo $this->data['Kitchensystem']['libelle'] ?>
                </td>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap=""> 
                  <?php echo $this->data['Kitchensystem']['reference'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Store</td>
                <td nowrap="">
                  <?php echo $this->data['Store']['libelle'] ?>
                </td>
                <td class="tableHead" nowrap="">Société</td>
                <td nowrap=""> 
                  <?php echo $this->data['Societe']['designation'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Adresse IP</td>
                <td nowrap="">
                  <?php echo $this->data['Kitchensystem']['ip_adresse'] ?>
                </td>
                <td class="tableHead" nowrap="">Produits afféctés</td>
                <td nowrap=""> 
                  <?php echo count($this->data['Produit']) ?> produit(s)
                </td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Détail KDS 
    </div>
    <div class="actions">
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Référence</th>
                <th nowrap="">Libellé</th>
                <th class="actions" nowrap="">
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['reference']); ?></td>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="actions">
                    <?php if ($globalPermission['Permission']['s']): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Kitchensystemproduit']['id']]) ?>" class="action"><i class="fa fa-trash-o"></i> Supprimer</a>
                    <?php endif ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-multi-select/js/jquery.multi-select.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-quicksearch/jquery.quicksearch.js') ?>
<script>
  var Init = function(){
    $('#my_multi_select1').multiSelect({
      selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Recherche rapide...'>",
      selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Recherche rapide...'>",
      afterInit: function(ms){
      var that = this,
          $selectableSearch = that.$selectableUl.prev(),
          $selectionSearch = that.$selectionUl.prev(),
          selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
          selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

      that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
      .on('keydown', function(e){
        if (e.which === 40){
          that.$selectableUl.focus();
          return false;
        }
      });

      that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
      .on('keydown', function(e){
        if (e.which == 40){
          that.$selectionUl.focus();
          return false;
        }
      });
      },
      afterSelect: function(){
        count = $("#my_multi_select1 :selected").length;
        $('#count').html(count);
        this.qs1.cache();
        this.qs2.cache();
      },
      afterDeselect: function(){
        count = $("#my_multi_select1 :selected").length;
        $('#count').html(count);
        this.qs1.cache();
        this.qs2.cache();
      },
      selectableOptgroup: true ,
    });
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('click','.select-all',function (e) {
    e.preventDefault();
    $('#my_multi_select1').multiSelect('select_all');
  });

  $('#edit').on('click','.deselect-all',function (e) {
    e.preventDefault();
    $('#my_multi_select1').multiSelect('deselect_all');
  });

  $('#edit').on('change','#StoreId',function(e){
    e.preventDefault();
    var store_id = $(this).val();
    societe(store_id);
  });

  function societe(store_id) {
    $.ajax({
      type: 'GET',
      dataType: "json",
      url: "<?php echo $this->html->url(['action' => 'societe']) ?>/"+store_id,
      success : function(dt){
        $('.societe_id').val(dt.societe_id);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
    });
  }
</script>
<?php echo $this->element('view-script'); ?>
<?php $this->end() ?>