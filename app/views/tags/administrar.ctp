<div class="mainform">
  <h2><?php __('title_admin')?></h2>
  <?php echo $form->create('Tag', array('url' =>
									   array('label' => __('tag', true),
											'controller' => 'tags', 'action' => 'administrar')));?>
  <p>
    <table>
      <?php
        foreach($data as $tag){
  			echo $html->tableCells(array($tag['Tag']['name'],
  								   $html->link(__('delete', true), array('action'=>'delete',
  								   								 'id'=>$tag['Tag']['id']),
  								   								 null,
  								   								 '¿Está seguro?')));
        }?>
    </table>
  </p>
  <p>
    <?php echo $form->input('Tag.name', array(
											'label' => __('add_tag', true),
											'size' => '26',
											'maxlength' => '25'));
    	  echo $form->submit(__('save', true));
	  	  $form->end();?>
  </p> 
</div>