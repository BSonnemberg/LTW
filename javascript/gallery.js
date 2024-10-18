let currentPhotoIndex = 0;

function changePhoto(direction) {
    const photos = document.querySelectorAll('.product-photo');
    photos[currentPhotoIndex].style.display = 'none';
    currentPhotoIndex += direction;

    if (currentPhotoIndex >= photos.length) {
        currentPhotoIndex = 0;
    } else if (currentPhotoIndex < 0) {
        currentPhotoIndex = photos.length - 1;
    }

    photos[currentPhotoIndex].style.display = 'block';
}
