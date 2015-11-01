<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

$lang['_text_title'] 		    = 'Authorize.Net';
$lang['text_tab_general'] 	    = 'General';
$lang['text_go_live'] 	        = 'Go Live';
$lang['text_test'] 	            = 'Test';
$lang['text_test_live'] 	    = 'Test Live';
$lang['text_sale'] 	            = 'SALE';
$lang['text_auth_only']         = 'Authorization Only';
$lang['text_auth_capture']      = 'Authorization & Capture';
$lang['text_visa'] 	            = 'Visa';
$lang['text_mastercard'] 	    = 'MasterCard';
$lang['text_american_express']  = 'American Express';
$lang['text_jcb'] 	            = 'JCB';
$lang['text_diners_club'] 	    = 'Diners Club';
$lang['text_cc_number'] 	    = 'Valid Card Number';
$lang['text_exp_month'] 	    = 'MM';
$lang['text_exp_year'] 	        = 'YY';
$lang['text_cc_cvc'] 	        = 'CVC';

$lang['label_title'] 	        = 'Title';
$lang['label_api_login_id'] 	= 'API Login ID';
$lang['label_transaction_key'] 	= 'Transaction Key';
$lang['label_transaction_mode'] = 'Transaction Mode';
$lang['label_transaction_type'] = 'Transaction Type';
$lang['label_accepted_cards']   = 'Accepted Cards';
$lang['label_order_total'] 	    = 'Order Total';
$lang['label_order_status']     = 'Order Status';
$lang['label_priority'] 	    = 'Priority';
$lang['label_status'] 	        = 'Status';
$lang['label_card_number'] 	    = 'CARD NUMBER';
$lang['label_card_expiry'] 	    = 'EXPIRY DATE';
$lang['label_card_cvc'] 	    = 'CV CODE';

$lang['text_tab_general'] 	    = 'General';

$lang['help_order_total'] 		= 'The total amount the order must reach before this payment gateway becomes active';
$lang['help_order_status'] 	    = 'Default order status when Authorize.Net (AIM) is the selected payment method';

$lang['error_cc_number']        = 'The selected payment is invalid, please contact us';

$lang['alert_min_order_total'] 	= 'You need to spend %s or more to use this payment method</p>';
$lang['alert_acceptable_cards'] = 'We only accept %s';
$lang['alert_error_contacting'] = '<p class="alert-danger">There was a problem while contacting the payment gateway. Please try again.</p>';

/* End of file authorize_net_aim_lang.php */
/* Location: ./extensions/authorize_net_aim/language/english/authorize_net_aim_lang.php */