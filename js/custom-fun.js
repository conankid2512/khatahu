 $(document).ready(function() {
   "use strict";
   /* -------------------------------------------------------------------------*
    * SCROLL BAR
    * -------------------------------------------------------------------------*/
   var seq = 0;
   $("html").niceScroll({
     styler: "fb",
     cursorcolor: "#e74c3c"
   });
   $(window).load(function() {
     setTimeout(function() {
       $("#gmbox div").animate({
         'top': 60
       }, 1500, "easeOutElastic");
     }, 1500);
   });

   /* -------------------------------------------------------------------------*
    * WOW ANIMATION
    * -------------------------------------------------------------------------*/
   new WOW().init();

   /* -------------------------------------------------------------------------*
    * CALENDAR
    * -------------------------------------------------------------------------*/
   $('.single').pickmeup({
     flat: true
   });


   /* -------------------------------------------------------------------------*
    * SEARCH BAR
    * -------------------------------------------------------------------------*/
   // Hide search wrap by default;
   $(".search-container").hide();
   $(".toggle-search").on("click", function(e) {
     // Prevent default link behavior
     e.preventDefault();
     // Stop propagation
     e.stopPropagation();
     // Toggle search-wrap
     $(".search-container").slideToggle(500, function() {
       // Focus on the search bar
       // When animation is complete
       $("#search-bar").focus();
     });
   });
   // Close the search bar if user clicks anywhere
   $(document).click(function(e) {
     var searchWrap = $(".search-container");
     if (!searchWrap.is(e.target) && searchWrap.has(e.target).length ===
       0) {
       searchWrap.slideUp(500);
     }
   });

   /* -------------------------------------------------------------------------*
    * ADDING SLIDE UP AND ANIMATION TO DROPDOWN
    * -------------------------------------------------------------------------*/
   enquire.register("screen and (min-width:767px)", {

     match: function() {
       $(".dropdown").hover(function() {
         $('.dropdown-menu', this).stop().fadeIn("slow");
       }, function() {
         $('.dropdown-menu', this).stop().fadeOut("slow");
       });
     },
   });

   /* -------------------------------------------------------------------------*
    * DROPDOWN LINK NUDGING
    * -------------------------------------------------------------------------*/
   $('.dropdown-menu a').hover(function() { //mouse in
     $(this).animate({
       paddingLeft: '30px'
     }, 400);
   }, function() { //mouse out
     $(this).animate({
       paddingLeft: 20
     }, 400);
   });

   /* -------------------------------------------------------------------------*
    * STICKY NAVIGATION
    * -------------------------------------------------------------------------*/
   $(window).scroll(function() {
     if ($(window).scrollTop() >= 99) {
       $('.nav-search-outer').addClass('navbar-fixed-top');
     }


     if ($(window).scrollTop() >= 100) {
       $('.nav-search-outer').addClass('show');
     } else {
       $('.nav-search-outer').removeClass('show navbar-fixed-top');
     }
   });
   
   /* -------------------------------------------------------------------------*
    *  KHATAHU TIME AGO PLUGINS
    * -------------------------------------------------------------------------*/
    jQuery("time.timeago").timeago();
 });