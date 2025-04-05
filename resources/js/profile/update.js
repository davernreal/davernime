const image_upload = document.getElementById('image-upload');
const button_upload = document.getElementById('upload-image');
const image_preview = document.getElementById('image-preview');

button_upload.addEventListener('click', function(e) {
    e.preventDefault();
    image_upload.click();
})

image_upload.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            image_preview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
});