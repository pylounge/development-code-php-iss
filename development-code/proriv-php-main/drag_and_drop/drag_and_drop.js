window.onload = function () 
{
    let dropArea = document.getElementById("drop-area")
    let more = document.getElementById("more")
    let choice = document.getElementById("choice")
    let loading = document.getElementById("loading")
    let progressBar = document.getElementById('progress-bar')
    let uploadProgress = []

        ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)  // Отключаем стандартное поведение элемента на перечисленные события 
            //document.body.addEventListener(eventName, preventDefaults, false)
        })

        ;['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false) 
        })

        ;['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false)
        })

    dropArea.addEventListener('drop', handleDrop, false)

    function preventDefaults(e) {
        e.preventDefault()
        e.stopPropagation()
    }

    function highlight(e) {
        dropArea.classList.add('highlight')
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight')
    }

    function handleDrop(e) {
        var dt = e.dataTransfer
        var files = dt.files
        handleFiles(files)
    }

    function initializeProgress(numFiles) {
        progressBar.value = 0
        uploadProgress = []

        for (let i = numFiles; i > 0; i--) {
            uploadProgress.push(0)
        }
    }

    function updateProgress(fileNumber, percent) {
        uploadProgress[fileNumber] = percent
        let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
        progressBar.value = total
    }

    function handleFiles(files) {
        files = [...files]
        initializeProgress(files.length)
        files.forEach(uploadFile)
    }


    function uploadFile(file, i) {
        var url = 'drag_and_drop.php' // скрипт, который будет обрабатывать загрузку файла 
        var xhr = new XMLHttpRequest()
        var formData = new FormData()
        xhr.open('POST', url)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')


       xhr.upload.addEventListener("progress", function (e) {
            updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
            choice.style.display = 'none';
            more.style.display = 'none';
            loading.style.display = 'block';
        })

        xhr.addEventListener('readystatechange', function (e) {
            if (xhr.readyState == 4 && xhr.status == 200) {  // tесли запрос успешно отправлен 
                updateProgress(i, 100)
                loading.style.display = 'none';
                more.style.display = 'block';
            }
            else if (xhr.readyState == 4 && xhr.status != 200) {
                console.log("error")
            }
        })

        formData.append('file', file)  // отправляем файл в тело запроса 
        xhr.send(formData) // отправляем файл 
    }
};