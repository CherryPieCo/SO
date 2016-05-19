@extends('layouts.home')

@section('main')

<div id="wrapper">

    @include('partials.login_header')
    @include('partials.header')

    <!-- Start Content -->

    <div class="container">
        <div class="row">
            <div class="span6">
                <div class="inner">
                    <div class="hero">
                        <h1>Simplify Your Link Building Strategies</h1>
                        <h2>Influencer Outreach & Link Building Tool Provides:</h2>
                        <div class="advantages-list">
                            <div class="advantages-list-inner">
                                <h2><span class="glyph-item  icon-check" aria-hidden="true"></span> Mail Marge</h2>
                                <h2><span class="glyph-item  icon-check" aria-hidden="true"></span> Email Tamplate</h2>
                                <h2><span class="glyph-item  icon-check" aria-hidden="true"></span> Bulk Email Finder</h2>
                                <h2><span class="glyph-item  icon-check" aria-hidden="true"></span> Broken Links Finder</h2>
                                <h2><span class="glyph-item  icon-check" aria-hidden="true"></span> Backlink Cheker</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span5">
                <div class="inner">
                    <div class="form-box">
                        <div class="top">
                            <h2>Try Our Service For Free</h2>
                            <p>
                                Create your account and get a free 14-day trial!
                            </p>
                        </div>

                        <div class="bottom">
                            <div id="success">
                                <span class="green textcenter">
                                    <p>
                                        Registered successfully!
                                    </p> </span>
                            </div>

                            <div id="error">
                                <span>
                                    <p>
                                        Something went wrong. Please refresh and try again.
                                    </p> </span>
                            </div>

                            <form id="contact" method="post" novalidate="novalidate">
                                <div class="form-row">
                                    <input type="text" name="name" id="name" size="30" value="" required="" class="text login_input"  placeholder="Your name">
                                </div>
                                <div class="form-row">
                                    <input type="text" name="email" id="email" size="30" value="" required="" class="text login_input"  placeholder="Email Address">
                                </div>
                                <div class="form-row">
                                    <input id="submit" type="submit" name="submit" value="Sign Up Now" class="btn" style="padding: 1em 0; width: 100%;">
                                    <!-- <a href="#">Privacy Policy</a> | <a href="#">Terms &amp; Conditions</a> -->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="shadow"></div>
                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Notice</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <ol style="color: #263238;">
                                <li>
                                    Pleace check your inbox to confirm your email address and complete your request. (Make sure to check your Spam box if you don't see our email).
                                </li>
                                <li>
                                    Now you'll be directed to <a href="#">http://simpleoutreach.com</a> where you'll be able to see our backlinks inventory, link prices, select and buy the best Pr1-Pr8 links by yourself, OR <a href="#">request a dedicated SEO expert</a> who will manage your entire SEO and link building campaign for you, for no extra cost.
                                </li>
                            </ol>
                            <div class="text-center form-row">
                                <input id="submit" type="submit" name="submit" value="OK" class="btn" data-dismiss="modal">
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /modal -->

    <!-- End content -->

    <div class="clearfix"></div>

</div>

<div class="strip features">

    <div class="container">

        <div class="row">

            <div class="span3">
                <div class="inner">
                    <span class="glyph-item mega icon-magnifier" aria-hidden="true"></span>
                    <h3>Bulk E-mail</h3>
                    <p>
                        Bulk Email can help you to find all emails easily with the help of websites list.  Use our API access to integrate it into your apps.
                    </p>
                </div>
            </div>

            <div class="span3">
                <div class="inner">
                    <span class="glyph-item mega icon-envelope" aria-hidden="true"></span>
                    <h3>Mail Merge</h3>
                    <p>
                        Send personalized email messages to people using Mail Merge for Gmail. You are able to send emails automatically to a selected list.
                    </p>
                </div>
            </div>

            <div class="span3">
                <div class="inner">
                    <span class="glyph-item mega icon-link" aria-hidden="true"></span>
                    <h3>Backlink Checker</h3>
                    <p>
                        Get backlinks from any competitor website and create a profile with high diversification of links (like the profiles of websites from TOP 10 search engines).
                    </p>
                </div>
            </div>

            <div class="span3">
                <div class="inner">
                    <span class="glyph-item mega icon-fire" aria-hidden="true"></span>
                    <h3>404 Link Checker</h3>
                    <p>
                        Bulk Checker for broken links on your list of websites URLs. Use broken link building strategy today.
                    </p>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>

    </div>

</div>

<div class="strip highlight strip-alt">

    <div class="container">

        <div class="row">

            <div class="span6">

                <div class="inner inner-text" style="padding-top: 3.9em">

                    <h2>RESEARCH INFLUENCER <span>AUTOMATICALLY</span></h2>

                    <!-- <h4>Phasellus consequat facilisis volutpat ma faucibus odio vitae semper. Ae volutpat lobortis. </h4> -->

                    <p>
                        Simple Outreach is an app that provides you with required contact information like email addresses, checks broken links, helps to get backlinks from URL list and can be used for automatic email delivery. You’ll need it if you want to be in trend and to use popular strategies for link building:
                    </p>

                    <div class="row">
                        <div class="span6">
                            <div class="advantages-list">
                                <div class="advantages-list-inner">
                                    <p>
                                        <span class="glyph-item  icon-check" aria-hidden="true"></span>Guest post opportunities
                                    </p>
                                    <p>
                                        <span class="glyph-item  icon-check" aria-hidden="true"></span>Guestographics
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="advantages-list">
                                <div class="advantages-list-inner">
                                    <p>
                                        <span class="glyph-item  icon-check" aria-hidden="true"></span>Skyscraper techniques
                                    </p>
                                    <p>
                                        <span class="glyph-item  icon-check" aria-hidden="true"></span>404 link building
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p>
                        Moreover, you can become a growth hacker and create your own strategies too!
                    </p>

                </div>

            </div>

            <div class="span6">

                <div class="inner">

                    <img src="images/safari-browser.png" alt="Bulk page in Safari browser" class="promoimg" />

                </div>

            </div>

            <div class="clearfix"></div>

        </div>

    </div>

</div>

<div class="strip highlight">

    <div class="container">

        <div class="row">

            <div class="span6">

                <div class="inner">

                    <img src="images/browser_table.png" alt="SimpleOutreach.com" class="promoimg" />

                </div>

            </div>

            <div class="span6">

                <div class="inner inner-text" style="padding-top: 3.5em">

                    <h2>Influencer <span>Outreach APP</span></h2>

                    <!-- <h4>Phasellus consequat facilisis volutpat ma faucibus odio vitae semper. Ae volutpat lobortis. </h4> -->
                    <p>
                        The most effective and easy app for building connections with bloggers. Doubt that? Well, then try it now and see for yourself!
                    </p>
                    <p>
                        Follow few simple steps:
                    </p>
                    <ol style="margin-top: 0">
                        <li>
                            Add the list of websites
                        </li>
                        <li>
                            Find contact information
                        </li>
                        <li>
                            Create an email template
                        </li>
                        <li>
                            Start Outreach
                        </li>
                    </ol>

                </div>

            </div>

            <div class="clearfix"></div>

        </div>

    </div>

</div>

<div class="strip strip-alt pricing highlight criterias">
    <div class="container">
        <div class="row blocks">
            <h2>Criteria for link choosing</h2>
            <div class="span4 criteria-item">
                <div class="number-wrapper">
                    1
                </div>
                <div class="text-wrapper">
                    <h4>Come from a relevant trusted source</h4>
                    <p>
                        With high PA and DA values
                    </p>
                </div>
            </div>
            <div class="span4 criteria-item">
                <div class="number-wrapper">
                    2
                </div>
                <div class="text-wrapper">
                    <h4>Sends traffic</h4>
                    <p>
                        Traffic is measured by traffic rank, number of views and comments in posts
                    </p>
                </div>
            </div>
            <div class="span4 criteria-item">
                <div class="number-wrapper">
                    3
                </div>
                <div class="text-wrapper">
                    <h4>In-content</h4>
                    <p>
                        Are situated in text and used in relevant content
                    </p>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="chart-section">
                <div class="arrow-down">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M6 0l12 12-12 12z"/>
                    </svg>
                </div>
                <div class="chart-item">
                    <div class="linearChartLegend" id="linearChartLegend"></div>
                    <canvas id="linearChart" width="600" height="200"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="strip pricing">
    <div class="container">
        <div class="row blocks">
            <div class="span4">
                <div class="inner secondary">
                    <ul>
                        <li>
                            <h2>Free</h2>
                        </li>
                        <li class="price">
                            <h1><strong>14</strong><small> Day Trial</small></h1>
                        </li>
                        <li>
                            Email Finder /Unlim.
                        </li>
                        <li>
                            Backlink Cheker /Unlim.
                        </li>
                        <li>
                            Broken Links Finder /Unlim.
                        </li>
                        <li>
                            App for Excel:
                        </li>
                        <li>
                            Send Mail automatically
                        </li>
                        <li>
                            Api Email Finder
                        </li>
                    </ul>
                    <a href="#" class="btn">Buy Now</a>
                </div>
            </div>

            <div class="span4">

                <div class="inner primary">

                    <ul>
                        <li>
                            <h2>Blogger</h2>
                        </li>
                        <li class="price">
                            <h1><span>$ </span><strong>31</strong><small> per month</small></h1>
                        </li>
                        <li>
                            Bulk Email Finder /Unlim.
                        </li>
                        <li>
                            App for Excel:
                        </li>
                        <li>
                            Send Mail automatically
                        </li>

                        <li>
                            Api Email Finder
                        </li>
                    </ul>

                    <a href="#" class="btn">Buy Now</a>

                </div>

            </div>

            <div class="span4">

                <div class="inner secondary">

                    <ul>
                        <li>
                            <h2>Pro</h2>
                        </li>
                        <li class="price">
                            <h1><span>$ </span><strong>47</strong><small> per month</small></h1>
                        </li>
                        <li>
                            Email Finder /Unlim.
                        </li>
                        <li>
                            Backlink Cheker /Unlim.
                        </li>
                        <li>
                            Broken Links Finder /Unlim.
                        </li>
                        <li>
                            App for Excel:
                        </li>
                        <li>
                            Send Mail automatically
                        </li>
                        <li>
                            Api Email Finder
                        </li>
                    </ul>

                    <a href="#" class="btn">Buy Now</a>

                </div>

            </div>

            <div class="clearfix"></div>

        </div>

    </div>

</div>

<div class="strip strip-alt pricing highlight testimonials">
    <div class="container">
        <div class="row blocks">
            <h2>Testimonials</h2>
            <div class="span12">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <div class="testimonial-item">
                                <div class="user-wrapper">
                                    <img class="user-photo" src="images/profiles/brian-jens.jpg">
                                    <span class="user-name"><strong>Brian Jens</strong></span>
                                </div>
                                <div class="text-wrapper">
                                    <span class="user-text">I am a designer and I use my own website to promote my services. Recently I was looking for the ways to get my first customers and Simple Outreach app turned out to be the perfect option for me. I used it to build high quality links placed in relevant content. As a result, my website rankings in Google Top 10 have improved, I’ve got traffic from search engines, and (what’s most important) I’ve got my first clients!</span>
                                    <span class="user-screenshot"> <img src="images/profiles/rodger_graph.jpg"> </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="testimonial-item">
                                <div class="user-wrapper">
                                    <img class="user-photo" src="images/profiles/lucy-adams.jpg">
                                    <span class="user-name"><strong>Lucy Adams</strong></span>
                                </div>
                                <div class="text-wrapper">
                                    <span class="user-text">For me, this service is a reliable tool, which allows using the latest link mass building tactics such as broken link building, guestographic, competitors backlinks and others. This is really simple and effective app useful for building a powerful link profile. Now I’m not afraid of Google spam algorithms (Penguin and Panda) as I receive an increase of traffic and search engine rankings every month.</span>
                                    <span class="user-screenshot"> <img src="images/profiles/lucy_graph.jpg"> </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="testimonial-item">
                                <div class="user-wrapper">
                                    <img class="user-photo" src="images/profiles/rodger-smith.jpg">
                                    <span class="user-name"><strong>Rodger Smith</strong></span>
                                </div>
                                <div class="text-wrapper">
                                    <span class="user-text">I’ve been working as a SEO for more than five years. I’ve been using similar services for some time, so I decided to check Simple Outreach and to compare it with the others. This app turned out to be surprisingly easy to use: I changed its settings to automatize the process of building connections with bloggers and to increase overall efficiency. All I had to do is to set this app once and now I’m receiving emails from bloggers, who are willing to publish my content, every day. I think this app has the best price/performance criteria.</span>
                                    <span class="user-screenshot"> <img src="images/profiles/brian_graph.jpg"> </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="strip pricing highlight reasons">
    <div class="container">
        <div class="row blocks">
            <h2>10 Reasons Why Your Competitors Are Using Our Simple Outreach App</h2>
            <div class="span12 reasons-list">
                <h4><span class="glyph-item icon-paper-plane" aria-hidden="true"></span> High Link Diversification and Links from Top 10 Search Engines </h4>
                <h4><span class="glyph-item icon-graph" aria-hidden="true"></span> Traffic and Ranking Growth </h4>
                <h4><span class="glyph-item icon-link" aria-hidden="true"></span> Simple Set of Functions for Building a Strong Link Profile </h4>
                <h4><span class="glyph-item icon-user" aria-hidden="true"></span> Effective system that allows building connections with bloggers </h4>
                <h4><span class="glyph-item icon-eye" aria-hidden="true"></span> Safe link profile, which allows to get more conversions from target audience </h4>
                <h4><span class="glyph-item icon-bar-chart" aria-hidden="true"></span> Increase of sales and income from search marketing sources </h4>
                <h4><span class="glyph-item icon-list" aria-hidden="true"></span> The most detailed contact information about web resources </h4>
                <h4><span class="glyph-item icon-fire" aria-hidden="true"></span> Broken link checker </h4>
                <h4><span class="glyph-item icon-check" aria-hidden="true"></span> Information about competitors’ links </h4>
                <h4><span class="glyph-item icon-envelope" aria-hidden="true"></span> Automatic email delivery: easy template setting and email sending </h4>
            </div>
            <div class="btn-wrapper">
                <a href="#header" class="btn btn-cta">Try it Now</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="strip strip-alt pricing highlight faq">
    <div class="container">
        <div class="row blocks">
            <h2>FAQ</h2>
            <div class="span12 faq-items">
                <ol>
                    <li>
                        <h4>How can you help me?</h4>
                        <p>
                            Our app allows finding any email address with the help of URL list, detecting external and broken links on a webpage, and setting an automatic email delivery with the help of custom template.
                        </p>
                    </li>

                    <li>
                        <h4>Is there a limit of the emails I can send per day?</h4>
                        <p>
                            We use Google Merge for Google Gmail for email delivery. This app allows sending 100 emails per day if you have standard account and 1500 emails per day if you have Google business account.
                        </p>
                    </li>
                    <li>
                        <h4>Will my Paypal be charged automatically?</h4>
                        <p>
                            You will receive an email about the Simple Outreach subscription renewal 15 days before it expires. You will also receive this email on a billing day.
                        </p>
                    </li>

                    <li>
                        <h4>Do you have any contracts or hidden charges?</h4>
                        <p>
                            There are no contracts or hidden charges: you can cancel subscription any time you want.
                        </p>
                    </li>
                    <li>
                        <h4>What do I need to know to use Simple Outreach?</h4>
                        <p>
                            If you know how to surf the web and how to write emails, you will be able to use Simple Outreach. We will send you an email with all the information you need to know.
                        </p>
                    </li>

                </ol>
            </div>
            <div class="btn-wrapper">
                <a href="#header" class="btn btn-cta">Sign Up Free</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="clearfix"></div>


@include('partials.footer')

@stop

@section('scripts')

<script src="/js/jquery.form.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/contact.js"></script>
<script src="/js/Chart.min.js"></script>
<script src="/js/jquery.flexslider-min.js"></script>
<script src="/js/drawing-chart.js"></script>
<script src="/js/bootstrap-modal.min.js"></script>

<script>
    $(function() {
        var loginToggler = $('#loginToggler');
        var loginLine = $('.login-line');
        loginToggler.on('click', function() {
            loginLine.toggleClass('opened');
        });

        $('.flexslider').flexslider({
            animation : "slide",
            // randomize: true,
            // controlNav: false,
            directionNav : false,
            prevText : "",
            nextText : ""
        });

        $('a.btn-cta').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop : target.offset().top
                    }, 1000);
                    $('.form-box #name').focus();
                    return false;
                }
            }

        });
    }); 
</script>

@stop

