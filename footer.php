<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<footer class="footer">
	<section class="container">
        <ul id="menu-footer" class="menu">
        <?php
        try {
            // 检查links表是否存在
            $db = Typecho_Db::get();
            $db->fetchAll($db->select()->from('table.links')->limit(1));
            // 如果没有异常，表存在，输出友情链接
            Links_Plugin::output('<li><a href="{url}" target="_blank" rel="me noopener" title="{title}">{name}</a></li>');
        } catch (Exception $e) {
            // 表不存在或查询失败，显示提示信息
            echo '<span style="color: #999;">请先安装links插件</span>';
        }
        ?>
        </ul>        
        <div style="display: flex;justify-content: space-between;">
            <span class='left'>&copy; <?php echo date('Y'); ?>  
            <?php echo $this->options->title(); ?> 
            <?php if (!empty($this->options->icp)): ?> | 
                <a href="https://beian.miit.gov.cn/" target="_blank"><?php echo $this->options->icp; ?></a>
            <?php endif; ?>          
            </span>
            <span class='right'>Theme by <a href="https://biji.io" target="_blank">Adams</a></span>
	</section>
</footer>
<?php if (!empty($this->options->footcode)): ?>
    <?php echo $this->options->footcode; ?>
<?php endif; ?>
<script src="https://v1.hitokoto.cn/?encode=js&select=%23hitokoto" defer></script> 
<?php $this->footer(); ?>
<div class="setting_tool iconfont">
    <a class="back2top" style="display:none;"><i class="czs-arrow-up-l"></i></a>
    <a class="sosearch"><i class="czs-search-l"></i></a>
    <a class="socolor"><i class="czs-clothes-l"></i></a>
    <div class="s">
		<form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search" class="search">
		    <input class="search-key text" id="s" name="s" autocomplete="off" placeholder="输入关键词..." type="text" value="" required="required">
		</form>
    </div>
    <div class="c">
        <ul>
            <li class="color undefined">默认</li>
            <li class="color sepia">护眼</li>
            <li class="color night">夜晚</li>
            <li class="hr"></li>
            <li class="font serif">Serif</li>
            <li class="font sans">Sans</li>
        </ul>
    </div>
</div>
<script data-no-instant>
    document.addEventListener('DOMContentLoaded', () => {
        pangu.autoSpacingPage();
    });
	    (function ($) {
	        $.extend({
	            adamsOverload: function () {
	                $('.navigation:eq(0)').remove();
	                $(".post_article a").attr("rel" , "external");
	                $("a[rel='external']:not([href^='#']),a[rel='external nofollow']:not([href^='#'])").attr("target","_blank");
	                $("a.vi,.gallery a,.attachment a").attr("rel" , "");

	                var applyMacCode = function (withButton) {
	                    $('.post_article pre, .comment-body pre').each(function () {
	                        var $pre = $(this);
 
	                        if (!$pre.hasClass('code-mac') && ($pre.hasClass('prettyprint') || $pre.find('code').length)) {
	                            $pre.addClass('code-mac');
	                        }

	                        if ($pre.hasClass('code-mac') && $pre.find('> .code-mac-scroll').length === 0) {
	                            var $scroll = $('<div class="code-mac-scroll"></div>');
	                            $pre.prepend($scroll);
	                            $scroll.append($pre.contents().not($scroll).not($pre.find('> .code-copy-btn')));
	                        }
 
	                        if (withButton && $pre.hasClass('code-mac') && $pre.find('> .code-copy-btn').length === 0) {
	                            $pre.prepend('<button type="button" class="code-copy-btn" aria-label="复制代码">复制代码</button>');
	                        }

	                        if ($pre.hasClass('code-mac') && $pre.find('> .code-expand-btn').length === 0) {
	                            $pre.append('<button type="button" class="code-expand-btn" aria-expanded="false">展开</button>');
	                        }
	                    });
	                };

	                var updateMacCodeExpand = function () {
	                    $('.post_article pre.code-mac, .comment-body pre.code-mac').each(function () {
	                        var $pre = $(this);
	                        var $scroll = $pre.find('> .code-mac-scroll');
	                        var $btn = $pre.find('> .code-expand-btn');

	                        if ($scroll.length === 0 || $btn.length === 0) return;

	                        if ($pre.hasClass('is-expanded')) {
	                            $btn.text('收起').attr('aria-expanded', 'true');
	                            $pre.removeClass('is-collapsed');
	                            return;
	                        }

	                        // collapsed state: only show button when content overflows
	                        var overflow = $scroll[0].scrollHeight - $scroll[0].clientHeight > 1;
	                        $btn.text('展开').attr('aria-expanded', 'false');
	                        $pre.toggleClass('is-collapsed', overflow);
	                    });
	                };
	                applyMacCode(false);
	                $.viewImage({
	                    'target'  : '.gallery a,.gallery img,.attachment a,.post_article img,.post_article a,a.vi',
	                    'exclude' : '.readerswall img,.gallery a img,.attachment a img',
	                    'delay'   : 300
	                });
	                $.lately({
	                    'target' : '.commentmetadata a,.infos time,.post-list time'
	                });
	                if (typeof prettyPrint !== 'undefined') prettyPrint();
	                applyMacCode(true);
	                updateMacCodeExpand();
	                
	                $('ul.links li a').each(function(){
	                    if($(this).parent().find('.bg').length==0){
	                        $(this).parent().append('<div class="bg" style="background-image:url(https://www.google.com/s2/favicons?domain='+$(this).attr("href")+')"></div>')
	                    }
	                });
	            }
	        });
	    })(jQuery);

	    if (!window.__adamsCodeCopyBound) {
	        window.__adamsCodeCopyBound = true;
	        jQuery(document).on('click', '.code-copy-btn', async function () {
	            var btn = this;
	            var pre = btn.closest('pre');
	            if (!pre) return;

	            var clone = pre.cloneNode(true);
	            clone.querySelectorAll('.code-copy-btn,.code-expand-btn').forEach(function (el) { el.remove(); });
	            var text = (clone.textContent || '').replace(/\s+$/, '');

	            var setText = function (t) { btn.textContent = t; };
	            var reset = function () {
	                clearTimeout(btn.__copyTimer);
	                btn.__copyTimer = setTimeout(function () { setText('复制代码'); }, 1200);
	            };

	            try {
	                if (navigator.clipboard && window.isSecureContext) {
	                    await navigator.clipboard.writeText(text);
	                } else {
	                    var ta = document.createElement('textarea');
	                    ta.value = text;
	                    ta.setAttribute('readonly', '');
	                    ta.style.position = 'fixed';
	                    ta.style.left = '-9999px';
	                    ta.style.top = '0';
	                    document.body.appendChild(ta);
	                    ta.select();
	                    document.execCommand('copy');
	                    document.body.removeChild(ta);
	                }
	                setText('已复制');
	                reset();
	            } catch (e) {
	                setText('复制失败');
	                reset();
	            }
	        });
	    }

	    if (!window.__adamsCodeExpandBound) {
	        window.__adamsCodeExpandBound = true;
	        jQuery(document).on('click', '.code-expand-btn', function () {
	            var $pre = jQuery(this).closest('pre.code-mac');
	            if ($pre.length === 0) return;

	            $pre.toggleClass('is-expanded');
	            if ($pre.hasClass('is-expanded')) {
	                jQuery(this).text('收起').attr('aria-expanded', 'true');
	                $pre.removeClass('is-collapsed');
	            } else {
	                jQuery(this).text('展开').attr('aria-expanded', 'false');
	                // re-evaluate overflow after collapsing
	                var $scroll = $pre.find('> .code-mac-scroll');
	                var overflow = $scroll.length ? ($scroll[0].scrollHeight - $scroll[0].clientHeight > 1) : false;
	                $pre.toggleClass('is-collapsed', overflow);
	            }
	        });
	    }
    InstantClick.on('change', function(isInitialLoad) {
        jQuery.adamsOverload();
        if (isInitialLoad === false) {
            // support MathJax
            if (typeof MathJax !== 'undefined') MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
            // support google code prettify
            if (typeof prettyPrint !== 'undefined') prettyPrint();
            // support 百度统计
            if (typeof _hmt !== 'undefined') _hmt.push(['_trackPageview', location.pathname + location.search]);
            // support google analytics
            if (typeof ga !== 'undefined') ga('send', 'pageview', location.pathname + location.search);
        }
    });
    InstantClick.on('wait', function() {
        // pjax href click
    });
    InstantClick.on('fetch', function() {
        // pjax begin
    });
    InstantClick.on('receive', function() {
        // pjax end
    });
    InstantClick.init('mousedown');
    jQuery.adamsOverload();
</script>
</body>
</html>
