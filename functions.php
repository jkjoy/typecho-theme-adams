<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/* 初始化 */
/**
 * 主题启用时执行的方法
 */
function themeInit() {
	$db = Typecho_Db::get();
    /* 设置评论最大嵌套层数 */
    $query = $db->update('table.options')->rows(array('value'=>'999'))->where('name=?', 'commentsMaxNestingLevels');
    $db->query($query);
    /* 强制新评论在前 */
    $query = $db->update('table.options')->rows(array('value'=>'DESC'))->where('name=?', 'commentsOrder');
    $db->query($query);
    /* 默认显示第一页评论 */
    $query = $db->update('table.options')->rows(array('value'=>'first'))->where('name=?', 'commentsPageDisplay');
    $db->query($query);
}
/**
 * 主题后台设置
 */
function themeConfig($form) {
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('站点图标地址'), _t('填写站点图标的 URL 地址，建议使用 16x16 或 32x32 的 PNG 格式图片'));
    $form->addInput($favicon);
    $notice = new Typecho_Widget_Helper_Form_Element_Text('notice', NULL, NULL, _t('站点介绍'), _t('写入站点介绍或者公告，会显示在 header 部分'));
    $form->addInput($notice);
	$github = new Typecho_Widget_Helper_Form_Element_Text('github', NULL, NULL, _t('GitHub 主页地址'), _t('你 GitHub 个人主页的链接地址'));
    $form->addInput($github);
	$weibo = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, NULL, _t('微博主页地址'), _t('你新浪微博个人主页的链接地址'));
    $form->addInput($weibo);
    $mastodon = new Typecho_Widget_Helper_Form_Element_Text('mastodon', NULL, NULL, _t('Mastodon 主页地址'), _t('你 Mastodon 个人主页的链接地址'));
    $form->addInput($mastodon);
    $telegram = new Typecho_Widget_Helper_Form_Element_Text('telegram', NULL, NULL, _t('Telegram 地址'), _t('你 Telegram 的链接地址'));
    $form->addInput($telegram);
	$alipay_img = new Typecho_Widget_Helper_Form_Element_Text('alipay_img', NULL, NULL, _t('支付宝付款码'), _t('填入你支付宝付款二维码的 url 地址，用作别人打赏的途径'));
    $form->addInput($alipay_img);
	$wechat_img = new Typecho_Widget_Helper_Form_Element_Text('wechat_img', NULL, NULL, _t('微信付款码'), _t('填入你微信付款二维码的 url 地址，用作别人打赏的途径'));
    $form->addInput($wechat_img);
    $icp = new Typecho_Widget_Helper_Form_Element_Text('icp', NULL, NULL, _t('ICP备案号'), _t('填写你的 ICP 备案号，会显示在 footer 部分'));
    $form->addInput($icp);
    $cnavatar = new Typecho_Widget_Helper_Form_Element_Text('cnavatar', NULL, NULL , _t('Gravatar镜像'), _t('默认https://cravatar.cn/avatar/'));
    $form->addInput($cnavatar);
    $headcode = new Typecho_Widget_Helper_Form_Element_Textarea('headcode', NULL, NULL, _t('Head 额外代码'), _t('插入代码到 &lt;head&gt; 标签内，通常用于添加统计代码'));
    $form->addInput($headcode);
    $footcode = new Typecho_Widget_Helper_Form_Element_Textarea('footcode', NULL, NULL, _t('Footer 额外代码'), _t('插入代码到 &lt;body&gt; 标签结束前，通常用于添加统计代码'));
    $form->addInput($footcode);
    $colorStyle = new Typecho_Widget_Helper_Form_Element_Radio(
        'colorStyle',
        array(
            'default' => _t('默认'),
            'sepia'   => _t('护眼'),
            'night'   => _t('夜晚')
        ),
        'default',
        _t('页面风格'),
        _t('默认风格会在未设置浏览器本地偏好时生效。')
    );
    $form->addInput($colorStyle);
    $showrelated = new Typecho_Widget_Helper_Form_Element_Radio('showrelated',
    array('0'=> _t('否'), '1'=> _t('是')),
    '0', _t('是否显示相关文章'), _t('选择"是"将在文章页面显示相关文章。'));
    $form->addInput($showrelated);
    $pangu = new Typecho_Widget_Helper_Form_Element_Radio('pangu',
    array('0'=> _t('否'), '1'=> _t('是')),
    '0', _t('是否使用pangu.js'), _t('选择"是"将启用。'));
    $form->addInput($pangu);
}

/* 工具 */
/**
 * 输出 title
 */
function title(Widget_Archive $archive)
{
    $archive->archiveTitle(array(
        'category'  =>  '分类 %s 下的文章',
        'search'    =>  '包含关键字 %s 的文章',
        'tag'       =>  '标签 %s 下的文章',
        'author'    =>  '%s 发布的文章'
    ), '', ' | ');
    Helper::options()->title();
}

/**
 * 匹配文章首图
 */
function getPostImg($archive) {
    $img = array();
    //  匹配 img 的 src 的正则表达式
    preg_match_all("/<img.*?src=\"(.*?)\".*?\/?>/i", $archive->content, $img);
    //  判断是否匹配到图片
    if (count($img) > 0 && count($img[0]) > 0) {
        //  返回图片
        return $img[1][0];
    } else {
        //  如果没有匹配到就返回 none
        return 'none';
    }
}

/**
 * 获取文章浏览次数
 */
function getPostViews($archive) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $cid = $archive->cid;
    //  查询当前文章的浏览次数
    $row = $db->fetchRow($db->select('views')->from('table.contents')
        ->where('cid = ?', $cid));
    if ($row) {
        //  返回浏览次数
        return intval($row['views']);
    } else {
        return 0;
    }
}

/**
 * 回复加上@
 * @param int $coid 评论ID
 * @return string
 */
function getPermalinkFromCoid($coid) {
	$db = Typecho_Db::get();
	$row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
	if (empty($row)) return '';
	return '<a href="#comment-'.$coid.'"">@'.$row['author'].'</a>';
}

/** 
 * Gravatar镜像     
 * @package custom
*/
$options = Typecho_Widget::widget('Widget_Options');
$gravatarPrefix = empty($options->cnavatar) ? 'https://cn.cravatar.com/avatar/' : $options->cnavatar;
if (!defined('TYPECHO_GRAVATAR_PREFIX')) {
	define('__TYPECHO_GRAVATAR_PREFIX__', $gravatarPrefix);
}

/**
 * 文章点赞数
 */
function get_post_like($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `likes` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }

    $row = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid));
    echo $row['likes'] ?? 0;
}

// AJAX 处理函数
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['likeup']) && isset($_POST['cid'])) {
    $cid = intval($_POST['cid']);
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    // 检查是否已点赞
    if (isset($_COOKIE['extend_contents_likes_' . $cid])) {
        header('Content-Type: application/json');
        echo json_encode(array(
            'success' => false,
            'msg' => '您已经点过赞了',
            'likes' => 0
        ));
        exit;
    }

    // 更新点赞数
    $row = $db->fetchRow($db->select('likes')->from('table.contents')->where('cid = ?', $cid));
    $newLikes = ($row['likes'] ?? 0) + 1;
    
    $db->query($db->update('table.contents')
        ->rows(array('likes' => $newLikes))
        ->where('cid = ?', $cid));

    // 设置cookie防止重复点赞(30天有效期)
    setcookie('extend_contents_likes_' . $cid, '1', time() + 2592000, '/');

    // 返回结果
    header('Content-Type: application/json');
    echo json_encode(array(
        'success' => true,
        'msg' => '点赞成功',
        'likes' => $newLikes
    ));
    exit;
}