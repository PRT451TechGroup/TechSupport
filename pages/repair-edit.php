<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::repair_edit()?></h1>
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
		$theme = "cdefg";
		$theme = $theme{intval(Bean::completion())};
		
		$dt = explode(" ", Bean::repair()->duedate);
		
		$datepart = explode("-", $dt[0]);
		$year = $datepart[0];
		$month = $datepart[1];
		$day = $datepart[2];
		
		$timepart = explode(":", $dt[1]);
		$hour = $timepart[0];
		$minute = $timepart[1];
	?>
	<div data-role="content">
		<form action="<?=APPDIR.Bean::back().'/'.Bean::repairid()?>" method="POST" data-ajax="false">
			<input type="hidden" name="__action" value="repair-edit" />
			<ul data-role="listview" data-inset="false">
				<li class="ui-field-contain">
					<label><?=Language::owner()?></label>
					<input type="text" disabled="disabled" value="<?=Bean::repairusername()?>" />
				</li>
				<li class="ui-field-contain">
					<label for="name"><?=Language::jobname()?></label>
					<input type="text" name="name" value="<?=htmlspecialchars(Bean::repair()->name)?>" />
				</li>
				<li class="ui-field-contain">
					<label for="complainer"><?=Language::complainer()?></label>
					<input type="text" name="complainer" value="<?=htmlspecialchars(Bean::repair()->complainer)?>" />
				</li>
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
					<label><?=Language::date_due()?></label>
					<fieldset class="ui-grid-b">
						<div class="ui-block-a">
							<label for="year"><?=Language::year()?></label>
							<select name="year">
								<?php for($i=2015;$i<=2020;$i++): ?>
								<option value="<?=$i?>" <?=selected($year, $i)?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="ui-block-b">
							<label for="month"><?=Language::month()?></label>
							<select name="month">
								<?php for($i=1;$i<=12;$i++): ?>
								<option value="<?=$i?>" <?=selected($month, $i)?>><?=Language::monthat(array("month" => $i-1))?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="ui-block-c">
							<label for="day"><?=Language::day()?></label>
							<select name="day">
								<?php for($i=1;$i<=31;$i++): ?>
								<option value="<?=$i?>" <?=selected($day, $i)?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
					</fieldset>
				</li>
				<li class="ui-field-contain">
					<label><?=Language::time_due()?></label>
					<fieldset class="ui-grid-a">
						<div class="ui-block-a">
							<label for="hour"><?=Language::hour()?></label>
							<select name="hour">
								<?php for($i=0;$i<24;$i++): ?>
								<option value="<?=$i?>" <?=selected($hour, $i)?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
						<div class="ui-block-b">
							<label for="minute"><?=Language::minute()?></label>
							<select name="minute">
								<?php for($i=0;$i<60;$i++): ?>
								<option value="<?=$i?>" <?=selected($minute, $i)?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
					</fieldset>
				</li>
				<li class="ui-field-contain">
					<label for="priority"><?=Language::priority()?></label>
					<select name="priority" data-role="flipswitch">
						<option value="0" <?=selected(Bean::repair()->priority, 0)?>><?=Language::priority_off()?></option>
						<option value="1" <?=selected(Bean::repair()->priority, 1)?>><?=Language::priority_on()?></option>
					</select>
				</li>
				<li class="ui-field-contain">
					<label for="priority"><?=Language::completion_label()?></label>
					<select name="completion" data-theme="<?=$theme?>">
						<?php for($i=0;$i<5;$i++): ?>
						<option value="<?=$i?>" <?=selected(Bean::repair()->completion, $i)?>><?=Language::completion(array("completion" => $i))?></option>
						<?php endfor; ?>
					</select>
				</li>
				<li>
					<a href="<?=APPDIR.Bean::back().'/'.Bean::repairid()?>/equipment" data-transition="slide"><?=Language::equipment()?><span class="ui-li-count"><?=Bean::repair()->equipmentcount?></span></a>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=APPDIR.Bean::back().'/'.Bean::repairid()?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input type="submit" value="<?=Language::save()?>" data-icon="check" />
					</div>
				</li>
			</ul>
		</form?
	</div>
</div>