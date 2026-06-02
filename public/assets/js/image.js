document.addEventListener("DOMContentLoaded", function () {

  const featureItems = document.querySelectorAll(".feature-item");
  const images = document.querySelectorAll(".ui_img");

  featureItems.forEach(item => {
    item.addEventListener("click", function () {

      // remove active classes
      featureItems.forEach(i => i.classList.remove("active"));
      images.forEach(img => img.classList.remove("active"));

      // activate clicked item
      this.classList.add("active");

      // show related image
      const targetId = this.getAttribute("data-target");
      const targetImg = document.getElementById(targetId);

      if (targetImg) {
        targetImg.classList.add("active");
      }
    });
  });

});



document.addEventListener("DOMContentLoaded", function () {

  const items = document.querySelectorAll(".teacher_feature");
  const images = document.querySelectorAll(".teacher_img");

  items.forEach(item => {
    item.addEventListener("click", function () {

      items.forEach(i => i.classList.remove("active"));
      images.forEach(img => img.classList.remove("active"));

      this.classList.add("active");

      const target = this.getAttribute("data-target");
      const targetImg = document.getElementById(target);
      if (targetImg) {
        targetImg.classList.add("active");
      }

    });
  });

});