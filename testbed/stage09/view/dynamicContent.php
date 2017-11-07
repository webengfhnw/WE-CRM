<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 16:59
 */
use view\View;
?>
<div class="container" style="display:flex;flex-direction:column;justify-content:center;">
    <div class="page-header">
        <h2 class="text-center"><strong><?php echo $this->title; ?></strong></h2></div>
    <section>
        <p class="text-center"><?php echo $this->text; ?></p>
    </section>
</div>