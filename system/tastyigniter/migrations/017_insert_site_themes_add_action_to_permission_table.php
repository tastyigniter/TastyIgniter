<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Update 'Site.Themes' rule to include 'Add' action
 */
class Migration_insert_site_themes_add_action_to_permission_table extends CI_Migration {

	public function up() {
		$this->db->update('permissions', array(
			'action' => serialize(array('access', 'manage', 'add', 'delete')),
		), array('name' => 'Site.Themes'));

		$staff_group = $this->db->get_where('staff_groups', array('staff_group_id' => '11'));
		if ($staff_group->num_rows() > 0) {
			$group_row = $staff_group->row_array();

			$site_themes = $this->db->get_where('permissions', array('name' => 'Site.Themes'));
			if ($site_themes->num_rows() > 0) {
				$permission_row = $site_themes->row_array();

				$group_permissions = ( ! empty($group_row['permissions'])) ? unserialize($group_row['permissions']) : array();

				$group_permissions[$permission_row['permission_id']] = array('access', 'manage', 'add', 'delete');

				$this->db->set('permissions', serialize($group_permissions));
				$this->db->where('staff_group_id', '11');
				$this->db->update('staff_groups');
			}
		}
	}

	public function down() {
		$this->db->update('permissions', array(
			'action' => serialize(array('access', 'manage', 'delete')),
		), array('name' => 'Site.Themes'));

		$staff_group = $this->db->get_where('staff_groups', array('staff_group_id' => '11'));
		if ($staff_group->num_rows() > 0) {
			$group_row = $staff_group->row_array();

			$site_themes = $this->db->get_where('permissions', array('name' => 'Site.Themes'));
			if ($site_themes->num_rows() > 0) {
				$permission_row = $site_themes->row_array();

				$group_permissions = ( ! empty($group_row['permissions'])) ? unserialize($group_row['permissions']) : array();

				$group_permissions[$permission_row['permission_id']] = array('access', 'manage', 'delete');

				$this->db->set('permissions', serialize($group_permissions));
				$this->db->where('staff_group_id', '11');
				$this->db->update('staff_groups');
			}
		}
	}
}

/* End of file 017_insert_site_themes_add_action_to_permission_table.php */
/* Location: ./setup/migrations/017_insert_site_themes_add_action_to_permission_table.php */