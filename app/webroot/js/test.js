var init = function(urlGetEEfile, urlUploader){
	var loadfiles = function(){
		$.ajax({
			//url: "<?php echo $this->Html->url(['controller' => 'efiles', 'action' => 'getEfileModules', 'processus_id', $idP]) ?>",
			url: urlGetEEfile,
			success: function(dt){
				$('#fileBrowser').html(dt);		}
		});
	}
	loadfiles();
	$("#fileBrowser").on('click', '.deleteFile', function(e){
		e.preventDefault();
		var url = $(this).attr('data-href');
		bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
			if( result ){
				$.ajax({
					url: url,
					success: function(dt){
						toastr.success(dt.message);
					},
					error: function(dt){
						if( dt.responseJSON == null ){
							toastr.error('il y a um probleme !');
						}else{
							toastr.error(dt.responseJSON.message);
						}
					},
					complete: function(){
						loadfiles();
					}
				});
			}
		});
	});

	var uploader = new plupload.Uploader({
		runtimes : 'html5,html4',
		//container : document.getElementById('plupload'),
		browse_button : 'browse',
		//url : "<?php echo $this->Html->url(array('controller' => 'efiles', 'action' => 'uploadModules', 'processus_id', $idP)) ?>",
		url : urlUploader,
		multipart : true,
		//urlstream_upload : true,
		multipart_params : {directory:'test'},
		filters : {
			//max_file_size : '30mb',
			/*mime_types: [
				{title : "Office files", extensions : "doc,docx"},
				{title : "Pdf files", extensions : "pdf"},
				{title : "Image files", extensions : "jpg,gif,png"},
				{title : "Video files", extensions : "mp4,wmv,flv"},
				{title : "Zip files", extensions : "zip.rar"}
			]*/
		},
	});

	uploader.init();

	uploader.bind('FilesAdded',function(up,files){
		var filelist = $('#filelist');
		for(var i in files){
			var file = files[i];
			filelist.append('<div id="'+file.id+'" class="file" fileName="'+file.name+'">'+file.name+' ('+plupload.formatSize(file.size)+') <div class="progress"><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%"></div></div> </div>');
		}
		uploader.start();
	});

	uploader.bind('UploadProgress',function(up,file){
		$('#'+file.id).find('.progress-bar').css('width',file.percent+'%');
	});

	uploader.bind('FileUploaded',function(up,file,response){
		var data = $.parseJSON(response.response);

		//$('#' + file.id).attr('data-id',data.id);
		if(data.error){
			toastr.error(data.message);
			$('#'+file.id).remove();
		}else{
			$('#'+file.id).find('.progress').fadeOut();
			//$('#'+file.id).append('<div class="deleteFile"> <a href="#"><span class="glyphicon glyphicon-remove"></span></a> </div>');
			toastr.success(data.message);
		}
		loadfiles();
	});

	uploader.bind('Error',function(up,err){
		toastr.error(err.message);
	});
}