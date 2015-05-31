<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::loan()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="bars"><a href="<?=$APPLET_ROOT?>/review" data-transition="slide"><?=Language::loan_review()?></a></li>
			<li data-icon="calendar"><a href="<?=$APPLET_ROOT?>/calendar" data-transition="slide" data-ajax="false"><?=Language::loan_calendar()?></a></li>
			<li data-icon="recycle"><a href="<?=$APPLET_ROOT?>/completed" data-transition="slide" data-ajax="false"><?=Language::loan_completed()?></a></li>
			<li data-icon="plus"><a href="<?=$APPLET_ROOT?>/create" data-transition="slide"><?=Language::loan_create()?></a></li>
		</ul>
	</div>
</div>
