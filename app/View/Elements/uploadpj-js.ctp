<?php //$folderId = isset($folderId)? $folderId: ''; ?>
<?php //echo $this->Html->script('/app-assets/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/js/plupload.full.min.js') ?>

<script>
  jQuery(function($){
	var PJUpload = function(urlGetEEfile, urlUploader){
		var loadfiles = function(){
			$.ajax({
				//url: "<?php echo $this->Html->url(['controller' => 'efiles', 'action' => 'getEfileModules', 'processus_id', 1]) ?>",
				url: urlGetEEfile,
				success: function(dt){
					$('#fileBrowser').html(dt);
				}
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
			browse_button : 'browse',
			url : urlUploader,
			multipart : true,
			multipart_params : {directory:'test'},
			filters : {
				mime_types : [
				    { title : "Image files", extensions : "jpg,gif,png,jpeg" },
				    { title : "Zip files", extensions : "zip,rar" },
				    { title : "Pdf files", extensions : "pdf" },
				    { title : "Text files", extensions : "txt,doc,docx,xls,xlsx,csv,ppt,pptx,xml" },
				    { title : "Video files", extensions : "mp4,flv,avi,mov,mpg,wma" },
				    { title : "Audio files", extensions : "mp3,wav" },
				    { title : "Outlook files", extensions : "msg,pst,htm,rtf" },
				  ],
				//max_file_size : '6mb',
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
			if(data.error){
				toastr.error(data.response);
				$('#'+file.id).remove();
			}else{
				$('#'+file.id).find('.progress').fadeOut();
				toastr.success(data.message);
			}
			loadfiles();
		});

		uploader.bind('Error',function(up,err){
			toastr.error(err.response);
		});
	}


	PJUpload("<?php echo $urlGetEEfile ?>","<?php echo $urlUploader ?>");
  });
</script>