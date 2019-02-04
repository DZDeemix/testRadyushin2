<?php
/**
 * Library Doc Comment
 *
 * Library managment
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 * PHP version 5
 */

namespace App;

use App\ConnectionDb;

/**
 * Class Library
 *
 * Library managment
 *
 * @category ConsoleUtils
 * @package  TestTask
 * @author   Zyablikov Dmitry <zyablikovdmitry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/DZDeemix/testRadyushin2
 */
class Library
{
    private $_db;

    /**
     * Library constructor.
     */
    public function __construct()
    {
        $this->_db = new ConnectionDb();
    }

    /**
     * Returns authors by genre
     *
     * @param string $ganre - ganre
     *
     * @return void
     */
    public function getAutorsByGenre($ganre)
    {
        if (empty($ganre)) {
            echo "Введите название жанра";
            exit;
        }

        $db = $this->_db->getConnection();

        try {
            //выбираем жанры автора
            $autors = mysqli_query(
                $db,
                "SELECT DISTINCT a.name 
            FROM books 
            INNER JOIN authors a on books.author_id = a.id 
            INNER JOIN genres g on books.genre_id = g.id
            WHERE g.name = '${ganre}'"
            );

            $autors = mysqli_fetch_all($autors, MYSQLI_ASSOC);

            //вывод в консоль
            echo "Autor" . "\n";
            $this->printArray($autors);
        } catch (Exception $e) {
            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * Returns authors sorted by number of books
     *
     * @return void
     */
    public function getAutorsByCountBooks()
    {
        $db = $this->_db->getConnection();

        try {
            //выбираем жанры автора
            $autors = mysqli_query(
                $db,
                "SELECT distinct (a.name), count(a.name) as count 
            FROM books b 
            INNER JOIN authors a on b.author_id = a.id
            GROUP BY a.name
            ORDER BY count DESC"
            );
            $autors = mysqli_fetch_all($autors, MYSQLI_ASSOC);

            //вывод в консоль
            echo "Autor" . "\t" . "\t" . "Count" . "\n";
            $this->printArray($autors);
        } catch (Exception $e) {
            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * Returns authors by ganre sorted by rating
     *
     * @param string $autor - autor
     *
     * @return void
     */
    public function getAutorsByGenreSortByRating($autor)
    {
        if (empty($autor)) {
            echo "Введите имя автора";
            exit;
        }

        $db = $this->_db->getConnection();

        try {
            //выбираем жанры автора
            $autors = mysqli_query(
                $db,
                "SELECT DISTINCT a.name, AVG(books.rating) as rating 
            FROM books 
            INNER JOIN authors a on books.author_id = a.id 
            INNER JOIN genres g on books.genre_id = g.id
            WHERE g.name = '${autor}'
            GROUP BY a.name
            ORDER BY rating DESC"
            );
            //вывод в консоль
            echo "Autor" . "\t" . "\t" . "Rating" . "\n";
            $this->printArray($autors);
        } catch (Exception $e) {
            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * Return similar Autors
     *
     * @param string $autor - autor
     *
     * @return void
     */
    public function getSimilarAutor($autor)
    {
        if (empty($autor)) {
            echo "Введите имя автора \n";
            exit;
        }

        $db = $this->_db->getConnection();

        try {
            //выбираем жанры автора
            $genres = mysqli_query(
                $db,
                "SELECT DISTINCT (g.id) 
            FROM books b 
            INNER JOIN authors a on b.author_id = a.id 
            INNER JOIN genres g on b.genre_id = g.id
            WHERE a.name = '${autor}'"
            );
            $genres = mysqli_fetch_all($genres, MYSQLI_ASSOC);

            if (!empty($genres)) {
                $where = "";
                foreach ($genres as $genre) {
                    $where = $where . " b.genre_id = " . $genre["id"] . " OR";
                }
                $where = substr($where, 0, -2);

                /*выбираем похожих авторов по жанрам
                (если совпадающих жанров больше значит
                автор больше похож на заданного автора)*/
                $autors = mysqli_query(
                    $db,
                    "SELECT DISTINCT (a.name), COUNT(a.name) AS similar 
                FROM books b 
                INNER JOIN authors a on b.author_id = a.id
                WHERE (${where}) AND NOT a.name = '${autor}'
                GROUP BY a.name
                ORDER BY similar DESC"
                );
                $autors = mysqli_fetch_all($autors, MYSQLI_ASSOC);

                //вывод в консоль
                echo "Autor" . "\t\t" . "Similar" . "\n";
                $this->printArray($autors);
                die;
            }

            return ['errorMessage' => "Нет заданного автора в базе"];
        } catch (Exception $e) {
            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * Print result in console
     *
     * @param array $arr - sort data from db
     *
     * @return void
     */
    public function printArray($arr)
    {
        foreach ($arr as $item) {
            foreach ($item as $k => $v) {
                echo $v . "\t";
            }
            echo "\n";
        }
    }
}
