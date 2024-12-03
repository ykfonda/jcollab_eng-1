<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">

		</div>
	</div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
      Liste des crédits client
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['e']): ?>
        <?php echo $this->Form->input('<i class="fa fa-file-excel-o"></i> Export Excel',['class'=>'btn btn-primary btn-sm ','label'=>false,'div'=>false,'type'=>'button','escape'=>false,'id'=>'ExcelBtn']); ?>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="formFilter">
          <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'callIndexAjaxExcel'); ?>
          <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'smallForm form-horizontal','id'=>'FilterIndexForm','autocomplete'=>'off')) ?>
            <div class="form-group row row">
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Bonlivraison.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
              </div>
              <!-- <div class="col-md-3">
                <div class="d-flex align-items-end">
                  <?php echo $this->Form->input('Filter.Bonlivraison.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                    <span class="input-group-addon">&nbsp;à&nbsp;</span>
                  <?php echo $this->Form->input('Filter.Bonlivraison.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
                </div>
              </div> -->
              <div class="col-md-3">
                <?php echo $this->Form->submit('Rechercher',array('class' => 'searchBtn btn btn-primary','div' => false)) ?>
                <?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>
              </div>
            </div>
          <?php echo $this->Form->end() ?>
        </div>
      </div>
      <div class="col-md-12">
        <div id="indexAjax"></div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;

  $(".select2").select2();

  // ----------------------- Filtre & Pagination ------------------------ //

  var loadIndexAjax = function(url){
    $.ajax({
      url: url,
      success : function(dt){
        $('#indexAjax').html(dt);
      }
    });
  }

  var loadIndexAjaxFilter = function(data,load){
    if(load !== true)
      dataPage = 1;

    $.ajax({
      type: 'POST',
      url: "<?php echo $this->Html->url(['action' => 'callIndexAjax']) ?>/" + dataPage,
      data: data,
      success : function(dt){
        $('#indexAjax').html(dt);
      }
    });
  }

  loadIndexAjaxFilter( dataFilter , false);

  $('#indexAjax').on('click','.pagination li:not(.disabled,.active) a',function(e){
    e.preventDefault();
    loadIndexAjax( $(this).attr('href') );
    dataPage = 1;

    SplitArr = $(this).attr('href').split('/');
    for (var i = 0; i < SplitArr.length; i++) {
      if(SplitArr[i].split(':')[0] == "page"){
        dataPage = SplitArr[i].split(':')[1];
      }
    };
  });

  $('.action').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });

  $('#indexAjax').on('click','.btnFlagDelete',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
      if( result ){
        $.ajax({
          url: url,
          success: function(dt){
            toastr.success("La suppression a été effectué avec succès.");
            loadIndexAjaxFilter( dataFilter, true );
          },
          error: function(dt){
            toastr.error("Il y a un problème")
          }
        });
      }
    });
  });

  $('#ExcelBtn').on('click',function(e){
    e.preventDefault();
    dataFilter = $('#FilterIndexForm').serialize();
    loadExcelFilter( dataFilter, false );
  });

  var loadExcelFilter = function(data,load){
    if(load !== true)
      dataPage = 1;

    $.ajax({
      type: 'POST',
      url: "<?php echo $this->Html->url(['action' => 'callIndexAjaxExcel']) ?>/" + dataPage,
      data: data,
      success : function(dt){
        window.open(dt ,'_blank' );
      }
    });
  }

  $('#FilterIndexForm').on('submit',function(e){
    e.preventDefault();
    dataFilter = $(this).serialize();
    loadIndexAjaxFilter( dataFilter, false );
  });

  $('.btnResetFilter').on('click',function(e){
    dataFilter = null;
    $('.select2').val('').trigger('change');
    loadIndexAjaxFilter( dataFilter, false );
  });

});
</script>
<?php $this->end() ?>