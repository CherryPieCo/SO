<tr class="{{ $hash }} hashed" style="{{ isset($hide) ? 'display:none' : '' }}">
    <td class="text-center">
        <div class="checkbox">
            <label>
                <input class="hashed-row-checkbox" type="checkbox" value="{{ $hash }}">
            </label>
        </div>
    </td>
    <td class="sitename">
        <strong>{{ !isset($site['title']) || !$site['title'] ? '[notitle]' : $site['title'] }}</strong>
        <a target="_blank" href="{{ $site['url'] }}">{{ $site['url'] }}</a>
        <div class="status-icons">
            <i class="fa fa-envelope fa-lg brand-mail {{ array_get($site, 'parsers.email.data.emails', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Emails"></i>
            <i class="fa fa-list fa-lg brand-form {{ array_get($site, 'parsers.email.data.contacts', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Contact page"></i>
            <i class="fa fa-chain-broken fa-lg brand-link" data-toggle="tooltip" data-placement="top" title="Broken links"></i>
            <i class="fa fa-facebook-official fa-lg brand-facebook {{ array_get($site, 'parsers.email.data.social.facebook', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Facebook"></i>
            <i class="fa fa-twitter fa-lg brand-twitter {{ array_get($site, 'parsers.email.data.social.twitter', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Twitter"></i>
            <i class="fa fa-pinterest fa-lg brand-pinterest {{ array_get($site, 'parsers.email.data.social.pinterest', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Pinterest"></i>
            <i class="fa fa-google-plus fa-lg brand-google {{ array_get($site, 'parsers.email.data.social.gplus', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Google+"></i>
            <i class="fa fa-linkedin fa-lg brand-linkedin {{ array_get($site, 'parsers.email.data.social.linkedin', []) ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="LinkedIn"></i>
        </div>
    </td>
    <td>
        <span class="badge">{{ count(array_get($site, 'parsers.email.data.emails', [])) }}</span>
    </td><!-- Contacts -->
    <td>
        <div class="status-icons mt-0 second-set">
            <i class="fa fa-audio-description fa-lg {{ array_get($site, 'parsers.pages.data.advertising') ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Advertising"></i>
            <i class="fa fa-link fa-lg {{ array_get($site, 'parsers.pages.data.useful') ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Useful links section found"></i>
            <i class="fa fa-money fa-lg {{ array_get($site, 'parsers.pages.data.donate') ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Donate"></i>
            <i class="fa fa-bold fa-lg {{ array_get($site, 'parsers.pages.data.blog') ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Blog found"></i>
            <i class="fa fa-pencil fa-lg {{ array_get($site, 'parsers.pages.data.guest') ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="Guest posting opportunities"></i>
        </div>
    </td><!-- Status -->
    <td>{{ array_get($site, 'parsers.moz.data.upa', '-') }}</td><!-- PA -->
    <td>{{ array_get($site, 'parsers.moz.data.pda', '-') }}</td><!-- DA -->
    <td>{{ array_get($site, 'parsers.alexa.data.rank', '-') }}</td><!-- Alex -->
</tr>
<tr class="advanced-info {{ $hash }} hashed" style="{{ isset($hide) ? 'display:none' : '' }}">
    <td></td>
    <td colspan="6">
    <div>
        <div class="advanced-info-wrapper">
            {{-- 
            <div class="username">
                <!-- <i class="fa fa-user" data-title=""></i> -->
                Martin Scorsese
            </div>
             --}}
            <div class="block-emails">
                <i class="fa fa-envelope" data-title=""></i>
                @foreach (array_get($site, 'parsers.email.data.emails', []) as $email)
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                @endforeach
            </div>
            <div class="block-contacts">
                <i class="fa fa-info-circle" data-title=""></i>
                @foreach (array_get($site, 'parsers.email.data.contacts', []) as $contactUrl)
                    <a href="{{ $contactUrl }}" target="_blank">Contacts Information</a>
                @endforeach
            </div>
            <div class="block-socials">
                <i class="fa fa-user" data-title=""></i>
                @foreach (array_get($site, 'parsers.email.data.social', []) as $social => $socialLinks)
                    @foreach ($socialLinks as $socialLink)
                        <a href="{{ $socialLink }}" target="_blank">{{ $social }}</a>
                    @endforeach
                @endforeach
            </div>
        </div>
        <!-- /.advanced-info-wrapper -->
    </div><!-- /.advanced-info --></td>
</tr>
