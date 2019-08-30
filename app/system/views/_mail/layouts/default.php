name = "Default layout"
==
{{ $body }}
==
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style type="text/css">
        {{ $custom_css }}
        {{ $layout_css }}
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    @partial('header')
                        @if(is_array($site_logo))
                        <img
                            src="{{ Image_tool_model::resize($site_logo, ['height' => 90]) }}"
                            alt="{{ $site_name }}"
                        >
                        @endif
                    @endpartial
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {{ $body }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @partial('footer')
                        <p>&copy; {{ date('Y') }} {{ $site_name }}. All rights reserved.</p>
                    @endpartial
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
