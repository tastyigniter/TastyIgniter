<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

$lang['_text_title'] 		                    = 'Stripe';
$lang['text_tab_general'] 	                    = 'General';
$lang['text_description'] 	                    = 'Pay by Credit Card using Stripe';
$lang['text_live'] 	                            = 'Live';
$lang['text_test'] 	                            = 'Test';
$lang['text_cc_number'] 	                    = 'Valid Card Number';
$lang['text_exp'] 	                            = 'MM / YY';
$lang['text_cc_cvc'] 	                        = 'CVC';
$lang['text_stripe_charge_description'] 	    = '%s Charge for %s';
$lang['text_payment_status'] 	                = 'Payment %s (%s)';

$lang['label_title'] 	                        = 'Title';
$lang['label_description'] 	                    = 'Description';
$lang['label_transaction_mode']                 = 'Transaction Mode';
$lang['label_test_secret_key'] 	                = 'Test Secret Key';
$lang['label_test_publishable_key']             = 'Test Publishable Key';
$lang['label_live_secret_key'] 	                = 'Live Secret Key';
$lang['label_live_publishable_key']             = 'Live Publishable Key';
$lang['label_force_ssl']                        = 'Force SSL';
$lang['label_order_total'] 	                    = 'Order Total';
$lang['label_order_status']                     = 'Order Status';
$lang['label_priority'] 	                    = 'Priority';
$lang['label_status'] 	                        = 'Status';
$lang['label_card_number'] 	                    = 'CARD NUMBER';
$lang['label_card_expiry'] 	                    = 'EXPIRY DATE';
$lang['label_card_cvc'] 	                    = 'CV CODE';

$lang['help_order_total'] 		                = 'The total amount the order must reach before this payment gateway becomes active';
$lang['help_order_status'] 	                    = 'Default order status when Stripe is the selected payment method';

$lang['alert_min_order_total'] 	                = 'You need to spend %s or more to use this payment method</p>';
$lang['alert_error_contacting']                 = '<p class="alert-danger">There was a problem while contacting the payment gateway. Please try again.</p>';

/* End of file stripe_lang.php */
/* Location: ./extensions/stripe/language/english/stripe_lang.php */