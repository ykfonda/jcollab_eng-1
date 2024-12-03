<?php if (!isset($options['portlet']) || $options['portlet'] != false ): ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					Pièce jointe
				</div>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
<?php endif ?>
				<div class="row Pj">
					<div class="col-md-8">
						<div id="fileBrowser">
						</div>
					</div>
					<div class="col-md-4">
						<div style="text-align:right">
						<?php if (!isset($options['addPJ']) || $options['addPJ'] == 'Y'): ?>
					  		<a href="#" id="browse" class="btn btn-primary btn-sm"><i class="fa fa-file-archive-o"></i> Parcourir</a>
						<?php endif ?>
						</div>
						<div class="portlet-body form" style="display:block">
							<div id="plupload">
								<!-- <a id="browse" href="#">Parcourir</a> -->
								<div id="filelist"></div>
							</div>
						</div>
					</div>
				</div>
<?php if (!isset($options['portlet']) || $options['portlet'] != false ): ?>
			</div>
		</div>
	</div>
</div>
<?php endif ?>