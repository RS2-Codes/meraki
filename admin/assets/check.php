<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) && !isset($_SERVER['HTTP_REFERER'])) {
    /*
    Up to you which header to send, some prefer 404 even if
    the files does exist for security
    */
    header('HTTP/1.0 403 Forbidden', TRUE, 403);

    /* choose the appropriate page to redirect users */
    die(header('location: /new_blog/error403.php'));
}

class dbConnect
{
    private $host = 'localhost';
    private $user = 'root';
    private $dbname = 'meraki';
    private $password = '';

    function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbname . ';', $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    }
}

class menuData
{
    private $main_course_id;
    private $main_menu_name;

    private $menu_id;
    private $menu_name;

    private $submenu_id;
    private $submenu_name;
    private $submenu_price;


    private $dbconn;

    function getMain_course_id()
    {
        return $this->main_course_id;
    }

    function setMain_course_id($main_course_id)
    {
        $this->main_course_id = $main_course_id;
    }

    function getMain_menu_name()
    {
        return $this->main_menu_name;
    }

    function setMain_menu_name($main_menu_name)
    {
        $this->main_menu_name = $main_menu_name;
    }

    function getMenu_id()
    {
        return $this->menu_id;
    }

    function setMenu_id($menu_id)
    {
        $this->menu_id = $menu_id;
    }

    function getMenu_name()
    {
        return $this->menu_name;
    }

    function setMenu_name($menu_name)
    {
        $this->menu_name = $menu_name;
    }

    function getSubmenu_id()
    {
        return $this->submenu_id;
    }

    function setSubmenu_id($submenu_id)
    {
        $this->submenu_id = $submenu_id;
    }

    function getSubmenu_name()
    {
        return $this->submenu_name;
    }

    function setSubmenu_name($submenu_name)
    {
        $this->submenu_name = $submenu_name;
    }

    function getSubmenu_price()
    {
        return $this->submenu_price;
    }

    function setSubmenu_price($submenu_price)
    {
        $this->submenu_price = $submenu_price;
    }


    function __construct()
    {
        $db = new dbConnect;
        $this->dbconn = $db->connect();
    }

    function mainCourseInsert()
    {

        $query_check = "SELECT * FROM main_course WHERE main_menu_name LIKE ?";
        $stmt_check = $this->dbconn->prepare($query_check);
        $params = array("%$this->main_menu_name%");
        //$stmt_check->bindParam(':main_menu_name', $this->main_menu_name);
        $stmt_check->execute($params);

        if ($stmt_check->errorCode()) {
            $stmt_check_count = $stmt_check->rowCount();
        } else {
            die();
        }

        if ($stmt_check_count > 0) {
            return 2;
        } else {
            $query = "INSERT INTO main_course (main_menu_name) ";
            $query .= "VALUES(:main_menu_name)";

            $stmt = $this->dbconn->prepare($query);
            $stmt->bindParam(':main_menu_name', $this->main_menu_name);
            $stmt->execute();
            if ($stmt->errorCode()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function mainCourseFetch()
    {
        $query = "SELECT * FROM main_course";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function mainMenuInsert()
    {

        $query_check = "SELECT * FROM menu WHERE main_course_id = ? AND menu_name LIKE ?";
        $stmt_check = $this->dbconn->prepare($query_check);
        $params = array($this->main_course_id, "%$this->menu_name%");
        $stmt_check->execute($params);

        if ($stmt_check->errorCode()) {
            $stmt_check_count = $stmt_check->rowCount();
        } else {
            die();
        }

        if ($stmt_check_count > 0) {
            return 2;
        } else {
            $query = "INSERT INTO menu (main_course_id,menu_name) ";
            $query .= "VALUES(:main_course_id,:menu_name)";

            $stmt = $this->dbconn->prepare($query);
            $stmt->bindParam(':main_course_id', $this->main_course_id);
            $stmt->bindParam(':menu_name', $this->menu_name);
            $stmt->execute();
            if ($stmt->errorCode()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function mainMenuFetch()
    {
        $query = "SELECT * FROM menu";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function subMenuInsert()
    {

        $query_check = "SELECT * FROM submenu WHERE menu_id = ? AND submenu_name LIKE ?";
        $stmt_check = $this->dbconn->prepare($query_check);
        $params = array($this->menu_id, "%$this->submenu_name%");
        $stmt_check->execute($params);

        if ($stmt_check->errorCode()) {
            $stmt_check_count = $stmt_check->rowCount();
        } else {
            die();
        }

        if ($stmt_check_count > 0) {
            return 2;
        } else {
            $query = "INSERT INTO submenu (menu_id,submenu_name,submenu_price) ";
            $query .= "VALUES(:menu_id,:submenu_name,:submenu_price)";

            $stmt = $this->dbconn->prepare($query);
            $stmt->bindParam(':menu_id', $this->menu_id);
            $stmt->bindParam(':submenu_name', $this->submenu_name);
            $stmt->bindParam(':submenu_price', $this->submenu_price);
            $stmt->execute();
            if ($stmt->errorCode()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function subMenuFetch()
    {
        $query = "SELECT * FROM submenu";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function productDataFetch()
    {
        $query = "SELECT * FROM product INNER JOIN category ON product.product_category_id = category.category_id WHERE product.product_id = :product_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->execute();
        if ($stmt->errorCode()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function productView()
    {
        $query = "SELECT * FROM product INNER JOIN category ON product.product_category_id = category.category_id ORDER BY 1 DESC";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        if ($stmt->errorCode()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function productUpdate()
    {
        $query = "UPDATE product SET product_category_id = :product_category_id,product_name=:product_name,product_desc=:product_desc,product_image_alt=:product_image_alt WHERE product_id = :product_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':product_category_id', $this->product_category_id);
        $stmt->bindParam(':product_name', $this->product_name);
        $stmt->bindParam(':product_desc', $this->product_desc);
        $stmt->bindParam(':product_image_alt', $this->product_image_alt);
        $stmt->execute();
        if ($stmt->errorCode()) {
            return 1;
        } else {
            return 0;
        }
    }
}

if (isset($_POST['main_course_insert'])) {
    $main_menu_name = $_POST['main_course'];

    $main_course_data = new menuData;
    $main_course_data->setMain_menu_name($main_menu_name);
    $return_value = $main_course_data->mainCourseInsert();
    if ($return_value == 1) {
        echo "Main Course inserted successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "Main Course not inserted successfully.";
    }
}

if (isset($_POST['main_insert'])) {
    $main_course_category = $_POST['main_course_category'];
    $main_course = $_POST['main_course'];

    $main_course_data = new menuData;
    $main_course_data->setMain_course_id($main_course_category);
    $main_course_data->setMenu_name($main_course);
    $return_value = $main_course_data->mainMenuInsert();
    if ($return_value == 1) {
        echo "Main Menu inserted successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "Main Menu not inserted successfully.";
    }
}

if (isset($_POST['sub_menu_insert'])) {
    $menu_id = $_POST['menu_category'];
    $sub_menu_name = $_POST['sub_menu_name'];
    $sub_menu_price = $_POST['sub_menu_price'];

    $menu_data = new menuData;
    $menu_data->setMenu_id($menu_id);
    $menu_data->setSubmenu_name($sub_menu_name);
    $menu_data->setSubmenu_price($sub_menu_price);
    $return_value = $menu_data->subMenuInsert();
    if ($return_value == 1) {
        echo "Sub Menu inserted successfully.";
    } else if ($return_value == 2) {
        echo "Sub Menu starting or ending with this name already exits";
    } else {
        echo "Sub Menu not inserted successfully.";
    }
}


/* $insertFile = new productData;
$insertFile->setProductCategoryId(2);
$insertFile->setProductName("123");
$insertFile->setProductDesc('Kuch bhi keh raha');
$insertFile->setProductImage('kuch_bhi.jpg');
$insertFile->setProductImageAlt('Jhooth bolta hai saala, jalta hai maderjaat');

$insertFile->productInsert(); */
