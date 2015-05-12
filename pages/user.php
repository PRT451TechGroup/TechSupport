<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::user()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="lock"><a href="<?=APPDIR?>/user/login" data-transition="slide"><?=Language::login()?></a></li>
			<li data-icon="user"><a href="<?=APPDIR?>/user/register" data-transition="slide"><?=Language::register()?></a></li>
			<?php if (Session::verify()): ?>
			<li data-icon="power"><a href="<?=APPDIR?>/user/logout" data-transition="slide"><?=Language::logout()?></a></li>
			<?php endif;?>
		</ul>
	</div>
</div>
