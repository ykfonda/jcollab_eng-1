<div class="hr"></div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-star"></i> Personalisation
        </div>
        <div class="actions">
            <?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'PersonalisationEditForm','class' => 'saveBtn btn btn-default')) ?>
        </div>
    </div>
    <div class="portlet-body" >
        <?php echo $this->Form->create('Personalisation',['id' => 'PersonalisationEditForm','class' => 'form-horizontal']); ?>
            <div class="row">
                <?php echo $this->Form->input('id'); ?>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="control-label col-md-3">Théme</label>
                        <div class="col-md-7">
                            <?php echo $this->Form->input('color_theme',['class' => 'form-control','label'=>false,'empty' => '--Théme','options'=>$this->Personalisation->getTheme()]); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Layout style</label>
                        <div class="col-md-7">
                            <?php echo $this->Form->input('layout',['class' => 'form-control','label'=>false,'empty' => '--Layout style','options'=>$this->Personalisation->getTemplateStyle()]); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Sidebar style</label>
                        <div class="col-md-7">
                            <?php echo $this->Form->input('sidebar_style',['class' => 'form-control','label'=>false,'empty' => '--Sidebar style','options'=>$this->Personalisation->getSidebarStyle()]); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Sidebar type</label>
                        <div class="col-md-7">
                            <?php echo $this->Form->input('sidebar_type',['class' => 'form-control','label'=>false,'empty' => '--Sidebar type','options'=>$this->Personalisation->getSidebarType()]); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Sidebar position</label>
                        <div class="col-md-7">
                            <?php echo $this->Form->input('sidebar_position',['class' => 'form-control','label'=>false,'empty' => '--Sidebar position','options'=>$this->Personalisation->getSidebarPosition(),'default'=>'none']); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Header</label>
                        <div class="col-md-7">
                            <?php echo $this->Form->input('header_type',['class' => 'form-control','label'=>false,'empty' => '--Header','options'=>$this->Personalisation->getHeader()]); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>