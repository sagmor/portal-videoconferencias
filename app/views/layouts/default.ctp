

<?php echo $html->doctype() ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php echo $html->charset() ?>
  <title><?php echo $title_for_layout?></title>

  <?php echo $html->css('default') ?>
  <?php echo $html->css('jquery-ui') ?>
  <?php echo $javascript->link('jquery') ?>
  <?php echo $javascript->link('jquery-ui') ?>
  <?php echo $javascript->link("standardista-table-sorting/common"); ?>
  <?php echo $javascript->link("standardista-table-sorting/css"); ?>
  <?php echo $javascript->link("standardista-table-sorting/standardista-table-sorting"); ?>
  <?php echo $scripts_for_layout ?>
</head>

<body>
  <!-- start header -->
  <div id="header">
  	<div id="logo">
  		<h1><a href="#">Portal Conferencias<sup></sup></a></h1>
  		<h2>Departamento de Ciencias de la Computación</h2>
  	</div>
  	<div id="menu">
  		<ul>
  			<li>
  			  <?php echo $html->link('Inicio', '/'); ?>
			</li>
			<li>
			  <?php echo $html->link('Buscar', array('controller' => 'speeches', 'action' => 'search')); ?>
			</li>
  			<li>
  			  <?php echo $html->link('Calendario', array('controller' => 'calendar', 'action' => 'index')); ?>
  			<li>
  			  <?php echo $html->link('Acerca de', array('controller' => 'pages', 'action' => 'display', 'about')); ?>
        </li>
  		</ul>
  	</div>
  </div>
  <!-- end header -->
  <!-- start page -->
  <div id="page">
  	<!-- start content -->
  	<div id="content">
    <?php echo $content_for_layout ?>
  	</div>
  	<!-- end content -->
  	<!-- start sidebar -->
  	<div id="sidebar">
  		<ul>
  			<li>
  				<?php
  				  if($current_user == null) {
  				      echo $this->renderElement('loginbox');
  				    } else {
  				      echo $this->renderElement('user_data');
  				    } ?>
  			</li>
  			<?php
  			  if ($this->params['controller'] != 'calendar') {
  			   echo "<li>".$this->renderElement('calendarbox')."</li>";
  			  }
  			?>
  			<li>
  				<?php echo $this->renderElement('next_speaches'); ?>
  			</li>
  		</ul>
  	</div>
  	<!-- end sidebar -->
  	<div style="clear: both;">&nbsp;</div>
  </div>
  <!-- end page -->
  <!-- start footer -->
  <div id="footer">
  	<p id="legal">(c) 2008 YourSite. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
  </div>
  <!-- end footer -->
  </body>
  <!--

  Design by Free CSS Templates
  http://www.freecsstemplates.org
  Released for free under a Creative Commons Attribution 2.5 License

  Title      : Complimentary
  Version    : 1.0
  Released   : 20080409
  Description: A two-column, fixed-width and lightweight template ideal for 1024x768 resolutions. Suitable for blogs and small websites.

  -->
</html>