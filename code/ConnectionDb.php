<?php
/**
 * ConnectionDb Doc Comment
 *
 * Connect to DB
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */

namespace App;

use App\Config;


/**
 * Class ConnectionDb
 *
 * Connect to DB
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */
class ConnectionDb
{
    private $_config;
    private $_db;

    /**
     * ConnectionDb constructor.
     */
    public function __construct()
    {
        $this->_config = new Config();
    }

    /**
     * Return connection object
     *
     * @return \PDO
     */
    public function getConnection()
    {
        $config = $this->_config->getConfig();

        $dsn = 'myssql:host=' . $config['host'] . ';dbname=' . $config['db'] . ';charset=' . $config['charset'];
        $this->_db = new PDO (
            $dsn,
            $config['user'],
            $config['password']
        ) or die('Ошибка соединения с БД');

        return $this->_db;
    }
}