<?php
class MailDaemonController extends AppController {
	
	var $name = 'MailDaemon';
	var $uses = array('Speech');
	
	function index(){
		
		$fecha = date('m-d-Y H:i:s');
		$manana_comienzo = date('m-d-Y', time()+24*60*60).' 00:00:00';
		$manana_fin = date('m-d-Y', time()+24*60*60).' 23:59:59';
		$toNotify = $this->Speech->SpeechesUser->find('all',
			                                          array('conditions' =>
			                                                array('remember_at <=' => $fecha,
			                                                      'resend_in !=' => '0')));
		$charlasManana = $this->Speech->find('all',
			                                               array('conditions' =>
			                                                     array('date <=' => $manana_fin,
			                                                           'date >=' => $manana_comienzo)));                                                   
			                                                	                                                
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
				if($user['lang'] = 'esp'){
					$subject = 'Recordatorio charla '.$speech['title'].' - Portal Conferencias DCC';
					$from = 'Portal Conferencias DCC <no-reply@videosdcc.cl>';
					$text = 'Le recordamos que la charla '.$speech['title'].
                                                ' se llevara a cabo en la fecha'.$speech['date'].
                                                'Para más información visite la siguiente dirección '.
                                        $this->getRoot().'/speeches/show/'.$speech['id'];
					$this->ae_send_mail($from, $to, $subject, $text);
					$out.='Mail enviado a '.$user['email']."<br>";
					$i++;
				}
				else{
					$subject = 'Reminder of the lecture '.$speech['title'].' - Portal Conferencias DCC';
					$from = 'Portal Conferencias DCC <no-reply@videosdcc.cl>';
					$text = 'We remind you that the lecture '.$speech['title'].
                                                ' will be held on '.$speech['date'].
                                                'For further information visit the next page '.
        		            $this->getRoot().'/speeches/show/'.$speech['id'];
					$this->ae_send_mail($from, $to, $subject, $text);
					$out.='Mail sent to '.$user['name'].'<br>';
					$i++;
				}
				$notif['SpeechesUser']['remember_at'] = date('m-d-Y H:i:s',
				                                             time()+$notif['SpeechesUser']['resend_in']*24*60*60);
			    $this->Speech->SpeechesUser->save($notif);
			}
		}
		
		foreach($charlasManana as $speech){
			foreach($speech['User'] as $user){
					$to = $user['email'];
					if($user['lang'] = 'esp'){
						$subject = 'Recordatorio charla '.$speech['Speech']['title'].' - Portal Conferencias DCC';
						$from = 'Portal Conferencias DCC <no-reply@videosdcc.cl>';
						$text = 'Le recordamos que la charla '.$speech['Speech']['title'].
                                                        ' se llevara a cabo en mañana '.
                                                        'Para más información visite la siguiente dirección '.
        		            $this->getRoot().'/speeches/show/'.$speech['Speech']['id'];
						$this->ae_send_mail($from, $to, $subject, $text);
						$out.='Mail enviado a '.$user['email']."<br>";
						$i++;
					}
					else{
						$subject = 'Reminder of the lecture '.$speech['Speech']['title'].' - Portal Conferencias DCC';
						$from = 'Portal Conferencias DCC <no-reply@videosdcc.cl>';
						$text = 'We remind you that the lecture '.$speech['Speech']['title'].
                                                        ' will be held tomorrow '.
                                                        'For further information visit the next page '.
        	                                $this->getRoot().'/speeches/show/'.$speech['Speech']['id'];
						$this->ae_send_mail($from, $to, $subject, $text);
						$out.='Mail sent to '.$user['name'].'<br>';
						$i++;
					}
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
	
	function getRoot(){
		return 'http://'.$_SERVER['SERVER_NAME'].'/videos';
	}

}
?>
