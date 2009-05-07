<div class="mainform">
  <h2>Administrar Categorias</h2>
  <?php echo $form->create('Tag', array('url' =>
									   array('controller' => 'tags', 'action' => 'administrar')));?>
  <p>
    <table>
      <?php
        foreach($data as $tag){
  			echo $html->tableCells(array($tag['Tag']['name'],
  								   $html->link('Eliminar', array('action'=>'delete',
  								   								 'id'=>$tag['Tag']['id']),
  								   								 null,
  								   								 '¿Está seguro?')));
        }?>
    </table>
  </p>
  <p>
    <?php echo $form->input('Tag.name', array(
											'label' => 'Nombre',
											'size' => '26',
											'maxlength' => '25'));
    	  echo $form->submit('Crear');
	  	  $form->end();?>
  </p> 
</div>