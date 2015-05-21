<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::repair_create()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<?php
	$fsl = new FSLocation($repair->location);
	$fsdt = new FSDateTime($repair->duedate);
	?>
	<div data-role="content">
		<form action="<?=APPDIR?>/repair/create/<?=$repairid?>" method="POST" data-ajax="false">
			<input type="hidden" name="__method" value="repair-create" />
			<ul data-role="listview" data-inset="false">
				<!-- <li class="ui-field-contain">
					<label><?=Language::owner()?></label>
					<input type="text" disabled="disabled" value="<?=$repairusername?>" />
				</li> -->
				<li class="ui-field-contain">
					<?php Widgets::field_jobname(array("jobname" => $repair->name)); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_complainer(array("complainer" => $repair->complainer)); ?>
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
					<?php Widgets::field_priority(array("priority" => $repair->priority)); ?>
				</li>
				<li>
					<?php Widgets::field_equipmentcount(array("repairid" => $repairid,
						"equipmentcount" => $repair->equipmentcount, "url" => "/repair/create/".$repairid."/equipment")); ?>
				</li>
				<li>
					<input type="submit" value="<?=Language::save()?>" data-icon="check" />
				</li>
			</ul>
		</form?
	</div>
</div>
