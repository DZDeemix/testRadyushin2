<?php
/**
 * LibraryModel Doc Comment
 *
 * LibraryModel queries the database
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */

namespace App\Models;


use App\ConnectionDb;
use App\QueryBulder;
use PDO;

/**
 * Class LibraryModel
 *
 * LibraryModel queries the database
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */
class LibraryModel
{
    public $qb;
    public $mainTable = "books";
    public $joinTable1 = "authors a on books.author_id = a.id";
    public $joinTable2 = "genres g on books.genre_id = g.id";

    /**
     * LibraryModel constructor.
     */
    public function __construct()
    {
        $this->_db = (new ConnectionDb())->getConnection();
        $this->qb = new QueryBulder(
            $this->mainTable,
            $this->joinTable1,
            $this->joinTable2);
    }

    /**
     * Returns authors by genre
     *
     * @param string $ganre - ganre
     *
     * @return array
     */
    public function getAutorsByGenre($ganre)
    {
        $this->qb
            ->select("DISTINCT a.name")
            ->from()
            ->innerJoin()
            ->where("g.name = (:ganre)");
        $stmt = $this->_db->prepare($this->qb->query);
        return $this->execute($stmt, [':ganre' => $ganre]);
    }

    /**
     * Returns authors sorted by number of books
     *
     * @return array
     */
    public function getAutorsByCountBooks()
    {
        $this->qb
            ->select("DISTINCT (a.name), count(a.name) as count")
            ->from()
            ->innerJoin($this->joinTable1)
            ->groupBy("a.name")
            ->orderBy("count DESC");

        $stmt = $this->_db->prepare($this->qb->query);
        return $this->execute($stmt);
    }

    /**
     * Returns authors by ganre sorted by rating
     *
     * @param string $autor - autor
     *
     * @return array
     */
    public function getAutorsByGenreSortByRating($ganre)
    {
        $this->qb
            ->select("DISTINCT a.name, AVG(books.rating) as rating")
            ->from()
            ->innerJoin()
            ->where("g.name = (:ganre)")
            ->groupBy("a.name")
            ->orderBy("rating DESC");

        $stmt = $this->_db->prepare($this->qb->query);
        return $this->execute($stmt, [':ganre' => $ganre]);
    }

    /**
     * Return similar Autors
     *
     * @param string $autor - autor
     *
     * @return array
     */
    public function getSimilarAutor($autor)
    {
        $this->qb
            ->select("DISTINCT a.name")
            ->from()
            ->innerJoin()
            ->where("NOT a.name = (:autor) AND")
            ->exists(
                (new QueryBulder(
                    $this->mainTable,
                    $this->joinTable1,
                    $this->joinTable2
                    )
                )
                    ->select("g.name")
                    ->from()
                    ->innerJoin()
                    ->where("a.name = (:autor) AND books.genre_id = books.genre_id")
            );

        //echo $this->qb->query;
        $stmt = $this->_db->prepare($this->qb->query);
        return $this->execute($stmt, [':autor' => $autor]);
    }

    /**
     * Queries the database
     *
     * @param object $stmt - sort data from db
     *
     * @return array
     */
    public function execute($stmt, $bindParam = null)
    {
        try {
            $stmt->execute($bindParam);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die;
        }

    }

}