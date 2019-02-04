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
     * @return \mysqli
     */
    public function getConnection()
    {
        $config = $this->_config->getConfig();

        $this->_db = @mysqli_connect(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['db']
        ) or die('Ошибка соединения с БД');
        if (!$this->_db) {
            die(mysqli_connect_error());
        }
        mysqli_set_charset($this->_db, "utf8") or die('Не установлена кодировка');
        return $this->_db;
    }
}
