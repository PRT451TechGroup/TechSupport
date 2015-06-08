<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=(intval($repair['completion']) >= 0) ? Language::repair_edit() : Language::repair_create()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<?php
	$fsl = new FSLocation($repair['location']);
	$fsdt = new FSDateTime($repair['duedate']);
	?>
	<div data-role="content">
		<form action="<?=$APPLET_ROOT.'/'.$repairid?>" method="POST" data-ajax="false" data-autosave="true">
			<input type="hidden" name="__method" value="update" />
			<ul data-role="listview" data-inset="false">
				<li class="ui-field-contain">
					<?php Widgets::field_owner(array("owner" => $repairusername)); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_jobname(array("jobname" => $repair['name'])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_complainer(array("complainer" => $repair['complainer'])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_location($fsl->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_date(array("prefix" => "", "label" => Language::date_due()) +
						$fsdt->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_time(array("prefix" => "", "label" => Language::time_due()) +
						$fsdt->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_priority(array("priority" => $repair['priority'])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_completion(array("completion" => $repair['completion'])); ?>
				</li>
				<li>
					<?php Widgets::field_equipmentcount(array("repairid" => $repairid,
						"equipmentcount" => $repair['equipmentcount'], "url" => "$appletRoot/$repairid/equipment")); ?>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=$APPLET_ROOT.'/'.$repairid?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input type="submit" value="<?=Language::save()?>" data-icon="check" />
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>