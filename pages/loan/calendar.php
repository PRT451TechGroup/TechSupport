<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::loan_review()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<?php
		$themes = "cdefgh";
		function loanname($loan)
		{
			return strlen($loan["debtor"]) ? $loan["debtor"] : ("Loan #" . $loan["loanid"]);
		}
		function diff_pos($x)
		{
			return ($x >= 0) ? intval($x) : -1;
		}
		$prevdiff = false;
	?>
	<div data-role="content">
		<ul data-role="listview" class="loanreview">
			<?php foreach($loans as $loan): ?>
				<?php if (diff_pos($loan["daydiff"]) !== $prevdiff): ?>
					<?php
						$prevdiff = diff_pos($loan["daydiff"]);
						$theme = $themes{$categoryOf($prevdiff)};
					?>
					<?php if ($prevdiff < 0): ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=Language::loan_overdue()?></li>
					<?php elseif ($prevdiff == 0): ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=Language::today()?></li>
					<?php elseif ($prevdiff == 1): ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=Language::tomorrow()?></li>
					<?php else: ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=date('l, jS \of F, Y', strtotime($loan["returndate"]))?></li>
					<?php endif; ?>
				<?php endif; ?>
				
				<li>
					<a data-transition="slide" href="<?=$APPLET_ROOT.'/calendar/'.$loan['loanid']?>">
						<h2><?=htmlspecialchars(loanname($loan))?></h2>
						<p><strong>Loaned on <?=date('d M y', strtotime($loan["loandate"]))?></strong></p>
						<p data-icon="calendar">Due on <?=date('d M y', strtotime($loan["returndate"]))?></p>
						<span class="ui-li-count"><?=$loan["equipmentcount"]?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
