<?php
class User extends AppModel
{
	var $name = 'User';
	var $hasAndBelongsToMany = array('Tag' =>
									 array('className' => 'Tag',
            							   'joinTable' => 'users_tags',
            							   'foreignKey' => 'user_id',
            							   'associationForeignKey' => 'tag_id'),
            					     'Speech' =>
									 array('className' => 'Speech',
            							   'joinTable' => 'speeches_users',
            							   'foreignKey' => 'user_id',
            							   'associationForeignKey' => 'speech_id'));

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
    if (!array_key_exists('hashed_password', $this->data['User']) || strlen($this->data['User']['hashed_password']) == 0) {
      if (!array_key_exists('password', $this->data['User']) || strlen($this->data['User']['password']) == 0) return false;
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

	  if (array_key_exists('password', $this->data['User']) && strlen($this->data['User']['password'])>0) {
	    $this->data['User']['hashed_password'] = $this->encrypt($this->data['User']['salt'], $this->data['User']['password']);
	  }

	  return true;
	}

  function afterCreate() {
        if($user['Data']['lang'] == 'es'){
                ae_send_mail("no-reply@remitente.com",
                             $this->data['User']['email'],
                             "Subscripción portal conferencias",
                             "Te haz registrado correctamente al portal de conferencias.\n".
                             "Tu constraseña es ".$this->data['User']['password']);
        }
        else{
                ae_send_mail("no-reply@remitente.com",
                             $this->data['User']['email'],
                             "Lectures portal subscription",
                             "You have been correctly registered to the lectures portal.\n".
                             "Your password is ".$this->data['User']['password']);
        }
  }

  function encrypt($salt,$password) {
  	return md5($salt.'-'.$password);
  }

  public function authenticate($email, $password) {
  	if ($user = $this->findByEmail($email)) {
  		if ($user['User']['hashed_password'] == $this->encrypt($user['User']['salt'], $password)) {
  			return $user;
  		}
  	}

  	return null;
  }

    function ae_send_mail($from, $to, $subject, $text, $headers=""){

        if (strtolower(substr(PHP_OS, 0, 3)) === 'win')
        $mail_sep = "\r\n";
        else
        $mail_sep = "\n";

        function _rsc($s)
        {
                $s = str_replace("\n", '', $s);
                $s = str_replace("\r", '', $s);
                return $s;
        }

        $h = '';
        if (is_array($headers))
        {
                foreach($headers as $k=>$v)
                $h = _rsc($k).': '._rsc($v).$mail_sep;
                if ($h != '') {
                        $h = substr($h, 0, strlen($h) - strlen($mail_sep));
                        $h = $mail_sep.$h;
                }
        }

        $from = _rsc($from);
        $to = _rsc($to);
        $subject = _rsc($subject);
        return mail($to, $subject, $text, 'From: '.$from.$h);
  }

}
?>