<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::newequip()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR.$back?>" method="POST" data-ajax="false">
			<input type="hidden" name="__method" value="insert" />
			<ul data-role="listview">
				<li class="ui-field-contain">
					<label for="equipmentname"><?=Language::equipname()?></label>
					<input type="text" name="equipmentname" maxlength="32" />
				</li>
				<li class="ui-field-contain">
					<label for="assetno"><?=Language::assetno()?></label>
					<input type="text" name="assetno" maxlength="32" />
				</li>
				<li>
					<input data-icon="plus" type="submit" value="<?=Language::addequipment()?>" />
				</li>
			</ul>
		</form>
	</div>
</div>
