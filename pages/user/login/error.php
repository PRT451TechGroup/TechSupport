<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::login()?></h1>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<p><?=$error?></p>
	</div>
</div>