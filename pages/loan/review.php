<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::loan_review()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<ul data-role="listview">
			<?php $themes = "cdefg"; ?>
			<?php foreach($categories as $catno => $catcount): ?>
			<?php
			$text = Language::duecat(array("duecat" => $catno));
			?>
			<li data-theme="<?=$themes{$catno}?>"><a href="<?=$APPLET_ROOT?>/review/<?=$catno?>" data-transition="slide"><?=$text?><?php if ($catcount !== 0):?><span class="ui-li-count"><?=$catcount?></span><?php endif; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>