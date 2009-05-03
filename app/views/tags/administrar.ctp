<h2><b class="text1">Administrar Categorias</b></h2>
<?php echo $form->create('Tag', array('url' =>
									   array('controller' => 'tags', 'action' => 'administrar')));?>
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
      array(
        array(
          $tag,
          $html->link('Eliminar',
          			  array('controller' => 'tags',
          			  		'action' => 'eliminar/'.$tag)))));
}
?>

</table>
<?php echo $form->input('Tag.name', array('label' => 'Nombre')); echo $form->end('Crear');?>