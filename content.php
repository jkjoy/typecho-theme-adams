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
        <nav class="nearbypost">
            <div class="alignleft"><?php $this->thePrev('%s','没有了'); ?></div>
            <div class="alignright"><?php $this->theNext('%s','没有了'); ?></div>
        </nav>
        <?php endif; ?>  
        <?php $this->related(6)->to($relatedPosts); ?>
        <?php if ($relatedPosts->have()): ?>
        <section class="related-posts" aria-label="相关文章">
            <h3 class="related-posts-title">相关文章</h3>
            <div class="related">
            <?php while ($relatedPosts->next()): ?>
                <div class="related_item">
                    <a class="related_link" href="<?php $relatedPosts->permalink(); ?>">
                        <span class="related_date"><?php $relatedPosts->date('Y-m-d'); ?></span>
                        <span class="related_name"><?php $relatedPosts->title(); ?></span>
                    </a>
                </div>
            <?php endwhile; ?>
            </div>
        </section>
        <?php endif; ?>
    </section>