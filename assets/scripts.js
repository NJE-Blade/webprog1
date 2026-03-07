document.addEventListener('DOMContentLoaded', function() { //ez a rész arra kell, hogy a js csak akkor induljon el, ha a weboldal betöltődött 
    const deleteLinks = document.querySelectorAll('.btn-action.text-danger'); // konkrétan az összes kuka ikon
    const confirmBtn = document.getElementById('confirmDeleteBtn'); // törlés gomb a felugróban 'id' után
    const deleteModalEl = document.getElementById('deleteModal'); //speckó bootstrap objektum
    const deleteModal = new bootstrap.Modal(deleteModalEl);

    deleteLinks.forEach(link => { //végigmegy a táblázat összes során
        link.addEventListener('click', function(e) {  // figyeli a táblázatban a törlés gombokat, hogy mikor kattintunk rá
            e.preventDefault();
            
            // ez a rész kell ahhoz, hogy a klikkelés után ne nyíljon meg azonnal a yt ablak
            const href = this.getAttribute('href'); //yt link kiolvasása
            confirmBtn.dataset.targetUrl = href; //elmentjük a videó linkjét, így tudni fogja a modal melyik yt vidit játssza le
            
            deleteModal.show(); // itt pedig jön az ablak
        });
    });

    // mi történjen amikor a modal-ban megerősítik a törlést:
    confirmBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const url = this.dataset.targetUrl;
        
        // itt nyílik az új ablak
        window.open(url, '_blank');
        
        // ez pedig azért kell, hogy eltűnkön a felugró ablak.
        deleteModal.hide();
    });
});


//kép nagyításhoz a script
document.addEventListener('DOMContentLoaded', function() {
    const zoomImages = document.querySelectorAll('.zoom-img');
    const imageModalEl = document.getElementById('imageModal');
    
    if (imageModalEl) {
        const fullImage = document.getElementById('fullImage');
        const caption = document.getElementById('imageCaption');
        const imageModal = new bootstrap.Modal(imageModalEl);

        zoomImages.forEach(img => {
            img.addEventListener('click', function() {
                fullImage.src = this.src;
                caption.innerText = this.alt;
                imageModal.show();
            });
        });
    }
});