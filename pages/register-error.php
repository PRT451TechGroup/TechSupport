<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::register()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<p><?=$error?></p>
	</div>
</div>
