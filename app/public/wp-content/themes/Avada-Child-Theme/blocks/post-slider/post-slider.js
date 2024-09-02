function postSlider() {
  const waitjQuery = setInterval(() => {
    if (jQuery) {
      clearInterval(waitjQuery);
      jQuery('.post-slider').slick({
        centerMode: true,
        centerPadding: '30px',
        slidesToShow: 3,
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 2
            }
          },
          {
            breakpoint: 800,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });
    }
  }, 300);
}
postSlider();