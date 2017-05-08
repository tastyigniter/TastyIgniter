<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * New column 'label' on Mail templates table
 */
class Migration_add_column_label_to_mail_templates_data_table extends TI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('mail_templates_data', [
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => TRUE,
                'after'      => 'code',
            ],
        ]);

        $labels = [
            'registration'                 => 'lang:text_registration',
            'registration_alert'           => 'lang:text_registration_alert',
            'password_reset_request'       => 'lang:text_password_reset_request',
            'password_reset_request_alert' => 'lang:text_password_reset_request_alert',
            'password_reset'               => 'lang:text_password_reset',
            'password_reset_alert'         => 'lang:text_password_reset_alert',
            'order'                        => 'lang:text_order',
            'order_alert'                  => 'lang:text_order_alert',
            'order_update'                 => 'lang:text_order_update',
            'reservation'                  => 'lang:text_reservation',
            'reservation_alert'            => 'lang:text_reservation_alert',
            'reservation_update'           => 'lang:text_reservation_update',
            'internal'                     => 'lang:text_internal',
            'contact'                      => 'lang:text_contact',
        ];

        $query = $this->db->get('mail_templates_data');
        foreach ($query->result() as $row) {
            if (!isset($labels[$row->code])) continue;

            $this->db->set('label', $labels[$row->code]);
            $this->db->where('template_data_id', $row->template_data_id);
            $this->db->update('mail_templates_data');
        }
    }

    public function down()
    {
        $this->dbforge->drop_column('mail_templates_data', 'label');
    }
}

/* End of file 034_add_column_label_to_mail_templates_data_table.php */
/* Location: ./system/tastyigniter/migrations/034_add_column_label_to_mail_templates_data_table.php */