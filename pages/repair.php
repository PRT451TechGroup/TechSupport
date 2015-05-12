<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::repair()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="bars"><a href="<?=APPDIR?>/repair/review" data-transition="slide"><?=Language::repair_review()?></a></li>
			<li data-icon="plus"><a href="<?=APPDIR?>/repair/create" data-transition="slide"><?=Language::repair_create()?></a></li>
		</ul>
	</div>
</div>