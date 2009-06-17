<div class="speech">
<h1 class="title"><?php echo $speech['Speech']['title']?></h1>

<div class="meta">
	<p class="at">
		<?php echo $speech['Speech']['date']?>
		<?php __('at')?>
		<?php echo $speech['Speech']['location']?></p>
	<p class="links"> <?php echo $speech_subscriptions.' '.__('users_suscribed', true)?>&nbsp;
		<?php if($current_user['User']['type'] == 'normal') {
			if($this->requestAction('/speeches/isCurrentUserSubscribed/'.$speech['Speech']['id'])){
				echo $html->link(__('edit_suscription', true),
									 '/speeches/subscribe/'.$speech['Speech']['id']);
				echo '&nbsp;&nbsp;';
				echo $html->link(__('unsubscribe', true),
									 '/speeches/unsubscribe/'.$speech['Speech']['id']);

			}
			else{
				echo $html->link(__('suscribe', true),
									 '/speeches/subscribe/'.$speech['Speech']['id']);
			}
		}?>
	</p>
</div>
<div class="description">
	<p><?php __('speakers')?></p>
	<ul>
		<?php
		$presentadores = split("[,]|[\n]|[;]", $speech['Speech']['speakers']);
		foreach ($presentadores as $presentador):
		if($presentador != ''):
		?>
		<li><?php echo $presentador ?></li>
		<?php endif; endforeach; ?>
	</ul>

	<p><?php __('description')?><br />
		<?php echo $speech['Speech']['description']?>
	</p>

	<p><?php __('tags')?></p>
	<?php
	$tags = $this->requestAction('speeches/getTagsBySpeechId/'.$speech['Speech']['id']);
	foreach ($tags as $tag) :
	?>
	<ul>
		<li><?php echo $tag['name']?></li>
	</ul>
	<?php endforeach; ?>

</div>

<div class="attachments">
<?php if($current_user['User']['type'] == 'admin'){ ?>
<h3><?php __('administration')?></h3>
<ul>
	<li>
		<?php echo $html->link(__('edit', true), array('action'=>'edit', 'id'=>$speech['Speech']['id']));?>
	</li>
	<li>
		<?php echo $html->link(__('delete', true), array(
														'action'=>'delete',
														'id'=>$speech['Speech']['id']),
			null,
			sprintf('¿'. __('are_you_sure_delete', true).' %s?', $speech['Speech']['title']))?>

	</li>
</ul>
<h3><?php __('upload_file')?></h3>
<?php
$folder = '/files/'.$speech['Speech']['id'].'/';
echo $form->create('Attachment', array(
												'url'=>array(
															'action' => 'upload',
			$speech['Speech']['id'],
			$folder,
			$speech['Speech']['title']
		),
												'type' => 'file'));

echo $form->input('Attachment.name',
	array ('label' => 'Tipo de archivo (vídeo, presentación, etc.)',
							 'options' => array(
												'video' => __('video_speech', true),
												'ppt' => __('file_speech', true),
												'foto' => __('image_speech', true),
												'audio' => __('audio_speech', true),
												'otro' => __('other', true)
		)));

echo $form->file('File');
echo $form->submit(__('upload', true));
echo $form->end();
?>
<hr />
<?php } ?>

<h3><?php __('attachments')?></h3>

<ul>
	<?php
	$files = $this->requestAction('/attachments/getFiles/'.$speech['Speech']['id']);
	if ($files) :
	foreach ($files as $file) :
	?>
	<?php
	switch ($file['Attachment']['name']) {
		case 'video':
			echo '<li class="video">';
			$file_type = __('video_speech', true);
			break;
		case 'ppt':
			echo '<li class="document">';
			$file_type = __('file_speech', true);
			break;
		case 'foto':
			echo '<li class="image">';
			$file_type = __('image_speech', true);
			break;
		case 'audio':
			echo '<li class="audio">';
			$file_type = __('audio_speech', true);
			break;
		default:
			echo '<li>';
			$file_type = __('other', true);
			break;
	}
	?>
	<?php
	echo $html->link($file_type,
												"/attachments/download/".$file['Attachment']['id']);
	if($current_user['User']['type'] == 'admin'){
		?>
	&nbsp;
	<?php
	echo  $html->link(__('delete', true) , array('controller' => 'attachments','action' => 'delete', $file['Attachment']['id'], $speech['Speech']['id']),null,
		sprintf(__('are_you_sure_delete', true).' %s?', $file_type));
}
?>
	</li>
	<?php endforeach;?>
</ul>

<?php
else :
echo __("not_attachment", true);

endif;
?>
</div>
</div>
