$(document).ready(function() {
    //Summernote inicializálása
    $('#summernote').summernote({
        placeholder: 'Írd ide a bejegyzés tartalmát...',
        tabsize: 2,
        height: 400,
        lang: 'hu-HU',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
    });

    // Képfeltöltés AJAX-szal Summernote-on keresztül
    function uploadImage(file) {
    let data = new FormData();
    data.append("image", file);

    // 1. A tokent a rejtett inputból szedjük ki
    const tokenInput = document.querySelector('input[name="csrf_token"]');
    if (tokenInput) {
        data.append("csrf_token", tokenInput.value);
    }

    // 2. A BASE_URL-t az űrlap 'action' attribútumából is kinyerheted alapnak,
    // vagy használhatod az ablak aktuális URL-jét.
    // Ha az 1. módszert választod, akkor itt: AppConfig.baseUrl + "admin/kep-feltoltes"
    
    const uploadUrl = AppConfig.baseUrl + "kep-feltoltes";

    fetch(uploadUrl, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.url) {
            $('#summernote').summernote('insertImage', data.url);
        } else {
            // Itt fog megjelenni a PHP-tól kapott hibaüzenet
            alert("Szerver hiba: " + data.error);
        }
    })
    .catch(error => {
        console.error("Hiba:", error);
    });
}


});