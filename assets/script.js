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

    function uploadImage(file) {
        let data = new FormData();
        data.append("image", file);

        const tokenInput = document.querySelector('input[name="csrf_token"]');
        if (tokenInput) {
            data.append("csrf_token", tokenInput.value);
        }

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
                alert("Szerver hiba: " + data.error);
            }
        })
        .catch(error => {
            console.error("Hiba:", error);
        });
    }


});