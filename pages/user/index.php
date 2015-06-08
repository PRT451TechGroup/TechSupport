<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::user()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="power"><a href="<?=$APPLET_ROOT?>/logout" data-transition="slide" data-ajax="false"><?=Language::logout()?></a></li>
			<li data-icon="edit"><a href="<?=$APPLET_ROOT?>/change" data-transition="slide" data-ajax="false"><?=Language::change_password()?></a></li>
			<li data-icon="check"><a href="<?=$APPLET_ROOT?>/approve" data-transition="slide"><?=Language::approve_users()?></a></li>
		</ul>
	</div>
</div>