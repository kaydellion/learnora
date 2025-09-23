/**
* Template Name: FashionStore
* Template URL: https://bootstrapmade.com/fashion-store-bootstrap-template/
* Updated: Apr 26 2025 with Bootstrap v5.3.5
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Countdown timer
   */
  function updateCountDown(countDownItem) {
    const timeleft = new Date(countDownItem.getAttribute('data-count')).getTime() - new Date().getTime();

    const days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

    countDownItem.querySelector('.count-days').innerHTML = days;
    countDownItem.querySelector('.count-hours').innerHTML = hours;
    countDownItem.querySelector('.count-minutes').innerHTML = minutes;
    countDownItem.querySelector('.count-seconds').innerHTML = seconds;

  }

  document.querySelectorAll('.countdown').forEach(function(countDownItem) {
    updateCountDown(countDownItem);
    setInterval(function() {
      updateCountDown(countDownItem);
    }, 1000);
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Ecommerce Cart Functionality
   * Handles quantity changes and item removal
   */

  function ecommerceCartTools() {
    // Get all quantity buttons and inputs directly
    const decreaseButtons = document.querySelectorAll('.quantity-btn.decrease');
    const increaseButtons = document.querySelectorAll('.quantity-btn.increase');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const removeButtons = document.querySelectorAll('.remove-item');

    // Decrease quantity buttons
    decreaseButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const quantityInput = btn.closest('.quantity-selector').querySelector('.quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
          quantityInput.value = currentValue - 1;
        }
      });
    });

    // Increase quantity buttons
    increaseButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const quantityInput = btn.closest('.quantity-selector').querySelector('.quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue < parseInt(quantityInput.getAttribute('max'))) {
          quantityInput.value = currentValue + 1;
        }
      });
    });

    // Manual quantity inputs
    quantityInputs.forEach(input => {
      input.addEventListener('change', function() {
        let currentValue = parseInt(input.value);
        const min = parseInt(input.getAttribute('min'));
        const max = parseInt(input.getAttribute('max'));

        // Validate input
        if (isNaN(currentValue) || currentValue < min) {
          input.value = min;
        } else if (currentValue > max) {
          input.value = max;
        }
      });
    });

    // Remove item buttons
    removeButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        btn.closest('.cart-item').remove();
      });
    });
  }

  ecommerceCartTools();

  /**
   * Product Image Zoom and Thumbnail Functionality
   */

  function productDetailFeatures() {
    // Initialize Drift for image zoom
    function initDriftZoom() {
      // Check if Drift is available
      if (typeof Drift === 'undefined') {
        console.error('Drift library is not loaded');
        return;
      }

      const driftOptions = {
        paneContainer: document.querySelector('.image-zoom-container'),
        inlinePane: window.innerWidth < 768 ? true : false,
        inlineOffsetY: -85,
        containInline: true,
        hoverBoundingBox: false,
        zoomFactor: 3,
        handleTouch: false
      };

      // Initialize Drift on the main product image
      const mainImage = document.getElementById('main-product-image');
      if (mainImage) {
        new Drift(mainImage, driftOptions);
      }
    }

    // Thumbnail click functionality
    function initThumbnailClick() {
      const thumbnails = document.querySelectorAll('.thumbnail-item');
      const mainImage = document.getElementById('main-product-image');

      if (!thumbnails.length || !mainImage) return;

      thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
          // Get image path from data attribute
          const imageSrc = this.getAttribute('data-image');

          // Update main image src and zoom attribute
          mainImage.src = imageSrc;
          mainImage.setAttribute('data-zoom', imageSrc);

          // Update active state
          thumbnails.forEach(item => item.classList.remove('active'));
          this.classList.add('active');

          // Reinitialize Drift for the new image
          initDriftZoom();
        });
      });
    }

    // Image navigation functionality (prev/next buttons)
    function initImageNavigation() {
      const prevButton = document.querySelector('.image-nav-btn.prev-image');
      const nextButton = document.querySelector('.image-nav-btn.next-image');

      if (!prevButton || !nextButton) return;

      const thumbnails = Array.from(document.querySelectorAll('.thumbnail-item'));
      if (!thumbnails.length) return;

      // Function to navigate to previous or next image
      function navigateImage(direction) {
        // Find the currently active thumbnail
        const activeIndex = thumbnails.findIndex(thumb => thumb.classList.contains('active'));
        if (activeIndex === -1) return;

        let newIndex;
        if (direction === 'prev') {
          // Go to previous image or loop to the last one
          newIndex = activeIndex === 0 ? thumbnails.length - 1 : activeIndex - 1;
        } else {
          // Go to next image or loop to the first one
          newIndex = activeIndex === thumbnails.length - 1 ? 0 : activeIndex + 1;
        }

        // Simulate click on the new thumbnail
        thumbnails[newIndex].click();
      }

      // Add event listeners to navigation buttons
      prevButton.addEventListener('click', () => navigateImage('prev'));
      nextButton.addEventListener('click', () => navigateImage('next'));
    }

    // Initialize all features
    initDriftZoom();
    initThumbnailClick();
    initImageNavigation();
  }

  productDetailFeatures();

  /**
   * Price range slider implementation for price filtering.
   */
  function priceRangeWidget() {
    // Get all price range widgets on the page
    const priceRangeWidgets = document.querySelectorAll('.price-range-container');

    priceRangeWidgets.forEach(widget => {
      const minRange = widget.querySelector('.min-range');
      const maxRange = widget.querySelector('.max-range');
      const sliderProgress = widget.querySelector('.slider-progress');
      const minPriceDisplay = widget.querySelector('.current-range .min-price');
      const maxPriceDisplay = widget.querySelector('.current-range .max-price');
      const minPriceInput = widget.querySelector('.min-price-input');
      const maxPriceInput = widget.querySelector('.max-price-input');
      const applyButton = widget.querySelector('.filter-actions .btn-primary');

      if (!minRange || !maxRange || !sliderProgress || !minPriceDisplay || !maxPriceDisplay || !minPriceInput || !maxPriceInput) return;

      // Slider configuration
      const sliderMin = parseInt(minRange.min);
      const sliderMax = parseInt(minRange.max);
      const step = parseInt(minRange.step) || 1;

      // Initialize with default values
      let minValue = parseInt(minRange.value);
      let maxValue = parseInt(maxRange.value);

      // Set initial values
      updateSliderProgress();
      updateDisplays();

      // Min range input event
      minRange.addEventListener('input', function() {
        minValue = parseInt(this.value);

        // Ensure min doesn't exceed max
        if (minValue > maxValue) {
          minValue = maxValue;
          this.value = minValue;
        }

        // Update min price input and display
        minPriceInput.value = minValue;
        updateDisplays();
        updateSliderProgress();
      });

      // Max range input event
      maxRange.addEventListener('input', function() {
        maxValue = parseInt(this.value);

        // Ensure max isn't less than min
        if (maxValue < minValue) {
          maxValue = minValue;
          this.value = maxValue;
        }

        // Update max price input and display
        maxPriceInput.value = maxValue;
        updateDisplays();
        updateSliderProgress();
      });

      // Min price input change
      minPriceInput.addEventListener('change', function() {
        let value = parseInt(this.value) || sliderMin;

        // Ensure value is within range
        value = Math.max(sliderMin, Math.min(sliderMax, value));

        // Ensure min doesn't exceed max
        if (value > maxValue) {
          value = maxValue;
        }

        // Update min value and range input
        minValue = value;
        this.value = value;
        minRange.value = value;
        updateDisplays();
        updateSliderProgress();
      });

      // Max price input change
      maxPriceInput.addEventListener('change', function() {
        let value = parseInt(this.value) || sliderMax;

        // Ensure value is within range
        value = Math.max(sliderMin, Math.min(sliderMax, value));

        // Ensure max isn't less than min
        if (value < minValue) {
          value = minValue;
        }

        // Update max value and range input
        maxValue = value;
        this.value = value;
        maxRange.value = value;
        updateDisplays();
        updateSliderProgress();
      });

      // Apply button click
      if (applyButton) {
        applyButton.addEventListener('click', function() {
          // This would typically trigger a form submission or AJAX request
          console.log(`Applying price filter: $${minValue} - $${maxValue}`);

          // Here you would typically add code to filter products or redirect to a filtered URL
        });
      }

      // Helper function to update the slider progress bar
      function updateSliderProgress() {
        const range = sliderMax - sliderMin;
        const minPercent = ((minValue - sliderMin) / range) * 100;
        const maxPercent = ((maxValue - sliderMin) / range) * 100;

        sliderProgress.style.left = `${minPercent}%`;
        sliderProgress.style.width = `${maxPercent - minPercent}%`;
      }

      // Helper function to update price displays
      function updateDisplays() {
        minPriceDisplay.textContent = `$${minValue}`;
        maxPriceDisplay.textContent = `$${maxValue}`;
      }
    });
  }
  priceRangeWidget();

  /**
   * Ecommerce Checkout Section
   * This script handles the functionality of both multi-step and one-page checkout processes
   */

  function initCheckout() {
    // Detect checkout type
    const isMultiStepCheckout = document.querySelector('.checkout-steps') !== null;
    const isOnePageCheckout = document.querySelector('.checkout-section') !== null;

    // Initialize common functionality
    initInputMasks();
    initPromoCode();

    // Initialize checkout type specific functionality
    if (isMultiStepCheckout) {
      initMultiStepCheckout();
    }

    if (isOnePageCheckout) {
      initOnePageCheckout();
    }

    // Initialize tooltips (works for both checkout types)
    initTooltips();
  }

  initCheckout();

  // Function to initialize multi-step checkout
  function initMultiStepCheckout() {
    // Get all checkout elements
    const checkoutSteps = document.querySelectorAll('.checkout-steps .step');
    const checkoutForms = document.querySelectorAll('.checkout-form');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const editButtons = document.querySelectorAll('.btn-edit');
    const paymentMethods = document.querySelectorAll('.payment-method-header');
    const summaryToggle = document.querySelector('.btn-toggle-summary');
    const orderSummaryContent = document.querySelector('.order-summary-content');

    // Step Navigation
    nextButtons.forEach(button => {
      button.addEventListener('click', function() {
        const nextStep = parseInt(this.getAttribute('data-next'));
        navigateToStep(nextStep);
      });
    });

    prevButtons.forEach(button => {
      button.addEventListener('click', function() {
        const prevStep = parseInt(this.getAttribute('data-prev'));
        navigateToStep(prevStep);
      });
    });

    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const editStep = parseInt(this.getAttribute('data-edit'));
        navigateToStep(editStep);
      });
    });

    // Payment Method Selection for multi-step checkout
    paymentMethods.forEach(header => {
      header.addEventListener('click', function() {
        // Get the radio input within this header
        const radio = this.querySelector('input[type="radio"]');
        if (radio) {
          radio.checked = true;

          // Update active state for all payment methods
          const allPaymentMethods = document.querySelectorAll('.payment-method');
          allPaymentMethods.forEach(method => {
            method.classList.remove('active');
          });

          // Add active class to the parent payment method
          this.closest('.payment-method').classList.add('active');

          // Show/hide payment method bodies
          const allPaymentBodies = document.querySelectorAll('.payment-method-body');
          allPaymentBodies.forEach(body => {
            body.classList.add('d-none');
          });

          const selectedBody = this.closest('.payment-method').querySelector('.payment-method-body');
          if (selectedBody) {
            selectedBody.classList.remove('d-none');
          }
        }
      });
    });

    // Order Summary Toggle (Mobile)
    if (summaryToggle) {
      summaryToggle.addEventListener('click', function() {
        this.classList.toggle('collapsed');

        if (orderSummaryContent) {
          orderSummaryContent.classList.toggle('d-none');
        }

        // Toggle icon
        const icon = this.querySelector('i');
        if (icon) {
          if (icon.classList.contains('bi-chevron-down')) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
          } else {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
          }
        }
      });
    }

    // Form Validation for multi-step checkout
    const forms = document.querySelectorAll('.checkout-form-element');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
          } else {
            field.classList.remove('is-invalid');
          }
        });

        // If it's the final form and valid, show success message
        if (isValid && form.closest('.checkout-form[data-form="4"]')) {
          // Hide form fields
          const formFields = form.querySelectorAll('.form-group, .review-sections, .form-check, .d-flex');
          formFields.forEach(field => {
            field.style.display = 'none';
          });

          // Show success message
          const successMessage = form.querySelector('.success-message');
          if (successMessage) {
            successMessage.classList.remove('d-none');

            // Add animation
            successMessage.style.animation = 'fadeInUp 0.5s ease forwards';
          }

          // Simulate redirect after 3 seconds
          setTimeout(() => {
            // In a real application, this would redirect to an order confirmation page
            console.log('Redirecting to order confirmation page...');
          }, 3000);
        }
      });
    });

    // Function to navigate between steps
    function navigateToStep(stepNumber) {
      // Update steps
      checkoutSteps.forEach(step => {
        const stepNum = parseInt(step.getAttribute('data-step'));

        if (stepNum < stepNumber) {
          step.classList.add('completed');
          step.classList.remove('active');
        } else if (stepNum === stepNumber) {
          step.classList.add('active');
          step.classList.remove('completed');
        } else {
          step.classList.remove('active', 'completed');
        }
      });

      // Update step connectors
      const connectors = document.querySelectorAll('.step-connector');
      connectors.forEach((connector, index) => {
        if (index + 1 < stepNumber) {
          connector.classList.add('completed');
          connector.classList.remove('active');
        } else if (index + 1 === stepNumber - 1) {
          connector.classList.add('active');
          connector.classList.remove('completed');
        } else {
          connector.classList.remove('active', 'completed');
        }
      });

      // Show the corresponding form
      checkoutForms.forEach(form => {
        const formNum = parseInt(form.getAttribute('data-form'));

        if (formNum === stepNumber) {
          form.classList.add('active');

          // Scroll to top of form on mobile
          if (window.innerWidth < 768) {
            form.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        } else {
          form.classList.remove('active');
        }
      });
    }
  }

  // Function to initialize one-page checkout
  function initOnePageCheckout() {
    // Payment Method Selection for one-page checkout
    const paymentOptions = document.querySelectorAll('.payment-option input[type="radio"]');

    paymentOptions.forEach(option => {
      option.addEventListener('change', function() {
        // Update active class on payment options
        document.querySelectorAll('.payment-option').forEach(opt => {
          opt.classList.remove('active');
        });

        this.closest('.payment-option').classList.add('active');

        // Show/hide payment details
        const paymentId = this.id;
        document.querySelectorAll('.payment-details').forEach(details => {
          details.classList.add('d-none');
        });

        document.getElementById(`${paymentId}-details`).classList.remove('d-none');
      });
    });

    // Form Validation for one-page checkout
    const checkoutForm = document.querySelector('.checkout-form');

    if (checkoutForm) {
      checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');

            // Scroll to first invalid field
            if (isValid === false) {
              field.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
              field.focus();
              isValid = null; // Set to null so we only scroll to the first invalid field
            }
          } else {
            field.classList.remove('is-invalid');
          }
        });

        // If form is valid, show success message
        if (isValid === true) {
          // Hide form sections except the last one
          const sections = document.querySelectorAll('.checkout-section');
          sections.forEach((section, index) => {
            if (index < sections.length - 1) {
              section.style.display = 'none';
            }
          });

          // Hide terms checkbox and place order button
          const termsCheck = document.querySelector('.terms-check');
          const placeOrderContainer = document.querySelector('.place-order-container');

          if (termsCheck) termsCheck.style.display = 'none';
          if (placeOrderContainer) placeOrderContainer.style.display = 'none';

          // Show success message
          const successMessage = document.querySelector('.success-message');
          if (successMessage) {
            successMessage.classList.remove('d-none');
            successMessage.style.animation = 'fadeInUp 0.5s ease forwards';
          }

          // Scroll to success message
          const orderReview = document.getElementById('order-review');
          if (orderReview) {
            orderReview.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }

          // Simulate redirect after 3 seconds
          setTimeout(() => {
            // In a real application, this would redirect to an order confirmation page
            console.log('Redirecting to order confirmation page...');
          }, 3000);
        }
      });

      // Add input event listeners to clear validation styling when user types
      const formInputs = checkoutForm.querySelectorAll('input, select, textarea');
      formInputs.forEach(input => {
        input.addEventListener('input', function() {
          if (this.value.trim()) {
            this.classList.remove('is-invalid');
          }
        });
      });
    }
  }

  // Function to initialize input masks (common for both checkout types)
  function initInputMasks() {
    // Card number input mask (format: XXXX XXXX XXXX XXXX)
    const cardNumberInput = document.getElementById('card-number');
    if (cardNumberInput) {
      cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);

        // Add spaces after every 4 digits
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
          if (i > 0 && i % 4 === 0) {
            formattedValue += ' ';
          }
          formattedValue += value[i];
        }

        e.target.value = formattedValue;
      });
    }

    // Expiry date input mask (format: MM/YY)
    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
      expiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);

        // Format as MM/YY
        if (value.length > 2) {
          value = value.slice(0, 2) + '/' + value.slice(2);
        }

        e.target.value = value;
      });
    }

    // CVV input mask (3-4 digits)
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
      cvvInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        e.target.value = value;
      });
    }

    // Phone number input mask
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
      phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) value = value.slice(0, 10);

        // Format as (XXX) XXX-XXXX
        if (value.length > 0) {
          if (value.length <= 3) {
            value = '(' + value;
          } else if (value.length <= 6) {
            value = '(' + value.slice(0, 3) + ') ' + value.slice(3);
          } else {
            value = '(' + value.slice(0, 3) + ') ' + value.slice(3, 6) + '-' + value.slice(6);
          }
        }

        e.target.value = value;
      });
    }

    // ZIP code input mask (5 digits)
    const zipInput = document.getElementById('zip');
    if (zipInput) {
      zipInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) value = value.slice(0, 5);
        e.target.value = value;
      });
    }
  }

  // Function to handle promo code application (common for both checkout types)
  function initPromoCode() {
    const promoInput = document.querySelector('.promo-code input');
    const promoButton = document.querySelector('.promo-code button');

    if (promoInput && promoButton) {
      promoButton.addEventListener('click', function() {
        const promoCode = promoInput.value.trim();

        if (promoCode) {
          // Simulate promo code validation
          // In a real application, this would make an API call to validate the code

          // For demo purposes, let's assume "DISCOUNT20" is a valid code
          if (promoCode.toUpperCase() === 'DISCOUNT20') {
            // Show success state
            promoInput.classList.add('is-valid');
            promoInput.classList.remove('is-invalid');
            promoButton.textContent = 'Applied';
            promoButton.disabled = true;

            // Update order total (in a real app, this would recalculate based on the discount)
            const orderTotal = document.querySelector('.order-total span:last-child');
            const btnPrice = document.querySelector('.btn-price');

            if (orderTotal) {
              // Apply a 20% discount
              const currentTotal = parseFloat(orderTotal.textContent.replace('$', ''));
              const discountedTotal = (currentTotal * 0.8).toFixed(2);
              orderTotal.textContent = '$' + discountedTotal;

              // Update button price if it exists
              if (btnPrice) {
                btnPrice.textContent = '$' + discountedTotal;
              }

              // Add discount line
              const orderTotals = document.querySelector('.order-totals');
              if (orderTotals) {
                const discountElement = document.createElement('div');
                discountElement.className = 'order-discount d-flex justify-content-between';
                discountElement.innerHTML = `
                <span>Discount (20%)</span>
                <span>-$${(currentTotal * 0.2).toFixed(2)}</span>
              `;

                // Insert before the total
                const totalElement = document.querySelector('.order-total');
                if (totalElement) {
                  orderTotals.insertBefore(discountElement, totalElement);
                }
              }
            }
          } else {
            // Show error state
            promoInput.classList.add('is-invalid');
            promoInput.classList.remove('is-valid');

            // Reset after 3 seconds
            setTimeout(() => {
              promoInput.classList.remove('is-invalid');
            }, 3000);
          }
        }
      });
    }
  }

  // Function to initialize Bootstrap tooltips
  function initTooltips() {
    // Check if Bootstrap's tooltip function exists
    if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    } else {
      // Fallback for when Bootstrap JS is not loaded
      const cvvHint = document.querySelector('.cvv-hint');
      if (cvvHint) {
        cvvHint.addEventListener('mouseenter', function() {
          this.setAttribute('data-original-title', this.getAttribute('title'));
          this.setAttribute('title', '');
        });

        cvvHint.addEventListener('mouseleave', function() {
          this.setAttribute('title', this.getAttribute('data-original-title'));
        });
      }
    }
  }

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

})();



function showToast(message) {
  const toastContainer = document.createElement('div');
  toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
  toastContainer.style.zIndex = 11;

  const toast = document.createElement('div');
  toast.id = 'liveToast';
  toast.className = 'toast align-items-center text-white bg-primary border-0';
  toast.role = 'alert';
  toast.ariaLive = 'assertive';
  toast.ariaAtomic = 'true';

  const toastBody = document.createElement('div');
  toastBody.className = 'toast-body';
  toastBody.textContent = message;

  const toastButton = document.createElement('button');
  toastButton.type = 'button';
  toastButton.className = 'btn-close btn-close-white me-2 m-auto';
  toastButton.setAttribute('data-bs-dismiss', 'toast');
  toastButton.ariaLabel = 'Close';

  const toastFlex = document.createElement('div');
  toastFlex.className = 'd-flex';
  toastFlex.appendChild(toastBody);
  toastFlex.appendChild(toastButton);

  toast.appendChild(toastFlex);
  toastContainer.appendChild(toast);
  document.body.appendChild(toastContainer);

  const bootstrapToast = new bootstrap.Toast(toast, { delay: 5000 });
  bootstrapToast.show();
}
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            let moreText = this.previousElementSibling;
            let previewText = moreText.previousElementSibling;

            if (moreText.style.display === "none") {
                moreText.style.display = "block";
                previewText.style.display = "none";
                this.textContent = "Read Less";
            } else {
                moreText.style.display = "none";
                previewText.style.display = "inline";
                this.textContent = "Read More";
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var priceElement = document.getElementById('paidPrice');
    var loyaltyContainer = document.querySelector('.product-loyalty-container');
    var checkboxes = document.querySelectorAll('input[name="variation_ids[]"]');
    var loyaltyBadges = document.querySelectorAll('.loyalty-badge');

    function updateLoyaltyPrices(basePrice) {
        loyaltyBadges.forEach(function(badge) {
            var discount = parseFloat(badge.dataset.discount);
            var discounted = basePrice - (basePrice * (discount / 100));
            var priceSpan = badge.querySelector('.loyalty-price');
            if (priceSpan) {
                priceSpan.textContent = discounted.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });
    }

    function updateTotalPrice() {
        let total = 0;
        let selected = 0;

        checkboxes.forEach(function(box) {
            if (box.checked) {
                total += parseFloat(box.dataset.price || 0);
                selected++;
            }
        });

        // Update main price
        if (priceElement) {
            if (selected > 0) {
                priceElement.textContent = '₦' + total.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                priceElement.textContent = '';
            }
        }

        // Show/hide loyalty badge container
        if (loyaltyContainer) {
            loyaltyContainer.style.display = selected > 0 ? 'block' : 'none';
        }

        // Update loyalty prices
        updateLoyaltyPrices(total);
    }

    // Attach change event listeners
    checkboxes.forEach(function(box) {
        box.addEventListener('change', updateTotalPrice);
    });

    // Initial run
    updateTotalPrice();
});


document.addEventListener('DOMContentLoaded', function () {
  const likeBtn = document.getElementById('likeBtn');
  if (!likeBtn) return;

  const blogId = likeBtn.getAttribute('data-blog-id');
  const likeUrl = likeBtn.getAttribute('data-like-url');
  const likeCountEl = document.getElementById('likeCount');

  likeBtn.addEventListener('click', function () {
    fetch(likeUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `blog_id=${blogId}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          likeCountEl.textContent = data.likes;
        } else {
          alert(data.message || 'You already liked this post.');
        }
      });
  });
});



document.addEventListener('DOMContentLoaded', function () {
      const stateAndLGAs = {
    "Abia": [
        "Aba North",
        "Aba South",
        "Arochukwu",
        "Bende",
        "Ikwuano",
        "Isiala-Ngwa North",
        "Isiala-Ngwa South",
        "Isuikwato",
        "Obi Nwa",
        "Ohafia",
        "Osisioma",
        "Ngwa",
        "Ugwunagbo",
        "Ukwa East",
        "Ukwa West",
        "Umuahia North",
        "Umuahia South",
        "Umu-Neochi"
    ],
		 "Adamawa": [
        "Demsa",
        "Fufore",
        "Ganaye",
        "Gireri",
        "Gombi",
        "Guyuk",
        "Hong",
        "Jada",
        "Lamurde",
        "Madagali",
        "Maiha",
        "Mayo-Belwa",
        "Michika",
        "Mubi North",
        "Mubi South",
        "Numan",
        "Shelleng",
        "Song",
        "Toungo",
        "Yola North",
        "Yola South"
    ],
    "Anambra": [
        "Aguata",
        "Anambra East",
        "Anambra West",
        "Anaocha",
        "Awka North",
        "Awka South",
        "Ayamelum",
        "Dunukofia",
        "Ekwusigo",
        "Idemili North",
        "Idemili south",
        "Ihiala",
        "Njikoka",
        "Nnewi North",
        "Nnewi South",
        "Ogbaru",
        "Onitsha North",
        "Onitsha South",
        "Orumba North",
        "Orumba South",
        "Oyi"
    ],
    "Akwa Ibom": [
        "Abak",
        "Eastern Obolo",
        "Eket",
        "Esit Eket",
        "Essien Udim",
        "Etim Ekpo",
        "Etinan",
        "Ibeno",
        "Ibesikpo Asutan",
        "Ibiono Ibom",
        "Ika",
        "Ikono",
        "Ikot Abasi",
        "Ikot Ekpene",
        "Ini",
        "Itu",
        "Mbo",
        "Mkpat Enin",
        "Nsit Atai",
        "Nsit Ibom",
        "Nsit Ubium",
        "Obot Akara",
        "Okobo",
        "Onna",
        "Oron",
        "Oruk Anam",
        "Udung Uko",
        "Ukanafun",
        "Uruan",
        "Urue-Offong/Oruko ",
        "Uyo"
    ],
    "Bauchi": [
        "Alkaleri",
        "Bauchi",
        "Bogoro",
        "Damban",
        "Darazo",
        "Dass",
        "Ganjuwa",
        "Giade",
        "Itas/Gadau",
        "Jama'are",
        "Katagum",
        "Kirfi",
        "Misau",
        "Ningi",
        "Shira",
        "Tafawa-Balewa",
        "Toro",
        "Warji",
        "Zaki"
    ],
    "Bayelsa": [
        "Brass",
        "Ekeremor",
        "Kolokuma/Opokuma",
        "Nembe",
        "Ogbia",
        "Sagbama",
        "Southern Jaw",
        "Yenegoa"
    ],
    "Benue": [
        "Ado",
        "Agatu",
        "Apa",
        "Buruku",
        "Gboko",
        "Guma",
        "Gwer East",
        "Gwer West",
        "Katsina-Ala",
        "Konshisha",
        "Kwande",
        "Logo",
        "Makurdi",
        "Obi",
        "Ogbadibo",
        "Oju",
        "Okpokwu",
        "Ohimini",
        "Oturkpo",
        "Tarka",
        "Ukum",
        "Ushongo",
        "Vandeikya"
    ],
    "Borno": [
        "Abadam",
        "Askira/Uba",
        "Bama",
        "Bayo",
        "Biu",
        "Chibok",
        "Damboa",
        "Dikwa",
        "Gubio",
        "Guzamala",
        "Gwoza",
        "Hawul",
        "Jere",
        "Kaga",
        "Kala/Balge",
        "Konduga",
        "Kukawa",
        "Kwaya Kusar",
        "Mafa",
        "Magumeri",
        "Maiduguri",
        "Marte",
        "Mobbar",
        "Monguno",
        "Ngala",
        "Nganzai",
        "Shani"
    ],
    "Cross River": [
        "Akpabuyo",
        "Odukpani",
        "Akamkpa",
        "Biase",
        "Abi",
        "Ikom",
        "Yarkur",
        "Odubra",
        "Boki",
        "Ogoja",
        "Yala",
        "Obanliku",
        "Obudu",
        "Calabar South",
        "Etung",
        "Bekwara",
        "Bakassi",
        "Calabar Municipality"
    ],
    "Delta": [
        "Oshimili",
        "Aniocha",
        "Aniocha South",
        "Ika South",
        "Ika North-East",
        "Ndokwa West",
        "Ndokwa East",
        "Isoko south",
        "Isoko North",
        "Bomadi",
        "Burutu",
        "Ughelli South",
        "Ughelli North",
        "Ethiope West",
        "Ethiope East",
        "Sapele",
        "Okpe",
        "Warri North",
        "Warri South",
        "Uvwie",
        "Udu",
        "Warri Central",
        "Ukwani",
        "Oshimili North",
        "Patani"
    ],
    "Ebonyi": [
        "Edda",
        "Afikpo",
        "Onicha",
        "Ohaozara",
        "Abakaliki",
        "Ishielu",
        "lkwo",
        "Ezza",
        "Ezza South",
        "Ohaukwu",
        "Ebonyi",
        "Ivo"
    ],
    "Enugu": [
        "Enugu South,",
        "Igbo-Eze South",
        "Enugu North",
        "Nkanu",
        "Udi Agwu",
        "Oji-River",
        "Ezeagu",
        "IgboEze North",
        "Isi-Uzo",
        "Nsukka",
        "Igbo-Ekiti",
        "Uzo-Uwani",
        "Enugu Eas",
        "Aninri",
        "Nkanu East",
        "Udenu."
    ],
    "Edo": [
        "Esan North-East",
        "Esan Central",
        "Esan West",
        "Egor",
        "Ukpoba",
        "Central",
        "Etsako Central",
        "Igueben",
        "Oredo",
        "Ovia SouthWest",
        "Ovia South-East",
        "Orhionwon",
        "Uhunmwonde",
        "Etsako East",
        "Esan South-East"
    ],
    "Ekiti": [
        "Ado",
        "Ekiti-East",
        "Ekiti-West",
        "Emure/Ise/Orun",
        "Ekiti South-West",
        "Ikere",
        "Irepodun",
        "Ijero,",
        "Ido/Osi",
        "Oye",
        "Ikole",
        "Moba",
        "Gbonyin",
        "Efon",
        "Ise/Orun",
        "Ilejemeje."
    ],
    "FCT": [
        "Abaji",
        "Abuja Municipal",
        "Bwari",
        "Gwagwalada",
        "Kuje",
        "Kwali"
    ],
    "Gombe": [
        "Akko",
        "Balanga",
        "Billiri",
        "Dukku",
        "Kaltungo",
        "Kwami",
        "Shomgom",
        "Funakaye",
        "Gombe",
        "Nafada/Bajoga",
        "Yamaltu/Delta."
    ],
    "Imo": [
        "Aboh-Mbaise",
        "Ahiazu-Mbaise",
        "Ehime-Mbano",
        "Ezinihitte",
        "Ideato North",
        "Ideato South",
        "Ihitte/Uboma",
        "Ikeduru",
        "Isiala Mbano",
        "Isu",
        "Mbaitoli",
        "Mbaitoli",
        "Ngor-Okpala",
        "Njaba",
        "Nwangele",
        "Nkwerre",
        "Obowo",
        "Oguta",
        "Ohaji/Egbema",
        "Okigwe",
        "Orlu",
        "Orsu",
        "Oru East",
        "Oru West",
        "Owerri-Municipal",
        "Owerri North",
        "Owerri West"
    ],
    "Jigawa": [
        "Auyo",
        "Babura",
        "Birni Kudu",
        "Biriniwa",
        "Buji",
        "Dutse",
        "Gagarawa",
        "Garki",
        "Gumel",
        "Guri",
        "Gwaram",
        "Gwiwa",
        "Hadejia",
        "Jahun",
        "Kafin Hausa",
        "Kaugama Kazaure",
        "Kiri Kasamma",
        "Kiyawa",
        "Maigatari",
        "Malam Madori",
        "Miga",
        "Ringim",
        "Roni",
        "Sule-Tankarkar",
        "Taura",
        "Yankwashi"
    ],
    "Kaduna": [
        "Birni-Gwari",
        "Chikun",
        "Giwa",
        "Igabi",
        "Ikara",
        "jaba",
        "Jema'a",
        "Kachia",
        "Kaduna North",
        "Kaduna South",
        "Kagarko",
        "Kajuru",
        "Kaura",
        "Kauru",
        "Kubau",
        "Kudan",
        "Lere",
        "Makarfi",
        "Sabon-Gari",
        "Sanga",
        "Soba",
        "Zango-Kataf",
        "Zaria"
    ],
    "Kano": [
        "Ajingi",
        "Albasu",
        "Bagwai",
        "Bebeji",
        "Bichi",
        "Bunkure",
        "Dala",
        "Dambatta",
        "Dawakin Kudu",
        "Dawakin Tofa",
        "Doguwa",
        "Fagge",
        "Gabasawa",
        "Garko",
        "Garum",
        "Mallam",
        "Gaya",
        "Gezawa",
        "Gwale",
        "Gwarzo",
        "Kabo",
        "Kano Municipal",
        "Karaye",
        "Kibiya",
        "Kiru",
        "kumbotso",
        "Ghari",
        "Kura",
        "Madobi",
        "Makoda",
        "Minjibir",
        "Nasarawa",
        "Rano",
        "Rimin Gado",
        "Rogo",
        "Shanono",
        "Sumaila",
        "Takali",
        "Tarauni",
        "Tofa",
        "Tsanyawa",
        "Tudun Wada",
        "Ungogo",
        "Warawa",
        "Wudil"
    ],
    "Katsina": [
        "Bakori",
        "Batagarawa",
        "Batsari",
        "Baure",
        "Bindawa",
        "Charanchi",
        "Dandume",
        "Danja",
        "Dan Musa",
        "Daura",
        "Dutsi",
        "Dutsin-Ma",
        "Faskari",
        "Funtua",
        "Ingawa",
        "Jibia",
        "Kafur",
        "Kaita",
        "Kankara",
        "Kankia",
        "Katsina",
        "Kurfi",
        "Kusada",
        "Mai'Adua",
        "Malumfashi",
        "Mani",
        "Mashi",
        "Matazuu",
        "Musawa",
        "Rimi",
        "Sabuwa",
        "Safana",
        "Sandamu",
        "Zango"
    ],
    "Kebbi": [
        "Aleiro",
        "Arewa-Dandi",
        "Argungu",
        "Augie",
        "Bagudo",
        "Birnin Kebbi",
        "Bunza",
        "Dandi",
        "Fakai",
        "Gwandu",
        "Jega",
        "Kalgo",
        "Koko/Besse",
        "Maiyama",
        "Ngaski",
        "Sakaba",
        "Shanga",
        "Suru",
        "Wasagu/Danko",
        "Yauri",
        "Zuru"
    ],
    "Kogi": [
        "Adavi",
        "Ajaokuta",
        "Ankpa",
        "Bassa",
        "Dekina",
        "Ibaji",
        "Idah",
        "Igalamela-Odolu",
        "Ijumu",
        "Kabba/Bunu",
        "Kogi",
        "Lokoja",
        "Mopa-Muro",
        "Ofu",
        "Ogori/Mangongo",
        "Okehi",
        "Okene",
        "Olamabolo",
        "Omala",
        "Yagba East",
        "Yagba West"
    ],
    "Kwara": [
        "Asa",
        "Baruten",
        "Edu",
        "Ekiti",
        "Ifelodun",
        "Ilorin East",
        "Ilorin West",
        "Irepodun",
        "Isin",
        "Kaiama",
        "Moro",
        "Offa",
        "Oke-Ero",
        "Oyun",
        "Pategi"
    ],
    "Lagos": [
        "Agege",
        "Ajeromi-Ifelodun",
        "Alimosho",
        "Amuwo-Odofin",
        "Apapa",
        "Badagry",
        "Epe",
        "Eti-Osa",
        "Ibeju/Lekki",
        "Ifako-Ijaye",
        "Ikeja",
        "Ikorodu",
        "Kosofe",
        "Lagos Island",
        "Lagos Mainland",
        "Mushin",
        "Ojo",
        "Oshodi-Isolo",
        "Shomolu",
        "Surulere"
    ],
    "Nasarawa": [
        "Akwanga",
        "Awe",
        "Doma",
        "Karu",
        "Keana",
        "Keffi",
        "Kokona",
        "Lafia",
        "Nasarawa",
        "Nasarawa-Eggon",
        "Obi",
        "Toto",
        "Wamba"
    ],
    "Niger": [
        "Agaie",
        "Agwara",
        "Bida",
        "Borgu",
        "Bosso",
        "Chanchaga",
        "Edati",
        "Gbako",
        "Gurara",
        "Katcha",
        "Kontagora",
        "Lapai",
        "Lavun",
        "Magama",
        "Mariga",
        "Mashegu",
        "Mokwa",
        "Muya",
        "Pailoro",
        "Rafi",
        "Rijau",
        "Shiroro",
        "Suleja",
        "Tafa",
        "Wushishi"
    ],
    "Ogun": [
        "Abeokuta North",
        "Abeokuta South",
        "Ado-Odo/Ota",
        "Yewa North",
        "Yewa South",
        "Ewekoro",
        "Ifo",
        "Ijebu East",
        "Ijebu North",
        "Ijebu North East",
        "Ijebu Ode",
        "Ikenne",
        "Imeko-Afon",
        "Ipokia",
        "Obafemi-Owode",
        "Ogun Waterside",
        "Odeda",
        "Odogbolu",
        "Remo North",
        "Shagamu"
    ],
    "Ondo": [
        "Akoko North East",
        "Akoko North West",
        "Akoko South Akure East",
        "Akoko South West",
        "Akure North",
        "Akure South",
        "Ese-Odo",
        "Idanre",
        "Ifedore",
        "Ilaje",
        "Ile-Oluji",
        "Okeigbo",
        "Irele",
        "Odigbo",
        "Okitipupa",
        "Ondo East",
        "Ondo West",
        "Ose",
        "Owo"
    ],
    "Osun": [
        "Aiyedade",
        "Aiyedire",
        "Atakumosa East",
        "Atakumosa West",
        "Boluwaduro",
        "Boripe",
        "Ede North",
        "Ede South",
        "Egbedore",
        "Ejigbo",
        "Ife Central",
        "Ife East",
        "Ife North",
        "Ife South",
        "Ifedayo",
        "Ifelodun",
        "Ila",
        "Ilesha East",
        "Ilesha West",
        "Irepodun",
        "Irewole",
        "Isokan",
        "Iwo",
        "Obokun",
        "Odo-Otin",
        "Ola-Oluwa",
        "Olorunda",
        "Oriade",
        "Orolu",
        "Osogbo"
    ],
    "Oyo": [
        "Afijio",
        "Akinyele",
        "Atiba",
        "Atisbo",
        "Egbeda",
        "Ibadan Central",
        "Ibadan North",
        "Ibadan North West",
        "Ibadan South East",
        "Ibadan South West",
        "Ibarapa Central",
        "Ibarapa East",
        "Ibarapa North",
        "Ido",
        "Irepo",
        "Iseyin",
        "Itesiwaju",
        "Iwajowa",
        "Kajola",
        "Lagelu Ogbomosho North",
        "Ogbomosho South",
        "Ogo Oluwa",
        "Olorunsogo",
        "Oluyole",
        "Ona-Ara",
        "Orelope",
        "Ori Ire",
        "Oyo East",
        "Oyo West",
        "Saki East",
        "Saki West",
        "Surulere"
    ],
    "Plateau": [
        "Barikin Ladi",
        "Bassa",
        "Bokkos",
        "Jos East",
        "Jos North",
        "Jos South",
        "Kanam",
        "Kanke",
        "Langtang North",
        "Langtang South",
        "Mangu",
        "Mikang",
        "Pankshin",
        "Qua'an Pan",
        "Riyom",
        "Shendam",
        "Wase"
    ],
    "Rivers": [
        "Abua/Odual",
        "Ahoada East",
        "Ahoada West",
        "Akuku Toru",
        "Andoni",
        "Asari-Toru",
        "Bonny",
        "Degema",
        "Emohua",
        "Eleme",
        "Etche",
        "Gokana",
        "Ikwerre",
        "Khana",
        "Obio/Akpor",
        "Ogba/Egbema/Ndoni",
        "Ogu/Bolo",
        "Okrika",
        "Omumma",
        "Opobo/Nkoro",
        "Oyigbo",
        "Port-Harcourt",
        "Tai"
    ],
    "Sokoto": [
        "Binji",
        "Bodinga",
        "Dange-shnsi",
        "Gada",
        "Goronyo",
        "Gudu",
        "Gawabawa",
        "Illela",
        "Isa",
        "Kware",
        "kebbe",
        "Rabah",
        "Sabon birni",
        "Shagari",
        "Silame",
        "Sokoto North",
        "Sokoto South",
        "Tambuwal",
        "Tqngaza",
        "Tureta",
        "Wamako",
        "Wurno",
        "Yabo"
    ],
    "Taraba": [
        "Ardo-kola",
        "Bali",
        "Donga",
        "Gashaka",
        "Cassol",
        "Ibi",
        "Jalingo",
        "Karin-Lamido",
        "Kurmi",
        "Lau",
        "Sardauna",
        "Takum",
        "Ussa",
        "Wukari",
        "Yorro",
        "Zing"
    ],
    "Yobe": [
        "Bade",
        "Bursari",
        "Damaturu",
        "Fika",
        "Fune",
        "Geidam",
        "Gujba",
        "Gulani",
        "Jakusko",
        "Karasuwa",
        "Karawa",
        "Machina",
        "Nangere",
        "Nguru Potiskum",
        "Tarmua",
        "Yunusari",
        "Yusufari"
    ],
    "Zamfara": [
        "Anka",
        "Bakura",
        "Birnin Magaji",
        "Bukkuyum",
        "Bungudu",
        "Gummi",
        "Gusau",
        "Kaura",
        "Namoda",
        "Maradun",
        "Maru",
        "Shinkafi",
        "Talata Mafara",
        "Tsafe",
        "Zurmi"
    ]
      };

      const stateSelect = document.getElementById('state');
      const lgaSelect = document.getElementById('lga');

      // Populate states
      Object.keys(stateAndLGAs).forEach(state => {
        const option = document.createElement('option');
        option.value = state;
        option.textContent = state;
        stateSelect.appendChild(option);
      });

      // Populate LGAs when state is selected
      stateSelect.addEventListener('change', function () {
        const selectedState = this.value;
        lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';

        if (stateAndLGAs[selectedState]) {
          stateAndLGAs[selectedState].forEach(lga => {
            const option = document.createElement('option');
            option.value = lga;
            option.textContent = lga;
            lgaSelect.appendChild(option);
          });
        }
      });
    });



document.addEventListener('DOMContentLoaded', function () {
  const shareBtn = document.getElementById('webShareBtn');
  if (shareBtn) {
    shareBtn.addEventListener('click', function () {
      const title = shareBtn.getAttribute('data-title');
      const url = shareBtn.getAttribute('data-url');

      if (navigator.share) {
        navigator.share({
          title: title,
          text: title,
          url: url
        }).catch(err => {
          console.error('Share failed:', err);
        });
      } else {
        alert('Sharing is not supported in this browser. Please use the social icons.');
      }
    });
  }
});
document.addEventListener('DOMContentLoaded', function() {
  function setupReadMore(section) {
    var readMoreBtn = section.querySelector('.read-more-btn');
    var readLessBtn = section.querySelector('.read-less-btn');
    var shortDesc = section.querySelector('.short-desc');
    var fullDesc = section.querySelector('.full-desc');
    if(readMoreBtn && readLessBtn && shortDesc && fullDesc) {
      readMoreBtn.addEventListener('click', function() {
        shortDesc.style.display = 'none';
        fullDesc.style.display = 'inline';
        readMoreBtn.style.display = 'none';
        readLessBtn.style.display = 'inline';
      });
      readLessBtn.addEventListener('click', function() {
        shortDesc.style.display = 'inline';
        fullDesc.style.display = 'none';
        readMoreBtn.style.display = 'inline';
        readLessBtn.style.display = 'none';
      });
    }
  }
  document.querySelectorAll('.collapsible-section').forEach(setupReadMore);
});

/*

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-description').forEach(function (container) {
        var readMoreBtn = container.querySelector('.read-more-desc');
        var readLessBtn = container.querySelector('.read-less-desc');
        var shortDesc = container.querySelector('.desc-short');
        var fullDesc = container.querySelector('.desc-full');
        if (readMoreBtn && readLessBtn && shortDesc && fullDesc) {
            readMoreBtn.addEventListener('click', function () {
                shortDesc.style.display = 'none';
                fullDesc.style.display = 'inline';
                readMoreBtn.style.display = 'none';
                readLessBtn.style.display = 'inline';
            });
            readLessBtn.addEventListener('click', function () {
                shortDesc.style.display = 'inline';
                fullDesc.style.display = 'none';
                readMoreBtn.style.display = 'inline';
                readLessBtn.style.display = 'none';
            });
        }
    });
});

*/
//reviews load more
document.addEventListener('DOMContentLoaded', function() {
  var reviews = document.querySelectorAll('.reviews-list .review-item');
  var loadMoreBtn = document.getElementById('loadMoreReviews');
  var shown = 3;
  var perClick = 3;

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
      var next = shown + perClick;
      for (var i = shown; i < next && i < reviews.length; i++) {
        reviews[i].style.display = '';
      }
      shown = next;
      if (shown >= reviews.length) {
        loadMoreBtn.style.display = 'none';
      }
    });
  }
});


function togglePricingFields() {
  var pricing = document.getElementById('pricingSelect').value;
  document.getElementById('donationFields').style.display = (pricing === 'donation') ? 'block' : 'none';
  document.getElementById('freeFields').style.display = (pricing === 'free') ? 'block' : 'none';
  document.getElementById('paidFields').style.display = (pricing === 'paid') ? 'block' : 'none';
}
function showReplyForm(commentId) {
  var form = document.getElementById('reply-form-' + commentId);
  if (form.style.display === 'none') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}

function toggleReplies(commentId) {
  var replies = document.getElementById('replies-' + commentId);
  if (replies.style.display === 'none') {
    replies.style.display = 'block';
  } else {
    replies.style.display = 'none';
  }
}


function displayInstructorInfo() {
  var select = document.getElementById('instructorSelect');
  var selected = select.options[select.selectedIndex];
  var infoDiv = document.getElementById('instructorInfo');
  var addFields = document.getElementById('addInstructorFields');
  if (select.value === "add_new") {
    infoDiv.style.display = "none";
    addFields.style.display = "block";
  } else if (select.value !== "") {
    document.getElementById('instructorPhoto').src = selected.getAttribute('data-photo');
    document.getElementById('instructorName').textContent = selected.getAttribute('data-name');
    infoDiv.style.display = "block";
    addFields.style.display = "none";
  } else {
    infoDiv.style.display = "none";
    addFields.style.display = "none";
  }
}

function toggleDeliveryFields() {
  const format = document.getElementById('deliveryFormat').value;

  // List of all section IDs
  const sections = [
    'physicalFields',
    'onlineFields',
    'hybridFields',
    'videoFields',
    'textFields'
  ];

  // Hide all first
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
  });

  // Show only the selected one
  if (format === 'physical') {
    document.getElementById('physicalFields').style.display = 'block';
  } 
  else if (format === 'online') {
    document.getElementById('onlineFields').style.display = 'block';
  } 
  else if (format === 'hybrid') {
    document.getElementById('hybridFields').style.display = 'block';
    toggleHybridLocationFields(); // Still call this if needed
  } 
  else if (format === 'video') {
    document.getElementById('videoFields').style.display = 'block';
  } 
  else if (format === 'text') {
    document.getElementById('textFields').style.display = 'block';
  }
      else if (format === 'video_text') {
    document.getElementById('videoFields').style.display = 'block';
    document.getElementById('textFields').style.display = 'block';
  }
}

function togglePhysicalLocationFields() {
  const type = document.getElementById('physicalLocationType').value;
  document.getElementById('nigeriaPhysicalFields').style.display = (type === 'nigeria') ? 'block' : 'none';
  document.getElementById('foreignPhysicalFields').style.display = (type === 'foreign') ? 'block' : 'none';
}


function addVideoModule() {
  const container = document.getElementById('videoModules');
  const firstModule = container.querySelector('.video-module');
  const newModule = firstModule.cloneNode(true);

  const moduleCount = container.querySelectorAll('.video-module').length + 1;
  newModule.querySelector('.module-number').textContent = moduleCount;

  // Clean cloned TinyMCE UI
  newModule.querySelectorAll('.tox').forEach(el => el.remove());

  // Reset fields
  newModule.querySelectorAll('input, textarea').forEach(el => {
    if (el.type === 'checkbox' || el.type === 'radio') {
      el.checked = false;
    } else {
      el.value = '';
    }

    if (el.classList.contains('editor')) {
      el.removeAttribute('aria-hidden');
      el.style.display = '';
      el.id = `video_editor_${moduleCount}`;
    }
  });

  // Add Remove button (only for cloned modules)
  const removeBtn = document.createElement('button');
  removeBtn.type = 'button';
  removeBtn.className = 'remove-module';
  removeBtn.innerHTML = '❌ Remove';
  removeBtn.onclick = function () {
    newModule.remove();
    updateModuleNumbers(container, '.video-module');
  };
  newModule.appendChild(removeBtn);

  container.appendChild(newModule);

  initTinyMCE(`#video_editor_${moduleCount}`);
}

function addTextModule() {
  const container = document.getElementById('textModules');
  const firstModule = container.querySelector('.text-module');
  const newModule = firstModule.cloneNode(true);

  const moduleCount = container.querySelectorAll('.text-module').length + 1;
  newModule.querySelector('.module-number').textContent = moduleCount;

  // Clean cloned TinyMCE UI
  newModule.querySelectorAll('.tox').forEach(el => el.remove());

  // Reset fields
  newModule.querySelectorAll('input, textarea').forEach(el => {
    if (el.type === 'checkbox' || el.type === 'radio') {
      el.checked = false;
    } else {
      el.value = '';
    }

    if (el.classList.contains('editor')) {
      el.removeAttribute('aria-hidden');
      el.style.display = '';
      el.id = `text_editor_${moduleCount}`;
    }
  });

  // Add Remove button (only for cloned modules)
  const removeBtn = document.createElement('button');
  removeBtn.type = 'button';
  removeBtn.className = 'remove-module';
  removeBtn.innerHTML = '❌ Remove';
  removeBtn.onclick = function () {
    newModule.remove();
    updateModuleNumbers(container, '.text-module');
  };
  newModule.appendChild(removeBtn);

  container.appendChild(newModule);

  initTinyMCE(`#text_editor_${moduleCount}`);
}

// Re-number modules after removal
function updateModuleNumbers(container, selector) {
  container.querySelectorAll(selector).forEach((module, index) => {
    module.querySelector('.module-number').textContent = index + 1;
  });
}

function initTinyMCE(selector) {
  tinymce.init({
    selector: selector,
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' }
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
}


function toggleHybridLocationFields() {
  const type = document.getElementById('hybridLocationType').value;
  document.getElementById('nigeriaHybridFields').style.display = (type === 'nigeria') ? 'block' : 'none';
  document.getElementById('foreignHybridFields').style.display = (type === 'foreign') ? 'block' : 'none';
}

function addDateTimeRow() {
  const container = document.getElementById('dateTimeRepeater');
  const row = document.createElement('div');
  row.className = 'row mb-2 dateTimeRow';
  row.innerHTML = `
    <div class="col">
      <input type="date" class="form-control" name="event_dates[]" required>
    </div>
    <div class="col">
      <input type="time" class="form-control" name="event_start_times[]" required>
    </div>
    <div class="col">
      <input type="time" class="form-control" name="event_end_times[]" required>
    </div>
    <div class="col-auto">
      <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.dateTimeRow').remove()">-</button>
    </div>
  `;
  container.appendChild(row);

  const today = new Date().toISOString().split('T')[0];
  const dateInput = row.querySelector('input[name="event_dates[]"]');
  const startTimeInput = row.querySelector('input[name="event_start_times[]"]');
  const endTimeInput = row.querySelector('input[name="event_end_times[]"]');
  dateInput.setAttribute('min', today);

  // Helper to check and reset invalid time
  function validateTime(input) {
    if (dateInput.value === today && input.value) {
      const now = new Date();
      const [h, m] = input.value.split(':');
      const selected = new Date();
      selected.setHours(h, m, 0, 0);
      if (selected < now) {
        input.value = '';
        input.setCustomValidity('Please select a future time.');
        input.reportValidity();
      } else {
        input.setCustomValidity('');
      }
    } else {
      input.setCustomValidity('');
    }
  }

  dateInput.addEventListener('change', function() {
    if (dateInput.value === today) {
      const now = new Date();
      const minTime = now.toTimeString().slice(0,5);
      startTimeInput.min = minTime;
      endTimeInput.min = minTime;
      validateTime(startTimeInput);
      validateTime(endTimeInput);
    } else {
      startTimeInput.removeAttribute('min');
      endTimeInput.removeAttribute('min');
      startTimeInput.setCustomValidity('');
      endTimeInput.setCustomValidity('');
    }
  });

  startTimeInput.addEventListener('input', function() {
    validateTime(startTimeInput);
  });
  endTimeInput.addEventListener('input', function() {
    validateTime(endTimeInput);
  });
}

function toggleQuizOption(option) {
  document.getElementById('quizText').style.display = 'none';
  document.getElementById('quizUpload').style.display = 'none';
  document.getElementById('quizFormButton').style.display = 'none';

  if (option === 'text') {
    document.getElementById('quizText').style.display = 'block';
  } else if (option === 'upload') {
    document.getElementById('quizUpload').style.display = 'block';
  } else if (option === 'form') {
    document.getElementById('quizFormButton').style.display = 'block';
  }
}

function openQuizModal() {
  document.getElementById('quizModal').style.display = 'block';
}

function closeQuizModal() {
  document.getElementById('quizModal').style.display = 'none';
}

let questionCounter = 1;

function addQuizQuestionModal() {
  const originalBlock = document.querySelector('.question-block');

  // Clone original block
  const clone = originalBlock.cloneNode(true);
  questionCounter++;

  // Remove any existing TinyMCE editor DOM wrappers from the clone
  const oldEditorWrapper = clone.querySelector('.tox-tinymce');
  if (oldEditorWrapper) {
    // Replace the entire TinyMCE wrapper with a new textarea
    const newTextarea = document.createElement('textarea');
    newTextarea.name = 'questions[]';
    newTextarea.placeholder = 'Question';
    newTextarea.className = 'form-control mb-2 editor';
    newTextarea.id = `question_editor_${questionCounter}`;

    oldEditorWrapper.parentNode.replaceChild(newTextarea, oldEditorWrapper);
  } else {
    // Fallback: if somehow there's no wrapper, still update the ID
    const textarea = clone.querySelector('textarea[name="questions[]"]');
    if (textarea) {
      textarea.id = `question_editor_${questionCounter}`;
      textarea.value = '';
    }
  }

  // Reset inputs
  clone.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
  clone.querySelector('select[name="correct_answer[]"]').selectedIndex = 0;

  // Remove existing remove button
  const oldRemoveBtn = clone.querySelector('.remove-question');
  if (oldRemoveBtn) oldRemoveBtn.remove();

  // Add new remove button
  const removeBtn = document.createElement('button');
  removeBtn.type = 'button';
  removeBtn.className = 'btn btn-danger remove-question';
  removeBtn.innerHTML = '🗑️ Remove';
  const hr = clone.querySelector('hr');
  clone.insertBefore(removeBtn, hr);

  // Append clone to DOM
  document.getElementById('quizBuilderModal').appendChild(clone);

  // Init TinyMCE on new textarea
  tinymce.init({
    selector: `#question_editor_${questionCounter}`,
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
}

// 🗑️ Remove cloned question blocks
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-question')) {
    const block = e.target.closest('.question-block');
    const editor = block.querySelector('textarea.editor');
    if (editor && tinymce.get(editor.id)) {
      tinymce.get(editor.id).remove();
    }
    block.remove();
  }
});





function updateCartCount(count) {
  const cartCountElement = document.querySelector('.cart-count');
  if (cartCountElement) {
    cartCountElement.textContent = count;
  }
}



function updateWishlistCount(count) {
  const wishlistCountElement = document.querySelector('.wishlist-count');
  if (wishlistCountElement) {
    wishlistCountElement.textContent = count;
  }
}


document.addEventListener('DOMContentLoaded', function () {
  const today = new Date().toISOString().split('T')[0];

  document.querySelectorAll('input[name="event_dates[]"]').forEach(function (dateInput) {
    dateInput.setAttribute('min', today);

    const row = dateInput.closest('.dateTimeRow');
    if (row) {
      const startTimeInput = row.querySelector('input[name="event_start_times[]"]');
      const endTimeInput = row.querySelector('input[name="event_end_times[]"]');

      // Helper to check and reset invalid time
      function validateTime(input) {
        if (dateInput.value === today && input.value) {
          const now = new Date();
          const [h, m] = input.value.split(':');
          const selected = new Date();
          selected.setHours(h, m, 0, 0);
          if (selected < now) {
            input.value = '';
            input.setCustomValidity('Please select a future time.');
            input.reportValidity();
          } else {
            input.setCustomValidity('');
          }
        } else {
          input.setCustomValidity('');
        }
      }

      // Initial check if value is already today
      if (dateInput.value === today) {
        const now = new Date();
        const minTime = now.toTimeString().slice(0, 5);
        if (startTimeInput) startTimeInput.min = minTime;
        if (endTimeInput) endTimeInput.min = minTime;
        validateTime(startTimeInput);
        validateTime(endTimeInput);
      }

      dateInput.addEventListener('change', function () {
        if (dateInput.value === today) {
          const now = new Date();
          const minTime = now.toTimeString().slice(0, 5);
          if (startTimeInput) startTimeInput.min = minTime;
          if (endTimeInput) endTimeInput.min = minTime;
          validateTime(startTimeInput);
          validateTime(endTimeInput);
        } else {
          if (startTimeInput) {
            startTimeInput.removeAttribute('min');
            startTimeInput.setCustomValidity('');
          }
          if (endTimeInput) {
            endTimeInput.removeAttribute('min');
            endTimeInput.setCustomValidity('');
          }
        }
      });

      if (startTimeInput) {
        startTimeInput.addEventListener('input', function () {
          validateTime(startTimeInput);
        });
      }
      if (endTimeInput) {
        endTimeInput.addEventListener('input', function () {
          validateTime(endTimeInput);
        });
      }
    }
  });
});


    document.addEventListener("DOMContentLoaded", function () {
        const paystackButton = document.querySelector(".paystack-button");
        const manualButton = document.querySelector(".manual-button");
        const paymentMethods = document.querySelectorAll("input[name='payment_method']");

        paymentMethods.forEach(method => {
            method.addEventListener("change", function () {
                if (this.value === "paystack") {
                    paystackButton.style.display = "block";
                    manualButton.style.display = "none";
                } else if (this.value === "manual") {
                    paystackButton.style.display = "none";
                    manualButton.style.display = "block";
                }
            });
        });
    });
//password


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-module').forEach(function (button) {
    button.addEventListener('click', function () {
      const moduleId = this.getAttribute('data-module-id');

      if (!moduleId) {
        alert('Module ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video module?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideomodule&module_id=${moduleId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        if (cleaned.includes('success')) {
          this.closest('.video-module')?.remove();
          alert('Video module deleted successfully.');
        } else {
          alert('Failed to delete video module: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-texts-module').forEach(function (button) {
    button.addEventListener('click', function () {
      const moduleId = this.getAttribute('data-module-id');

      if (!moduleId) {
        alert('Module ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this text module?')) {
        return;
      }

      fetch(`delete_image.php?action=deletetextmodule&module_id=${moduleId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        if (data.trim().toLowerCase().includes('success')) {
          this.closest('.text-module')?.remove();
          alert('Text module deleted successfully.');
        } else {
          alert('Failed to delete text module: ' + data);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-trailer').forEach(function (button) {
    button.addEventListener('click', function () {
      const videoId = this.getAttribute('data-video-id');

      if (!videoId) {
        alert('Video ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideotrailer&video_id=${videoId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug log

        if (cleaned.includes('success')) {
          this.closest('li')?.remove();
          alert('Video deleted successfully.');
        } else {
          alert('Failed to delete video: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});



document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-promo').forEach(function (button) {
    button.addEventListener('click', function () {
      const videoId = this.getAttribute('data-video-id');

      if (!videoId) {
        alert('Video ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideopromo&video_id=${videoId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug log

        if (cleaned.includes('success')) {
          this.closest('li')?.remove();
          alert('Video deleted successfully.');
        } else {
          alert('Failed to delete video: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});


document.querySelectorAll('.delete-image').forEach(button => {
  button.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this image?')) {
          let imageId = this.getAttribute('data-image-id');
          fetch(`delete_image.php?action=deleteimage&image_id=${imageId}`, {
              method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  this.closest('.image-preview').remove();
                  showToast('Image deleted successfully.');
              } else {
                  alert('Failed to delete image.');
              }
          })
          .catch(error => {
              console.error('Error deleting image:', error);
          });
      }
  });
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-lesson').forEach(function (button) {
    button.addEventListener('click', function () {
      const videoId = this.getAttribute('data-video-id');

      if (!videoId) {
        alert('Video ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideo&video_id=${videoId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug log

        if (cleaned.includes('success')) {
          this.closest('li')?.remove(); // Remove the <li> that contains the video
          alert('Video deleted successfully.');
        } else {
          alert('Failed to delete video: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});



document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-text-module').forEach(function (button) {
    button.addEventListener('click', function () {
      const textId = this.getAttribute('data-id');

      if (!textId) {
        alert('Text ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this document?')) {
        return;
      }

      fetch(`delete_image.php?action=deletetext&text_id=${textId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug

        if (cleaned.includes('success')) {
          this.closest('li')?.remove(); // Remove <li> containing the button
          alert('Text module deleted successfully.');
        } else {
          alert('Failed to delete text module: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});



document.querySelectorAll('a.delete').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});

function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const parent = passwordField.parentElement; // input-group
  const icon = parent.querySelector('i'); // icon inside the same input-group
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    icon.classList.remove('bi-eye');
    icon.classList.add('bi-eye-slash');
  } else {
    passwordField.type = 'password';
    icon.classList.remove('bi-eye-slash');
    icon.classList.add('bi-eye');
  }
}

   // If using jQuery.noConflict()
$(document).ready(function() {
  $('.select2').select2();
});

//add to cart
$(document).ready(function(){
    $("#addCart").click(function(){
        var selectedIds = $('input[name="variation_ids[]"]:checked')
                          .map(function(){ return $(this).val(); })
                          .get()
                          .join(',');

        var training_id = $('#current_training_id').val();
        var user_id = $('#user_id').val();
        var order_id = $('#order_id').val();
        var siteurl = $('#siteurl').val();
        var affliate_id = $('#affliate_id').val();
        var pricing = $('#pricing').val();

        if (!user_id) {
            window.location.href = siteurl + 'login';
            return;
        }

              if (pricing === 'paid') {
        if (!selectedIds) {
            showToast('Please select at least one variation.');
            return;
        }
      }
        $.ajax({
            url: siteurl + 'add_to_cart',
            type: 'POST',
            data: {
                trainingId: training_id,
                userId: user_id,
                orderId: order_id,
                affliateId: affliate_id,
                variation_ids: selectedIds
            },
            success: function(response){
                let data = typeof response === 'string' ? JSON.parse(response) : response;
                if (data.error) {
                    showToast(data.error);
                } else {
                    showToast('Item added to cart successfully');
                }
                if (data.cartCount) {
                    updateCartCount(data.cartCount);
                }
            },
            error: function(){
                showToast('Error adding to cart');
            }
        });
    });
});





$(document).on('click', '.remove-item', function () {
    const itemId = $(this).data('item-id');
    const siteUrl = $('#siteurl').val();

    if (confirm('Are you sure you want to remove this item?')) {
        $.ajax({
            url: siteUrl + 'delete_cart_item',
            type: 'POST',
            data: { item_id: itemId },
            success: function (response) {
                try {
                    const data = JSON.parse(response);

                    if (data.success) {
                        // Remove the item from the DOM
                        $('#cart-item-' + itemId).remove();

                        // Update cart count and total
                        updateCartCount(data.cartCount);
                        $('.cart-total').text(data.total);

                        // Reload if the cart is now empty
                        if (parseInt(data.cartCount) === 0) {
                            window.location.reload();
                        }

                        showToast('Item deleted from cart successfully');
                    } else {
                        showToast('Error removing item');
                    }
                } catch (e) {
                    console.error('Invalid JSON response:', response);
                    showToast('An unexpected error occurred.');
                }
            },
            error: function () {
                showToast('Failed to communicate with the server.');
            }
        });
    }
});

$(document).ready(function () {
  $("#donateBtn").click(function () {
    var training_id = $(this).data('training-id');
    var order_id = $(this).data('orders_id');
    var affiliate_id = $(this).data('affiliate-id');
    var user_id = $('#user_id').val(); // from your header
    var siteurl = $('#siteurl').val(); // from your header

    // Redirect if not logged in
    if (!user_id) {
      window.location.href = siteurl + 'login';
      return;
    }

    // Build redirect URL
    var redirectUrl = siteurl + 'donate?' +
      'training_id=' + encodeURIComponent(training_id) +
      '&user_id=' + encodeURIComponent(user_id) +
      '&order_id=' + encodeURIComponent(order_id) +
      '&affiliate_id=' + encodeURIComponent(affiliate_id);

    window.location.href = redirectUrl;
  });
});



// Add to wishlist functionality for product detail page
$('.wishlist-btn').click(function(e) {
    e.preventDefault();

    var button = $(this);
    var productId = button.data('product-id');
    var userId = $('#user_id').val();
    var siteurl = $('#siteurl').val();

    if (!userId) {
        window.location.href = siteurl +'login';
        return;
    }
    $.ajax({
        url: siteurl +'addwishlist',
        type: 'POST',
        data: {
            productId: productId,
            user: userId,
        },
        success: function(response) {
            if (response.trim() === 'success') {
                button.addClass('added');
                button.find('i').css('color', 'red'); // Change icon to red
                showToast('Item added to wishlist');
              
            } else if (response.trim() === 'removed') {
                button.removeClass('added');
                button.find('i').css('color', ''); // Reset to default
                showToast('Item removed from wishlist');
                
            } else if (response.trim() === 'redirect') {
                window.location.href = siteurl +'login';
            } else {
                showToast('Failed to update wishlist');
            }
            
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('An error occurred. Please try again.');
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
  const addBtn = document.getElementById('addTicketBtn');
  const wrapper = document.getElementById('ticketWrapper');

  if (addBtn && wrapper) {
    addBtn.addEventListener('click', function () {
      const ticketHTML = `
        <div class="ticket-group mb-4">
          <label class="form-label">Ticket Name</label>
          <input type="text" class="form-control mb-2" name="ticket_name[]" placeholder="e.g. General Admission">

          <label class="form-label">Benefits</label>
          <textarea class="editor mb-2" name="ticket_benefits[]" placeholder="e.g. Certificate, Lunch"></textarea>

          <label class="form-label">Price</label>
          <input type="number" class="form-control mb-2" name="ticket_price[]" min="0" step="0.01" placeholder="e.g. 5000">

          <label class="form-label">Number of Seats Available</label>
          <input type="number" class="form-control" name="ticket_seats[]" min="1" placeholder="e.g. 100">
        </div>
      `;
      wrapper.insertAdjacentHTML('beforeend', ticketHTML);

      // Re-init TinyMCE for new textarea
      tinymce.remove('.editor');
      tinymce.init({
        selector: '.editor',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
          { value: 'First.Name', title: 'First Name' },
          { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) =>
          respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
      });
    });
  }
});
