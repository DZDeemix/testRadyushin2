<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.02.19
 * Time: 14:50
 */

namespace App\Models;


use App\ConnectionDb;
use PDO;

class LibraryModel
{
    public function __construct()
    {
        $this->_db = (new ConnectionDb())->getConnection();
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
        $query = "SELECT DISTINCT a.name 
            FROM books 
            INNER JOIN authors a on books.author_id = a.id 
            INNER JOIN genres g on books.genre_id = g.id
            WHERE g.name = (:ganre)";

        $stmt = $this->_db->prepare($query);
        return $this->execute($stmt, [':ganre' => $ganre]);
    }

    /**
     * Returns authors sorted by number of books
     *
     * @return array
     */
    public function getAutorsByCountBooks()
    {
        $query = "SELECT distinct (a.name), count(a.name) as count 
            FROM books b 
            INNER JOIN authors a on b.author_id = a.id
            GROUP BY a.name
            ORDER BY count DESC";

        $stmt = $this->_db->prepare($query);
        return $this->execute($stmt);
    }

    /**
     * Returns authors by ganre sorted by rating
     *
     * @param string $autor - autor
     *
     * @return array
     */
    public function getAutorsByGenreSortByRating($autor)
    {
        $query = "SELECT DISTINCT a.name, AVG(books.rating) as rating 
            FROM books 
            INNER JOIN authors a on books.author_id = a.id 
            INNER JOIN genres g on books.genre_id = g.id
            WHERE g.name = (:autor)
            GROUP BY a.name
            ORDER BY rating DESC";

        $stmt = $this->_db->prepare($query);
        return $this->execute($stmt, [':autor' => $autor]);
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
        $query = "SELECT DISTINCT a.name FROM books 
            INNER JOIN authors a on books.author_id = a.id 
            INNER JOIN genres g on books.genre_id = g.id
            WHERE NOT a.name = (:autor) AND 
            EXISTS (
                SELECT g.name FROM books as b 
                INNER JOIN authors a on b.author_id = a.id 
                INNER JOIN genres g on b.genre_id = g.id
                WHERE a.name = (:autor) AND books.genre_id = b.genre_id
            )";
        $stmt = $this->_db->prepare($query);
        return $this->execute($stmt, [':autor' => $autor]);
    }

    /**
     * Execute from database
     *
     * @param object $stmt - sort data from db
     *
     * @return array
     */
    public function execute($stmt, $bindParam)
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