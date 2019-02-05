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
 */

namespace App\Controllers;

use App\Models\LibraryModel;

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
    private $model;

    /**
     * Library constructor.
     */
    public function __construct()
    {
        $this->model = new LibraryModel();
    }

    /**
     * Returns authors by genre
     *
     * @param string $ganre - ganre
     *
     * @return void
     */
    public function getAutorsByGenre($ganre) :void
    {
        if (empty($ganre)) {
            echo "Введите название жанра";
            exit;
        }
        $result = $this->model->getAutorsByGenre($ganre);

        //вывод в консоль
        echo "Autor"  . "\n";
        $this->printArray($result);
    }

    /**
     * Returns authors sorted by number of books
     *
     * @return void
     */
    public function getAutorsByCountBooks() :void
    {
        $result = $this->model->getAutorsByCountBooks();

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
    public function getAutorsByGenreSortByRating($ganre) :void
    {
        if (empty($ganre)) {
            echo "Введите имя автора";
            exit;
        }
        $result = $this->model->getAutorsByGenreSortByRating($ganre);

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
    public function getSimilarAutor($autor) :void
    {
        if (empty($autor)) {
            echo "Введите имя автора \n";
            exit;
        }

        $result = $this->model->getSimilarAutor($autor);
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
    public function printArray($arr) :void
    {
        foreach ($arr as $item) {
            foreach ($item as $k => $v) {
                echo $v . "\t";
            }
            echo "\n";
        }
    }
}
