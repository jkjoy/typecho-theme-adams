<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
/**
 * 友情链接
 *
 * @package custom
 */
$this->need('header.php'); ?>

<section class="section content main-load">
    <div class="container">
        <article class="post_article links-page">
            <?php
            ob_start();
            $this->content();
            $pageContent = trim(ob_get_clean());
            if ($pageContent !== '') {
                echo '<div class="links-page-intro">' . $pageContent . '</div><hr>';
            }

            $linksHtml = '';
            $linksError = '';
            $linksCount = 0;
            $links = array();

            try {
                $db = Typecho_Db::get();
                try {
                    $sql = $db->select()->from('table.links')->where('state = ?', 1);
                    try {
                        $sql = $sql->order('table.links.order', Typecho_Db::SORT_ASC);
                        $links = $db->fetchAll($sql);
                    } catch (Exception $orderError) {
                        $links = $db->fetchAll($db->select()->from('table.links')->where('state = ?', 1));
                    }
                } catch (Exception $stateError) {
                    $sql = $db->select()->from('table.links');

                    try {
                        $sql = $sql->order('table.links.order', Typecho_Db::SORT_ASC);
                        $links = $db->fetchAll($sql);
                    } catch (Exception $orderError) {
                        $links = $db->fetchAll($db->select()->from('table.links'));
                    }
                }

                foreach ($links as $link) {
                    if (isset($link['state']) && (string) $link['state'] !== '1') {
                        continue;
                    }
                    if (isset($link['sort']) && strtolower(trim((string) $link['sort'])) === 'menu') {
                        continue;
                    }

                    $url = isset($link['url']) ? trim($link['url']) : '';
                    if ($url === '') {
                        continue;
                    }

                    $name = isset($link['name']) && trim($link['name']) !== '' ? trim($link['name']) : '未命名站点';
                    $title = isset($link['description']) && trim($link['description']) !== '' ? trim($link['description']) : $name;

                    $linksHtml .= '<li><a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener nofollow external" title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</a></li>';
                    $linksCount++;
                }
            } catch (Exception $e) {
                $linksError = '未检测到 links 数据表，无法加载友情链接。';
            }
            ?>

            <h3>友情链接</h3>
            <?php if ($linksCount > 0): ?>
                <p class="links-page-count">目前共收录 <?php echo $linksCount; ?> 个站点</p>
            <?php endif; ?>

            <ul class="links">
                <?php if ($linksHtml !== ''): ?>
                    <?php echo $linksHtml; ?>
                <?php else: ?>
                    <li class="links-empty"><span><?php echo $linksError ?: '暂无友情链接，欢迎先添加再展示。'; ?></span></li>
                <?php endif; ?>
            </ul>
        </article>
    </div>
</section>

<?php $this->need('footer.php'); ?>
