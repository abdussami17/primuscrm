@php
    use App\Models\EmailConfiguration;
    $emailConf = $emailConf ?? EmailConfiguration::first() ?? new EmailConfiguration();
    $headerLogo = $emailConf->include_logo_header && $emailConf->header_logo_path ? asset('storage/'.$emailConf->header_logo_path) : null;
    $footerLogo = $emailConf->include_logo_footer && $emailConf->footer_logo_path ? asset('storage/'.$emailConf->footer_logo_path) : null;
@endphp

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        /* Minimal inline styles to keep email rendering consistent */
        body { font-family: Arial, Helvetica, sans-serif; color: #111827; margin:0; padding:0; }
        .email-container { width:100%; background:#ffffff; padding:20px; }
        .email-header, .email-footer { text-align:center; padding:10px 0; }
        .email-body { padding:20px 0; }
        .social-icons img { height:24px; margin:0 6px; }
        .confidentiality { font-size:12px; color:#6b7280; margin-top:18px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            @if($headerLogo)
                <img src="{{ $headerLogo }}" alt="Header Logo" style="max-width:240px; height:auto; display:block; margin:0 auto 10px;">
            @endif
        </div>

        <div class="email-body">
            {!! $body !!}
        </div>

        <div class="email-footer">
            @if($footerLogo)
                <div style="margin-bottom:10px;"><img src="{{ $footerLogo }}" alt="Footer Logo" style="max-width:180px; height:auto; display:inline-block;"></div>
            @endif

            @if($emailConf->facebook_url || $emailConf->instagram_url || $emailConf->twitter_url || $emailConf->youtube_url || $emailConf->reddit_url)
                <div class="social-icons" style="margin-bottom:10px;">
                    @if($emailConf->facebook_url)<a href="{{ $emailConf->facebook_url }}"><img src="{{ asset('assets/social/facebook.png') }}" alt="Facebook"></a>@endif
                    @if($emailConf->instagram_url)<a href="{{ $emailConf->instagram_url }}"><img src="{{ asset('assets/social/instagram.png') }}" alt="Instagram"></a>@endif
                    @if($emailConf->twitter_url)<a href="{{ $emailConf->twitter_url }}"><img src="{{ asset('assets/social/twitter.png') }}" alt="Twitter"></a>@endif
                    @if($emailConf->youtube_url)<a href="{{ $emailConf->youtube_url }}"><img src="{{ asset('assets/social/youtube.png') }}" alt="YouTube"></a>@endif
                    @if($emailConf->reddit_url)<a href="{{ $emailConf->reddit_url }}"><img src="{{ asset('assets/social/reddit.png') }}" alt="Reddit"></a>@endif
                </div>
            @endif

            @if($emailConf->confidentiality_notice)
                <div class="confidentiality">{!! nl2br(e($emailConf->confidentiality_notice)) !!}</div>
            @endif
        </div>
    </div>
</body>
</html>