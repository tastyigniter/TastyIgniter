subject = "Your Order Update - {order_number}"
==

Order Update!

Your order {order_number} has been updated to the following status: {status_name}

The comments for your order are:
{status_comment}

To view your order progress, click the link below
{order_view_url}

==

<!-- BODY -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                <table>
                    <tr>
                        <td>
                            <h3>Order Update!</h3>
                            <p>Your order
                                <strong>{order_number}</strong> has been updated to the following status: </strong>{status_name}</strong>
                            </p>
                            <p><strong>The comments for your order are:</strong><br>{status_comment}</p>
                            <p><a href="{order_view_url}">Click here</a> to view your order progress.</p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->
        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->