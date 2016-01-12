<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter User agent Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_User_agent.php
 * @link           http://docs.tastyigniter.com
 */
class TI_User_agent extends CI_User_agent {

    /**
     * Compile the User Agent Data
     *
     * @return    bool
     */
    protected function _load_agent_file() {
        if (($found = file_exists(IGNITEPATH . 'config/user_agents.php'))) {
            include(IGNITEPATH . 'config/user_agents.php');
        }

        if (file_exists(IGNITEPATH . 'config/' . ENVIRONMENT . '/user_agents.php')) {
            include(IGNITEPATH . 'config/' . ENVIRONMENT . '/user_agents.php');
            $found = TRUE;
        }

        if ($found !== TRUE) {
            return FALSE;
        }

        $return = FALSE;

        if (isset($platforms)) {
            $this->platforms = $platforms;
            unset($platforms);
            $return = TRUE;
        }

        if (isset($browsers)) {
            $this->browsers = $browsers;
            unset($browsers);
            $return = TRUE;
        }

        if (isset($mobiles)) {
            $this->mobiles = $mobiles;
            unset($mobiles);
            $return = TRUE;
        }

        if (isset($robots)) {
            $this->robots = $robots;
            unset($robots);
            $return = TRUE;
        }

        return $return;
    }

    // --------------------------------------------------------------------
}

/* End of file User_agent.php */
/* Location: ./system/tastyigniter/libraries/User_agent.php */