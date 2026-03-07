<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
/**
 * Theme Adams | 一款移植自 Wordpress 的简洁主题
 * 
 * @package Adams
 * @author  老孙博客
 * @version 1.1.4
 * @link    https://www.imsun.org
 */
$this->need('header.php');
?>
    <!-- Post List -->
    <section class="posts main-load">
        <div class="container">
            <div class="post-list">
                <?php if ($this->have()): ?>
				<?php while($this->next()): ?>
                <article class="meta">
                    <header>
                        <a href="<?php $this->permalink(); ?>" itemprop="url"><h2 itemprop="name headline"><?php $this->title(); ?></h2></a>
	                    </header>
	                    <main>
	                        <?php $thumb = getPostImg($this); ?>
	                        <?php if (!empty($thumb) && $thumb !== 'none'): ?>
	                        <a href="<?php $this->permalink(); ?>" class="thumb" style="background-image: url('<?php echo $thumb; ?>');"></a>
	                        <?php endif; ?>
	                        <p itemprop="articleBody">
	                            <?php $this->excerpt(200); ?>
	                        </p>
	                    </main>
                    <footer>
                        <span class="time"><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished" pubdate><?php $this->date('Y-m-d'); ?></time>发布</span>
                        <span class="hr"></span>
                        <span class="comments"><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('去评论', '1 条评论', '%d 条评论'); ?></a></span>
                        <span class="hr"></span><span class="likes"><?php get_post_like($this); ?> 人喜欢</span>
                    </footer>
                </article>
                <?php endwhile; else: ?>
                <article class="meta">
                    <h3 style="font-size: 3em;margin: 0 0 20px;color: #000;">Sorry!</h3>
                    <p>这个页面没有你要找的内容。</p>
                </article>
            <?php endif; ?>
            <?php
                ob_start();
                $this->pageNav(
                '«','»', 1,'...',
                array(
                    'wrapTag' => 'nav',
                    'wrapClass' => 'reade_more',
                    'itemTag' => '',
                    'textTag' => 'span',
                    'itemClass'   => '', 
                    'currentClass' => 'page-numbers current',
                    'prevClass' => 'page-numbers',
                    'nextClass' => ''
                ));
                $pageNav = trim(ob_get_clean());
                if ($pageNav !== '') {
                    echo $pageNav;
                } else {
                    echo '<div class="reade_more reade_more--placeholder" aria-hidden="true"></div>';
                }
            ?>
            </div>
        </div>
    </section>
<?php $this->need('footer.php'); ?>
