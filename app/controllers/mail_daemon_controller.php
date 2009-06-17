<?php
class MailDaemonController extends AppController {
	
	var $name = 'MailDaemon';
	var $uses = array('Speech');
	
	function index(){
		
		$fecha = date('Y-m-d H:i:s');
		$toNotify = $this->Speech->SpeechesUser->find('all',
			                                          array('conditions' =>
			                                                array('remember_at <=' => $fecha,
			                                                      'resend_in !=' => '2009-06-14')));
		$i=0;
		$out = '';
		foreach($toNotify as $notif){
			$user = $this->Speech->User->find('first',
			                                  array('conditions' =>
			                                        array('id' => $notif['SpeechesUser']['user_id'])));
			$user = $user['User'];                                        
			$speech = $this->Speech->find('first',
			                              array('conditions' =>
			                                    array('id' => $notif['SpeechesUser']['speech_id'],
			                                          'date >=' => $fecha )));
			$speech = $speech['Speech'];
			if($speech){
				$to = $user['email'];
				if($user['lang'] = 'es'){
					$subject = 'Recordatorio charla '.$speech['title'].' - Portal Conferencias DCC';
					$from = 'Portal Conferencias DCC <noreply@example.com>';
					$text = 'Le recordamos que la charla '.$speech['title'].
            	            ' se llevara a cabo en la fecha'.$speech['date'].
            	            'Para más información visite la siguiente dirección '.
        		            'http://'.$_SERVER['SERVER_NAME'].'/speeches/show/'.$speech['id'];
					$this->ae_send_mail($from, $to, $subject, $text);
					$out.='Mail enviado a '.$user['email']."<br>";
					$i++;
				}
				else{
					$subject = 'Reminder of the lecture '.$speech['title'].' - Portal Conferencias DCC';
					$from = 'Portal Conferencias DCC <noreply@example.com>';
					$text = 'We remind you that the lecture '.$speech['title'].
            	            ' will be held on '.$speech['date'].
            	            'For further information visit the next page '.
        		            'http://'.$_SERVER['SERVER_NAME'].'/speeches/show/'.$speech['id'];
					$this->ae_send_mail($from, $to, $subject, $text);
					$out.='Mail sent to '.$user['name'].'<br>';
					$i++;
				}
				$notif['SpeechesUser']['remember_at'] = date('m-d-Y H:i:s',
				                                             time()+$notif['SpeechesUser']['resend_in']*24*60*60);
			    $this->Speech->SpeechesUser->save($notif);
			}
		}
		$out.="$i mails enviados<br>";
		$this->set('out', $out);
	}
	
	function _rsc($s)
	{
		$s = str_replace("\n", '', $s);
		$s = str_replace("\r", '', $s);
		return $s;
	}
	
	function ae_send_mail($from, $to, $subject, $text, $headers=""){

		if (strtolower(substr(PHP_OS, 0, 3)) === 'win')
		$mail_sep = "\r\n";
		else
		$mail_sep = "\n";

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

		$from = $this->_rsc($from);
		$to = $this->_rsc($to);
		$subject = $this->_rsc($subject);
		return mail($to, $subject, $text, 'From: '.$from.$h);
	}

}
?>