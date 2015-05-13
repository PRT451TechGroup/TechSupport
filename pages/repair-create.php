<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::repair_create()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<?php
		$location = explode(".", Bean::repair()->location);

		for($i=count($location);$i<3;$i++)
		{
			$location[$i] = "1";
		}
		
		$building = $location[0];
		$floor = $location[1];
		$room = $location[2];

		function selected($v0, $v1)
		{
			return $v0 == $v1 ? 'selected="selected"' : "";
		}
	?>
	<div data-role="content">
		<form action="<?=APPDIR?>/repair/create/<?=Bean::repairid()?>" method="POST" data-ajax="false">
			<input type="hidden" name="__method" value="repair-create" />
			<ul data-role="listview" data-inset="false">
				<!-- <li class="ui-field-contain">
					<label><?=Language::owner()?></label>
					<input type="text" disabled="disabled" value="<?=Bean::repairusername()?>" />
				</li> -->
				<li class="ui-field-contain">
					<label><?=Language::location()?></label>
					<fieldset class="ui-grid-b">
						<div class="ui-block-a">
							<label for="building"><?=Language::building()?></label>
							<select name="building">
								<option value="2" <?=selected($building, 2)?>>2</option>
								<option value="12" <?=selected($building, 12)?>>12</option>
							</select>
						</div>
						<div class="ui-block-b">
							<label for="floor"><?=Language::floor()?></label>
							<select name="floor">
								<?php for($i=1;$i<=3;$i++): ?>
								<option value="<?=$i?>" <?=selected($floor, $i)?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="ui-block-c">
							<label for="room"><?=Language::room()?></label>
							<select name="room">
								<?php for($i=1;$i<=25;$i++): ?>
								<option value="<?=$i?>" <?=selected($room, $i)?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
					</fieldset>
				</li>
				<li class="ui-field-contain">
					<label for="duedate"><?=Language::duedate()?></label>
					<input type="datetime" name="duedate" value="<?=Bean::repair()->duedate?>" />
				</li>
				<li class="ui-field-contain">
					<label for="priority"><?=Language::priority()?></label>
					<select name="priority" data-role="flipswitch">
						<option value="0" <?=selected(Bean::repair()->priority, 0)?>><?=Language::priority_off()?></option>
						<option value="1" <?=selected(Bean::repair()->priority, 1)?>><?=Language::priority_on()?></option>
					</select>
				</li>
				<li>
					<a href="<?=APPDIR?>/repair/create/<?=Bean::repairid()?>/equipment" data-transition="slide"><?=Language::equipment()?><span class="ui-li-count"><?=Bean::repair()->equipmentcount?></span></a>
				</li>
				<li>
					<input type="submit" value="<?=Language::save()?>" data-icon="check" />
				</li>
			</ul>
		</form?
	</div>
</div>
