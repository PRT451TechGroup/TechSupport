<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::repair_edit()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	
	<div data-role="content">
		<form action="<?=APPDIR.$back.'/'.$repairid?>" method="POST" data-ajax="false">
			<input type="hidden" name="__action" value="repair-edit" />
			<ul data-role="listview" data-inset="false">
				<li class="ui-field-contain">
					<?php Widgets::field_owner(array("owner" => $repairusername)); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_jobname(array("jobname" => $repair->name)); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_complainer(array("complainer" => $repair->complainer)); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_location((new FSLocation($repair->location))->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_date(array("prefix" => "", "label" => Language::date_due()) +
						(new FSDateTime($repair->duedate))->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_time(array("prefix" => "", "label" => Language::time_due()) +
						(new FSDateTime($repair->duedate))->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_priority(array("priority" => $repair->priority)); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_completion(array("completion" => $repair->completion)); ?>
				</li>
				<li>
					<?php Widgets::field_equipmentcount(array("repairid" => $repairid,
						"equipmentcount" => $repair->equipmentcount, "url" => $back."/".$repairid."/equipment")); ?>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=APPDIR.$back.'/'.$repairid?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input type="submit" value="<?=Language::save()?>" data-icon="check" />
					</div>
				</li>
			</ul>
		</form?
	</div>
</div>
