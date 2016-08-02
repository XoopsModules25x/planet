<!-- phppp (D.J.): http://xoopsforge.com; http://xoops.org.cn -->

<div id="page_header">
    <div class="head">
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php"><{$modname}></a>: <a
                href="search.php"><{$smarty.const._SR_SEARCH}></a>
    </div>
</div>

<{if $search_info}>
    <div class="resultMsg"> <{$search_info}> </div>
    <{if $results}>
        <{foreach item=result from=$results}>
            <div class="item">
                <strong><a href="<{$result.link}>"><{$result.res_title}></a></strong><br>
                <{$result.res_time}>
                <{if $result.res_text}>
                    <br>
                    <{$result.res_text}>
                <{/if}>
            </div>
            <br style="clear:both"/>
        <{/foreach}>
    <{/if}>
<{/if}>

<form name="search" action="search.php" method="post">
    <table class="outer" border="0" cellpadding="1" cellspacing="0" align="center" width="95%">
        <tr>
            <td>
                <table border="0" cellpadding="1" cellspacing="1" width="100%" class="head">
                    <tr>
                        <td class="head" width="10%" align="right"><strong><{$smarty.const._SR_KEYWORDS}></strong></td>
                        <td class="even"><input type="text" name="term" value="<{$search_term}>" size="80"/></td>
                    </tr>
                    <tr>
                        <td class="head" align="right"><strong><{$smarty.const._SR_TYPE}></strong></td>
                        <td class="even"><{$type_select}></td>
                    </tr>
                    <tr>
                        <td class="head" align="right"><strong><{$smarty.const._SR_SEARCHIN}></strong></td>
                        <td class="even"><{$searchin_select}></td>
                    </tr>
                    <tr>
                        <td class="head" align="right"><strong><{php}>echo planet_constant("MD_SORTBY")<{/php}></strong>&nbsp;
                        </td>
                        <td class="even"><{$sortby_select}></td>
                    </tr>
                    <{if $search_rule}>
                        <tr>
                            <td class="head" align="right"><strong><{$smarty.const._SR_SEARCHRULE}></strong>&nbsp;</td>
                            <td class="even"><{$search_rule}></td>
                        </tr>
                    <{/if}>
                    <tr>
                        <td class="head" align="right">&nbsp;
                            <input type="hidden" name="category" value="<{$category}>"/>
                            <input type="hidden" name="blog" value="<{$blog}>"/>
                            <input type="hidden" name="uid" value="<{$uid}>"/>
                        </td>
                        <td class="even"><input type="submit" name="submit" value="<{$smarty.const._SUBMIT}>"/>&nbsp;
                            <input type="reset" name="cancel" value="<{$smarty.const._CANCEL}>"/></td>
                </table>
            </td>
        </tr>
    </table>
</form>
<!-- end module contents -->
