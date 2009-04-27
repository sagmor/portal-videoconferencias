<?php
class SpeechesController extends AppController {
    var $helpers = array('Html', 'Javascript', 'Form');
    var $name = 'Speeches';

    function index() {
        $this->set('speeches', $this->Speech->find('all'));
    }

    function view_speech($id = null) {
        $this->Speech->id = $id;
        $this->set('speech', $this->Speech->read());
    }

    function add() {
        if(!empty($this->data)) {
            if($this->Speech->save($this->data)) {
                $this->flash('Nueva charla creada', '', 1);
                $this->redirect(array('action' => '/'));
            }
        }
    }

    function edit($id = null) {
        $this->Speech->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Speech->read();
        } else {
            if ($this->Speech->save($this->data)) {
                $this->flash('La charla ha sido modificada exitosamente.', '/', 1);
                $this->redirect(array('action' => '/'));
            }
        }
    }

    function delete($id) {
        $this->Speech->del($id);
        $this->flash('The speech with id: '.$id.' has been deleted.', '/speeches/', 0);
        $this->redirect(array('action' => '/'));
    }

}
?>