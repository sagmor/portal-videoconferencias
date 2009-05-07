<div class="speech">
	<h1 class="title"><?php echo $speech['Speech']['title']?></h1>
	<div class="meta">
		<p class="at"><?php echo $speech['Speech']['date']?> en <?php echo $speech['Speech']['location']?></p>
		<p class="links"> 32 Subscritos &nbsp;
		<?php if($current_user['User']['type'] == 'normal') {?>
			<a href="" class="comments">Subscribir!</a>
		<?php }?></p>
	</div>
	<div class="description">
	  <p>Presentadores</p>
	  <ul>
        <?php
            $presentadores = split("[,]|[\n]|[;]", $speech['Speech']['speakers']);
            foreach ($presentadores as $presentador):
    			if($presentador != ''):
        ?>
        <li><?php echo $presentador ?></li>
        <?php endif; endforeach; ?>
    </ul>
    
		<p>Descripción de la charla<br />
			<?php echo $speech['Speech']['description']?>
		</p>

		<p>Categorías</p>
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
			<h3>Administración</h3>
			<ul>
				<li>
					<a href="">Usuarios suscritos</a>
				</li>
				<li>
					<?php echo $html->link('Editar', array('action'=>'edit', 'id'=>$speech['Speech']['id']));?>
				</li>
				<li>
					<?php echo $html->link('Borrar', array(
													'action'=>'delete',
													'id'=>$speech['Speech']['id']),
													null,
													'¿Está seguro?')?>
				</li>
			</ul>
			<h3>Subir Archivo</h3>
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
				echo $form->submit('Subir');
				echo $form->end();
			?>
			<hr />
		<?php } ?>

		<h3>Adjuntos</h3>
		<ul>
			<li class="video">
				<a href="" rel="#attachment-1">Video de la Presentacion</a>
				<div id="attachment-1" class="overlay"></div>
			</li>
			<li class="document">
				<a href="" rel="#attachment-2">Presentación</a>
				<div id="attachment-2" class="overlay"></div>
			</li>
			<li class="image">
				<a href="" rel="#attachment-3">Una Foto</a>
				<div id="attachment-3" class="overlay"></div>
			</li>
			<li class="audio">
				<a href="" rel="#attachment-4">Un archivo de Audio</a>
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
				echo 'Esta charla no posee archivos adjuntos';

			endif;
		?>
	</div>
</div>