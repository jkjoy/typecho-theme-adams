(function ($) {
    function bindDonateShare() {
        $(document)
            .off('click.adamsDonateShare')
            .on('click.adamsDonateShare', '.infos .donate, .infos .share', function (e) {
                e.preventDefault();

                var $item = $(this);
                var $infos = $item.closest('.infos');

                if ($item.hasClass('donate')) {
                    $infos.removeClass('share-close');
                    $infos.toggleClass('donate-close');
                    return;
                }

                $infos.removeClass('donate-close');
                $infos.toggleClass('share-close');

                if ($item.find('img').length === 0) {
                    var qrcode = $item.find('a').data('qrcode') || '';
                    $item.append('<div class="qrcode"><img src="' + qrcode + '" /> <i>移动设备上继续阅读</i></div>');
                }
            });
    }

    bindDonateShare();
    
    function hasCookie(name) {
        return (document.cookie || '').split(';').some(function (c) {
            c = c.trim();
            return c.indexOf(name + '=') === 0;
        });
    }

    function syncLikeButtons() {
        $('.dot-good').each(function () {
            var $btn = $(this);
            var cid = $btn.data('cid') || $btn.data('id');
            if (!cid) return;
            if (hasCookie('extend_contents_likes_' + cid)) {
                $btn.addClass('done');
            }
        });
    }

    $(document).on('click', '.dot-good', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var cid = $btn.data('cid') || $btn.data('id');
        if (!cid) return false;

        if ($btn.hasClass('done') || hasCookie('extend_contents_likes_' + cid)) {
            $btn.addClass('done');
            alert('点多了伤身体~');
            return false;
        }

        $btn.addClass('done');
        var $rateHolder = $btn.children('.count');
        var url = (window.location.href || '').split('#')[0] || window.location.pathname;

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: { likeup: 1, cid: cid },
            success: function (data) {
                if (data && typeof data.likes !== 'undefined') {
                    $rateHolder.text(data.likes);
                }
                if (data && data.success === false) {
                    alert(data.msg || '点多了伤身体~');
                }
                syncLikeButtons();
            },
            error: function () {
                $btn.removeClass('done');
                alert('点赞失败，请稍后重试');
            }
        });

        return false;
    });

    syncLikeButtons();
    if (window.InstantClick && typeof InstantClick.on === 'function') {
        InstantClick.on('change', function () {
            bindDonateShare();
            syncLikeButtons();
        });
    }
})(jQuery);
