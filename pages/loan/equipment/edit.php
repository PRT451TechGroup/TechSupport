<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::editequip()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR.$back?>" method="POST" data-ajax="false">
			<input type="hidden" name="__method" value="update" />
			<input type="hidden" name="equipmentid" value="<?=$equipmentid?>" />
			<ul data-role="listview">
				<li class="ui-field-contain">
					<label for="equipmentname"><?=Language::equipname()?></label>
					<input type="text" name="equipmentname" maxlength="32" value="<?=htmlspecialchars($equipment['equipmentname'])?>" />
				</li>
				<li class="ui-field-contain">
					<label for="assetno"><?=Language::assetno()?></label>
					<input type="text" name="assetno" maxlength="32" value="<?=htmlspecialchars($equipment['assetno'])?>" />
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=APPDIR.$back.'/'.$equipmentid?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input data-icon="check" type="submit" value="<?=Language::save()?>" />
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>
