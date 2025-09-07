   $(document).ready(function() {
        // init controller
        var controller = new ScrollMagic.Controller();

        // build scenes
        new ScrollMagic.Scene({triggerElement: '.parallax-start', triggerHook: 0, duration: '100%'})
              .setTween('.full-image-dark', {backgroundPosition: '50% 100%', ease: Linear.easeNone})
              .addTo(controller);


      });