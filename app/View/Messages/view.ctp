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
<div class="row inbox">
	<div class="col-md-2">
		<ul class="inbox-nav margin-bottom-10">
			<li class="compose-btn">
				<a href="<?php echo $this->Html->url(['action' => 'add']) ?>" data-title="Compose" class="btn green">
				<i class="fa fa-edit"></i> Compose </a>
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
<!-- 			<li class="draft">
	<a class="btn" href="javascript:;" data-title="Draft">
	Draft </a>
	<b></b>
</li> -->
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
						<h1 class="pull-left">Voir le message</h1>
					</div>
					<div class="inbox-loading" style="display: none;">
						 Loading...
					</div>
					<div class="inbox-content"><div class="inbox-header inbox-view-header">
	<h1 class="pull-left"><?php echo $message['Message']['subject'] ?>
	<a href="javascript:;">
	<?php if ($toUserKey !== -1): ?>
		<?php if ($message['MessagesUser'][$toUserKey]['istrash'] == '0'): ?>
			Boîte de réception
		<?php else: ?>
			Corbeille
		<?php endif ?>
	<?php else: ?>
		Envoyé
	<?php endif ?>
	</a>
	</h1>
	<div class="pull-right">
		<a class="delete btn btn-danger btn-sm" href="<?php echo $this->Html->url(['action' => 'trashMessage', $message['Message']['id']]) ?>"> <i class="fa fa-trash-o"></i> Supprimer </a>
	</div>
</div>
<div class="inbox-view-info">
	<div class="row">
		<div class="col-md-12">
			<?php if (isset($message['From']['avatar']) AND file_exists(WWW_ROOT.'/uploads/avatar/user/'.$message['From']['avatar'])): ?>
				<img alt="" class="round" src="<?php echo $this->Html->url('/uploads/avatar/user/'.$message['From']['avatar']) ?>" style="width: 35px;" />
			<?php else: ?>		
				<img alt="" class="round" src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" style="width: 35px;" />
			<?php endif ?>
			<span class="bold">
				&ensp;<?php echo $message['From']['nom'] ?> <?php echo $message['From']['prenom'] ?>&ensp;à&ensp;
			</span>
			<span class="bold">
				<?php foreach ($message['MessagesUser'] as $key => $val): ?>
					<small><?php echo $val['User']['nom'] ?> <?php echo $val['User']['prenom'] ?>,</small>
				<?php endforeach ?>
			</span>
			le <?php echo date("F j, Y, H:i",strtotime($message['Message']['date_c'])); ?>
		</div>
	</div>
</div>
		<div class="inbox-view">
			<?php echo $message['Message']['message'] ?>
		</div>

		<hr>

		<div class="inbox-attached">
			<div class="margin-bottom-15">
				<span> <?php echo count($message['Attachment']); ?> fichier(s) attaché(s) </span>
			</div>
			<?php foreach ($message['Attachment'] as $k => $v): ?>
				<div class="margin-bottom-25">
					<div>
						<strong><?php echo $v['name'] ?></strong>
						<span> <?php echo $this->App->formatSize($v['size']) ?> </span>
						<a href="<?php echo $this->Html->url('/attachments/'.$v['name']) ?>" download="<?php echo $v['name'] ?>"> Télécharger </a>
					</div>
				</div>
			<?php endforeach ?>
		</div>


		</div><hr/>
		<?php if ($toUserKey === -1): ?>
			<?php foreach ($message['MessagesUser'] as $v): ?>
				<small>
					<?php echo $v['User']['nom'] ?> : <?php echo ( $v['isread'] == 0 )? 'Non Lu' : 'Lu'; ?> <br>
				</small>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>

<?php $this->start('js') ?>
<script type="text/javascript">
$(document).ready(function() {

	$('.delete').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
	      if( result ){
	      	window.location = url;
	      }
	    });
	  });

});
</script>
<?php $this->end() ?>

