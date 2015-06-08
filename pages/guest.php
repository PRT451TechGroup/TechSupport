<div data-role="page">
	<div data-role="header">
		<h1><?=Language::techsupport()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::userhome()?>
	</div>
	<div data-role="content">
		<img src="<?=APPDIR?>/themes/images/appLogo.jpg" alt="Mountain View" >
		<ul data-role="listview" data-inset="true">
			<li data-icon="gear"><a href="<?=APPDIR?>/repair" data-transition="slide"><?=Language::repair()?></a></li>
			<li data-icon="mail"><a href="<?=APPDIR?>/request" data-transition="slide"><?=Language::request()?></a></li>
			<li data-icon="recycle"><a href="<?=APPDIR?>/loan" data-transition="slide"><?=Language::loan()?></a></li>
		</ul>
	</div>
</div>