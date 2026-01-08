<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php $favicon = $this->options->favicon; if (!empty($favicon)): ?>
    <link rel="icon" href="<?php $this->options->favicon(); ?>" type="image/x-icon"/>
    <?php else: ?>
    <link rel="icon" href="<?php $this->options->themeUrl('favicon.ico'); ?>" type="image/x-icon"/>
    <?php endif; ?>
    <link href="<?php $this->options->themeUrl('style/style.css'); ?>" type="text/css" rel="stylesheet">
    <link href="<?php $this->options->themeUrl('style/caomei/style.css'); ?>" type="text/css" rel="stylesheet">
	<script src="<?php $this->options->themeUrl('static/jquery.min.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('static/script.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('static/support.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('static/prettify.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('static/instantclick.min.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('static/pangu.min.js'); ?>"></script>
    <title><?php title($this); ?></title>
    <?php $this->header(); ?>
    <?php if (!empty($this->options->headcode)): ?>
    <?php echo $this->options->headcode; ?>
    <?php endif; ?>
    <script>
        if(localStorage.adams_color_style) $('head').append("<style class='diy-color-style'>" + localStorage.adams_color_style + "</style>");
        if(localStorage.adams_font_style) $('head').append("<style class='diy-font-style'>" + localStorage.adams_font_style + "</style>");
    </script>
</head>
<body>
<!-- Header -->
<header class="header">
    <section class="container">
        <hgroup>
            <h1 class="fullname">
			  <?php
			    if($this->is('single')){
					echo $this->title();
				}elseif($this->is('arvhie')){
					echo $this->archiveTitle(array(
                      'category'  =>  '分类 %s 下的文章',
                      'search'    =>  '包含关键字 %s 的文章',
                      'tag'       =>  '标签 %s 下的文章',
                      'author'    =>  '%s 发布的文章'
                    ), '', '');
				}else{
					echo $this->options->title();
				}
			  ?>
			</h1>
        </hgroup>
		<nav class="social">
		  <ul id="menu-socialx" class="menu">
		    <li class="czs-rss menu-item">
				<a title="RSS" target="_blank" href="<?php $this->options->feedUrl(); ?>">RSS</a>
			</li>
			<?php if ($this->options->github): ?>
            <li class="czs-github-logo menu-item">
				<a title="GitHub" target="_blank" href="<?php $this->options->github(); ?>">GitHub</a>
			</li>
			<?php endif;?>
			<?php if ($this->options->weibo): ?>
            <li class="czs-weibo menu-item">
				<a target="_blank" href="<?php $this->options->weibo(); ?>">WeiBo</a>
			</li>
			<?php endif;?>
            <?php if ($this->options->mastodon): ?>
            <li class="czs-moments menu-item">
				<a title="Mastodon" target="_blank" href="<?php $this->options->mastodon(); ?>">Mastodon</a>
			</li>
            <?php endif;?>
            <?php if ($this->options->telegram): ?>
            <li class="czs-telegram menu-item">
                <a title="Telegram" target="_blank" href="<?php $this->options->telegram(); ?>">Telegram</a>
            </li>
            <?php endif;?>
          </ul>
		</nav>
        <nav class="header_nav">
		  <ul id="menu-header" class="menu">
		    <li class="menu-item <?php if($this->is('index')): ?>current-menu-item current_page_item <?php endif; ?>menu-item-4759"><a href="<?php $this->options->SiteUrl(); ?>" aria-current="page">首页</a></li>
			<?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
			<?php while($categorys->next()): ?>
			<li class="menu-item <?php if($this->is('category', $categorys->slug)): ?> current-menu-item<?php endif; ?>">
			  <a href="<?php $categorys->permalink(); ?>"><?php $categorys->name(); ?></a>
			</li>
			<?php endwhile; ?>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <li class="menu-item"><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
            <?php endwhile; ?>
          </ul>
		</nav>    
    </section>
	<section class="infos">
        <div class="container">
        <?php if($this->is('single')) { ?>
	        <h2 class="fixed-title"></h2>
	        <!--<div class="fixed-menus"></div>-->
	        <div class="fields">
	            <span><i class="czs-time-l"></i> <?php $this->date('Y-m-d'); ?></span>
	                / 
                <span><i class="czs-eye-l"></i> <?php echo getPostViews($this); ?></span>
	                <?php if(!$this->is('page')): ?>
	                / 
                <span><i class="czs-folder-l"></i> <?php $this->category(','); ?></span>
	                / 
                <span><i class="czs-tag-l"></i> <?php $this->tags(',', true, '无标签'); ?></span>
	                <?php endif; ?>
		            / 
                <span><i class="czs-talk-l"></i> <?php $this->commentsNum('无评论', '1 条', '%d 条'); ?></span>
		            <?php if($this->user->hasLogin()) : ?>
		            <?php $editFile = $this->is('page') ? 'write-page.php' : 'write-post.php'; ?>
		            / 
                <span><i class="czs-pen"></i><a href="<?php $this->options->adminUrl($editFile . '?cid=' . $this->cid); ?>" target="_blank" title="<?php echo $this->is('page') ? '编辑页面' : '编辑文章'; ?>"><?php echo $this->is('page') ? '编辑页面' : '编辑文章'; ?></a></span> 
		            <?php endif; ?>
		    </div>
            
            <div class="socials">
                <div class="donate">
                    <a href="javascript:;"><i class="czs-coin-l s"></i><i class="czs-coin h"></i> 赏</a>
                    <div class="window">
                        <ul>
                            <li class="alipay"><img src="<?php $this->options->alipay_img(); ?>"/></li>
                            <li><img src="<?php $this->options->wechat_img(); ?>"/></li>
                        </ul>
                    </div>
                </div>
                <div class="share">
                    <a href="javascript:;" data-qrcode="//api.qrserver.com/v1/create-qr-code/?size=150x150&margin=10&data=<?php $this->permalink(); ?>"><i class="czs-scan-l s"></i><i class="czs-qrcode-l h"></i> 码</a>
                </div>
            </div>
        <?php } else {?>
	            <h2 class="fixed-title"></h2>
	            <div class="fixed-menus"></div>
	            <div class="placard">
	                <?php if (!empty($this->options->notice)): ?>
	                <?php $this->options->notice(); ?>
	                <?php else: ?>
	                <span id="hitokoto">少女祈祷中......</span>
	                <?php endif; ?>
	            </div>
        <?php } ?>
        </div>
    </section>
</header>