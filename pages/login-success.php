<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::login()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<p><?=Language::goodlogin(Bean::extract("username"))?></p>
		<a href="<?=APPDIR.Bean::back()?>" data-rel="back" class="ui-btn ui-btn-icon-right ui-icon-action"><?=Language::_continue()?></a>
	</div>
</div>
