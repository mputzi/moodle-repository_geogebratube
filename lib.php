<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

global $CFG;
require_once($CFG->dirroot . '/repository/lib.php');

/**
 *
 * @package        repository_geogebratube
 * @author         Christoph Stadlbauer <christoph.stadlbauer@geogebra.org>
 * @copyright  (c) International GeoGebra Institute 2014
 * @license        http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * license of GeoGebra: http://creativecommons.org/licenses/by-nc-nd/3.0/
 * For commercial use please see: http://www.geogebra.org/license
 */
class repository_geogebratube extends repository {

    /**
     * GeoGebratube plugin doesn't support global search<br>
     *
     * @see repository::global_search()
     */
    public function global_search() {
        return false;
    }

    /**
     * To check whether the user is logged in.
     *
     * @return bool true because we don't want to show a moodleform for login
     */
    public function check_login() {
        return true;
    }

    /**
     * Use an external file chooser.
     *
     * See details on {@link http://docs.moodle.org/dev/Repository_plugins} and
     * {@link https://docs.moodle.org/dev/Repository_plugins_embedding_external_file_chooser}
     *
     * @see \repository::get_listing
     *
     * @param string $path this parameter can a folder name, or a identification of folder
     * @param string $page the page number of file list
     * @return array the list of files, including meta information, containing the following keys
     *                     help, nologin, nosearch, norefresh, object
     */
    public function get_listing($path = '', $page = '') {
        $callbackurl = new moodle_url('/repository/geogebratube/callback.php');

        $url = 'https://www.geogebratube.org/widgetprovider/index/widgettype/moodle'
                . '?url=' . urlencode($callbackurl);

        $list = array(
                'help'      => 'http://wiki.geogebra.org/',
                'nologin'   => true,
                'nosearch'  => true,
                'norefresh' => false,
                'object'    => array(
                        'type' => ( string )'text/html',
                        'src'  => ( string )$url
                )
        );

        return $list;
    }

    /**
     * file types supported by GeoGebraTube plugin
     * .html is somewhat true since it's a link to a page
     *
     * @return array
     */
    public function supported_filetypes() {
        return array('.html');
    }

    /**
     * GeoGebraTube always returns FILE_EXTERNAL
     *
     * @return int
     */
    public function supported_returntypes() {
        return FILE_EXTERNAL;
    }

    /**
     * Is this repository accessing private data?
     * FEATURE: check if data chosen is really private
     *
     * @return bool
     */
    public function contains_private_data() {
        return true;
    }
}