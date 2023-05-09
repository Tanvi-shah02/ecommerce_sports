/*

 BODY TOP PADDING AS PER HEADER HEIGHT

--------------------------------------------*/

jQuery(document).ready(function() {

    var headerHeight = jQuery(".header").outerHeight();

     jQuery("body").css("padding-top", headerHeight);

});

/*
jQuery(document).ready(function() {

    var owl = jQuery('.prject-carousel');

    owl.owlCarousel({

      loop: true,

      items:2,

      margin: 80,

      autoplay: true,

      nav:true,

      navClass:["owl-prev d-flex justify-content-center align-items-center","owl-next d-flex justify-content-center align-items-center"],

      navText:["<img src='images/assets/arrow-prev-small.png'>","<img src='images/assets/arrow-next-small.png'>"],

      dots:false,

    });

  });
  
  */