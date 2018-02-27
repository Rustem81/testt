
<?php
class DB
{
    /*
    public $var = 'значение по умолчанию';
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "config";*/

    // объявление метода
    public function displayVar() {

        echo $this->var;
    }

    public function set($paramName, $paramValue){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "config";


        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Подключение не удалось: " . $conn->connect_error);
        }

        $sql = "INSERT INTO config_t ( paramName, 	paramValue)
          VALUES ($paramName, $paramValue)";

        if ($conn->query($sql) === TRUE) {
            echo "Новая запись";
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    public function get(){ //метод Get возвраащаем все значения paramValue

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "config";

// создаем подключение к БД
        $conn = new mysqli($servername, $username, $password, $dbname);
// проверяем подключение
        if ($conn->connect_error) {
            die("Подключение не удалось: " . $conn->connect_error);
        }

        $sql = "SELECT paramValue FROM config_t";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { // если массив не пуст
            // выводим из массива
            while($row = $result->fetch_assoc()) {
                echo "paramValue: " . $row["paramValue"]. ", ";
            }
        } else { //значений нет
            echo "записи отсутствуют";
        }
        $conn->close(); //закрываем соединение с БД
    }

    public function save(){//в ТЗ отсутствует инфа, что должен делаать этот метод

    }
}

//тесты
$test =new DB();
$test->get();
for ($i = 1; $i <= 10; $i++) {
    //$paramValue=$i;
    $test->set($i,$i+1);





?>