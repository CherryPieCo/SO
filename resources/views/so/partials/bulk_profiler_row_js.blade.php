

<script id="bulk-profiler-row-template" type="text/html">
    
~foreach site in sites~
<tr data-hash="~site.hash~" class="~site.hash~ hashed">
    <td class="text-center">
        <div class="checkbox">
            <label>
                <input class="hashed-row-checkbox" type="checkbox" value="~site.hash~">
            </label>
        </div>
    </td>
    <td class="sitename">
        <strong class="open-advanced-info"><div class="truncate">~site.title~</div></strong>
        <a target="_blank" href="~site.url~"><div class="truncate">~site.url~</div></a>
        <div class="status-icons open-advanced-info">
            <i class="fa fa-envelope fa-lg brand-mail ~site.has_email | active~" data-toggle="tooltip" data-placement="top" title="Emails"></i>
            <i class="fa fa-list fa-lg brand-form ~site.has_contacts | active~" data-toggle="tooltip" data-placement="top" title="Contact page"></i>
            <i class="fa fa-chain-broken fa-lg brand-link" data-toggle="tooltip" data-placement="top" title="Broken links"></i>
            <i class="fa fa-facebook-official fa-lg brand-facebook ~site.has_facebook | active~" data-toggle="tooltip" data-placement="top" title="Facebook"></i>
            <i class="fa fa-twitter fa-lg brand-twitter ~site.has_twitter | active~" data-toggle="tooltip" data-placement="top" title="Twitter"></i>
            <i class="fa fa-pinterest fa-lg brand-pinterest ~site.has_pinterest | active~" data-toggle="tooltip" data-placement="top" title="Pinterest"></i>
            <i class="fa fa-google-plus fa-lg brand-google ~site.has_gplus | active~" data-toggle="tooltip" data-placement="top" title="Google+"></i>
            <i class="fa fa-linkedin fa-lg brand-linkedin ~site.has_linkedin | active~" data-toggle="tooltip" data-placement="top" title="LinkedIn"></i>
        </div>
    </td>
    <td>
        <span class="badge">~site.emails.length~</span>
    </td><!-- Contacts -->
    <td>
        <div class="status-icons mt-0 second-set">
            <i class="fa fa-audio-description fa-lg ~site.pages.advertising | active~" data-toggle="tooltip" data-placement="top" title="Advertising"></i>
            <i class="fa fa-link fa-lg ~site.pages.useful | active~" data-toggle="tooltip" data-placement="top" title="Useful links section found"></i>
            <i class="fa fa-money fa-lg ~site.pages.donate | active~" data-toggle="tooltip" data-placement="top" title="Donate"></i>
            <i class="fa fa-bold fa-lg ~site.pages.blog | active~" data-toggle="tooltip" data-placement="top" title="Blog found"></i>
            <i class="fa fa-pencil fa-lg ~site.pages.guest | active~" data-toggle="tooltip" data-placement="top" title="Guest posting opportunities"></i>
        </div>
    </td><!-- Status -->
    <td>~site.page_authority~</td><!-- PA -->
    <td>~site.domain_authority~</td><!-- DA -->
    <td>~site.alexa_rank~</td><!-- Alex -->
</tr>
<tr class="advanced-info ~site.hash~ hashed" style="display: none;">
    <td></td>
    <td colspan="6">
    <div>
        <div class="advanced-info-wrapper">
            <div class="block-emails">
                <i class="fa fa-envelope" data-title=""></i>
                ~foreach email in site.emails~
                    <a href="mailto:~email~" ~email | display($index)~>~email~</a>
                ~end~
                ~if site.emails.length > 7~
                    <a href="javascript:void(0);" onclick="Profiler.showMore(this)">show more</a>
                ~fi~
            </div>
            <div class="block-contacts"> 
                <i class="fa fa-info-circle" data-title=""></i>
                ~foreach contactUrl in site.contacts~
                    <a href="~contactUrl~" target="_blank" ~contactUrl | display($index)~>Contacts Information</a>
                ~end~
                ~if site.contacts.length > 7~
                    <a href="javascript:void(0);" onclick="Profiler.showMore(this)">show more</a>
                ~fi~
            </div>
            <div class="block-socials">
                <i class="fa fa-user" data-title=""></i>
                ~foreach social in site.social~
                    <a href="~social.link~" target="_blank" ~social.link | display($index)~>~social.title~</a>
                ~end~
                ~if site.contacts.length > 7~
                    <a href="javascript:void(0);" onclick="Profiler.showMore(this)">show more</a>
                ~fi~
            </div>
        </div>
        <!-- /.advanced-info-wrapper -->
    </div><!-- /.advanced-info -->
    </td>
</tr>
~end~

</script>