语言：简体中文 | [English](README-en.md)

> The English editon of Adams is preparing now and being done by [KevinZonda](https://github.com/KevinZonda/). You can see it in [this repository](https://github.com/KevinZonda/adams).

# Theme Adams

<p align="center">
  <img src="screenshot.png">
</p>

## 介绍
这是移植自 WordPress 的一款主题，原作者 [Tokinx](https://github.com/Tokinx/Adams)  
个人很喜欢这种简洁而不失优雅的主题，功能也比较齐，于是就选择了移植。

## 二次开发部分内容

- 增加部分设置项,对于 Typecho 用户更友好
- 增加 Mastodon 和 Telegram 社交链接支持
- 增加站点图标设置支持
- 修复站点介绍/公告设置,如无填写则显示Hitokoto
- 修复评论表单问题
- 本地化js和css文件，减少对外部资源的依赖
- 移除google字体
- 增加备案号显示支持
- 增加 Head 和 Footer 额外代码插入支持
- 修改底部菜单为友情链接,使用links插件
- 自动匹配文章的第一张图片为缩略图
- 增加文章浏览次数统计
- 修复文章点赞功能
- 修复主题模式选择
- 增加评论中@功能
- 增加相关文章显示
- 其他一些细节优化

## 特色
- 自适应/响应式设计
- 单栏简洁设置
- 简洁的图片灯箱
- 护眼/夜间模式
- Instantclick 预加载
- 体积轻小，压缩后仅 310KB
- More to find

移植版本相对于原版的改动：
- ~~取消点赞功能~~
- 取消自定义导航
- 取消 ajax 评论
- 取消了留言墙
- ~~减少了大部分设置项，不让设置成为累赘~~
- ~~底部导航被 Hitokoto 一言替换~~
- 自动隔开中英文（By Pangu.js）
- 字体替换为思源宋体/黑体

## 引用
- [jQuery](https://github.com/jquery/jquery)
- [Prettify](https://github.com/google/code-prettify)
- [instantclick](https://github.com/dieulot/instantclick)
- [pangu.js](https://github.com/vinta/pangu.js)
- [Google Fonts](https://fonts.google.com)

## 演示
原 WP 版：https://biji.io  
Typecho 版演示：https://blog.vsc.im

## 版权
鉴于原项目没有 License，所以移植已经经过作者亲自授权。
![](copyright.png)

## 许可
Copyright &copy; 2019-2020 Eltrac & Tokinx, Under MIT License