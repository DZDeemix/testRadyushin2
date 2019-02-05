<?php
/**
 * Config Doc Comment
 *
 * Cofig data for connect to DB
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */

namespace App;
/**
 * Class Config
 *
 * Cofig data for connect to DB
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */
class Config
{
    /**
     * Return config array
     *
     * @return array
     */
    public function getConfig()
    {
        return $config = [
            'host' => 'mysql',
            'user' => 'root',
            'password' => 'secret',
            'db' => 'testRadyushin',
            'charset' => 'utf8'
        ];
    }
}
