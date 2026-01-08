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
    $headcode = new Typecho_Widget_Helper_Form_Element_Textarea('headcode', NULL, NULL, _t('Head 额外代码'), _t('插入代码到 &lt;head&gt; 标签内，通常用于添加统计代码'));
    $form->addInput($headcode);
    $footcode = new Typecho_Widget_Helper_Form_Element_Textarea('footcode', NULL, NULL, _t('Footer 额外代码'), _t('插入代码到 &lt;body&gt; 标签结束前，通常用于添加统计代码'));
    $form->addInput($footcode);
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