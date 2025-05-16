<?php
// Database configuration
$db_host = "localhost";     // Your database host
$db_user = "root";          // Your database username
$db_pass = "password";              // Your database password
$db_name = "Onboarding";    // Your database name

// Form processing
$formSubmitted = false;
$formErrors = [];
$dbError = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate email
  if (empty($_POST["email"])) {
    $formErrors["email"] = "Email is required";
  } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $formErrors["email"] = "Invalid email format";
  }

  // Validate phone
  if (empty($_POST["phone"])) {
    $formErrors["phone"] = "Phone number is required";
  } elseif (strlen($_POST["phone"]) < 10) {
    $formErrors["phone"] = "Please enter a valid phone number";
  }

  // Validate address
  if (empty($_POST["address"])) {
    $formErrors["address"] = "Address is required";
  }

  // Validate terms
  if (!isset($_POST["terms"])) {
    $formErrors["terms"] = "You must agree to the terms and conditions";
  }

  // If no errors, process form and save to database
  if (empty($formErrors)) {
    // Prepare data for database
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
    $isEmergency = isset($_POST["isEmergency"]) ? ($_POST["isEmergency"] === "yes" ? 1 : 0) : 0;
    $propertyType = isset($_POST["propertyType"]) ? filter_var($_POST["propertyType"], FILTER_SANITIZE_STRING) : "";
    $callbackTime = isset($_POST["callbackTime"]) ? filter_var($_POST["callbackTime"], FILTER_SANITIZE_STRING) : "";

    // Connect to database
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($conn->connect_error) {
      $dbError = "Database connection failed: " . $conn->connect_error;
    } else {
      // Prepare and execute SQL statement
      $stmt = $conn->prepare("INSERT INTO onboarding (email, address, phone, is_emergency, property_type, time) VALUES (?, ?, ?, ?, ?, ?)");

      if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssiss", $email, $address, $phone, $isEmergency, $propertyType, $callbackTime);

        // Execute statement
        if ($stmt->execute()) {
          $formSubmitted = true;
        } else {
          $dbError = "Error saving data: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
      } else {
        $dbError = "Error preparing statement: " . $conn->error;
      }

      // Close connection
      $conn->close();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pest Control Services</title>
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    body {
      background-color: #f9fafb;
      color: #333;
      line-height: 1.5;
    }

    /* Landing page styles */
    .landing-container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      position: relative;
      z-index: 100;
    }

    .landing-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 0;
      margin-bottom: 2rem;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: #111827;
    }

    .logo span {
      color: #dc2626;
    }

    .landing-hero {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 4rem 0;
    }

    .landing-hero h1 {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 1rem;
      color: #111827;
    }

    .landing-hero p {
      font-size: 1.25rem;
      color: #4b5563;
      max-width: 600px;
      margin-bottom: 2rem;
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 1.5rem;
      background-color: #dc2626;
      color: white;
      font-weight: 500;
      border-radius: 0.375rem;
      cursor: pointer;
      transition: background-color 0.2s ease;
      border: none;
      font-size: 1rem;
    }

    .btn-primary:hover {
      background-color: #b91c1c;
    }

    /* Modal styles */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
      z-index: 1000;
    }

    .modal {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      width: 100%;
      max-width: 900px;
      max-height: 90vh;
      overflow-y: auto;
      position: relative;
      transform: translateY(20px);
      opacity: 0;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .modal-overlay.active .modal {
      transform: translateY(0);
      opacity: 1;
    }

    .modal-close {
      position: absolute;
      top: 1rem;
      right: 1rem;
      width: 2rem;
      height: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 9999px;
      background-color: #f3f4f6;
      cursor: pointer;
      z-index: 10;
      transition: background-color 0.2s ease;
    }

    .modal-close:hover {
      background-color: #e5e7eb;
    }

    .modal-content {
      padding: 2rem;
    }

    /* Form styles from previous code */
    .container {
      width: 100%;
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
    }

    .text-center {
      text-align: center;
    }

    .mb-2 {
      margin-bottom: 0.5rem;
    }

    .mb-4 {
      margin-bottom: 1rem;
    }

    .mb-6 {
      margin-bottom: 1.5rem;
    }

    .mb-8 {
      margin-bottom: 2rem;
    }

    .mt-2 {
      margin-top: 0.5rem;
    }

    .mt-4 {
      margin-top: 1rem;
    }

    .mt-8 {
      margin-top: 2rem;
    }

    .mt-12 {
      margin-top: 3rem;
    }

    .pt-6 {
      padding-top: 1.5rem;
    }

    .py-3 {
      padding-top: 0.75rem;
      padding-bottom: 0.75rem;
    }

    .py-8 {
      padding-top: 2rem;
      padding-bottom: 2rem;
    }

    .px-4 {
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .p-3 {
      padding: 0.75rem;
    }

    .p-4 {
      padding: 1rem;
    }

    .p-6 {
      padding: 1.5rem;
    }

    .flex {
      display: flex;
    }

    .items-center {
      align-items: center;
    }

    .justify-center {
      justify-content: center;
    }

    .gap-1 {
      gap: 0.25rem;
    }

    .gap-2 {
      gap: 0.5rem;
    }

    .space-y-1 > * + * {
      margin-top: 0.25rem;
    }

    .space-y-4 > * + * {
      margin-top: 1rem;
    }

    .space-y-6 > * + * {
      margin-top: 1.5rem;
    }

    .w-full {
      width: 100%;
    }

    .min-w-16 {
      min-width: 4rem;
    }

    .flex-1 {
      flex: 1;
    }

    .grid {
      display: grid;
    }

    .grid-cols-1 {
      grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .gap-4 {
      gap: 1rem;
    }

    .border {
      border: 1px solid #e5e7eb;
    }

    .border-t {
      border-top: 1px solid #e5e7eb;
    }

    .border-red-500 {
      border-color: #ef4444;
    }

    .rounded-md {
      border-radius: 0.375rem;
    }

    .rounded-lg {
      border-radius: 0.5rem;
    }

    .rounded-full {
      border-radius: 9999px;
    }

    .overflow-hidden {
      overflow: hidden;
    }

    .bg-white {
      background-color: #fff;
    }

    .bg-black {
      background-color: #000;
    }

    .bg-red-50 {
      background-color: #fef2f2;
    }

    .bg-red-600 {
      background-color: #dc2626;
    }

    .bg-gray-100 {
      background-color: #f3f4f6;
    }

    .bg-gray-200 {
      background-color: #e5e7eb;
    }

    .bg-green-100 {
      background-color: #d1fae5;
    }

    .text-white {
      color: #fff;
    }

    .text-black {
      color: #000;
    }

    .text-gray-500 {
      color: #6b7280;
    }

    .text-gray-600 {
      color: #4b5563;
    }

    .text-gray-700 {
      color: #374151;
    }

    .text-red-500 {
      color: #ef4444;
    }

    .text-red-600 {
      color: #dc2626;
    }

    .text-green-500 {
      color: #10b981;
    }

    .text-blue-600 {
      color: #2563eb;
    }

    .text-blue-700 {
      color: #1d4ed8;
    }

    .text-sm {
      font-size: 0.875rem;
    }

    .text-lg {
      font-size: 1.125rem;
    }

    .text-xl {
      font-size: 1.25rem;
    }

    .text-2xl {
      font-size: 1.5rem;
    }

    .text-3xl {
      font-size: 1.875rem;
    }

    .text-4xl {
      font-size: 2.25rem;
    }

    .font-medium {
      font-weight: 500;
    }

    .font-semibold {
      font-weight: 600;
    }

    .font-bold {
      font-weight: 700;
    }

    .h-1 {
      height: 0.25rem;
    }

    .h-5 {
      height: 1.25rem;
    }

    .h-8 {
      height: 2rem;
    }

    .h-12 {
      height: 3rem;
    }

    .h-16 {
      height: 4rem;
    }

    .h-48 {
      height: 12rem;
    }

    .w-5 {
      width: 1.25rem;
    }

    .w-8 {
      width: 2rem;
    }

    .w-12 {
      width: 3rem;
    }

    .w-16 {
      width: 4rem;
    }

    .relative {
      position: relative;
    }

    .absolute {
      position: absolute;
    }

    .shadow-md {
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .outline-none {
      outline: none;
    }

    .transition-all {
      transition-property: all;
      transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
      transition-duration: 300ms;
    }

    .transition-colors {
      transition-property: color, background-color, border-color;
      transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
      transition-duration: 300ms;
    }

    .hover\:bg-red-700:hover {
      background-color: #b91c1c;
    }

    .hover\:bg-red-50:hover {
      background-color: #fef2f2;
    }

    .ring-2 {
      --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
      --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
      box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    }

    .ring-red-500 {
      --tw-ring-color: #ef4444;
    }

    /* Form elements */
    button {
      cursor: pointer;
      border: none;
      background: none;
      font-family: inherit;
      font-size: inherit;
      color: inherit;
    }

    button:focus {
      outline: none;
    }

    input {
      font-family: inherit;
      font-size: inherit;
    }

    /* Progress bar */
    .progress-container {
      position: relative;
      height: 4px;
      background-color: #e5e7eb;
      border-radius: 9999px;
      overflow: hidden;
      max-width: 600px;
      margin: 0 auto 2rem;
    }

    .progress-bar {
      position: absolute;
      height: 100%;
      background-color: #dc2626;
      transition: width 0.5s ease;
    }

    /* Option cards */
    .option-card {
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      overflow: hidden;
      transition: all 0.2s ease;
    }

    .option-card:hover {
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .option-card.selected {
      border-color: #dc2626;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .option-image {
      height: 12rem;
      background-size: cover;
      background-position: center;
    }

    .option-label {
      padding: 1rem;
      text-align: center;
    }

    .option-label.black {
      background-color: #000;
      color: #fff;
    }

    .option-label.light {
      background-color: #fef2f2;
      color: #000;
    }

    .icon-container {
      padding: 1.5rem;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Form styles */
    .form-group {
      margin-bottom: 1rem;
    }

    .form-control {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #e5e7eb;
      border-radius: 0.375rem;
    }

    .form-control:focus {
      border-color: #dc2626;
      outline: none;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 1rem;
      border-radius: 0.375rem;
      font-weight: 500;
      transition: background-color 0.2s ease;
    }

    .btn-primary {
      background-color: #dc2626;
      color: white;
    }

    .btn-primary:hover {
      background-color: #b91c1c;
    }

    /* Features section */
    .features {
      margin-top: 3rem;
      padding-top: 1.5rem;
      border-top: 1px solid #e5e7eb;
      display: grid;
      grid-template-columns: 1fr;
    }

    .feature {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    /* Database error message */
    .db-error {
      padding: 1rem;
      margin-bottom: 1rem;
      background-color: #fee2e2;
      border: 1px solid #ef4444;
      border-radius: 0.375rem;
      color: #b91c1c;
    }

    /* Step transitions - Left to Right */
    .steps-container {
      position: relative;
      min-height: 400px; /* Adjust based on your content */
      overflow: hidden; /* Important to hide content that slides out */
    }

    .form-step {
      position: absolute;
      width: 100%;
      max-width: 800px;
      left: 0;
      right: 0;
      margin: 0 auto;
      opacity: 0;
      visibility: hidden;
      transform: translateX(100px); /* Start from right */
      transition: opacity 0.5s ease, transform 0.5s ease, visibility 0.5s ease;
    }

    .form-step.active {
      position: relative;
      opacity: 1;
      visibility: visible;
      transform: translateX(0); /* Center position */
    }

    .form-step.exit {
      transform: translateX(-100px); /* Exit to left */
      opacity: 0;
      visibility: hidden;
    }

    /* Success message animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .success-message {
      animation: fadeIn 0.5s ease forwards;
    }

    /* Responsive */
    @media (min-width: 640px) {
      .sm\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (min-width: 768px) {
      .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .md\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }

      .md\:grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
      }

      .md\:text-2xl {
        font-size: 1.5rem;
      }

      .md\:text-4xl {
        font-size: 2.25rem;
      }
    }

    /* Icons */
    .icon {
      display: inline-block;
      width: 24px;
      height: 24px;
      stroke-width: 2;
      stroke: currentColor;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .icon-lg {
      width: 48px;
      height: 48px;
    }
  </style>
</head>
<body>
<!-- Landing Page -->
<div class="landing-container">
  <header class="landing-header">
    <div class="logo">Pest<span>Control</span> Services</div>
    <button id="contact-us-btn" class="btn-primary">Contact Us</button>
  </header>

  <div class="landing-hero">
    <h1>Professional Pest Control Services</h1>
    <p>We provide expert pest control solutions for residential and commercial properties. Our team of professionals is ready to help you eliminate any pest problem.</p>
    <button id="hero-contact-btn" class="btn-primary">Get a Free Quote</button>
  </div>
</div>

<!-- Modal Overlay -->
<div id="modal-overlay" class="modal-overlay">
  <div class="modal">
    <div class="modal-close" id="modal-close">
      <svg class="icon" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </div>

    <div class="modal-content">
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
            Your request has been submitted. One of our pest control experts will contact you
            <?php
            if ($callbackTime == "morning") {
              echo "in the morning";
            } elseif ($callbackTime == "afternoon") {
              echo "in the afternoon";
            } elseif ($callbackTime == "evening") {
              echo "in the evening";
            } else {
              echo "at a convenient time";
            }
            ?>
            with a free quote.
          </p>
          <button id="new-request-btn" class="btn btn-primary">Submit Another Request</button>
        </div>
      <?php else: ?>
        <div id="pest-control-form">
          <!-- Display database error if any -->
          <?php if ($dbError): ?>
            <div class="db-error">
              <p><strong>Database Error:</strong> <?php echo $dbError; ?></p>
            </div>
          <?php endif; ?>

          <!-- Step 1: Header (shown in steps 1-3) -->
          <div id="form-header" class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">
              Get a free <span class="text-red-600">Pest Control Quote</span>
            </h1>
            <h2 class="text-xl md:text-2xl font-medium text-gray-800">from your Local Trusted Experts</h2>
          </div>

          <!-- Progress Bar -->
          <div class="progress-container">
            <div id="progress-bar" class="progress-bar" style="width: 25%;"></div>
          </div>

          <!-- Steps Container -->
          <div class="steps-container">
            <!-- Step 1: Emergency Question -->
            <div id="step-1" class="form-step active">
              <div class="mb-6">
                <p class="text-blue-700 font-medium">Question 1 of 3</p>
                <h3 class="text-2xl font-bold mt-2">Is this an emergency?</h3>
                <p class="text-xl">Do you need same-day service?</p>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button type="button" class="option-card" data-value="yes" onclick="selectEmergency('yes')">
                  <div class="option-image" style="background-image: url('https://placehold.co/600x400/e2e8f0/e2e8f0')"></div>
                  <div class="option-label light">
                    <p class="font-medium">Yes</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="no" onclick="selectEmergency('no')">
                  <div class="option-image" style="background-image: url('https://placehold.co/600x400/e2e8f0/e2e8f0')"></div>
                  <div class="option-label light">
                    <p class="font-medium">No</p>
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

              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <button type="button" class="option-card" data-value="residential" onclick="selectPropertyType('residential')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                      <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Residential House</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="commercial" onclick="selectPropertyType('commercial')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                      <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Commercial Shop</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="office" onclick="selectPropertyType('office')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                      <rect x="9" y="9" width="6" height="6"></rect>
                      <line x1="9" y1="1" x2="9" y2="4"></line>
                      <line x1="15" y1="1" x2="15" y2="4"></line>
                      <line x1="9" y1="20" x2="9" y2="23"></line>
                      <line x1="15" y1="20" x2="15" y2="23"></line>
                      <line x1="20" y1="9" x2="23" y2="9"></line>
                      <line x1="20" y1="14" x2="23" y2="14"></line>
                      <line x1="1" y1="9" x2="4" y2="9"></line>
                      <line x1="1" y1="14" x2="4" y2="14"></line>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Office Building</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="industrial" onclick="selectPropertyType('industrial')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <path d="M22 21H2V8l4-4h16v17z"></path>
                      <path d="M6 12h4"></path>
                      <path d="M14 12h4"></path>
                      <path d="M6 16h4"></path>
                      <path d="M14 16h4"></path>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">Industrial Warehouse</p>
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

              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <button type="button" class="option-card" data-value="morning" onclick="selectCallbackTime('morning')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <path d="M17 18a5 5 0 0 0-10 0"></path>
                      <line x1="12" y1="2" x2="12" y2="9"></line>
                      <line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line>
                      <line x1="1" y1="18" x2="3" y2="18"></line>
                      <line x1="21" y1="18" x2="23" y2="18"></line>
                      <line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line>
                      <line x1="23" y1="22" x2="1" y2="22"></line>
                      <polyline points="8 6 12 2 16 6"></polyline>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">In the morning</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="afternoon" onclick="selectCallbackTime('afternoon')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <circle cx="12" cy="12" r="5"></circle>
                      <line x1="12" y1="1" x2="12" y2="3"></line>
                      <line x1="12" y1="21" x2="12" y2="23"></line>
                      <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                      <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                      <line x1="1" y1="12" x2="3" y2="12"></line>
                      <line x1="21" y1="12" x2="23" y2="12"></line>
                      <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                      <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">In the afternoon</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="evening" onclick="selectCallbackTime('evening')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <path d="M17 18a5 5 0 0 0-10 0"></path>
                      <line x1="12" y1="9" x2="12" y2="2"></line>
                      <line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line>
                      <line x1="1" y1="18" x2="3" y2="18"></line>
                      <line x1="21" y1="18" x2="23" y2="18"></line>
                      <line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line>
                      <line x1="23" y1="22" x2="1" y2="22"></line>
                      <polyline points="16 6 12 10 8 6"></polyline>
                    </svg>
                  </div>
                  <div class="option-label light">
                    <p class="font-medium">In evening</p>
                  </div>
                </button>

                <button type="button" class="option-card" data-value="anytime" onclick="selectCallbackTime('anytime')">
                  <div class="icon-container">
                    <svg class="icon-lg text-gray-700" viewBox="0 0 24 24">
                      <circle cx="12" cy="12" r="10"></circle>
                      <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                      <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
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
                  Our <span class="text-red-600">Pest Control</span> experts are ready to help you!
                </h2>
                <p class="text-gray-600 mt-2">Simply enter your details, and we'll contact you back to confirm.</p>
              </div>

              <form id="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="space-y-4">
                <!-- Hidden fields to store previous selections -->
                <input type="hidden" id="isEmergency" name="isEmergency" value="">
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
                      <span class="text-gray-700">GB</span>
                    </div>
                    <input
                      type="tel"
                      name="phone"
                      placeholder="+44 0000 000000"
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
                  class="w-full bg-red-600 text-white py-3 px-4 rounded-md flex items-center justify-center gap-2 hover:bg-red-700 transition-colors"
                >
                  <span>Get my free quote</span>
                  <svg class="icon" viewBox="0 0 24 24">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                  </svg>
                </button>
              </form>
            </div>
          </div>

          <!-- Features (shown in steps 1-3) -->
          <div id="features" class="features grid-cols-1 md:grid-cols-3 gap-4">
            <div class="feature">
              <svg class="icon text-red-600" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
              <p class="text-gray-700">Only three questions</p>
            </div>
            <div class="feature">
              <svg class="icon text-red-600" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
              <p class="text-gray-700">100% free of charge</p>
            </div>
            <div class="feature">
              <svg class="icon text-red-600" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
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
  const modalOverlay = document.getElementById('modal-overlay');
  const modalClose = document.getElementById('modal-close');
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
    isEmergency: null,
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
  const isEmergencyField = document.getElementById('isEmergency');
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
      if (formHeader && featuresSection) {
        if (step === 4) {
          formHeader.style.display = 'none';
          featuresSection.style.display = 'none';
        } else {
          formHeader.style.display = 'block';
          featuresSection.style.display = 'grid';
        }
      }

      // Update current step
      currentStep = step;
    }, 500); // Match this to the CSS transition duration
  }

  // Reset form
  function resetForm() {
    formData = {
      isEmergency: null,
      propertyType: null,
      callbackTime: null
    };

    // Reset hidden fields
    if (isEmergencyField) isEmergencyField.value = '';
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

  // Select emergency option
  function selectEmergency(value) {
    formData.isEmergency = value;

    // Update hidden field
    if (isEmergencyField) {
      isEmergencyField.value = value;
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