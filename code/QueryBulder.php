<?php
/**
 * QueryBulder Doc Comment
 *
 * LibraryModel creates a query string
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */


namespace App;

/**
 * Class QueryBulder
 *
 * LibraryModel creates a query string
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */

class QueryBulder
{

    public $query = "";
    public $mainTable;
    public $joinTable;
    public $joinTable2;

    /**
     * QueryBulder constructor.
     * @param string $mainTable - mainTable
     * @param string $joinTable - joinTable
     * @param string $joinTable2 - joinTable2
     */
    public function __construct($mainTable = "", $joinTable = "", $joinTable2 = "")
    {
        $this->mainTable = $mainTable;
        $this->joinTable = $joinTable;
        $this->joinTable2 = $joinTable2;
    }

    /**
     * Add string to $this->>query
     * @param string $param - add to query
     * @return $this
     */
    public function select(string $param) :self
    {
        $this->query = $this->query . "SELECT" . $this->addSpaces($param);
        return $this;
    }

    /**
     * Add string to $this->>query
     * @param string $param - add to query
     * @return $this
     */

    public function innerJoin(string $param = "") :self
    {
        if (!empty($param)) {
            $this->query = $this->query . "INNER JOIN" . $this->addSpaces($param);
            return $this;
        }

        if (!empty($this->joinTable)) {
            $this->query = $this->query . "INNER JOIN" . $this->addSpaces($this->joinTable);

            if (!empty($this->joinTable2)) {
                $this->query = $this->query . "INNER JOIN" . $this->addSpaces($this->joinTable2);
            }
        }
        return $this;
    }

    /**
     * Add string to $this->>query
     * @param string $param - add to query
     * @return $this
     */
    public function where(string $param) :self
    {
        $this->query = $this->query . "WHERE" . $this->addSpaces($param);
        return $this;
    }

    /**
     * Add string to $this->>query
     * @param string $param - add to query
     * @return $this
     */
    public function groupBy(string $param) :self
    {
        $this->query = $this->query . "GROUP BY" . $this->addSpaces($param);
        return $this;
    }

    /**
     * Add string to $this->>query
     * @param string $param - add to query
     * @return $this
     */
    public function orderBy(string $param) :self
    {
        $this->query = $this->query . "ORDER BY" . $this->addSpaces($param);
        return $this;
    }

    /**
     * Add string to $this->>query
     * @param string $param - add to query
     * @return $this
     */
    public function from(string $param = "") :self
    {
        if (!empty($this->mainTable)) {
            $this->query = $this->query . "FROM" . $this->addSpaces($this->mainTable);
        } else {
            $this->query = $this->query . "FROM" . $this->addSpaces($param);
        }
        return $this;
    }

    /**
     * Add subQuery
     * @param QueryBulder $param
     * @return $this
     */
    public function exists(QueryBulder $param) :self
    {
        $this->query = $this->query . "EXISTS (" . $param->query . ")";
        return $this;
    }

    /**
     * Add spaces to parameter
     * @param string $param - parameter for query
     * @return string
     */
    public function addSpaces(string $param) :string
    {
        return " " . $param . " ";
    }
}
