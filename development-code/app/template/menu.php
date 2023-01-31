<?php require_once("menuitems.php"); ?>
<nav>
                <ul>
                   <?php foreach($menu as $item => $link):?>
                       <li>
                           <a href="<?=SITE_DIR . $link?>"><?= $item ?></a>
                       </li>
                   <?php endforeach; ?> 
                </ul>
            </nav>
