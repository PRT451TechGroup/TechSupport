<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::request_create()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<?php
	$fsl = new FSLocation("Purple 1.1.1");
	$fsdt = new FSDateTime(date("Y-m-d H:i:s"));
	?>
	<div data-role="content">
		<form action="<?=$APPLET_ROOT?>/create" method="POST" data-ajax="false">
			<input type="hidden" name="__method" value="insert" />
			<ul data-role="listview" data-inset="false">
				<li class="ui-field-contain">
					<?php Widgets::field_techname(array("techname" => "")); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_staffname(array("staffname" => "")); ?>
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
					<?php Widgets::field_requirements(array("requirements" => "")); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_priority(array("priority" => "0")); ?>
				</li>
				<li>
					<input type="submit" value="<?=Language::save()?>" data-icon="check" />
				</li>
			</ul>
		</form>
	</div>
</div>
