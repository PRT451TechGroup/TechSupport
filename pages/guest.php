<div data-role="page">
	<div data-role="header">
		<h1><?=Language::techsupport()?></h1>
		<?=Widgets::logout()?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="user"><a href="<?=APPDIR?>/user" data-transition="slide"><?=Language::user()?></a></li>
			<li data-icon="gear"><a href="<?=APPDIR?>/repair" data-transition="slide"><?=Language::repair()?></a></li>
		</ul>
	</div>
</div>
