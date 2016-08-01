<?php
/**
 * Transfer handler for XOOPS
 *
 * This is intended to handle content intercommunication between modules as well as components
 * There might need to be a more explicit name for the handle since it is always confusing
 *
 * @copyright   XOOPS Project (http://xoops.org)
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since       1.00
 * @package     Frameworks::transfer
 */

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

if (!@include_once XOOPS_ROOT_PATH . '/Frameworks/transfer/transfer.php') {
    return null;
}

// Specify the addons to skip for the module
$GLOBALS['addons_skip_module'] = array('pm', 'email');
// Maximum items to show on page
$GLOBALS['addons_limit_module'] = 5;

/**
 * Class ModuleTransferHandler
 */
class ModuleTransferHandler extends TransferHandler
{
    /**
     * ModuleTransferHandler constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get valid addon list
     *
     * @param array   $skip Addons to skip
     * @param boolean $sort To sort the list upon 'level'
     *                      return  array   $list
     */
    public function &getList($skip = array(), $sort = true) {
        $list = parent::getList($skip, $sort);

        return $list;
    }

    /**
     * If need change config of an item
     * 1 parent::load_item
     * 2 $this->config
     * 3 $this->do_transfer
     * @param $item
     * @param $data
     * @return
     */
    public function do_transfer($item, &$data) {
        $ret = parent::do_transfer($item, $data);

        return $ret;
    }
}
