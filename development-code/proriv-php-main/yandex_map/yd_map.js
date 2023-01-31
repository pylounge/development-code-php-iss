window.onload = function () {

    var xmlhr = new XMLHttpRequest();
    xmlhr.onload = function () {
        var data = JSON.parse(this.responseText); // парсим данные полученные из php 
        ymaps.ready(init(data, 'map')); // Функция ymaps.ready() будет вызвана, когда загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    };
    xmlhr.open("get", "hh_pro.php", true); 
    xmlhr.send(); // отправляем запрос php-скрипту на получение данных

    /**
     * Создаёт Яндекс.Карту с отмеченными на ней вакансиями 
     * 
     * @param {Object} data Объект, соответствующий переданной строке JSON данных.
     * @param {String} htmlMapId Идентификатор div'a с картой (id="map") 
     */
    function init(data, htmlMapId) {
        var myMap = new ymaps.Map(htmlMapId, { 
            center: [data[0]['address_lat'], data[0]['address_lng']],  // центрируем карту на 1 объект из списка данных 
            zoom: 16  // выставляем первоначальный зум карты 
        }, {
            searchControlProvider: 'yandex#search'  // Интсументы, отображаемые на карте 
        });

        var myCollection = new ymaps.GeoObjectCollection(); 
        // Создаём макет содержимого.
        //MyIconContentLayout = ymaps.templateLayoutFactory.createClass('<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>');

        data.forEach(vac => {
            new_placemarcker = new ymaps.Placemark([vac['address_lat'], vac['address_lng']], {  // устанвливаем местоположение маркера вакансии 
                //iconCaption:vac['name'],  //   содержимое иконки геообъекта;
                iconContent: vac['name'], // подпись иконки геообъекта;
                balloonContent: vac['employer'], // Описание подсказки 
                hasHint: true
            }, {
                balloonPanelMaxMapArea: 0,
                preset: "islands#blueStretchyIcon",  
                openEmptyBalloon: true
                //preset: 'islands#icon',  // готовые пресеты для иконок  https://yandex.ru/dev/maps/jsapi/doc/2.1/dg/concepts/geoobjects.html#geoobjects__glyph-icons
                //iconColor: '#0000ff'
            });
            myCollection.add(new_placemarcker); // добавляем метку в коллекцию 
        });
        myMap.geoObjects.add(myCollection); // размещаем маркеры на карте 
        myMap.setBounds(myCollection.getBounds(), { checkZoomRange: true, zoomMargin: 9 }); // Автомасштаб карты, чтобы были видны все метки.
    }
}
