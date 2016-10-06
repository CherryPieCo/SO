<tr>
    <td class="text-center">
        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
            </label>
        </div>
    </td>
    <td class="sitename">
        <strong>Модуль Broken link building</strong>
        <a href="#">{{ $site['url'] }}</a>
        <div class="status-icons">
            <i class="fa fa-envelope fa-lg brand-mail active" data-title="description text"></i>
            <i class="fa fa-list fa-lg brand-form active" data-title="description text"></i>
            <i class="fa fa-chain-broken fa-lg brand-link active" data-title="description text"></i>
            <i class="fa fa-facebook-official fa-lg brand-facebook active" data-title="description text"></i>
            <i class="fa fa-twitter fa-lg brand-twitter active" data-title="description text"></i>
            <i class="fa fa-pinterest fa-lg brand-pinterest active" data-title="description text"></i>
            <i class="fa fa-google-plus fa-lg brand-google active" data-title="description text"></i>
            <i class="fa fa-linkedin fa-lg brand-linkedin active" data-title="description text"></i>
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
    <td>{{ array_get($site, 'parsers.moz.data.page_authority', '-') }}</td><!-- PA -->
    <td>{{ array_get($site, 'parsers.moz.data.domain_authority', '-') }}</td><!-- DA -->
    <td>{{ array_get($site, 'parsers.alexa.data.rank', '-') }}</td><!-- Alex -->
</tr>
<tr class="advanced-info">
    <td></td>
    <td colspan="6">
    <div>
        <div class="advanced-info-wrapper">
            <div class="username">
                <!-- <i class="fa fa-user" data-title="description text"></i> -->
                Martin Scorsese
            </div>
            <div class="block-emails">
                <i class="fa fa-envelope" data-title="description text"></i>
                <a href="mailto:somebody@somesite.com">Theaticand1990@jourrapide.com</a>
                <a href="mailto:somebody@somesite.com">samuel.ross@example.com</a>
                <a href="mailto:somebody@somesite.com">tracy.edwards50@example.com</a>
                <a href="mailto:somebody@somesite.com">hannah.terry51@example.com</a>
                <a href="mailto:somebody@somesite.com">edward.franklin47@example.com</a>
            </div>
            <div class="block-contacts">
                <i class="fa fa-info-circle" data-title="description text"></i>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Write Us</a>
            </div>
            <div class="block-socials">
                <i class="fa fa-user" data-title="description text"></i>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Pinterest</a>
                <a href="#">Google+</a>
                <a href="#">LinkedIn</a>
            </div>
        </div>
        <!-- /.advanced-info-wrapper -->
    </div><!-- /.advanced-info --></td>
</tr>
