// ======================
// AJAX PENCARIAN ANGGOTA
// ======================

const tombolCari = document.querySelector('.tombol-cari');
const keyword = document.querySelector('.keyword');
const container = document.querySelector('.container');

if (tombolCari) {
    tombolCari.style.display = 'none';
}

if (keyword) {
    keyword.addEventListener('keyup', function () {

        fetch('ajax/ajax_cari.php?keyword=' + keyword.value)
            .then(response => response.text())
            .then(data => {
                if (container) {
                    container.innerHTML = data;
                }
            });

    });
}


// ======================
// PREVIEW FOTO ANGGOTA
// ======================

function previewImage() {

    const foto = document.querySelector('input[name="foto"]');
    const imgPreview = document.querySelector('.img-preview');

    if (!foto || !imgPreview) {
        return;
    }

    const fileFoto = new FileReader();

    fileFoto.readAsDataURL(foto.files[0]);

    fileFoto.onload = function (e) {
        imgPreview.src = e.target.result;
    };

}