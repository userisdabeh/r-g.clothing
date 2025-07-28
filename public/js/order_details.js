const stars = document.querySelectorAll('.star-rating:not(.disabled) .star');
const ratingValue = document.getElementById('ratingValue');

if (stars.length > 0 && ratingValue) {
    let currentRating = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const val = parseInt(star.dataset.value);
            highlightStars(val);
        });

        star.addEventListener('mouseout', () => {
            highlightStars(currentRating);
        });

        star.addEventListener('click', () => {
            currentRating = parseInt(star.dataset.value);
            ratingValue.value = currentRating;
            highlightStars(currentRating);
        });
    });

    function highlightStars(val) {
        stars.forEach(star => {
            const starVal = parseInt(star.dataset.value);

            if (starVal <= val) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }
}
