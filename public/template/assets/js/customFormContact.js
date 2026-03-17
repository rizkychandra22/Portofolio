/**
 * Contact page specific Livewire hooks.
 * Loaded only on contact route.
 */
(function () {
  "use strict";

  document.addEventListener("livewire:initialized", () => {
    if (typeof Livewire !== "undefined" && typeof Livewire.hook === "function") {
      Livewire.hook("commit", ({ succeed }) => {
        succeed(() => {
          setTimeout(() => {
            if (typeof AOS !== "undefined") {
              AOS.refresh();
            }
          }, 1);
        });
      });
    }
  });
})();

