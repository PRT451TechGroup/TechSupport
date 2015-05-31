<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::request()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="calendar"><a href="<?=$APPLET_ROOT?>/calendar" data-transition="slide" data-ajax="false"><?=Language::request_calendar()?></a></li>
			<li data-icon="recycle"><a href="<?=$APPLET_ROOT?>/completed" data-transition="slide" data-ajax="false"><?=Language::request_completed()?></a></li>
			<li data-icon="plus"><a href="<?=$APPLET_ROOT?>/create" data-transition="slide"><?=Language::request_create()?></a></li>
		</ul>
	</div>
</div>
