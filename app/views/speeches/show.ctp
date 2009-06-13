<div class="speech">
	<h1 class="title"><?php echo $speech['Speech']['title']?></h1>
	<div class="meta">
<<<<<<< HEAD:app/views/speeches/show.ctp
		<p class="at">
			<?php echo $speech['Speech']['date']?>
			<?php __('at')?>
			<?php echo $speech['Speech']['location']?></p>
		<p class="links"> <?php echo $speech_subscriptions.' '.__('users_suscribed')?>&nbsp;
		<?php if($current_user['User']['type'] == 'normal') {
		    echo $html->link(__('suscribe', true),
                             '/speeches/subscribe/'.$speech['Speech']['id']);
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
					<a href="">Usuarios suscritos</a>
				</li>
				<li>
					<?php echo $html->link(__('edit', true), array('action'=>'edit', 'id'=>$speech['Speech']['id']));?>
				</li>
				<li>
					<?php echo $html->link(__('delete', true), array(
													'action'=>'delete',
													'id'=>$speech['Speech']['id']),
													null,
													sprintf('¿'. __('are_you_sure_delete', true).' %s?', $title))?>
					
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
				echo $form->input('Attachment.name', array('size' => '20',
															'label' => 'Tipo de archivo (vídeo, presentación, etc.)'));
				echo $form->file('File');
				echo $form->submit(__('upload', true));
				echo $form->end();
			?>
			<hr />
		<?php } ?>

		<h3><?php __('attachments')?></h3>
		<ul>
			<li class="video">
				<a href="" rel="#attachment-1"><?php __('video_speech', true)?></a>
				<div id="attachment-1" class="overlay"></div>
			</li>
			<li class="document">
				<a href="" rel="#attachment-2"><?php __('file_speech', true)?></a>
				<div id="attachment-2" class="overlay"></div>
			</li>
			<li class="image">
				<a href="" rel="#attachment-3"><?php __('image_speech', true)?></a>
				<div id="attachment-3" class="overlay"></div>
			</li>
			<li class="audio">
				<a href="" rel="#attachment-4"><?php __('audio_speech', true)?></a>
				<div id="attachment-4" class="overlay"></div>
			</li>
		</ul>

		<ul>
			<?php
				$files = $this->requestAction('/attachments/getFiles/'.$speech['Speech']['id']);
				if ($files) :
				foreach ($files as $file) :
			?>
			<li>
				<?php
					echo $html->link($file['Attachment']['name'],
											"/attachments/download/".$file['Attachment']['id']);
					if($current_user['User']['type'] == 'admin'){
				?>
				&nbsp;
				<?php
						echo $html->link('Borrar', "attachments/delete/".$file);
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