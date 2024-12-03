<?php foreach ($messages as $k => $message): ?>
	<?php if ($from['User']['id'] == $message['ChatmessageFrom']['from_id']): ?>
		<div class="chatRow post out" data-id="<?php echo $message['ChatmessageFrom']['id'] ?>">
			<img class="avatar" alt="" src="<?php
			if( $from['User']['avatar'] == null || !file_exists(WWW_ROOT.'/uploads/avatar/user/'.$from['User']['avatar']) )
				echo $this->Html->url('/img/no-avatar.jpg');
			else
				echo $this->Html->url('/uploads/avatar/user/'.$from['User']['avatar']);
			?>"/>
			<div class="message">
				<span class="arrow"></span>
				<a href="#" class="name"><?php echo $from['User']['nom'] ?> <?php echo $from['User']['prenom'] ?></a><br>
				<span class="datetime"><?php echo $this->Time->niceShort($message['ChatmessageFrom']['date_c']) ?></span>
				<span class="body"> <?php echo $message['ChatmessageFrom']['message'] ?> </span>
			</div>
		</div>
	<?php elseif ($to['User']['id'] == $message['ChatmessageFrom']['from_id']): ?>
		<div class="chatRow post in" data-id="<?php echo $message['ChatmessageFrom']['id'] ?>">
			<img class="avatar" alt="" src="<?php
			if( $to['User']['avatar'] == null || !file_exists(WWW_ROOT.'/uploads/avatar/user/'.$to['User']['avatar']) )
				echo $this->Html->url('/img/no-avatar.jpg');
			else
				echo $this->Html->url('/uploads/avatar/user/'.$to['User']['avatar']);
			?>"/>
			<div class="message">
				<span class="arrow"></span>
				<a href="#" class="name"><?php echo $to['User']['nom'] ?> <?php echo $to['User']['prenom'] ?></a><br>
				<span class="datetime"><?php echo $this->Time->niceShort($message['ChatmessageFrom']['date_c']) ?></span>
				<span class="body"> <?php echo $message['ChatmessageFrom']['message'] ?> </span>
			</div>
		</div>
	<?php endif ?>
<?php endforeach ?>