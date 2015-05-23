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
	?>
	<div data-role="content">
		<ul data-role="listview" class="loanreview" data-theme="<?=$theme?>">
			<?php foreach($loans as $loan): ?>
			<li><a data-transition="slide" href="<?=$APPLET_ROOT.'/'.$loan['loanid']?>"><?=htmlspecialchars(loanname($loan))?> <span class="ui-li-count"><?=$loan["equipmentcount"]?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
