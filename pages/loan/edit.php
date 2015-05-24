<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::loan_edit()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<?php
	$loandate = new FSDateTime($loan["loandate"]);
	$returndate = new FSDateTime($loan["returndate"]);
	?>
	<div data-role="content">
		<form action="<?=$APPLET_ROOT.'/'.$loanid?>" method="POST" data-ajax="false">
			<input type="hidden" name="__method" value="update" />
			<input type="hidden" name="userid" value="<?=$loan['userid']?>" />
			<ul data-role="listview" data-inset="false">
				<!-- <li class="ui-field-contain">
					<?php Widgets::field_owner(array("owner" => $loanowner)); ?>
				</li> -->
				<li class="ui-field-contain">
					<?php Widgets::field_loanername(array("loanername" => $loan["loanername"])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::field_staffname(array("staffname" => $loan["staffname"])); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_date(array("prefix" => "loan_", "label" => Language::loandate()) +
						$loandate->to_array()); ?>
				</li>
				<li class="ui-field-contain">
					<?php Widgets::fieldset_date(array("prefix" => "return_", "label" => Language::returndate()) +
						$returndate->to_array()); ?>
				</li>
				<li>
					<?php Widgets::field_equipmentcount(array(
						"equipmentcount" => $loan["equipmentcount"], "url" => "$appletRoot/$loanid/equipment")); ?>
				</li>
				<li class="ui-grid-a">
					<div class="ui-block-a">
						<a href="<?=$APPLET_ROOT.'/'.$loanid?>/delete" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left" data-ajax="false"><?=Language::delete()?></a>
					</div>
					<div class="ui-block-b">
						<input type="submit" value="<?=Language::save()?>" data-icon="check" />
					</div>
				</li>
			</ul>
		</form>
	</div>
</div>
