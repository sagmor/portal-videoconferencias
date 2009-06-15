<h2><strong><?php __('user', true)?></strong></h2>
Saludos: <br />
  <?php echo $current_user['User']['name']; ?>
<ul>
	<li><?php echo $html->link(__('user_edit', true), array('controller' => 'users',
                                      'action' => 'edit')); ?></li>
    <?php if($current_user['User']['type'] == 'admin'){ ?>
      <li>
      	<?php echo $html->link( __('add_speech', true), array('controller' => 'speeches', 'action' => 'add')); ?>
      </li>
      <li>
      	<?php echo $html->link(__('config_access', true), array('controller' => 'users', 'action' => 'index')); ?>
      </li>
   	  <li>
   	    <?php echo $html->link(__('config_tags', true), array('controller' => 'tags', 'action' => 'administrar')); ?>
   	  </li>
   	<?php } ?>
	<li><?php echo $html->link(__('exit', true), array('controller' => 'users',
                                        'action' => 'logout')); ?></li>
</ul>