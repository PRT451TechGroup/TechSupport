<div data-role="page" data-back="<?=APPDIR?>/">
	<div data-role="header">
		<h1><?=Language::user()?></h1>
		<a href="#" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all"><?=Language::back()?></a>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="lock"><a href="<?=APPDIR?>/user/login" data-transition="slide"><?=Language::login()?></a></li>
			<li data-icon="user"><a href="<?=APPDIR?>/user/register" data-transition="slide"><?=Language::register()?></a></li>
		</ul>
	</div>
</div>
