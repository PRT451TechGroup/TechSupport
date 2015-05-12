<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::login()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<p><?=Bean::error()?></p>
	</div>
</div>
