<?php
class UsersController extends AppController
{
	var $name = 'Users';
	
	function register()
	{
		if (!empty($this->params['form']))
		{
			if($this->data['User']['password'] == $this->data['User']['confirmed_password']){
				$this->data['User']['salt'] = md5(Time.now);
				$this->data['User']['password'] = md5(salt+$this->data['User']['password']);
				$this->data['User']['type'] = 'normal';
				if ($this->User->save($this->params['form']))
				{
					$this->flash('Te has registrado correctamente.',
					'');
				}
				else {
					$this->flash('Hubo un problema mientras te registrabas',
					'');
				}
			}
		}
	}
}
?>
