<?php $this->start('modal'); ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php $this->end(); ?>
<div class="hr"></div>

<?php echo $this->Form->create('Parametreste', ['id' => 'ParametresteForm']); ?>
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Paramétrage général</h4>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li><?php echo $this->Form->submit('Enregistrer', ['class' => 'btn btn-primary btn-sm', 'form' => 'ParametresteForm']); ?></li>
      </ul>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-tabs nav-justified" role="tablist">
          <li class="nav-item active">
            <a class="nav-link active" id="ecommerce-settings" data-toggle="pill" href="#ecommerce-fill" aria-expanded="false">Paramétrage e-commerce</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="smtp-settings" data-toggle="pill" href="#smtp-fill" aria-expanded="true">Paramétrage SMTP</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="alerts-settings" data-toggle="pill" href="#alerts-fill" aria-expanded="false">Paramétrage des alertes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="code-barre-settings" data-toggle="pill" href="#code-barre-fill" aria-expanded="false">Paramétrage code à barre</a>
          </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="smtp-fill" aria-labelledby="smtp-settings" aria-expanded="true">
              <div class="row">
                <div class="col-md-12">
                    <div class="form-horizontal mt-1">
                      <table class="table table-bordered table-striped table-hover tableHeadInformation">
                        <thead>
                          <tr>
                            <th nowrap="">Paramètre</th>
                            <th nowrap="">Valeur</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <?php $Key = 'SMTP_host'; ?>
                              <?php echo $Helper[$Key]['label']; ?>
                            </td>
                            <td>
                              <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                              <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <?php $Key = 'SMTP_port'; ?>
                              <?php echo $Helper[$Key]['label']; ?>
                            </td>
                            <td>
                              <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                              <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <?php $Key = 'SMTP_username'; ?>
                              <?php echo $Helper[$Key]['label']; ?>
                            </td>
                            <td>
                              <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                              <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <?php $Key = 'SMTP_password'; ?>
                              <?php echo $Helper[$Key]['label']; ?>
                            </td>
                            <td>
                              <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                              <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'type' => 'password']); ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <?php $Key = 'SMTP_from'; ?>
                              <?php echo $Helper[$Key]['label']; ?>
                            </td>
                            <td>
                              <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                              <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <?php $Key = 'Email_all'; ?>
                              <?php echo $Helper[$Key]['label']; ?>
                            </td>
                            <td>
                              <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                              <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'options' => [1 => 'Oui', -1 => 'Non'], 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="alerts-fill" role="tabpanel" aria-labelledby="alerts-settings" aria-expanded="false">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-horizontal mt-1">
                    <table class="table table-bordered table-striped table-hover tableHeadInformation">
                      <thead>
                        <tr>
                          <th nowrap="">Paramètre</th>
                          <th nowrap="">Valeur
                            <a href="<?php echo $this->Html->url(['controller' => 'alerts', 'action' => 'generatealerts']); ?>" class="btn btn-danger pull-right action"> Générer les alerts </a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <?php $Key = 'Alert_duree'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td>
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'Alert_groupe'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td>
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'options' => $groupes, 'empty' => '--Groupe']); ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane " id="code-barre-fill" role="tabpanel" aria-labelledby="code-barre-settings" aria-expanded="false">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-horizontal mt-1">
                    <table class="table table-bordered table-striped table-hover tableHeadInformation">
                      <thead>
                        <tr>
                          <th nowrap="">Paramètre</th>
                          <th nowrap="" colspan="2">Valeur</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <?php $Key = 'cb_identifiant'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'minlength' => 4, 'maxlength' => 4]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'cb_produit_depart'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td>
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'type' => 'number', 'min' => 1, 'step' => 1, 'minlength' => 1, 'maxlength' => 1]); ?>
                          </td>
                          <td>
                            <?php $Key = 'cb_produit_longeur'; ?>
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'type' => 'number', 'min' => 1, 'step' => 1, 'minlength' => 1, 'maxlength' => 1]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'cb_quantite_depart'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td>
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'type' => 'number', 'min' => 1, 'step' => 1, 'minlength' => 1, 'maxlength' => 1]); ?>
                          </td>
                          <td>
                            <?php $Key = 'cb_quantite_longeur'; ?>
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'type' => 'number', 'min' => 1, 'step' => 1, 'minlength' => 1, 'maxlength' => 1]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'cb_div_kg'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true, 'type' => 'number', 'min' => 1, 'step' => 1]); ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane active" id="ecommerce-fill" role="tabpanel" aria-labelledby="ecommerce-settings" aria-expanded="false">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-horizontal mt-1">
                    <table class="table table-bordered table-striped table-hover tableHeadInformation">
                      <thead>
                        <tr>
                          <th nowrap="">Paramètre</th>
                          <th nowrap="" colspan="2">Valeur
                            <a href="<?php echo $this->Html->url(['action' => 'generatecommandes']); ?>" class="btn btn-danger pull-right action"> Générer les commandes </a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <?php $Key = 'Api pending'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'Api update pos'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'Api annulation partielle'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'Api Abondan total'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        
                        <tr>
                          <td>
                            <?php $Key = 'Api sync produits'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'User'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <?php $Key = 'Password'; ?>
                            <?php echo $Helper[$Key]['label']; ?>
                          </td>
                          <td colspan="2">
                            <?php echo $this->Form->hidden($keyParametrestes[$Key]['id'].'.Parametreste.id', ['value' => $keyParametrestes[$Key]['id']]); ?>
                            <?php echo $this->Form->input($keyParametrestes[$Key]['id'].'.Parametreste.value', ['label' => false, 'value' => $keyParametrestes[$Key]['value'], 'class' => 'form-control', 'required' => true]); ?>
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
    </div>
  </div>
</div>
 <?php echo $this->Form->end(); ?>

<?php $this->start('js'); ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;
  
  var Init = function(){
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
    $('.uniform').uniform();
    $('.select2').select2();
  }

  Init();

  $('.action').on('click',function(e) {
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ) {
        window.location.href = url;
      }
    });
  });

  $('form').on('submit',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    var form = $(this);
    $('.saveBtn').attr("disabled", true);
    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data:formData,
      success : function(dt){
        toastr.success("L'enregistrement a été effectué avec succès.");
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete : function(){
        $('.saveBtn').attr("disabled", false);
      },
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
        toastr.error("Il y a un probleme");
      },
      complete: function(){
        Init();
      }
    });
  });


});
</script>
<?php $this->end(); ?>