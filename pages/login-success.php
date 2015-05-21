<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::login()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<p><?=Language::goodlogin(array("username" => $username))?></p>
		<a href="<?=APPDIR.$back?>" data-rel="back" class="ui-btn ui-btn-icon-right ui-icon-action"><?=Language::_continue()?></a>
	</div>
</div>
