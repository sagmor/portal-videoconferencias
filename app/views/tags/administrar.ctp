<h2><b class="text1">Administrar Categorias</b></h2>
<?php echo $form->create('Tag', array('url' =>
									   array('controller' => 'tags', 'action' => 'administrar')));
?>
	<table>

<?php

echo $html->tableHeaders(
    array(
      'Nombre',
      '',
    )
);

foreach($data as $tag)
{
  echo $html->tableCells(
      array($tag['Tag']['name'],
      		$html->link('Eliminar', array('action'=>'delete',
							 			  'id'=>$tag['Tag']['id']), null, '¿Está seguro?')));
}
?>

</table>
<?php echo $form->input('Tag.name', array('label' => 'Nombre')); echo $form->submit('Crear');
	  $form->end();?>