<tr class="{{ $hash }} hashed">
    <td class="text-center">
        <div class="checkbox">
            <label>
                <input class="hashed-row-checkbox" type="checkbox" value="1">
            </label>
        </div>
    </td>
    <td class="sitename">
        <strong>{{ $site['title'] }}</strong>
        <a target="_blank" href="{{ $site['url'] }}">{{ $site['url'] }}</a>
        <div class="status-icons">
            <i class="fa fa-envelope fa-lg brand-mail {{ array_get($site, 'parsers.email.data.emails', []) ? 'active' : '' }}" data-title="description text"></i>
            <i class="fa fa-list fa-lg brand-form {{ array_get($site, 'parsers.email.data.contacts', []) ? 'active' : '' }}" data-title="description text"></i>
            <i class="fa fa-chain-broken fa-lg brand-link" data-title="description text"></i>
            <i class="fa fa-facebook-official fa-lg brand-facebook {{ array_get($site, 'parsers.email.data.social.facebook', []) ? 'active' : '' }}" data-title="description text"></i>
            <i class="fa fa-twitter fa-lg brand-twitter {{ array_get($site, 'parsers.email.data.social.twitter', []) ? 'active' : '' }}" data-title="description text"></i>
            <i class="fa fa-pinterest fa-lg brand-pinterest {{ array_get($site, 'parsers.email.data.social.pinterest', []) ? 'active' : '' }}" data-title="description text"></i>
            <i class="fa fa-google-plus fa-lg brand-google {{ array_get($site, 'parsers.email.data.social.gplus', []) ? 'active' : '' }}" data-title="description text"></i>
            <i class="fa fa-linkedin fa-lg brand-linkedin {{ array_get($site, 'parsers.email.data.social.linkedin', []) ? 'active' : '' }}" data-title="description text"></i>
        </div>
    </td>
    <td>
        <span class="badge">{{ count(array_get($site, 'parsers.email.data.emails', [])) }}</span>
    </td><!-- Contacts -->
    <td>
        <div class="status-icons mt-0 second-set">
            <i class="fa fa-audio-description fa-lg active" data-title="description text"></i>
            <i class="fa fa-link fa-lg active" data-title="description text"></i>
            <i class="fa fa-money fa-lg active" data-title="description text"></i>
            <i class="fa fa-bold fa-lg active" data-title="description text"></i>
            <i class="fa fa-pencil fa-lg active" data-title="description text"></i>
        </div>
    </td><!-- Status -->
    <td>{{ array_get($site, 'parsers.moz.data.upa', '-') }}</td><!-- PA -->
    <td>{{ array_get($site, 'parsers.moz.data.pda', '-') }}</td><!-- DA -->
    <td>{{ array_get($site, 'parsers.alexa.data.rank', '-') }}</td><!-- Alex -->
</tr>
<tr class="advanced-info {{ $hash }} hashed">
    <td></td>
    <td colspan="6">
    <div>
        <div class="advanced-info-wrapper">
            {{-- 
            <div class="username">
                <!-- <i class="fa fa-user" data-title="description text"></i> -->
                Martin Scorsese
            </div>
             --}}
            <div class="block-emails">
                <i class="fa fa-envelope" data-title="description text"></i>
                @foreach (array_get($site, 'parsers.email.data.emails', []) as $email)
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                @endforeach
            </div>
            <div class="block-contacts">
                <i class="fa fa-info-circle" data-title="description text"></i>
                @foreach (array_get($site, 'parsers.email.data.contacts', []) as $contactUrl)
                    <a href="{{ $contactUrl }}" target="_blank">Contacts Information</a>
                @endforeach
            </div>
            <div class="block-socials">
                <i class="fa fa-user" data-title="description text"></i>
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
