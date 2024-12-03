<?php if (!isset($options['disabled']) || $options['disabled'] == 'Y'): ?>
	<fieldset disabled>
<?php else: ?>
	<fieldset>
<?php endif ?>

<?php if (!isset($options['portlet']) || $options['portlet'] != false ): ?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					Survey
				</div>
				<div class="actions">
					<?php if (!isset($options['disabled']) || $options['disabled'] == 'N'): ?>
						<button type="submit" form="SurveyForm" class="saveSurvey btn btn-primary btn-sm" data-id="0">
						<i class="fa fa-save"></i> Enregistrer </button>
					<?php endif ?>
				</div>
			</div>
			<div class="portlet-body">
<?php endif ?>

				<div class="row">
					<div class="col-md-12" id="SurveyBody"></div>
				</div>

<?php if (!isset($options['portlet']) || $options['portlet'] != false ): ?>
			</div>
		</div>
	</div>
</div>
<?php endif ?>

</fieldset>