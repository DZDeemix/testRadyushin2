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

use App\models\LibraryModel;

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
    private $_model;

    /**
     * Library constructor.
     */
    public function __construct()
    {
        $this->_model = new LibraryModel();
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
        $result = $this->_model->getAutorsByGenre($ganre);
        $this->printArray($result);
    }

    /**
     * Returns authors sorted by number of books
     *
     * @return void
     */
    public function getAutorsByCountBooks()
    {
        $result = $this->_model->getAutorsByCountBooks();

        //вывод в консоль
        echo "Autor" . "\t" . "\t" . "Count" . "\n";
        $this->printArray($result);
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
        $result = $this->_model->getAutorsByGenreSortByRating($autor);

        //вывод в консоль
        echo "Autor" . "\t" . "\t" . "Rating" . "\n";
        $this->printArray($result);
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

        $result = $this->_model->getSimilarAutor($autor);
        //вывод в консоль
        echo "Autor" . "\t\t" . "Similar" . "\n";
        $this->printArray($result);
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
