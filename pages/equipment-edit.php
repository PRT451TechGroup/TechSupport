<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::editequip()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR.Bean::back()?>" method="POST" data-validate="equipment-edit" data-ajax="false">
			<input type="hidden" name="__action" value="equipment-edit" />
			<input type="hidden" name="equipmentid" value="<?=Bean::equipmentid()?>" />
			<ul data-role="listview">
				<li class="ui-field-contain">
					<label for="equipmentname"><?=Language::equipname()?></label>
					<input type="text" name="equipmentname" maxlength="32" value="<?=Bean::equipment()->equipmentname?>" />
				</li>
				<li class="ui-field-contain">
					<label for="assetno"><?=Language::assetno()?></label>
					<input type="text" name="assetno" maxlength="32" value="<?=Bean::equipment()->assetno?>" />
				</li>
				<li class="ui-field-contain">
					<label for="description"><?=Language::equipdesc()?></label>
					<textarea name="description"><?=htmlspecialchars(Bean::equipment()->description)?></textarea>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=APPDIR.Bean::back().'/'.Bean::equipmentid()?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input data-icon="check" type="submit" value="<?=Language::save()?>" />
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>
