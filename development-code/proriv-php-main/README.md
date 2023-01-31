# proriv-php
PHP and JavaScript scripts for Digital  Breakthrough2020

## Для работы скрипта to_pdf.js

В html-файле подключить **html2pdf.bundle.min.js** и сам **to_pdf.js**:
```
<script src="html2pdf.bundle.min.js"></script>
<script src="to_pdf.js"></script>
```

Вешаем на кнопку вызов функции ***convert_to_pdf*** c 2 параметра. В параметры передаем: 
* id элемента, содержащего область, которая будет сохранена в pdf;
* id элемента, содержимое которого станет названием pdf-файла.

```
<html id="pdf-area">
<!-- ... -->
<div class="title" id="pdf-file-name">Web-программирование</div>
<!-- ... -->
<button onclick="convert_to_pdf('pdf-area', 'pdf-file-name')">Сохранить файл на диск</button>
```

## Для работы скрипта yd.php

С помощью скрипта **yd_env.bat(для Windows)** или **yd_env.sh(для Linux)** необходимо устанвоить значение переменной окружения **TOKEN**, содержащей access token приложения. 
