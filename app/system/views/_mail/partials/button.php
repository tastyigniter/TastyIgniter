name = "Button"
==
{{ $slot }} <{{ $url }}>
==
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <a href="{{ $url }}" class="button button-{{ $type or 'primary' }}" target="_blank">{{ $slot }}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
