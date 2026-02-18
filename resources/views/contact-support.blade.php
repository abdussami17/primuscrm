@extends('layouts.app')


@section('title','Contact Support')


@section('content')


<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
      style="min-height: 80px;">
      <!-- Left: Title -->
      

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

    
    </div>

    <!-- Header Section -->
 

    <div class="row">
        <!-- Contact Information -->
        <div class="col-lg-5 mb-4">
            <div class="contact-info-section">
                <h2 class="contact-info-title">Get In Touch</h2>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Email Support</h3>
                        <p><a href="mailto:support@company.com">support@company.com</a></p>
                        <p style="font-size: 0.9rem; margin-top: 5px;">We respond within 24 hours</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Phone Support</h3>
                        <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
                        <p style="font-size: 0.9rem; margin-top: 5px;">Mon - Fri: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Business Hours</h3>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                        <p>Saturday: 10:00 AM - 4:00 PM</p>
                        <p>Sunday: Closed</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Office Location</h3>
                        <p>123 Business Street</p>
                        <p>Texas, USA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="form-section">
                <h2 class="form-title">Send Us a Message</h2>
                <p class="form-subtitle">Fill out the form below and we'll get back to you as soon as possible</p>

                <div id="alertContainer"></div>

                <form id="supportForm">
                    <div class="mb-4">
                        <label for="fullName" class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>

                    <div class="mb-4">
                        <label for="issueType" class="form-label">Issue Type <span class="required">*</span></label>
                        <select class="form-select" id="issueType" name="issueType" required>
                            <option value="">Select issue type</option>
                            <option value="technical">Technical Support</option>
                            <option value="billing">Billing & Payment</option>
                            <option value="account">Account Issues</option>
                            <option value="feature">Feature Request</option>
                            <option value="bug">Bug Report</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="form-label">Subject <span class="required">*</span></label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Brief description of your issue" required>
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label">Problem / Issue Details <span class="required">*</span></label>
                        <textarea class="form-control" id="message" name="message" placeholder="Please describe your issue in detail..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-paper-plane me-2"></i> Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('supportForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const alertContainer = document.getElementById('alertContainer');
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
            
            // Get form data
            const formData = {
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                issueType: document.getElementById('issueType').value,
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value,
                timestamp: new Date().toLocaleString()
            };

            // Email configuration - REPLACE WITH YOUR ACTUAL EMAIL SERVICE
            const supportEmails = ['support@company.com', 'admin@company.com'];
            
            // Create email body
            const emailBody = `
New Support Request Received

Name: ${formData.fullName}
Email: ${formData.email}
Phone: ${formData.phone || 'Not provided'}
Issue Type: ${formData.issueType}
Subject: ${formData.subject}

Message:
${formData.message}

Submitted on: ${formData.timestamp}
            `.trim();

            try {
                // METHOD 1: Using mailto (opens email client)
                const mailtoLink = `mailto:${supportEmails.join(',')}?subject=${encodeURIComponent('Support Request: ' + formData.subject)}&body=${encodeURIComponent(emailBody)}`;
                
                // Open email client
                window.location.href = mailtoLink;
                
                // Show success message
                alertContainer.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Email client opened!</strong> Your default email application should open with the support request. Please send the email to complete your submission.
                    </div>
                `;
                
                // Reset form
                document.getElementById('supportForm').reset();
                
                // Scroll to alert
                alertContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                
            } catch (error) {
                // Show error message
                alertContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error!</strong> Unable to process your request. Please email us directly at support@company.com
                    </div>
                `;
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Request';
            }

            /* 
            METHOD 2: For actual email integration, use a backend service like:
            
            // Using EmailJS (Free service)
            emailjs.send("YOUR_SERVICE_ID", "YOUR_TEMPLATE_ID", formData)
                .then(() => {
                    alertContainer.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Success!</strong> Your support request has been submitted successfully. We'll get back to you soon!
                        </div>
                    `;
                    document.getElementById('supportForm').reset();
                })
                .catch(() => {
                    alertContainer.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Error!</strong> Failed to send message. Please try again.
                        </div>
                    `;
                });

            // OR use your own backend API:
            fetch('https://yourbackend.com/api/support', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });
            */
        });
    </script>
  </div>

@endsection



@push('styles')

<style>


    .header-section {
        text-align: center;
        margin-bottom: 50px;
        padding: 40px 20px;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
    }

    .header-section h1 {
        color: #2563eb;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .header-section p {
        color: #6b7280;
        font-size: 1.1rem;
        margin: 0;
    }

    .contact-info-section {
        background: #ffffff;
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 30px;
       
    }

    .contact-info-title {
        color: var(--cf-primary);
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
    }

    .contact-item {
        display: flex;
        align-items: center;
        padding: 20px;
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 0px;
        transition: all 0.3s ease;
        border-left: 4px solid var(--cf-primary);
    }

    .contact-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.15);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        background: var(--cf-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .contact-icon i {
        color: #ffffff;
        font-size: 1.5rem;
    }

    .contact-details h3 {
        color: #1f2937;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .contact-details p {
        color: #6b7280;
        margin: 0;
        font-size: 1rem;
    }

    .contact-details a {
        color:var(--cf-primary);
        text-decoration: none;
        font-weight: 500;
    }

    .contact-details a:hover {
        text-decoration: underline;
    }

    .form-section {
        background: #ffffff;
        border-radius: 15px;
        padding: 40px;
        border: 1px solid #ddd;

    }

    .form-title {
        color: var(--cf-primary);
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        text-align: center;
    }

    .form-subtitle {
        color: #6b7280;
        text-align: center;
        margin-bottom: 30px;
    }

    .form-label {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
       
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .submit-btn {
        background: var(--cf-primary);
        color: #ffffff;
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .submit-btn:hover {
        background: var(--cf-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
    }

    .submit-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .required {
        color: #dc2626;
    }

    @media (max-width: 768px) {
        .header-section h1 {
            font-size: 2rem;
        }

        .contact-info-section,
        .form-section {
            padding: 25px;
        }

        .contact-item {
            flex-direction: column;
            text-align: center;
        }

        .contact-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
    }
</style>
    
@endpush