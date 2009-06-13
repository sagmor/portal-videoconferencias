<div class="mainform">
  <h2>Configurar permisos</h2>
  <?php echo $form->create('Tag', array('url' =>
									   array('controller' => 'users', 'action' => 'index')));?>
  <p>
    <table width = "75%">
      <?php
		echo $html->tableHeaders(array(__('name', true),
									   __('email', true),
									   __('type', true),
									   '',
									   ''));
		foreach($users as $user){
			echo $html->tableCells(array($user['User']['name'],
										 $user['User']['email'],
										 $user['User']['type'],
										 $html->link(__('change_type', true),
													 array('action' => 'cambiarPermiso',
													 	   'id' => $user['User']['id'])),
										 $html->link(__('delete', true),
													 array('action' => 'eliminar',
													 	   'id' => $user['User']['id']))));
		}?>
    </table>
  </p> 
</div>