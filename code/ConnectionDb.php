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
use PDO;

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
    private $config;
    private $db;

    /**
     * ConnectionDb constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * Return connection object
     *
     * @return \PDO
     */
    public function getConnection() :object
    {
        $config = $this->config->getConfig();

        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db'] . ';charset=' . $config['charset'];

        try {
            $this->db = new PDO(
                $dsn,
                $config['user'],
                $config['password']
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $this->db;
    }
}
