
<ul class="media-list list-items">

<?php foreach ($users as $k => $user): ?>
	<?php if ( array_key_exists($user['User']['id'], $enligne) ): ?>
	<li class="media" data-id="<?php echo $user['User']['id'] ?>">
		<div class="media-status">
		<?php if ( array_key_exists($user['User']['id'], $notRead) ): ?>
			<span class="badge badge-success"><?php echo $notRead[$user['User']['id']] ?></span>
		<?php endif ?>
			<span class="badge badge-success">&ensp;</span>
		</div>
		<img class="media-object" title="<?php echo $user['User']['nom'].' '.$user['User']['prenom'] ?>" src="<?php 
		if( $user['User']['avatar'] == null || !file_exists(WWW_ROOT.'/uploads/avatar/user/'.$user['User']['avatar']) )
			echo $this->Html->url('/img/no-avatar.jpg');
		else
			echo $this->Html->url('/uploads/avatar/user/'.$user['User']['avatar']);
		?>" alt="...">
		<div class="media-body" title="<?php echo $user['User']['nom'].' '.$user['User']['prenom'] ?>">
			<h4 class="media-heading"><?php echo String::truncate($user['User']['nom'].' '.$user['User']['prenom'],20); ?></h4>
			<div class="media-heading-sub">
				 <?php echo $user['Role']['libelle'] ?>
			</div>
		</div>
	</li>
	<?php endif ?>
<?php endforeach ?>

</ul>

<ul class="media-list list-items">

<?php foreach ($users as $k => $user): ?>
	<?php if ( !array_key_exists($user['User']['id'], $enligne) ): ?>
	<li class="media" data-id="<?php echo $user['User']['id'] ?>">
		<div class="media-status">
		<?php if ( array_key_exists($user['User']['id'], $notRead) ): ?>
			<span class="badge badge-success"><?php echo $notRead[$user['User']['id']] ?></span>
		<?php endif ?>
			<span class="badge badge-default">&ensp;</span>
		</div>
		<img class="media-object" title="<?php echo $user['User']['nom'].' '.$user['User']['prenom'] ?>" src="<?php
		if( $user['User']['avatar'] == null || !file_exists(WWW_ROOT.'/uploads/avatar/user/'.$user['User']['avatar'])  )
			echo $this->Html->url('/img/no-avatar.jpg');
		else
			echo $this->Html->url('/uploads/avatar/user/'.$user['User']['avatar']);
		?>" alt="...">
		<div class="media-body" title="<?php echo $user['User']['nom'].' '.$user['User']['prenom'] ?>">
			<h4 class="media-heading"><?php echo String::truncate($user['User']['nom'].' '.$user['User']['prenom'],20); ?></h4>
			<div class="media-heading-sub">
				<?php echo $user['Role']['libelle'] ?>
			</div> 
		</div>
	</li>
	<?php endif ?>
<?php endforeach ?>

</ul>

<div id="nbrMessageNotRead" style="display:none"><?php echo array_sum($notRead) ?></div>