<?php echo $this->Html->css('/assets/admin/pages/css/inbox.css') ?>
<?php $this->start('page-bar') ?>
<div class="page-bar">
  <ul class="page-breadcrumb breadcrumb">
    <li>
      <i class="fa fa-home"></i>
      <a href="<?php echo $this->Html->url('/') ?>">Accueil</a>
      <i class="fa fa-angle-right"></i>
    </li>
    <li>
      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>">Mes message</a>
    </li>
  </ul>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<div class="messages form">
</div>
	<div class="row inbox">
		<div class="col-md-2">
			<ul class="inbox-nav margin-bottom-10">
				<li class="compose-btn active">
					<a href="<?php echo $this->Html->url(['action' => 'add']) ?>" data-title="Compose" class="btn green">
					<i class="fa fa-edit"></i> Ecrire </a>
				</li>
				<li class="inbox">
					<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn" data-title="Inbox">
					Boîte de réception <?php echo ($inbox > 0)? '('.$inbox.')' : ''; ?>
					</a>
					<b></b>
				</li>
				<li class="sent">
					<a class="btn" href="<?php echo $this->Html->url(['action' => 'sent']) ?>" data-title="Sent">
					Envoyé </a>
					<b></b>
				</li>
				<li class="trash">
					<a class="btn" href="<?php echo $this->Html->url(['action' => 'trash']) ?>" data-title="Trash">
					Corbeille <?php echo ($trash > 0)? '('.$trash.')' : ''; ?>
					</a>
					<b></b>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			<div class="inbox-header">
				<h1 class="pull-left">Ecrire un message</h1>
			</div>
			<div class="inbox-content">



<?php echo $this->Form->create('Message',['class' => 'inbox-compose form-horizontal', 'id' => 'fileupload']); ?>
	<div class="inbox-compose-btn">
		<button class="btn blue" type="submit" form="fileupload"><i class="fa fa-send"></i>Envoyer</button>
	</div>
	<div class="inbox-form-group row mail-to">
		<label class="control-label">à:</label>
		<div class="controls controls-to">
			<?php echo $this->Form->input('User',['label' => false, 'title' => '', 'class' => 'form-control select2', 'div' => false,'required'=>true]); ?>
		</div>
	</div>
	<div class="inbox-form-group row input-cc display-hide">
		<a href="javascript:;" class="close">
		</a>
		<label class="control-label">Cc:</label>
		<div class="controls controls-cc">
			<input type="text" name="cc" class="form-control">
		</div>
	</div>
	<div class="inbox-form-group row input-bcc display-hide">
		<a href="javascript:;" class="close">
		</a>
		<label class="control-label">Bcc:</label>
		<div class="controls controls-bcc">
			<input type="text" name="bcc" class="form-control">
		</div>
	</div>
	<div class="inbox-form-group row">
		<label class="control-label">Sujet:</label>
		<div class="controls">
			<?php echo $this->Form->input('subject',['label' => false, 'class' => 'form-control', 'div' => false]); ?>
		</div>
	</div>
	<div class="inbox-form-group row">
		<?php echo $this->Form->input('message',['label' => false, 'class' => 'inbox-editor inbox-wysihtml5 form-control', 'rows' => '12']); ?>
	</div>
	<div id="filesAttachment">
	</div>
	<div class="inbox-compose-attachment">
		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		<span class="btn green fileinput-button">
		<i class="fa fa-plus"></i>
		<span>
		Joindre fichier... </span>
		<input type="file" name="files[]" multiple>
		</span>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped margin-top-10">
		<tbody class="files">
		</tbody>
		</table>
	</div>
	<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="name" width="30%"><span>{%=file.name%}</span></td>
        <td class="size" width="40%"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" width="20%" colspan="2"><span class="label label-danger">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <p class="size">{%=o.formatFileSize(file.size)%}</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                   <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                   </div>
            </td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel" width="10%" align="right">{% if (!i) { %}
            <button class="btn btn-sm red cancel">
                       <i class="fa fa-ban"></i>
                       <span>Cancel</span>
                   </button>
        {% } %}</td>
    </tr>
{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td class="name" width="30%"><span>{%=file.name%}</span></td>
            <td class="size" width="40%"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" width="30%" colspan="2"><span class="label label-danger">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="name" width="30%">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size" width="40%"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete" width="10%" align="right">
            <button class="btn default btn-sm" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="fa fa-times"></i>
            </button>
        </td>
    </tr>
{% } %}
	</script>
	<div class="inbox-compose-btn">
		<button class="btn blue" type="submit" form="fileupload"><i class="fa fa-send"></i>Envoyer</button>
	</div>
<!-- </form> -->
<?php echo $this->Form->end(); ?>




					</div>
				</div>
			</div>

<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/fancybox/source/jquery.fancybox.pack.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/vendor/load-image.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js'); ?>

<?php echo $this->Html->script('/assets/admin/pages/scripts/inbox.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/tinymce/tinymce.min.js'); ?>
<script>
$(function(){

    $('#fileupload').fileupload({
        url: "<?php echo $this->Html->url(['action' => 'uploadAttachment']) ?>",
        autoUpload: true,
        success: function(dt){
	        var nbr = 0;
	        var inputName;
	        var inputSize;
	        var inputType;
        	$.each(dt.files, function(i,item){
        		nbr = $('#filesAttachment').children().length;
        		
        		inputName = $( "<input>" );
	        	inputName.attr({
	        		'name': 'Attachment['+nbr+'][name]',
	        		'value': dt.files[i].name,
	        		'type' : 'hidden'
	        	});
	        	$('#filesAttachment').append( inputName );

        		inputSize = $( "<input>" );
	        	inputSize.attr({
	        		'name': 'Attachment['+nbr+'][size]',
	        		'value': dt.files[i].size,
	        		'type' : 'hidden'
	        	});
	        	$('#filesAttachment').append( inputSize );

        		inputType = $( "<input>" );
	        	inputType.attr({
	        		'name': 'Attachment['+nbr+'][type]',
	        		'value': dt.files[i].type,
	        		'type' : 'hidden'
	        	});
	        	$('#filesAttachment').append( inputType );
        	});
        }
    });

    // Upload server status check for browsers with CORS support:
    if ($.support.cors) {
        $.ajax({
		//  url: '../../app-assets/plugins/jquery-file-upload/server/php/',
            url: "<?php echo $this->Html->url(['action' => 'uploadAttachment']) ?>",
            type: 'HEAD'
        }).fail(function () {
            $('<span class="alert alert-error"/>')
                .text('Upload server currently unavailable - ' +
                new Date())
                .appendTo('#fileupload');
        });
    }

	tinymce.init({
	    selector: '.inbox-wysihtml5',
	    forced_root_block_attrs: { "style": "margin: 5px 0;" },
		language:"fr_FR",
		height : 400,
		theme: 'modern',
		paste_data_images: false,
		menubar: false,
        plugins: "spellchecker table image advlist autolink lists  charmap print preview hr  pagebreak searchreplace  visualblocks visualchars code fullscreen insertdatetime   save table directionality paste textcolor colorpicker textpattern",
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | preview  | forecolor | backcolor | table',
        toolbar2:'sizeselect fontselect | fontsizeselect',
        image_advtab: true,
        statusbar: false,
        browser_spellcheck: true
    });

	$('.select2').select2(); 

	$(".select2").on("invalid", function(e) {
        e.preventDefault();
        toastr.error('Veuillez renseigner le champ');
        $(this).parent().css('border','1px solid #E57373');
        return false;
    });
})
</script>

<?php $this->end() ?>