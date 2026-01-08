<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    <!-- Content -->
    <section class="container main-load">
        <article class="post_article">
        <?php $this->content(); ?>
        </article>
        
        <nav class="nearbypost">
            <div class="alignleft"><?php $this->thePrev('%s','没有了'); ?></div>
            <div class="alignright"><?php $this->theNext('%s','没有了'); ?></div>
        </nav>
    </section>