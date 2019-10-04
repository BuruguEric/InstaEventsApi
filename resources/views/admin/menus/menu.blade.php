<!-- Load Menu -->
<?php $loadMenu = $CoreLoad->menuLoad('menu'); ?>

<!-- Menu View -->
<?php if (!is_null($loadMenu)): ?>
    <?php foreach ($loadMenu as $key => $menu_path): ?>
        <!-- Menu -->
	    @include("$menu_path")
        <!-- End Menu -->
    <?php endforeach ?>
<?php endif ?>
