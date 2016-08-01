<!-- phppp (D.J.): http://xoopsforge.com; http://xoops.org.cn -->

<div class="itemHead" style="text-align:center;">
    <h2><span class="itemTitle">
<{$article.title}>
</span></h2>
</div>
<br style="clear:both"/>

<div class="itemInfo">
    <{if $article.author}>
        <{php}>echo planet_constant("MD_AUTHOR")<{/php}>:
        <a href="<{$article.link}>" target="_blank"><{$article.author}></a>
        |
    <{else}>
        <a href="<{$article.link}>" target="_blank"><{php}>echo planet_constant("MD_SOURCE")<{/php}></a>
        |
    <{/if}>
    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php<{$smarty.const.URL_DELIMITER}>b<{$article.blog.id}>"><{$article.blog.title}></a>
    <br style="clear:both"/>
    <{php}>echo planet_constant("MD_DATE")<{/php}>: <{$article.time}>
    <{if $user_level gt 1}> | <a
        href="<{$xoops_url}>/modules/<{$xoops_dirname}>/action.article.php?article=<{$article.id}>"><{$smarty.const._EDIT}></a><{/if}>
    <br style="clear:both"/>
    <{php}>echo planet_constant("MD_VIEWS")<{/php}>: <{$article.views}>
    <{if $article.rates OR $canrate}>
        | <{php}>echo planet_constant("MD_RATE")<{/php}>:
        <{if $article.rates}>
            <{$article.star}>/<{$article.rates}>
        <{/if}>
        <{if $canrate}> (
            <{section name=rate loop=6 max=5 step=-1}>
                <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/action.rate.php?article=<{$article.id}>&amp;rate=<{$smarty.section.rate.index}>"><{$smarty.section.rate.index}></a>
            <{/section}>
            )<{/if}>
    <{/if}>
</div>

<div class="itemBody">
    <p class="itemText"><{$article.content}></p>
</div>

<{if $sibling}>
    <div class="sibling">
        <{if $sibling.previous}>
            <span class="previous">
<a href="<{$sibling.previous.url}>"><{php}>echo planet_constant("MD_PREVIOUS")<{/php}> <{$sibling.previous.title}></a>
</span>
        <{/if}>
        <{if $sibling.next}>
            <span class="next">
<a href="<{$sibling.next.url}>"><{$sibling.next.title}> <{php}>echo planet_constant("MD_NEXT")<{/php}></a>
</span>
        <{/if}>
        <br style="clear:both"/>
    </div>
<{/if}>

<script type="text/javascript">
    <!--
    function copytext(element) {
        var copyText = document.getElementById(element).value;
        if (window.clipboardData) { // IE send-to-clipboard method.
            window.clipboardData.setData('Text', copyText);

        } else if (window.netscape) {
            // You have to sign the code to enable this or allow the action in about:config by changing user_pref("signed.applets.codebase_principal_support", true);
            netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');

            // Store support string in an object.
            var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
            if (!str) return false;
            str.data = copyText;

            // Make transferable.
            var trans = Components.classes["@mozilla.org/widget/transferable;1"].createInstance(Components.interfaces.nsITransferable);
            if (!trans) return false;

            // Specify what datatypes we want to obtain, which is text in this case.
            trans.addDataFlavor("text/unicode");
            trans.setTransferData("text/unicode", str, copyText.length * 2);

            var clipid = Components.interfaces.nsIClipboard;
            var clip = Components.classes["@mozilla.org/widget/clipboard;1"].getService(clipid);
            if (!clip) return false;

            clip.setData(trans, null, clipid.kGlobalClipboard);
        }
    }
    //-->
</script>

<div class="itemFoot">
    <{php}>echo planet_constant("MD_URL")<{/php}>:
    <input name="a<{$article.id}>" id="a<{$article.id}>"
           value="<{$xoops_url}>/modules/<{$xoops_dirname}>/view.article.php<{$smarty.const.URL_DELIMITER}><{$article.id}>"
           type="hidden">
    <span class="copytext" onclick="copytext('a<{$article.id}>')" title="URI - <{php}>echo planet_constant("
          MD_CLICKTOCOPY")<{/php}>" ><{$xoops_url}>/modules/<{$xoops_dirname}>
    /view.article.php<{$smarty.const.URL_DELIMITER}><{$article.id}></span>
    <br style="clear:both"/>
    <{php}>echo planet_constant("MD_TRACKBACK")<{/php}>:
    <input name="t<{$article.id}>" id="t<{$article.id}>"
           value="<{$xoops_url}>/modules/<{$xoops_dirname}>/trackback.php<{$smarty.const.URL_DELIMITER}><{$article.id}>"
           type="hidden">
    <span class="copytext" onclick="copytext('t<{$article.id}>')" title="Trackback - <{php}>echo planet_constant("
          MD_CLICKTOCOPY")<{/php}>" ><{$xoops_url}>/modules/<{$xoops_dirname}>
    /trackback.php<{$smarty.const.URL_DELIMITER}><{$article.id}></span>
    <{if $copyright}>
    <br style="clear:both"/>
    <{$copyright}>
    <{/if}>
</div>

<div id="page_footer">
    <div style="text-align: left; float: left;">
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php"
           target="_self"><{php}>echo planet_constant("MD_HOME")<{/php}></a> |
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/view.blogs.php"
           target="_self"><{php}>echo planet_constant("MD_BLOGS")<{/php}></a> |
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php<{$smarty.const.URL_DELIMITER}>b<{$article.blog.id}>"
           target="_self"><{php}>echo planet_constant("MD_BLOG")<{/php}></a>
    </div>
    <div style="text-align: right; float: right;">
        <{if $transfer}>
            <{if $transfer.more}>
                <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/transfer.php<{$smarty.const.URL_DELIMITER}>c<{$article.category}>/<{$article.id}>/"
                   target="_blank"
                   title="<{$transfer.desc}>"><{$transfer.title}></a>
            <{/if}>
            <{foreach item=opt key=op from=$transfer.list}>
                <img src="<{$xoops_url}>/images/pointer.gif" alt=""/>
                <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/transfer.php<{$smarty.const.URL_DELIMITER}><{$article.id}>/<{$op}>"
                   target="<{$op}>" title="<{$opt.desc}>"><{$opt.title}></a>
            <{/foreach}>
            <br>
        <{/if}>
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/xml.php<{$smarty.const.URL_DELIMITER}>rss/<{$article.id}>"
           target="api"><{php}>echo planet_constant("MD_RSS")<{/php}></a>
        | <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/xml.php<{$smarty.const.URL_DELIMITER}>rdf/<{$article.id}>"
             target="api"><{php}>echo planet_constant("MD_RDF")<{/php}></a>
        | <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/xml.php<{$smarty.const.URL_DELIMITER}>atom/<{$article.id}>"
             target="api"><{php}>echo planet_constant("MD_ATOM")<{/php}></a>
    </div>
</div>
<br style="clear:both"/>

<{if $commentsnav}>
    <a id="comment" name="comment"></a>
    <div style="text-align: center; padding: 3px; margin:3px;">
        <{$commentsnav}>
        <{$lang_notice}>
    </div>
    <div style="margin:3px; padding: 3px;">
        <{if $comment_mode == "flat"}>
            <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode == "thread"}>
            <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode == "nest"}>
            <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
    </div>
<{/if}>

<{if $xoops_notification}>
    <{include file='db:system_notification_select.tpl'}>
<{/if}>

<img src="<{$xoops_url}>/modules/<{$xoops_dirname}>/counter.php?article=<{$article.id}>" alt="" width="1px"
     height="1px"/>
