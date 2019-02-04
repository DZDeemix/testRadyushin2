**Примеры команд для запуска из терминала**

**Получить список авторов по жанру книг, которые они написали.**
*php ./index.php getAutorsByGenre "Роман"*

**Получить список авторов отсортированный по количеству их книг.**
*php ./index.php getAutorsByCountBooks*

**Получить список авторов по жанру книг отсортированных по рейтингу**
**(рейтинг автора = средний рейтинг его книг)**
*php ./index.php getAutorsByGenreSortByRating "Роман"*

**Получить список похожих авторов основываясь на жанрах книг.**
*php ./index.php getSimilarAutor "Александр Дюма"*

*Изначально запрос был таким*
SELECT DISTINCT a.name FROM books INNER JOIN authors a on books.author_id = a.id INNER JOIN genres g on books.genre_id = g.id
    WHERE NOT a.name = "Алесандр Дюма" AND EXISTS (
        SELECT g.name FROM books as b INNER JOIN authors a on b.author_id = a.id INNER JOIN genres g on b.genre_id = g.id
        WHERE a.name = "Алесандр Дюма" AND books.genre_id = b.genre_id
    )
*но потом решил что лучше двумя запросами сделать*
