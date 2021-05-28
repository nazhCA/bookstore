<?php


class DbCon
{
//    kapcsolódáshoz szükséges információk
    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $dbname = "bookstore";
//    lekérdezések
    private string $select_all_book = "SELECT * FROM books";
    private string $select_all_book_categ = 'SELECT * FROM bookstore.books WHERE books.id in (SELECT book_categories.book_id FROM bookstore.book_categories WHERE book_categories.categ_name=?)';
    private string $select_books_via_search = 'SELECT * FROM books WHERE name LIKE ?';
    private string $add_to_cart = 'INSERT INTO carts(session_id, book_id, active) VALUES (?, ?, ?)';
    private string $get_number_of_available_books = "SELECT quantity FROM books WHERE id = ?";
    private string $get_books_via_sessionid = "SELECT * FROM books WHERE id IN (SELECT book_id FROM carts WHERE session_id = ? AND active = 1)";
    private string $insert_order = "INSERT INTO orders (session_id, user_name, user_phone,book_id) VALUES (?,?,?,?)";
    private string $set_to_not_active = "UPDATE `carts` SET `active` = '0' WHERE `carts`.`session_id` = ?;";

    public function connect() {    // metódus a kapcsolódásra az adatbázishoz
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        return new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function getAllBooks() {
        $result = $this->connect()->query($this->select_all_book);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }

    public function getAllBooksViaCategory($categ) {
        $db = $this->connect();                                     // kapcsolódás
        $stmt = $db->prepare($this->select_all_book_categ);         //prepared statement előkészítése
        return $this->searchCoreFunction($stmt, $categ);            // core function hívás
    }

    public function getBooksViaSearch($search) {
        $db = $this->connect();
        $stmt = $db->prepare($this->select_books_via_search);
        return $this->searchCoreFunction($stmt, $search);
    }

    public function searchCoreFunction($stmt, $param){
        $stmt->bind_param("s", $param);                             // paraméter hozzácsatolása a queryhez
        $stmt->execute();                                           // végrehajtás
        if ($result = $stmt->get_result()){                         // ha van eredmény, belépés az ifbe
            while ($row = $result->fetch_assoc()) {                 // asszociatív tömbben lekérésre kerül az eredmény soronként
                $data[] =  $row;                                    // hozzáadás a tömbhöz
            }
            $this->connect()->close();                              //kapcsolat lezárása
            return (empty($data)) ?  false :  $data;
        } else {
            $this->connect()->close();
            return false;
        }
    }

    public function addToCart($session_id, $book_id) {
        $active = 1;
        $db = $this->connect();
        $stmt = $db->prepare($this->add_to_cart);
        $stmt->bind_param("sii", $session_id, $book_id, $active);
        if ($this->getNumberOfAvailableBooks($book_id) > 0) {
            return $stmt->execute();
        }else {
            $this->connect()->close();
            return -1;
        }
    }

    private function getNumberOfAvailableBooks($book_id){
        $db = $this->connect();
        $stmt = $db->prepare($this->get_number_of_available_books);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        if ($result = $stmt->get_result()) {
            $data = $result->fetch_assoc();
            $this->connect()->close();
            return $data['quantity'];
        }
        $this->connect()->close();
        return false;
    }

    public function getBooksBySessionId($sessionid) {
        $db = $this->connect();
        $stmt = $db->prepare($this->get_books_via_sessionid);
        return $this->searchCoreFunction($stmt, $sessionid);
    }

    public function orderBooks($sessionid, $user_name, $phone) {
        $data = $this->getBooksBySessionId($sessionid);
        if (!empty($data)){
            $db = $this->connect();
            $stmt = $db->prepare($this->insert_order);
            foreach ($data as $item){
                $stmt->bind_param("sssi", $sessionid,$user_name,$phone,$item['id']);
                $stmt->execute();
            }
            $this->setCartItemNotActive($sessionid);
        }

    }

    public function setCartItemNotActive($sessionid){
        $db = $this->connect();
        $stmt = $db->prepare($this->set_to_not_active);
        $stmt->bind_param("s", $sessionid);
        $stmt->execute();
        $this->connect()->close();
    }

}

