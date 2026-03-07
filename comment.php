<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>

<li id="<?php $comments->theId(); ?>" class="comment<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' parent';
}
$comments->alt(' odd', ' even');
echo $commentClass;
?>">
<div id="div-<?php $comments->theId(); ?>" class="comment-body">
	<div class="comment-author vcard">
		<?php $comments->gravatar('120', ''); ?>		
		<cite class="fn"><?php $comments->author(); ?></cite><span class="says">说道：</span>		
	</div>
    <div class="comment-meta commentmetadata">
		<a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a>
	</div>
	<?php
	ob_start();
	$comments->content();
	$commentHtml = trim(ob_get_clean());

	$at = $comments->parent ? (getPermalinkFromCoid($comments->parent) . ' ') : '';
	$commentHtmlLtrim = ltrim($commentHtml);

	if ($commentHtmlLtrim !== '' && preg_match('/^<p\\b/i', $commentHtmlLtrim)) {
		if ($at !== '') {
			$commentHtmlLtrim = preg_replace('/^<p\\b([^>]*)>/', '<p$1>' . $at, $commentHtmlLtrim, 1);
		}
		echo $commentHtmlLtrim;
	} else {
		echo '<p>' . $at . $commentHtml . '</p>';
	}
	?>

	<div class="reply"><?php $comments->reply('回复'); ?></div>
</div>
    <?php if ($comments->children) { ?>
    <ul class="children">
        <?php $comments->threadedComments($options); ?>
    </ul>
    <?php } ?>
	</li>
<?php } ?>
    <!-- Comments -->
    <?php if ($this->allow('comment')): ?>
    <?php $this->comments()->to($comments); ?>
    <section class="comments">
        <div class="container" data-no-instant>
		    <h3 id="comments" class="comments-title"><?php $this->commentsNum('无', '1 条', '%d 条'); ?>回应：“<?php $this->title(); ?>”</h3>
            <?php if ($comments->have()): ?>
            <div class="commentlist"><?php $comments->listComments(); ?></div>
            <div class="navigation"><?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?></div>
            <?php endif; ?>				
			<div id="<?php $this->respondId(); ?>" class="comment-respond">
				<?php if($this->allow('comment')): ?>
			    <h3 id="reply-title" class="comment-reply-title">发表评论<small><?php $comments->cancelReply(); ?></small></h3>
                <form method="post" action="<?php $this->commentUrl() ?>" id="commentform" role="form">
					<!-- 如果当前用户已经登录 -->
                    <?php if($this->user->hasLogin()): ?>
                    <p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
                    <!-- 若当前用户未登录 -->
                    <?php else: ?>
					<p class="comment-notes"><span id="email-notes">电子邮件地址不会被公开。</span> 必填项已用<span class="required">*</span>标注</p>
					<p class="comment-form-author">
                        <label for="author" class="required"><?php _e('姓名 *'); ?></label>
                        <input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
                    </p>
                    <p class="comment-form-email">
                        <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('电子邮箱 *'); ?></label>
                        <input id="email" name="mail" type="text" value="<?php $this->remember('mail'); ?>" size="30" maxlength="100" aria-describedby="email-notes" required="required">
                    </p>
                    <p class="comment-form-url">
                        <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
                        <input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                    </p>
					<?php endif; ?>
					<p class="comment-form-comment">
                        <label for="textarea" class="required"><?php _e('评论'); ?></label>
                        <textarea rows="8" cols="45" name="text" id="textarea" class="textarea" required ><?php $this->remember('text'); ?></textarea>
                    </p>
                    <p class="form-submit">
                        <input name="submit" type="submit" id="submit" class="submit" value="发表评论" /> <input type='hidden' name='comment_post_ID' value='4905' id='comment_post_ID' />
                        <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
                    </p>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>