<div class="speech">
	<h1 class="title"><?php echo $speech['Speech']['title']?></h1>
	<div class="meta">
		<p class="at"><?php echo $speech['Speech']['date']?> en <?php echo $speech['Speech']['location']?></p>
		<p class="links"> 32 Subscritos &nbsp; <a href="" class="comments">Subscribir!</a></p>
	</div>
	<div class="description">
	  <p>Presentadores</p>
	  <ul>
        <?php
            $presentadores = split("[,]|[\n|\r]", $speech['Speech']['speakers']);
            foreach ($presentadores as $presentador):
    			if($presentador != ''):
        ?>
        <li><?php echo $presentador ?></li>
        <?php endif; endforeach; ?>
    </ul>
    
		<p>Descripción de la charla<br />
		  <?php echo $speech['Speech']['description']?></p>
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
    	  <?php echo $html->link('Borrar', array('action'=>'delete', 'id'=>$speech['Speech']['id']), null, '¿Está seguro?')?>
    	</li>
	  </ul>
	  <h3>Subir Archivo</h3>
    <?php
      echo $form->create('Attachment', array('url'=>array('action' => 'upload',
  													$speech['Speech']['id'],
  													$speech['Speech']['location']),
  										'type' => 'file'));
      echo $form->file('File');
      echo $form->submit('Upload');
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
	
	</div>
</div>


