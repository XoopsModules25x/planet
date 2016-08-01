<?php
//
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoops.org                         //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
include_once dirname(__DIR__) . '/include/vars.php';
mod_loadFunctions('', $GLOBALS['moddirname']);

if (!class_exists('Brate')):
    /**
     * Class Brate
     */
    class Brate extends XoopsObject
    {
        /**
         * Brate constructor.
         * @param null $id
         */
        public function __construct($id = null) {
            //            $this->ArtObject();
            $this->table = planet_DB_prefix('rate');
            $this->initVar('rate_id', XOBJ_DTYPE_INT, null, false);
            $this->initVar('art_id', XOBJ_DTYPE_INT, 0, true);
            $this->initVar('rate_uid', XOBJ_DTYPE_INT, 0);
            $this->initVar('rate_ip', XOBJ_DTYPE_INT, 0);
            $this->initVar('rate_rating', XOBJ_DTYPE_INT, 0, true);
            $this->initVar('rate_time', XOBJ_DTYPE_INT, 0, true);
        }
    }
endif;

planet_parse_class('
class [CLASS_PREFIX]RateHandler extends XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param object $db reference to the {@link XoopsDatabase} object
     **/
    public function __construct(XoopsDatabase $db) {
        parent::__construct($db, planet_DB_prefix("rate", true), "Brate", "rate_id");
    }

    public function &getByArticle($art_id, $criteria = null)
    {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("art_id", (int)($art_id)), "AND");
        } else {
            $criteria = new CriteriaCompo(new Criteria("art_id", (int)($art_id)));
        }
        $ret = $this->getAll($criteria);

        return $ret;
    }

    public function &getRatingByArticle($art_id, $criteria = null)
    {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("art_id", (int)($art_id)), "AND");
        } else {
            $criteria = new CriteriaCompo(new Criteria("art_id", (int)($art_id)));
        }
        $sql = "SELECT COUNT(*) AS rates, SUM(rate_rating) AS rating FROM " . planet_DB_prefix("rate");
        $sql .= " ".$criteria->renderWhere();
        if ($criteria->getSort() != "") {
            $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
        }
        $limit = $criteria->getLimit();
        $start = $criteria->getStart();
        $result = $this->db->query($sql, $limit, $start);
        $myrow = $this->db->fetchArray($result);
        $ret = array("rates"=>$myrow["rates"], "rating"=>$myrow["rating"]);

        return $ret;
    }
}
');
