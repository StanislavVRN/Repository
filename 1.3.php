<?php
/*Реализовать функцию findSimple ($a, $b). $a и $b – целые положительные числа. 
Результат ее выполнения: массив простых чисел от $a до $b.*/

function findSimple(int $a, int $b)
{
    if ($a > 0 and $b > 0) {
        
        $arr = range($a, $b);
        sort($arr);

        foreach ($arr as $items) {
            for ($i = 2; $i <= floor($items / 2); $i++) {
                if ($items % $i == 0)
                    break;
            }
            if ($items > 1 and $i > floor($items / 2)) {
                $arr2[] = $items;
            }
        }
    } else {
        throw new InvalidArgumentException('На входе ожидалось положительное число!');
    }

    return $arr2;
}

echo '<pre> Задание №1 <br>';
print_r(findSimple(30, 1));
echo '</pre>';

/*Реализовать функцию createTrapeze($a). $a – массив положительных чисел, количество 
элементов кратно 3. Результат ее выполнения: двумерный массив (массив состоящий из 
ассоциативных массивов с ключами a, b, c). Пример для входных массива 
[1, 2, 3, 4, 5, 6] результат [[‘a’=>1,’b’=>2,’с’=>3],[‘a’=>4,’b’=>5 ,’c’=>6]].*/

$inArr = findSimple(1, 13);

function createTrapeze($a)
{
    if (count($a) % 3 == 0) {
        $keys = ['a', 'b', 'c'];
        $arr = array_chunk($a, 3);

        foreach ($arr as $items) {
                $result[] = array_combine($keys, $items);
        } 
    } else {
        throw new Exception('Элементов в массиве не достаточно!',);
    }
    return $result;
}

echo "<pre> Задание №2 <br>";
print_r(createTrapeze($inArr));
echo "</pre>";


/* Реализовать функцию squareTrapeze($a). $a – массив результата выполнения функции 
createTrapeze(). Результат ее выполнения: в исходный массив для каждой тройки чисел 
добавляется дополнительный ключ s, содержащий результат расчета площади трапеции со 
сторонами a и b, и высотой c. */

$squTr = createTrapeze($inArr);

function squareTrapeze(&$a)
{
    //$arr[] = &$a;
    foreach ($a as &$item) {
        //print_r($item);
        $item['s'] = ($item['a'] + $item['b']) * $item['c'] / 2;
    }
    return $a;
}

echo "<pre> Задание №3 <br>";
print_r(squareTrapeze($squTr));
print_r($squTr);
echo "</pre>";

/* Реализовать функцию getSizeForLimit($a, $b). $a – массив результата выполнения 
функции squareTrapeze(), $b – максимальная площадь. Результат ее выполнения: 
массив размеров трапеции с максимальной площадью, но меньше или равной $b. */

$getSize = squareTrapeze($squTr);
$min = 15;
$max = 100;

function getSizeForLimit($a, $b)
{
    $arr2 = array();
    foreach ($a as $items) {
        $arr = $items;
        if ($arr['s'] <= $b) {
            $arr2 = $arr;
        }
    }
    if (!empty($arr2))
        return $arr2;
}

echo "<pre> Задание №4 <br>";
print_r(getSizeForLimit($getSize, $min));
print_r(getSizeForLimit($getSize, $max));
echo "</pre>";

/* Реализовать функцию getMin($a). $a – массив чисел. 
Результат ее выполнения: минимальное число в массиве 
(не используя функцию min, ключи массива могут быть ассоциативными). */

$aMin = [10, 91, 24, 43, 4, 2, 3, 4, 5, 6, 17];

function getMin($a)
{
    $min = $a[0];
    foreach ($a as $items) {
        if ($min > $items) {
            $min = $items;
        }
    }
    return $min;
}
echo "<pre> Задание №5 <br> Минимальное число в массиве: ";
print_r(getMin($aMin));
echo "</pre>";

/* Реализовать функцию printTrapeze($a). $a – массив результата выполнения функции 
squareTrapeze(). Результат ее выполнения: вывод таблицы с размерами трапеций, 
строки с нечетной площадью трапеции отметить любым способом. */

//$getSize;
function printTrapeze($a)
{
    echo '<table class="table">';
    echo '<tr> <td>Длинa</td> <td>Ширина</td> <td>Высота</td> <td>Площадь</td> </tr>';
    foreach ($a as $key => $items) {
        echo '<tr>';
        foreach ($items as $key => $value)
            if ($value % 2 != 0 && $key == 's') {
                echo "<td class=\"red\"> $value </td>";
            } else {
                echo "<td>" . $value . "</td>";
            }
        echo '</tr>';
    }
    echo '</table>';
}

echo "<pre> Задание №6 <br>";
printTrapeze($getSize);
echo "</pre>";

?>
<style>
    .table {
        width: 50%;
    }

    .table td {
        width: 25%;
        border: 1px solid #ddd;
        padding: 7px 10px;
    }

    .red {
        color: red;
        font-size: x-large;
    }
</style>

<?php

/* Реализовать абстрактный класс BaseMath содержащий 3 метода: exp1($a, $b, $c) 
и exp2($a, $b, $c),getValue(). Метод exp1 реализует расчет по формуле a*(b^c). 
Метод exp2 реализует расчет по формуле (a/b)^c. Метод getValue() возвращает 
результат расчета класса наследника. */

abstract class BaseMath
{
    
    abstract public function getValue();

    public function exp1($a, $b, $c)
    {
        $met1 = $a * ($b ^ $c);
        return $met1;
    }
    public function exp2($a, $b, $c)
    {
        $met2 = ($a / $b) ^ $c;
        return $met2;
    }
}


/* Реализовать класс F1 наследующий методы BaseMath, содержащий конструктор с 
параметрами ($a, $b, $c) и метод getValue(). Класс реализует 
расчет по формуле f=(a*(b^c)+(((a/c)^b)%3)^min(a,b,c)). */

class F1 extends BaseMath
{
    private $a, $b, $c;

    public function __construct(int $a, int $b, int $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
    public function getValue()
    {
        $exp1 = $this->exp1($this->a, $this->b, $this->c);
        $exp2 = $this->exp2($this->a, $this->b, $this->c);

        $f = $exp1 + (($exp2) % 3) ^ min($this->a, $this->b, $this->c);

        return $f;
    }
};

$class = new F1(11, 11, 11);

echo "Задание №8 <br> Результат: " . $class->getValue();
