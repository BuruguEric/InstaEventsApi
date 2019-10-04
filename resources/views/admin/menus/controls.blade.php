<!-- Control Load Menu -->
<?php $controlMenu = $CoreLoad->menuLoad('control'); ?>

<!-- Loop Menu View -->
<?php if (!is_null($controlMenu)): ?>
	<?php foreach ($controlMenu as $key => $menu_path): ?>
	    <!-- Control -->
	    @include("$menu_path")
	    <!-- End Control -->
	<?php endforeach ?>
<?php endif ?>
