<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

$lang['text_heading']                   = 'Checkout';
$lang['text_checkout']                  = 'Almost there, Please confirm your details and proceed to payment.';
$lang['text_payments']                  = 'Please choose your payment method.';
$lang['text_registered']                = 'Already have an account? <a href="%s">Login Here</a>';
$lang['text_logout']                    = 'Welcome Back %s, Not You? <a href="%s">Logout</a>';
$lang['text_asap']                      = 'As soon as possible';
$lang['text_later']                     = 'Later';
$lang['text_step_one']                  = 'Step 1';
$lang['text_step_one_summary']          = 'Your Details';
$lang['text_step_two']                  = 'Step 2';
$lang['text_step_two_summary']          = 'Payment';
$lang['text_step_three']                = 'Step 3';
$lang['text_step_three_summary']        = 'Confirmation';
$lang['text_location_closed']           = 'Sorry, but we\'re closed, come back during opening hours';
$lang['text_edit']                      = 'Edit';
$lang['text_close']                     = 'Close';
$lang['text_ip_warning']                = '(Warning: Your IP Address has been logged for our fraud prevention measures.)';
$lang['text_date_format']               = '%l %d';

$lang['text_greetings']                 = 'Hello %s,';
$lang['text_success_heading']           = 'Order Confirmation';
$lang['text_order_details']             = 'Order Details';
$lang['text_order_items']               = 'What you\'ve ordered:';
$lang['text_delivery_address']          = 'Your Delivery Address';
$lang['text_your_local']                = 'Your local restaurant';
$lang['text_thank_you']                 = 'We hope to see you again soon';
$lang['text_success_message']           = 'Your order  %s has been received and will be with you shortly. <br /><a href="%s">Click here</a> to view your order progress. <br />Thanks for shopping with us online!';
$lang['text_order_info']                = 'This is a %s order. <br /><br /><b>Order Date:</b> %s <br /><b>%s Time:</b> %s <br /><b>Payment Method:</b> %s ';
$lang['text_order_total']               = 'Order Total: <b>%s.</b>';
$lang['text_collection_order_type'] 	= 'This is a pick-up order';
$lang['text_no_payment'] 	            = 'No payment method selected';

$lang['label_customer_name']            = 'Customer Name';
$lang['label_first_name']               = 'First Name';
$lang['label_last_name']                = 'Last Name';
$lang['label_email']                    = 'Email';
$lang['label_telephone']                = 'Telephone';
$lang['label_address']                  = 'Delivery Address';
$lang['label_address_id']               = 'Address Id';
$lang['label_address_1']                = 'Address 1';
$lang['label_address_2']                = 'Address 2';
$lang['label_city']                     = 'City';
$lang['label_state']                    = 'State';
$lang['label_postcode']                 = 'Postcode';
$lang['label_country']                  = 'Country';
$lang['label_order_type']               = 'Order Type';
$lang['label_delivery']                 = 'Delivery';
$lang['label_collection']               = 'Pick-up';
$lang['label_order_time']               = '%s Time';
$lang['label_choose_order_time']        = 'Choose %s Time';
$lang['label_order_asap_time']          = '%s ASAP Time';
$lang['label_order_time_type']          = '%s Time Type';
$lang['label_date']                     = 'Date';
$lang['label_hour']                     = 'Hour';
$lang['label_minute']                   = 'Minute';
$lang['label_payment_method']           = 'Payment Method';
$lang['label_terms']                    = 'By clicking I Agree, you agree to the <a href="%s" data-toggle="modal" data-target="#terms-modal">Terms and Conditions</a> set out by this site, including our Cookie Use.';
$lang['label_comment']                  = 'Add Comments';
$lang['label_ip']                       = 'IP Address';

$lang['button_agree_terms']             = 'I Agree';

$lang['error_delivery_unavailable']     = 'Delivery is unavailable at the selected restaurant!';
$lang['error_collection_unavailable']   = 'Pick-up is unavailable at the selected restaurant!';
$lang['error_covered_area']             = 'This restaurant currently does not deliver to your address';
$lang['error_delivery_less_current_time'] = 'The Delivery or Pick-up Time can not be less than current time!';
$lang['error_no_delivery_time']         = 'The selected delivery time is outside our opening/closing hours';
$lang['error_invalid_payment']          = 'The selected payment is invalid, please contact us';

$lang['alert_no_menu_to_order']         = '<p class="alert-danger">Please, add some menus before you checkout!</p>';
$lang['alert_no_selected_local']        = '<p class="alert-danger">Please select your local restaurant</p>';
$lang['alert_location_closed']          = '<p class="alert-danger">Sorry, you can\'t place an order now, we are currently closed,<br /> please come back later during our opening times.</p>';
$lang['alert_order_unavailable']        = '<p class="alert-danger">Niether delivery or pick-up is available at the selected restaurant.</p>';
$lang['alert_customer_not_logged']      = '<p class="alert-info">Almost there, Please login or register to complete checkout.</p>';
$lang['alert_delivery_area_changed']    = '<p class="alert-info">Your delivery area has changed, please confirm the delivery cost.</p>';

/* End of file checkout_lang.php */
/* Location: ./main/language/english/main/checkout_lang.php */
