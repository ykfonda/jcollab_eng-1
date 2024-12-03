<div class="hr"></div>
<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Paramétrage des alerts
    </div>
    <div class="actions">
      <?php echo $this->Form->submit('Enregistrer',['class' => 'saveBtn btn btn-primary btn-sm','form'=>'ParametrealertForm']) ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12" style="margin-bottom: 10px;">
        <?php if ( isset( $this->data['Parametrealert']['id'] ) AND !empty( $this->data['Parametrealert']['id'] ) ): ?>
          <!-- <a href="<?php echo $this->Html->url(['action' => 'generate']) ?>" class="generate btn btn-danger btn-sm pull-right"><i class="fa fa-refresh"></i> Générer des alerts</a> -->
        <?php endif ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php echo $this->Form->create('Parametrealert',['id'=>'ParametrealertForm','class'=>'form-horizontal']) ?>
          <?php echo $this->Form->input('id'); ?>
          <table class="table table-bordered table-striped table-hover tableHeadInformation ">
            <thead>
              <tr>
                <th nowrap="">Paramètre</th>
                <th nowrap="">Valeur</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Groupe administrateur</td>
                <td><?php echo $this->Form->input('groupe_id',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Groupe administrateur']); ?></td>
              </tr>
              <tr>
                <td>Envoi d'email</td>
                <td><?php echo $this->Form->input('email_check',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--','options'=>$this->App->OuiNon()]); ?></td>
              </tr>
            </tbody>
          </table>
        <?php echo $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script>
  var Init = function(){
    $('.uniform').uniform();
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('.generate').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir générer des alertes ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>