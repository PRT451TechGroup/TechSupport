<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::duecat(array("duecat" => $category))?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<?php
		$theme = "cdefgh";
		$theme = $theme{$category};
		function loanname($loan)
		{
			return "Loan #" . $loan["loanid"];
		}
		$prevpriority = -1;
	?>
	<div data-role="content">
		<ul data-role="listview" class="loanreview" data-theme="<?=$theme?>">
			<?php foreach($loans as $loan): ?>
				<?php if ($loan["priority"] != $prevpriority): ?>
					<?php if ($loan["priority"] == 0): ?><li data-role="list-divider"><?=Language::loan_normal()?></li>
					<?php else: ?><li data-role="list-divider"><?=Language::loan_priority()?></li>
					<?php endif; ?>
				<?php endif; ?>
				<?php $prevpriority = $loan["priority"]; ?>
				<li><a data-transition="slide" href="<?=$APPLET_ROOT.'/'.$loan['loanid']?>"><?=htmlspecialchars(loanname($loan))?> <span class="ui-li-count"><?=$loan["equipmentcount"]?></span></a></li>
			<?php endforeach; ?>
			<?php if (count($loans) == 0): ?>
				<li data-role="list-divider"><?=Language::loan_none()?></li>
				<li>
					<a href="<?=APPDIR.$back?>" data-rel="back" class="ui-btn-icon-left ui-btn ui-icon-back"><?=Language::back()?></a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>
