<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
 <link rel="stylesheet" type="text/css" href="/css/enquiry.css">	
	
  <title>Solar Services</title>
  
</head>
<body>
<!-- Landing Page -->
<div class="landing-container">
  <div class="landing-hero">
    <button id="hero-contact-btn" class="btn-primary">Get a Free Quote</button>
  </div>
</div>

<!-- Modal Overlay -->
<div id="modal-form-overlay" class="modal-form-overlay">
  <div class="modal-form">
    <div class="modal-form-close" id="modal-form-close">
      <svg class="icon" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </div>

    <div class="modal-form-content">
      <?php if ($formSubmitted): ?>
        <!-- Completion Screen -->
        <div class="text-center py-8 space-y-6 success-message" style="max-width: 600px; margin: 0 auto;">
          <div class="flex justify-center mb-4">
            <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
              <svg class="icon text-green-500" style="width: 32px; height: 32px;" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </div>
          </div>
          <h3 class="text-2xl font-semibold mb-2">Thank You!</h3>
          <p class="text-gray-600 mb-6">
            Your request has been submitted. One of our Solar Advisors will call you
            <?php
            if ($callbackTime == "morning") {
              echo "in the morning";
            } elseif ($callbackTime == "afternoon") {
              echo "in the afternoon";
            } elseif ($callbackTime == "anytime") {
              echo "whenever is convenient and you are available";
            } else {
              echo "whenever you are available";
            }
            ?>
            to discuss your requirements.
          </p>
          <button id="new-request-btn" class="btn btn-primary">Submit Another Request</button>
        </div>
      <?php else: ?>
        <div id="solar-form">
          <!-- Display database error if any -->
          <?php if ($dbError): ?>
            <div class="db-error">
              <p><strong>Database Error:</strong> <?php echo $dbError; ?></p>
            </div>
          <?php endif; ?>

          <!-- Step 1: Header (shown in steps 1-3) -->
          <div id="form-header" class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">
              Get a Free <span class="text-red-600">Solar Consultation</span>
            </h1>
            <h2 class="text-xl md:text-2xl font-medium text-gray-800">From America's Leading Provider</h2>
          </div>

          <!-- Progress Bar -->
          <div class="progress-container">
            <div id="progress-bar" class="progress-bar" style="width: 25%;"></div>
          </div>

          <!-- Steps Container -->
          <div class="steps-container">
            <!-- Step 1: Interest Question -->
            <div id="step-1" class="form-step active">
              <div class="mb-6">
                <p class="text-blue-700 font-medium">Question 1 of 3</p>
                <h3 class="text-2xl font-bold mt-2">What are you interested in?</h3>
                <p class="text-xl"></p>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button type="button" class="option-card" data-value="Battery" onclick="selectInterest('Battery')">
                  <div class="icon-container">
                    <img src="/images/battery.svg" alt="Battery Icon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Battery Only</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="Solar" onclick="selectInterest('Solar')">
                  <div class="icon-container">
                    <img src="/images/solar.svg" alt="Solar Icon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Solar Only</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="Solar & Battery" onclick="selectInterest('Solar & Battery')">
                  <div class="icon-container">
                    <img src="/images/solar-battery.svg" alt="Solar and Battery Icon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Solar & Battery</p>
                  </div>
                </button>
              </div>
            </div>

            <!-- Step 2: Property Type -->
            <div id="step-2" class="form-step">
              <div class="mb-6">
                <p class="text-blue-700 font-medium">Question 2 of 3</p>
                <h3 class="text-2xl font-bold mt-2">What type of property is this for?</h3>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <button type="button" class="option-card" data-value="residential" onclick="selectPropertyType('residential')">
                  <div class="icon-container">
                    <img src="/images/residential.svg" alt="Battery Icon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Residential</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="commercial" onclick="selectPropertyType('commercial')">
                  <div class="icon-container">
                    <img src="/images/commercial.svg" alt="Solar Icon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Commercial</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="industrial" onclick="selectPropertyType('industrial')">
                  <div class="icon-container">
                    <img src="/images/industrial.svg" alt="Solar and Battery Icon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Industrial</p>
                  </div>
                </button>
              </div>
            </div>

            <!-- Step 3: Callback Time -->
            <div id="step-3" class="form-step">
              <div class="mb-6">
                <p class="text-blue-700 font-medium">Almost done!</p>
                <h3 class="text-2xl font-bold mt-2">When would you prefer a callback?</h3>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <button type="button" class="option-card" data-value="morning" onclick="selectCallbackTime('morning')">
                  <div class="icon-container">
                    <img src="/images/morning.svg" alt="Morning" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">In the morning</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="afternoon" onclick="selectCallbackTime('afternoon')">
                  <div class="icon-container">
                    <img src="/images/afternoon.svg" alt="Afternoon" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">In the afternoon</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="anytime" onclick="selectCallbackTime('anytime')">
                  <div class="icon-container">
                    <img src="/images/anytime.svg" alt="Anytime" class="w-16 h-16 text-gray-700">
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Anytime</p>
                  </div>
                </button>
              </div>
            </div>

            <!-- Step 4: Contact Information -->
            <div id="step-4" class="form-step">
              <div class="text-center mb-6">
                <h2 class="text-2xl font-bold">
                  Our <span class="text-red-600">Solar Experts</span> are ready to help you!
                </h2>

              </div>

				
              <form id="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="space-y-4">
                <!-- Hidden fields to store previous selections -->
                <input type="hidden" id="interest" name="interest" value="">
                <input type="hidden" id="propertyType" name="propertyType" value="">
                <input type="hidden" id="callbackTime" name="callbackTime" value="">

                <div class="flex border rounded-md overflow-hidden">
                  <div class="bg-gray-100 p-3 flex items-center justify-center">
                    <svg class="icon text-gray-500" viewBox="0 0 24 24">
                      <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                      <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                  </div>
                  <input
                    type="email"
                    name="email"
                    placeholder="Email address"
                    required
                    class="flex-1 p-3 outline-none"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                  >
                </div>
                <?php if (isset($formErrors['email'])): ?>
                  <div class="text-red-500 flex items-center gap-1 text-sm">
                    <span>✕</span> <?php echo $formErrors['email']; ?>
                  </div>
                <?php endif; ?>

                <div class="space-y-1">
                  <div class="flex border rounded-md overflow-hidden <?php echo isset($formErrors['phone']) ? 'border-red-500' : ''; ?>">
                    <div class="bg-gray-100 p-3 flex items-center justify-center min-w-16">
                      <span class="text-gray-700">USA</span>
                    </div>
                    <input
                      type="tel"
                      name="phone"
                      placeholder="+1 209 285 2814"
                      required
                      class="flex-1 p-3 outline-none"
                      value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                    >
                  </div>
                  <?php if (isset($formErrors['phone'])): ?>
                    <div class="text-red-500 flex items-center gap-1 text-sm">
                      <span>✕</span> <?php echo $formErrors['phone']; ?>
                    </div>
                  <?php endif; ?>
                </div>

                <div class="flex border rounded-md overflow-hidden">
                  <div class="bg-gray-100 p-3 flex items-center justify-center">
                    <svg class="icon text-gray-500" viewBox="0 0 24 24">
                      <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                      <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                  </div>
                  <input
                    type="text"
                    name="address"
                    placeholder="Address & Post Code"
                    required
                    class="flex-1 p-3 outline-none"
                    value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>"
                  >
                </div>
                <?php if (isset($formErrors['address'])): ?>
                  <div class="text-red-500 flex items-center gap-1 text-sm">
                    <span>✕</span> <?php echo $formErrors['address']; ?>
                  </div>
                <?php endif; ?>

                <div class="flex items-center gap-2 border p-3 rounded-md <?php echo isset($formErrors['terms']) ? 'border-red-500' : ''; ?>">
                  <input
                    type="checkbox"
                    id="terms"
                    name="terms"
                    class="h-5 w-5"
                    <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>
                  >
                  <label for="terms" class="text-sm">
                    I agree with the <span class="text-blue-600">terms and condition</span>
                  </label>
                </div>
                <?php if (isset($formErrors['terms'])): ?>
                  <div class="text-red-500 flex items-center gap-1 text-sm">
                    <span>✕</span> <?php echo $formErrors['terms']; ?>
                  </div>
                <?php endif; ?>

                <button
                  type="submit"
                  class="w-full bg-red-600 text-white py-2 px-4 rounded-md flex items-center justify-center gap-2 hover:bg-red-700 transition-colors"
                >
                  <span>Request Free Quote Consultation</span>
                  <img src="/images/arrow-right.svg" alt="Anytime" class="w-8 h-8 text-gray-700">
                </button>
              </form>
            </div>
          </div>

          <!-- Features (shown in steps 1-3) -->
          <div id="features" class="features grid-cols-1 md:grid-cols-3 gap-4">
            <div class="feature">
              <img src="/images/tick.svg" alt="Anytime" class="w-5 h-5">
              <p class="text-gray-700">Only three questions</p>
            </div>
            <div class="feature">
              <img src="/images/tick.svg" alt="Anytime" class="w-5 h-5">
              <p class="text-gray-700">100% free of charge</p>
            </div>
            <div class="feature">
              <img src="/images/tick.svg" alt="Anytime" class="w-5 h-5">
              <p class="text-gray-700">Individual consultation</p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  // Modal functionality
  const modalOverlay = document.getElementById('modal-form-overlay');
  const modalClose = document.getElementById('modal-form-close');
  const contactUsBtn = document.getElementById('contact-us-btn');
  const heroContactBtn = document.getElementById('hero-contact-btn');
  const newRequestBtn = document.getElementById('new-request-btn');

  // Open modal
  function openModal() {
    modalOverlay.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open

    // Reset form if needed
    if (currentStep !== 1) {
      resetForm();
    }
  }

  // Close modal
  function closeModal() {
    modalOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  // Event listeners for modal
  if (contactUsBtn) contactUsBtn.addEventListener('click', openModal);
  if (heroContactBtn) heroContactBtn.addEventListener('click', openModal);
  if (modalClose) modalClose.addEventListener('click', closeModal);
  if (newRequestBtn) newRequestBtn.addEventListener('click', function() {
    window.location.href = window.location.pathname; // Reload the page
  });

  // Close modal when clicking outside
  modalOverlay.addEventListener('click', function(e) {
    if (e.target === modalOverlay) {
      closeModal();
    }
  });

  // Form state
  let currentStep = 1;
  let formData = {
    interest: null,
    propertyType: null,
    callbackTime: null
  };

  // DOM elements
  const progressBar = document.getElementById('progress-bar');
  const formHeader = document.getElementById('form-header');
  const featuresSection = document.getElementById('features');
  const steps = [
    document.getElementById('step-1'),
    document.getElementById('step-2'),
    document.getElementById('step-3'),
    document.getElementById('step-4')
  ];

  // Hidden form fields
  const interestField = document.getElementById('interest');
  const propertyTypeField = document.getElementById('propertyType');
  const callbackTimeField = document.getElementById('callbackTime');

  // Update progress bar
  function updateProgress(step) {
    if (progressBar) {
      progressBar.style.width = (step * 25) + '%';
    }
  }

  // Show step with enhanced left-to-right transition
  function showStep(step) {
    // First add exit class to current step (slide to left)
    const currentStepElement = steps[currentStep - 1];
    if (currentStepElement) {
      currentStepElement.classList.add('exit');
      currentStepElement.classList.remove('active');
    }

    // Update progress bar immediately for smoother transition
    updateProgress(step);

    // Wait for exit animation to complete before showing the next step
    setTimeout(() => {
      // Remove exit class from all steps
      steps.forEach(stepEl => {
        if (stepEl) {
          stepEl.classList.remove('exit');
        }
      });

      // Show the new step (slide from right)
      if (steps[step - 1]) {
        steps[step - 1].classList.add('active');
      }

      // Hide header and features on step 4

//      if (formHeader && featuresSection) {
//        if (step === 4) {
//          formHeader.style.display = 'none';
//          featuresSection.style.display = 'none';
//        } else {
//          formHeader.style.display = 'block';
 //         featuresSection.style.display = 'grid';
 //       }
  //    }

      // Update current step
      currentStep = step;
    }, 500); // Match this to the CSS transition duration
  }

  // Reset form
  function resetForm() {
    formData = {
      interest: null,
      propertyType: null,
      callbackTime: null
    };

    // Reset hidden fields
    if (interestField) interestField.value = '';
    if (propertyTypeField) propertyTypeField.value = '';
    if (callbackTimeField) callbackTimeField.value = '';

    // Reset UI
    const options = document.querySelectorAll('.option-card');
    options.forEach(option => {
      option.classList.remove('selected');
    });

    // Reset all steps
    steps.forEach((stepElement, index) => {
      if (stepElement) {
        stepElement.classList.remove('exit');
        if (index === 0) {
          // First step should be active
          stepElement.classList.add('active');
        } else {
          stepElement.classList.remove('active');
        }
      }
    });

    // Reset progress bar
    updateProgress(1);

    // Reset current step
    currentStep = 1;

    // Show header and features
    if (formHeader) formHeader.style.display = 'block';
    if (featuresSection) featuresSection.style.display = 'grid';
  }

  // Select interest option
  function selectInterest(value) {
    formData.interest = value;

    // Update hidden field
    if (interestField) {
      interestField.value = value;
    }

    // Update UI
    const options = document.querySelectorAll('#step-1 .option-card');
    options.forEach(option => {
      if (option.getAttribute('data-value') === value) {
        option.classList.add('selected');
      } else {
        option.classList.remove('selected');
      }
    });

    // Move to next step with a slight delay for better UX
    setTimeout(() => {
      showStep(2);
    }, 300);
  }

  // Select property type
  function selectPropertyType(value) {
    formData.propertyType = value;

    // Update hidden field
    if (propertyTypeField) {
      propertyTypeField.value = value;
    }

    // Update UI
    const options = document.querySelectorAll('#step-2 .option-card');
    options.forEach(option => {
      if (option.getAttribute('data-value') === value) {
        option.classList.add('selected');
      } else {
        option.classList.remove('selected');
      }
    });

    // Move to next step with a slight delay for better UX
    setTimeout(() => {
      showStep(3);
    }, 300);
  }

  // Select callback time
  function selectCallbackTime(value) {
    formData.callbackTime = value;

    // Update hidden field
    if (callbackTimeField) {
      callbackTimeField.value = value;
    }

    // Update UI
    const options = document.querySelectorAll('#step-3 .option-card');
    options.forEach(option => {
      if (option.getAttribute('data-value') === value) {
        option.classList.add('selected');
      } else {
        option.classList.remove('selected');
      }
    });

    // Move to next step with a slight delay for better UX
    setTimeout(() => {
      showStep(4);
    }, 300);
  }

  // Initialize form
  function initForm() {
    // If form was submitted and has errors, show the appropriate step
    <?php if (!empty($formErrors)): ?>
    showStep(4);
    openModal();
    <?php elseif ($formSubmitted): ?>
    openModal();
    <?php else: ?>
    // Make sure first step is active
    steps.forEach((stepElement, index) => {
      if (stepElement) {
        if (index === 0) {
          stepElement.classList.add('active');
        } else {
          stepElement.classList.remove('active');
        }
      }
    });
    <?php endif; ?>

    // Auto-open modal if there's a hash in the URL
    if (window.location.hash === '#contact') {
      openModal();
    }
  }

  // Run initialization when DOM is loaded
  document.addEventListener('DOMContentLoaded', initForm);
</script>
</body>
</html>