<?php

interface Camera{
    function makePhoto();
    function makeVideo();
}

interface Message{
    function send($address);
}

interface Ethernetable{
    function goOnline();
    function goOffline();
}


trait Charge{
    function charge(){
        echo 'Идёт зарядка....%';
    }
}

abstract class Device{
    public $memory;
    public function powerOff(){
        echo 'Status: Off';
    }
    abstract function powerOn();
}

class Phone extends Device implements Ethernetable, Message, Camera {
		use Charge;
		public function powerOn(){
echo 'Status: On';
}

public function goOnline(){
echo '////';
}

public function goOffline(){
echo '///';
}

public function send($address){
echo '///';
}

public function makePhoto(){
echo '///';
}

public function makeVideo(){
echo '///';
}

public function call(){
echo 'Ring-ring';
}
}  

class MobilePhone extends Phone {
    public $brand;

    public function makePhoto(){
        echo 'Щёлк';
    }
    public function makeVideo(){
        echo 'REC...';
    }
    public function send($address){
        echo 'Отправлено абоненту ' . $address;
    }
    public function goOnline(){
        echo 'Ох как тут у вас в Интернетах весело';
    }
    public function goOffline(){
        echo 'Не нужон нам ваш Интернет';
    }
}


$iphone12 = new MobilePhone();
$iphone12->brand ='Apple';
$iphone12->memory = 128;
$iphone12->send('melnikov.maxx@yandex.ru');
$iphone12->makePhoto();
$iphone12->goOnline();
$iphone12->powerOn();
$iphone12->charge();



interface Driveable{
    function drive();
}

interface Flyable{
    function fly();
}

class Airplan implements Driveable, Flyable{
    use Charge;
    public function drive(){
        echo 'Ну всё, мужики, я погнал!';
    }
    public function fly(){
        echo 'Ну всё, мужики, я полетел!';
    }
}