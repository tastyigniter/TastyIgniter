<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Update 'Site.Themes' rule to include 'Add' action
 */
class Migration_insert_site_updates_rule_to_permission_table extends CI_Migration {

	public function up() {
		$this->db->insert('permissions', array(
			'name'        => 'Site.Updates',
			'description' => 'Ability to apply updates when a new version of TastyIgniter is available',
			'action'      => serialize(array('add')),
			'status'      => '1',
		));

		$permission_id = $this->db->insert_id();
		$staff_group = $this->db->get_where('staff_groups', array('staff_group_id' => '11'));

		if ($staff_group->num_rows() > 0) {
			$row = $staff_group->row_array();
			$group_permissions = ( ! empty($row['permissions'])) ? unserialize($row['permissions']) : array();

			$group_permissions[$permission_id] = array('add');

			$this->db->set('permissions', serialize($group_permissions));
			$this->db->where('staff_group_id', '11');
			$this->db->update('staff_groups');
		}
	}

	public function down() {
		$this->db->delete('permissions', array('name' => 'Site.Updates'));
	}
}

/* End of file 022_insert_site_updates_rule_to_permission_table.php */
/* Location: ./setup/migrations/022_insert_site_updates_rule_to_permission_table.php */