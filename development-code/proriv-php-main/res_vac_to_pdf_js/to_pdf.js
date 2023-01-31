/**
* Сохраняет выбранную область HTML-страницы в PDF-файл и автоматически его скачивает.
*
* @param {String} pdf_area id элемента, содержащего область, которая будет сохранена в pdf-файл.
* @param {String} file_name_area id элемента, содержимое которого станет названием генерируемого pdf-файла.
*/
function convert_to_pdf(pdf_area, file_name_area)
{
    var part_of_page_to_convert = document.getElementById(pdf_area); 
    var document_id = document.getElementById(file_name_area).textContent; 

    var opt = {
        margin: 0.2,               // отступы в jsPDF units 
        filename: document_id + '.pdf',      
        image: { type: 'jpg', quality: 1 }, // Тип и качество изображения, используемые для создания PDF-файла (1 = 100%)
        html2canvas: { scale: 2 },   // html2canvas-опция (масштабирование рендеринга, по умолчанию используется соотношение пикселей устройства браузера)
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' } // jsPDF-опции (jsPDF unit = 1 inches, формат страницы a4 и портретная ориентация)
    };
    html2pdf().set(opt).from(part_of_page_to_convert).save(); // cохраняет в PDF (сразу происходит скачивание файла в браузере)
}


// в html-файле <button onclick="convert_to_pdf('pdf-area','pdf-file-name')">Сохранить файл на диск</button>
