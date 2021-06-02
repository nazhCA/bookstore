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
    private string $select_all_categories = "SELECT * FROM categories";
    private string $select_all_book_categ = 'SELECT * FROM bookstore.books WHERE books.id in (SELECT book_categories.book_id FROM bookstore.book_categories WHERE book_categories.categ_name=?)';
    private string $select_books_via_search = 'SELECT * FROM books WHERE name LIKE ?';
    private string $select_book_via_id = 'SELECT * FROM books WHERE id = ?';
    private string $add_to_cart = 'INSERT INTO carts(session_id, book_id, active) VALUES (?, ?, ?)';
    private string $insert_book = 'INSERT INTO books(name, author,price, quantity, image) VALUES (?, ?, ?, ?, ?)';
    private string $get_number_of_available_books = "SELECT quantity FROM books WHERE id = ?";
    private string $get_books_via_sessionid = "SELECT * FROM books WHERE id IN (SELECT book_id FROM carts WHERE session_id = ? AND active = 1)";
    private string $insert_order = "INSERT INTO orders (session_id, user_name, user_phone,book_id) VALUES (?,?,?,?)";
    private string $insert_category = "INSERT INTO categories (name) VALUES (?)";
    private string $give_category_to_book = "INSERT INTO book_categories(book_id, categ_name) VALUES (?, ?)";
    private string $set_to_not_active = "UPDATE `carts` SET `active` = '0' WHERE `carts`.`session_id` = ?;";
    private string $delete_category = "DELETE FROM categories WHERE name = ?";
    private string $delete_cart_item = "DELETE FROM carts WHERE book_id = ? and session_id = ?";
    private string $update_with_image = "UPDATE books SET image= ? WHERE id = ?";
    private string $select_active_carts = "SELECT * FROM carts WHERE active = 1";
    private string $select_orders = "SELECT * FROM orders";
    private string $get_available_categories_for_book = "SELECT name FROM categories WHERE name NOT IN (SELECT categ_name FROM book_categories WHERE book_id = ?)";
    private string $get_book_categories = "SELECT categ_name FROM book_categories WHERE book_id = ?";
    private string $delete_category_from_book = "DELETE FROM book_categories WHERE book_id = ? AND categ_name = ?";
    private string $delete_book = "DELETE FROM books WHERE id = ?";

    public function connect() {    // metódus a kapcsolódásra az adatbázishoz

        return new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function getAllQuery($selector) {
        $result = null;
        switch ($selector) {
            case "books":
                $result = $this->connect()->query($this->select_all_book);
                break;
            case "categories":
                $result = $this->connect()->query($this->select_all_categories);
                break;
            case "carts":
                $result = $this->connect()->query($this->select_active_carts);
                break;
            case "orders":
                $result = $this->connect()->query($this->select_orders);
                break;
        }

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
        $stmt = $db->prepare($this->select_all_book_categ);
        $stmt->bind_param("s", $categ);                 //prepared statement előkészítése
        return $this->searchCoreFunction($stmt);            // core function hívás
    }

    public function getBooksViaSearch($search) {
        $db = $this->connect();
        $stmt = $db->prepare($this->select_books_via_search);
        $stmt->bind_param("s", $search);
        return $this->searchCoreFunction($stmt);
    }

    public function searchCoreFunction($stmt){                                                                    // paraméter hozzácsatolása a queryhez
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
        $stmt->bind_param("s", $sessionid);
        return $this->searchCoreFunction($stmt);
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

    public function insertNewCategory($new_category){
        $db = $this->connect();
        $stmt = $db->prepare($this->insert_category);
        $stmt->bind_param("s", $new_category);
        $result = $stmt->execute();
        $this->connect()->close();
        return $result;
    }

    public function deleteCategory($category) {
        $db = $this->connect();
        $stmt = $db->prepare($this->delete_category);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $this->connect()->close();
    }


    public function addBook($name, $author, $price, $quantity, $image) {
        $db = $this->connect();
        $stmt = $db->prepare($this->insert_book);
        $stmt->bind_param("ssiis", $name, $author, $price, $quantity, $image);
        return $stmt->execute();
    }

    public function selectBookViaId($id) {
        $db = $this->connect();
        $stmt = $db->prepare($this->select_book_via_id);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($result = $stmt->get_result()){
           $data = $result->fetch_assoc();
            $this->connect()->close();
            return (empty($data)) ?  false :  $data;
        } else {
            $this->connect()->close();
            return false;
        }
    }

    public function deleteBookFromCart($session_id, $book_id){
        $db = $this->connect();
        $stmt = $db->prepare($this->delete_cart_item);
        $stmt->bind_param("is", $book_id, $session_id);
        $stmt->execute();
        $this->connect()->close();
    }

    public function uploadImage($book_id, $image){
        $db = $this->connect();
        $stmt = $db->prepare($this->update_with_image);
        $stmt->bind_param("si",  $image,$book_id);
        $stmt->execute();
        $this->connect()->close();
    }
    public function updateBookWithCateg($book_id, $category){
        $db = $this->connect();
        $stmt = $db->prepare($this->give_category_to_book);
        $stmt->bind_param("is",  $book_id,$category);
        $stmt->execute();
        $this->connect()->close();
    }

    public function getAvailableCategoriesForBook($book_id){
        $db = $this->connect();
        $stmt = $db->prepare($this->get_available_categories_for_book);
        $stmt->bind_param("i",  $book_id);
        return $this->searchCoreFunction($stmt);
    }
    public function getBookCategories($book_id){
        $db = $this->connect();
        $stmt = $db->prepare($this->get_book_categories);
        $stmt->bind_param("i",  $book_id);
        return $this->searchCoreFunction($stmt);
    }

    public function deleteCategoryFromBook($book_id, $category){
        $db = $this->connect();
        $stmt = $db->prepare($this->delete_category_from_book);
        $stmt->bind_param("is",  $book_id,$category);
        $stmt->execute();
        $this->connect()->close();
    }

    public function deleteBook($book_id){
        $db = $this->connect();
        $stmt = $db->prepare($this->delete_book);
        $stmt->bind_param("i",  $book_id);
        $result = $stmt->execute();
        $this->connect()->close();
        return $result;
    }
}

