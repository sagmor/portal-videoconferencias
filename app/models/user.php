<?php
class User extends AppModel
{
	var $name = 'User';
	var $hasAndBelongsToMany = array('Tag' =>
									 array('className' => 'Tag',
            							   'joinTable' => 'users_tags',
            							   'foreignKey' => 'user_id',
            							   'associationForeignKey' => 'tag_id'));
  
	var $validate = array(
	  'name' => array( 
	                'rule' => '/.+/',
	                'required' => true,
	                'message' => 'Debes ingresar un nombre'
	              ),
	  'email' => array( 
                  'email' => array(
                                'rule' => 'email',
                                'required' => true,
                                'message' => 'Ingrese un correo válido'
                              ),
	                'unique' => array(
	                              'rule' => 'validateUniqueEmail',
								                'message' => 'Este correo ya se encuentra registrado',
								                'on' => 'create'
								              ) 
								),
		'password' => array(
		              'rule' => 'validatePassword',
									'message' => 'Debe contener más de 5 caracteres'
								),
		'password_confirmation' => array(
                  'rule' => 'validatePasswordConfirmation',
  				        'message' => 'Debe Coincidir con la Contraseña'
  			        )
  			  );
						  

  function validatePassword() {
    if (!array_key_exists('hashed_password', $this->data['User'])) {
      if (!array_key_exists('password', $this->data['User'])) return false;
    }
    
    if (array_key_exists('password', $this->data['User']) && (strlen($this->data['User']['password']) > 0)) {
      if (strlen($this->data['User']['password']) < 5) return false;
    }
    
    return true;
    
  }
  
  function validatePasswordConfirmation() {
    if (array_key_exists('password', $this->data['User'])) {
      if (!array_key_exists('password_confirmation', $this->data['User'])) return false;
      if ($this->data['User']['password'] != $this->data['User']['password_confirmation']) return false;
    }
    
    return true;
  }
  
  function validateUniqueEmail() {
    if ($this->findCount(array('User.email' => $this->data['User']['email'])) > 0 ) {
      return false;
    } else {
      return true;
    }
  }
	
	function beforeSave() {
	  if (!array_key_exists('type', $this->data['User'])) {
	    $this->data['User']['type'] = 'normal';
	  }
	  
	  if (!array_key_exists('salt', $this->data['User'])) {
	    $this->data['User']['salt'] = md5(time());
	  }
	  
	  if (array_key_exists('password', $this->data['User'])) {
	    $this->data['User']['hashed_password'] = $this->encrypt($this->data['User']['salt'], $this->data['User']['password']);
	  }
	  
	  return true;
	}
	
	function encrypt($salt,$password) {
	  return md5($salt.$password);
	}
	
	public function authenticate($email, $password) {
	  if ($user = $this->findByEmail($email)) {
	    if ($user['User']['hashed_password'] == $this->encrypt($user['User']['salt'], $password)) {
	     return $user;
	    }
	  }
	  
    return null;
	}
}
?>