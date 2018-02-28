<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'config');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');

class DB
{
    protected static $instance = null;

    public function __construct() {}
    public function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
            $opt  = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => TRUE,
            );
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = [])
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
$id  = 1;
$row = DB::run("SELECT * FROM pdowrapper WHERE id=?", [$id])->fetch();
var_export($row);

class helperDB extends DB {

    public static function get(){
        $id  = 7;
        $row = DB::run("SELECT * FROM config_t WHERE id=?", [$id])->fetch();
        var_export($row);


    }

}


//var_export($test);

/*
# Получение всех строк в массив
$all = DB::run("SELECT 	paramName, id FROM config_t")->fetchAll(PDO::FETCH_KEY_PAIR);
var_export($all);


# Создаем таблицу
//DB::query("CREATE  TABLE pdowrapper (id int auto_increment primary key, name varchar(255))");

# множественное исполнение подготовленных выражений
$stmt = DB::prepare("INSERT INTO pdowrapper VALUES (NULL, ?)");
foreach (['Sam','Bob','Joe'] as $name)
{
    $stmt->execute([$name]);
}
var_dump(DB::lastInsertId());
//string(1) "3"

# Получение строк в цикле
$stmt = DB::run("SELECT * FROM pdowrapper");
while ($row = $stmt->fetch(PDO::FETCH_LAZY))
{
    echo $row['name'],",";
    echo $row->name,",";
    echo $row[1], PHP_EOL;
}
/*
Sam,Sam,Sam
Bob,Bob,Bob
Joe,Joe,Joe
*/
/*
# Получение одной строки
$id  = 1;
$row = DB::run("SELECT * FROM pdowrapper WHERE id=?", [$id])->fetch();
var_export($row);
/*
array (
  'id' => '1',
  'name' => 'Sam',
)
*/
/*
# Получение одного поля
$name = DB::run("SELECT name FROM pdowrapper WHERE id=?", [$id])->fetchColumn();
var_dump($name);
//string(3) "Sam"

# Получение всех строк в массив
$all = DB::run("SELECT name, id FROM pdowrapper")->fetchAll(PDO::FETCH_KEY_PAIR);
var_export($all);
/*
array (
  'Sam' => '1',
  'Bob' => '2',
  'Joe' => '3',
)
*/
/*
# Обновление таблицы
$new = 'Sue';
$stmt = DB::run("UPDATE pdowrapper SET name=? WHERE id=?", [$new, $id]);
var_dump($stmt->rowCount());
//int(1)

