<?php

/*
Plugin Name: Duolingo Widget
Plugin URI: http://polyglotwannabe.com/
Description: A small plugin to display a widget that retrieves data from my Duolingo account
Version: 1.0
Author: Lidia Cirrone
Author URI: http://polyglotwannabe.com/
*/

if (!defined('ABSPATH')) {
   exit; // Exit if accessed directly
}

if (!function_exists('flags_css')) {
   function flags_css()
   {
      global $post;
      if (has_shortcode($post->post_content, 'duolingo')) {
         wp_enqueue_style('flag-icons-main', plugins_url('pw-duolingo-widget') . '/flag-icons-main/css/flag-icons.min.css', array(), null);
      }
   }
}
add_action('wp_enqueue_scripts', 'flags_css');




if (!function_exists('duolingo_shortcode')) {
   function duolingo_shortcode($attributes)
   {
      include "connect.php";
      $duo_user = json_decode($data);
      $creation_date = date("d/m/Y", $duo_user->creationDate);
      $all_languages = new stdClass();
      $courses = $duo_user->courses;
      foreach ($courses as $course) {
         $target = $course->learningLanguage;
         $source = $course->fromLanguage;
         if (!property_exists($all_languages, $source))
            $all_languages->$source = [];
         $all_languages->$source[] = $target;
      }

      ob_start();
?>
      <div class="card">
         <div class="card-body small">
            <h5 class="card-title mb-3">
               <img src="<?php echo $duo_user->picture . "/xlarge"; ?>" class="img-fluid rounded-circle w-20 me-2" alt="avatar">
               <a href="https://www.duolingo.com/lidiaCirrone" target="_href"><?php echo $duo_user->username; ?></a>
            </h5>
            <p class="card-subtitle text-pastel mt-0">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-top" viewBox="0 0 16 16">
                  <path d="M2 14.5a.5.5 0 0 0 .5.5h11a.5.5 0 1 0 0-1h-1v-1a4.5 4.5 0 0 0-2.557-4.06c-.29-.139-.443-.377-.443-.59v-.7c0-.213.154-.451.443-.59A4.5 4.5 0 0 0 12.5 3V2h1a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1h1v1a4.5 4.5 0 0 0 2.557 4.06c.29.139.443.377.443.59v.7c0 .213-.154.451-.443.59A4.5 4.5 0 0 0 3.5 13v1h-1a.5.5 0 0 0-.5.5zm2.5-.5v-1a3.5 3.5 0 0 1 1.989-3.158c.533-.256 1.011-.79 1.011-1.491v-.702s.18.101.5.101.5-.1.5-.1v.7c0 .701.478 1.236 1.011 1.492A3.5 3.5 0 0 1 11.5 13v1h-7z" />
               </svg>
               created on <?php echo $creation_date; ?>
            </p>
            <p class="card-subtitle text-pastel mt-0">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                  <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
               </svg>
               <?php echo $duo_user->streak; ?> day streak
            </p>
            <p class="card-subtitle text-pastel mt-0">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-charge" viewBox="0 0 16 16">
                  <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z" />
               </svg>
               <?php echo $duo_user->totalXp; ?> total xp
            </p>
            <p class="card-subtitle text-pastel mt-0">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-text" viewBox="0 0 16 16">
                  <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                  <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8zm0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
               </svg>
               <?php echo $courses[0]->title; ?>
            </p>
            <div class="card-text my-3">
               all the languages I've been studying on Duolingo up until now:<br>
               <?php
               foreach ($all_languages as $source => $target) {
                  if ($source == 'da') : ($source = 'dk');
                  endif;
                  if ($source == 'en') : ($source = 'gb');
                  endif; ?>
                  <span class="flag-icon flag-icon-<?php echo $source; ?> align-middle"></span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                     <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                  </svg>
                  <?php foreach ($target as $lang) {
                     if ($lang == 'da') : ($lang = 'dk');
                     endif;
                     if ($target == 'en') : ($target = 'gb');
                     endif; ?>
                     <span class="flag-icon flag-icon-<?php echo $lang; ?> align-middle"></span>
                  <?php } ?>
                  <br>
               <?php } ?>
            </div>
            - <a href="https://www.duolingo.com/lidiaCirrone" target="_href" class="card-link">my profile</a><br>
            - <a href="https://duome.eu/lidiaCirrone" target="_href" class="card-link">more statistics on duome.eu</a>
         </div>
      </div>
<?php
      return ob_get_clean();
   }
}
add_shortcode('duolingo', 'duolingo_shortcode');
