<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::editequip()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<form action="<?="$APPLET_ROOT/$repairid/equipment"?>" method="POST" data-ajax="false" data-form="repair.equipment.update">
			<input type="hidden" name="__method" value="update" />
			<input type="hidden" name="equipmentid" value="<?=$equipmentid?>" />
			<ul data-role="listview">
				<li class="ui-field-contain">
					<label for="equipmentname"><?=Language::equipname()?></label>
					<input type="text" name="equipmentname" maxlength="32" value="<?=$equipment['equipmentname']?>" />
				</li>
				<li class="ui-field-contain">
					<label for="assetno"><?=Language::assetno()?></label>
					<input type="text" name="assetno" maxlength="32" value="<?=$equipment['assetno']?>" />
				</li>
				<li class="ui-field-contain">
					<label for="description"><?=Language::equipdesc()?></label>
					<textarea name="description"><?=htmlspecialchars($equipment['description'])?></textarea>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?="$APPLET_ROOT/$repairid/equipment/$equipmentid/delete"?>" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input data-icon="check" type="submit" value="<?=Language::save()?>" />
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>