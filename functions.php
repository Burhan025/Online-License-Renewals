<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

add_action('wp_enqueue_scripts', 'parallax_enqueue_scripts_styles', 1000);
function parallax_enqueue_scripts_styles()
{
    wp_enqueue_script('customjs', get_stylesheet_directory_uri() . '/custom-script.js', array('jquery'));
}


// Add Additional Image Sizes
add_image_size( 'course-thumb', 380, 230, true );
add_image_size( 'course-full', 1200, 440, true );


//Search Function for courses
function course_state_filter_shortcode() {
    // Buffer output to return as a string
    ob_start();
    ?>
    <!-- Search Dropdown by Course -->
    <div class="search-dropdowns-wrapper">
    <div class="search-left">
    <h4>Flexible Learning for Simplified Online License Renewals</h4>
    </div>
    <div class="search-right">
    <form method="get" action="/" class="course-filter">
        <select id="course_dropdown">
            <option value="">Choose a Course</option>
            <?php
            $courses = get_posts(array(
                'post_type' => 'sfwd-courses',
                'posts_per_page' => -1,
                'post_status' => 'publish',
            ));
            foreach ($courses as $course) {
                echo '<option value="' . get_permalink($course->ID) . '">' . esc_html($course->post_title) . '</option>';
            }
            ?>
        </select>

        <!-- Search Dropdown by State -->
        <select id="state_dropdown">
            <option value="">Select a State</option>
            <?php
            $states = ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"];
            foreach ($states as $state) {
                echo '<option value="' . esc_attr($state) . '">' . esc_html($state) . '</option>';
            }
            ?>
        </select>

        <button type="button" id="find_course_btn">Find Your Course</button>
    </form>
    </div>
    </div>

    <script>
    jQuery(document).ready(function ($) {
        $('#find_course_btn').click(function () {
            var course = $('#course_dropdown').val();
            var state = $('#state_dropdown').val();

            if (course) {
                window.location.href = course;
            } else if (state) {
                alert('Selected State: ' + state);
            } else {
                alert('Please select a course or a state.');
            }
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('course_state_filter', 'course_state_filter_shortcode');


// Shortcode to display the course ID on a LearnDash certificate
function learndash_certificate_course_id_shortcode($atts) {
    // Ensure the global $post object is available
    global $post;

    // Check if we are on a LearnDash certificate
    if (isset($post) && $post->post_type === 'sfwd-certificates') {
        // Get the user's ID
        $user_id = get_current_user_id();

        // Get the course ID for the current certificate
        $course_id = learndash_get_course_id($post->ID);

        // Return the course ID or a default message
        return $course_id ? $course_id : 'Course ID not found';
    }

    return 'This shortcode is only for certificates.';
}

// Register the shortcode
add_shortcode('course_id', 'learndash_certificate_course_id_shortcode');