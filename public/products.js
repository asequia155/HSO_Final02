document.addEventListener('DOMContentLoaded', function () {
    const productContainer = document.getElementById('product-container');
    const prevButton = document.getElementById('prev-btn');
    const nextButton = document.getElementById('next-btn');
  
    // Total number of products in the slider (in this case, 8)
    const totalProducts = 8;
    let currentIndex = 0;
  
    // Function to update the slide position
    function updateSliderPosition() {
      productContainer.style.transform = `translateX(-${currentIndex * 33.33}%)`; // Shows 3 products at a time (33.33%)
    }
  
    // Event listener for the previous button
    prevButton.addEventListener('click', function () {
      if (currentIndex > 0) {
        currentIndex--;
        updateSliderPosition();
      }
    });
  
    // Event listener for the next button
    nextButton.addEventListener('click', function () {
      if (currentIndex < totalProducts / 3 - 1) { // Ensure we don't go past the last set of 3 products
        currentIndex++;
        updateSliderPosition();
      }
    });
  
    // Initialize the slider position
    updateSliderPosition();
  });
  