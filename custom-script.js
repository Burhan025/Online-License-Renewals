document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edu-slider .pp-carousel-image-container .swiper-slide-inner').forEach(item => {
        const titleElement = item.querySelector('h4');
        if (titleElement) {
            const title = titleElement.textContent;
            item.style.setProperty('--gallery-title', `"${title}"`);
        }
    });
});

//Add class to parent div
jQuery(document).ready(function() {
    jQuery('.single-sfwd-courses .ld-course-status').parent().addClass('ldc-status');
});

//Moved status div to top
jQuery(document).ready(function() {
    jQuery('.single-sfwd-courses .ldc-status').insertBefore('.single-sfwd-courses .fl-post-thumb');
});