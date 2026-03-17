/**
 * Custom scripts kept separate from template main.js
 * to keep upstream template logic clean.
 */
(function () {
  "use strict";

  // Script Layouts Website
  function reinitializeUiAfterLivewireNavigation() {
    window.scrollTo({ top: 0, behavior: "smooth" });

    const preloaderAfterNavigate = document.querySelector("#preloader");
    if (preloaderAfterNavigate) {
      preloaderAfterNavigate.remove();
    }

    if (typeof AOS !== "undefined") {
      AOS.init({
        duration: 600,
        easing: "ease-in-out",
        once: true,
      });
    }

    if (typeof GLightbox !== "undefined") {
      GLightbox({ selector: ".glightbox" });
    }

    if (typeof Swiper !== "undefined") {
      document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
        let configElement = swiperElement.querySelector(".swiper-config");
        if (configElement) {
          let config = JSON.parse(configElement.innerHTML.trim());
          new Swiper(swiperElement, config);
        }
      });
    }

    if (typeof Isotope !== "undefined") {
      document.querySelectorAll(".isotope-layout").forEach(function (isotopeItem) {
        let layout = isotopeItem.getAttribute("data-layout") ?? "masonry";
        let filter = isotopeItem.getAttribute("data-default-filter") ?? "*";
        let sort = isotopeItem.getAttribute("data-sort") ?? "original-order";
        let container = isotopeItem.querySelector(".isotope-container");

        if (container) {
          let initIsotope = new Isotope(container, {
            itemSelector: ".isotope-item",
            layoutMode: layout,
            filter: filter,
            sortBy: sort,
          });

          isotopeItem.querySelectorAll(".isotope-filters li").forEach(function (filters) {
            filters.addEventListener(
              "click",
              function () {
                isotopeItem
                  .querySelector(".isotope-filters .filter-active")
                  .classList.remove("filter-active");
                this.classList.add("filter-active");
                initIsotope.arrange({ filter: this.getAttribute("data-filter") });
              },
              false
            );
          });
        }
      });
    }
  }

  document.addEventListener("livewire:navigated", reinitializeUiAfterLivewireNavigation);

  // Script Contact Send Message
})();
