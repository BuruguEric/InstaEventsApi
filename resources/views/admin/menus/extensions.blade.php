<!-- Extension Load Menu -->
<?php $extensionMenu = $CoreLoad->menuLoad('extension'); ?>

<!-- Extension Menu View -->
<?php if (!is_null($extensionMenu)): ?>
	<?php foreach ($extensionMenu as $key => $menu_path): ?>
	    <!-- Extension -->
	    @include("extend/extensions/$menu_path")
	    <!-- End Extension -->
	<?php endforeach ?>
<?php endif ?>
