<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::techsupport()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<p><?=Language::unknown_page(Bean::extract("path"))?></p>
	</div>
</div>
