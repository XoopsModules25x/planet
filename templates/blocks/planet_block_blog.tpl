<!-- phppp (D.J.): http://xoopsforge.com; http://xoops.org.cn -->
<{foreach item=blog from=$block.blogs}>
    <div>
        <span><a href="<{$xoops_url}>/modules/<{$block.dirname}>/index.php<{$smarty.const.URL_DELIMITER}>b<{$blog.blog_id}>"><strong><{$blog.blog_title}></strong></a></span>
        <{if $blog.disp}> (<{$blog.disp}>)<{/if}>
    </div>
    <div style="margin-bottom:5px;">
        <span><{$blog.time}></span>
    </div>
    <{if $blog.summary}>
        <div><{$blog.summary}></div><{/if}>
<{/foreach}>
