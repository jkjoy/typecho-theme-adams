<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    <!-- Content -->
    <section class="container main-load">
        <article class="post_article">
        <?php $this->content(); ?>
        </article>
        <?php if(!$this->is('page')): ?>
        <p class="post_meta">
            <span><i class="czs-folder-l"></i> <?php $this->category(','); ?></span> / 
            <span><i class="czs-tag-l"></i> <?php $this->tags(',', true, '无标签'); ?></span>
        </p>
	    <?php endif; ?>       
        <nav class="nearbypost">
            <div class="alignleft"><?php $this->thePrev('%s','没有了'); ?></div>
            <div class="alignright"><?php $this->theNext('%s','没有了'); ?></div>
        </nav>
            <?php $this->related(6)->to($relatedPosts); ?> 
    <?php if ($relatedPosts->have()): ?> 
    <h3 class="title">相关文章</h3>
    <div class="related">
    <?php while ($relatedPosts->next()): ?>     
        <div class="related_item">
            <a href="<?php $relatedPosts->permalink(); ?>">
                <div class="related_title">
                <?php $relatedPosts->date('Y-m-d'); ?> - <?php $relatedPosts->title(); ?>
                </div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
    </section>