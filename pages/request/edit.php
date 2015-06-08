<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::request_edit()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<?php
	$fsl = new FSLocation($request['location']);
	$fsdt = new FSDateTime($request['duedate']);
	?>
	<div data-role="content">
		<form action="<?=$APPLET_ROOT.'/'.$requestid?>" method="POST" data-ajax="false" data-autosave="true">
			<input type="hidden" name="__method" value="update" />
			<ul data-role="listview" data-inset="false">
				<li class="ui-field-contain">
					<?php Widgets::field_techname(array("techname" => $request['techname'])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_staffname(array("staffname" => $request['staffname'])); ?>
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
					<?php Widgets::field_requirements(array("requirements" => $request['requirements'])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_completion2(array("completion" => $request["completed"])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_priority(array("priority" => $request["priority"])); ?>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=$APPLET_ROOT.'/'.$requestid?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input type="submit" value="<?=Language::save()?>" data-icon="check" />
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>