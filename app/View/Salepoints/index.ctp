<style>
  .caisse {
    width : 15rem;
  }
</style>
<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
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
			 Ventes POS
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['e']): ?>
        <a href="<?php echo $this->Html->url(['action' => 'Bonretourt09']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Bons retour T09 </a>
        <?php 
        
          echo $this->Form->input('<i class="fa fa-file-excel-o"></i> Détail des tickets',['class'=>'btn btn-primary btn-sm ','label'=>false,'div'=>false,'type'=>'button','escape'=>false,'id'=>'ExcelBtn']); 

        ?>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'salepoints', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Salepoint.reference',array('label'=>false,'placeholder'=>'Ticket','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Salepoint.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
            </div>
            <?php if ( in_array($role_id, $admins) ): ?>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Salepoint.user_id',array('label'=>false,'empty'=>'--Vendeur','class'=>'select2 form-control')) ?>
            </div>
            <?php endif ?>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Salepoint.paye',array('label'=>false,'empty'=>'--Statut','class'=>'form-control','options'=>$this->App->getStatutPayment() )) ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <div class="d-flex align-items-end">


                <?php 
                // old code
                //echo $this->Form->input('Filter.Salepoint.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>

                <?php
                // Version  4.1
                // Obtenez la date actuelle au format souhaité
                  $defaultDate = date('d-m-Y');

                  // Utilisez la valeur par défaut dans l'option 'value' du formulaire
                  echo $this->Form->input('Filter.Salepoint.date1', array(
                      'label' => false,
                      'placeholder' => 'Date 1',
                      'class' => 'date-picker form-control',
                      'type' => 'text',
                      'value' => $defaultDate // Utilisez la variable $defaultDate comme valeur par défaut
                  ));
                ?>


                <span class="input-group-addon">&nbsp;à&nbsp;</span>


                <?php
                // old code
                //echo $this->Form->input('Filter.Salepoint.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>

                <?php
                // Obtenez la date actuelle au format souhaité
                $defaultDate = date('d-m-Y');

                // Utilisez la valeur par défaut dans l'option 'value' du formulaire
                echo $this->Form->input('Filter.Salepoint.date2', array(
                    'label' => false,
                    'placeholder' => 'Date 2',
                    'class' => 'date-picker form-control',
                    'type' => 'text',
                    'value' => $defaultDate // Utilisez la variable $defaultDate comme valeur par défaut
                ));
                ?>





                <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Salepoint.store',array('label'=>false,'empty'=>'--Store','class'=>'form-control')) ?>
              </div>
              <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Salepoint.societe_id',array('label'=>false,'empty'=>'--Société','class'=>'form-control')) ?>
              </div>
              <div class="col-md-3">
              <?php echo $this->Form->submit('Rechercher',array('class' => 'btn btn-primary','div' => false)) ?>
              </div>
              </div>
              
            </div>
           
          </div>
          <div class="form-group row">
            <div class="col-md-6">
            <div class="d-flex align-items-end">
              <?php echo $this->Form->input('Filter.Salepoint.heure1',array('label'=>false,'placeholder' => 'Heure 1','class'=>'form-control')) ?>
              <span class="input-group-addon">&nbsp;à&nbsp;</span>
              <?php echo $this->Form->input('Filter.Salepoint.heure2',array('label'=>false,'placeholder' => 'Heure 2','class'=>'form-control')) ?> 
              <span class="input-group-addon">&nbsp;&nbsp;</span>
              <?php echo $this->Form->input('Filter.Salepoint.caisse_id',array('label'=>false,'empty'=>'--Caisse','placeholder' => 'Caisse','class'=>'caisse form-control')) ?> 
            
            </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
             
              <?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>
            </div>
          </div>
          </div>  
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
  
</script>
<?php echo $this->element('main-script',["form" => "Bonretourt09"]); ?>
<?php $this->end() ?>