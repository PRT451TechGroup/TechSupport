<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::approve_users()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<?php foreach($users as $user): ?>
				<li><a href="<?=$APPLET_ROOT?>/approve/<?=$user['userid']?>" data-transition="slide" data-ajax="false"><?=htmlspecialchars($user["username"])?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>