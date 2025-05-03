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

const form = document.getElementById('delete-account');
const delete_button = document.getElementById('delete-button');

if (delete_button) {
    delete_button.addEventListener('click', function (e) {
        e.preventDefault();
        const confirmation = confirm('Are you sure you want to delete your account? This action cannot be undone.');
        if (confirmation) {
            form.submit();
        }
    });
}