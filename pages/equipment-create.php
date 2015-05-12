<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::newequip()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR.Bean::back()?>" method="POST">
			<input type="hidden" name="__action" value="addequipment" />
		<ul data-role="listview">
			<li class="ui-field-contain">
				<label for="equipmentname"><?=Language::equipname()?></label>
				<input type="text" name="equipmentname" maxlength="32"
					data-validate="data-validate"
					data-regex-1="" data-msg-1
					data-regex-0="^\w+[\w ]*$" data-msg-0="<?=Language::validate_equipmentname1()?>"  />
			</li>
			<li class="ui-field-contain">
				<label for="assetno"><?=Language:assetno()?></label>
				<input type="text" name="assetno" maxlength="32" />
			</li>
			<li class="ui-field-contain">
				<label for="description"><?=Language::equipdesc()?></label>
				<textarea name="description"></textarea>
			</li>
			<li>
				<input data-icon="plus" type="submit" value="<?=Language::addequipment()?>" />
			</li>
		</ul>
		</form>
	</div>
</div>
