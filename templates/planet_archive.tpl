<!-- phppp (D.J.): http://xoopsforge.com; http://xoops.org.cn -->

<div id="page_header">
    <div class="head">
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/view.archive.php<{$smarty.const.URL_DELIMITER}><{$time.year}>/<{$time.month}>/<{$time.day}>/"><{$modulename}></a>
    </div>
</div>

<div id="pagetitle">
    <div class="title">
        <{$page.title}>: <{$page.time}>
        <{if $blog}>
            <br>
            <a
            href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php<{$smarty.const.URL_DELIMITER}>b<{$blog}>"><{$page.blog}></a><{/if}>
    </div>
</div>

<div class="item">
    <a href="<{$timenav.prev.url}>"><{$timenav.prev.title}></a>
    <{if $timenav.prev AND $timenav.next}> |
    <{/if}>
    <a href="<{$timenav.next.url}>"><{$timenav.next.title}></a>
    <br clear="both">
</div>
<{if $months}>
    <div class="item"><{php}>echo planet_constant("MD_MONTHLY")<{/php}></div>
    <{foreach item=month from=$months}>
        <div>
            <a href="<{$month.url}>"><{$month.title}></a>
        </div>
    <{/foreach}>
    <br clear="both">
<{/if}>
<{if $calendar}>
    <div class="item">
        <{$calendar}>
    </div>
    <br clear="both">
<{/if}>

<{if count($articles)>0}>
    <div id="article">
        <div class="title"><{php}>echo planet_constant("MD_ARTICLES")<{/php}></div>
        <{foreach item=article from=$articles}>
            <div class="title"><a
                        href="<{$xoops_url}>/modules/<{$xoops_dirname}>/view.article.php<{$smarty.const.URL_DELIMITER}><{$article.id}>"><{$article.title}></a>
            </div>
            <div class="item">
                <span class="title"><a
                            href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php<{$smarty.const.URL_DELIMITER}>b<{$article.blog.id}>"><{$article.blog.title}></a></span>
                <span class="item"><{$article.time}></span>
            </div>
            <div class="item"><{$article.summary}></div>
        <{/foreach}>
    </div>
<{/if}>

<div id="pagenav">
    <{$pagenav}>
</div>
