@extends('layouts.app')


@section('title','Dealership Training Material')


@section('content')

<div class="content content-two pt-0">
    

    <!-- Header Section -->
 

    <div class="main-container">
        <div class="content-card">
            <div class="icon-container">
                <i class="fas fa-tools main-icon"></i>
            </div>

            <div class="text-center">
                <span class="construction-badge">
                    <i class="fas fa-hard-hat"></i> Under Construction
                </span>
            </div>

            <h1>Dealership Training Material</h1>
            <p class="subtitle">
                We're building something extraordinary! Our comprehensive training platform will equip your dealership team with the knowledge and skills they need to excel.
            </p>

            <div class="loader-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>

            <!-- Features Grid -->
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="feature-title">Video Training</div>
                    <div class="feature-desc">High-quality video tutorials covering all aspects of dealership operations</div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="feature-title">Documentation</div>
                    <div class="feature-desc">Comprehensive guides, manuals, and reference materials</div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="feature-title">Certifications</div>
                    <div class="feature-desc">Track progress and earn certificates upon completion</div>
                </div>
            </div>

            <!-- Timeline Section -->
            <div class="timeline-section">
                <div class="timeline-title">
                    <i class="fas fa-map-signs"></i> Development Roadmap
                </div>
                <div class="timeline-steps">
                    <div class="timeline-step">
                        <div class="step-circle">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="step-label">Platform Design</div>
                    </div>
                    <div class="timeline-step">
                        <div class="step-circle">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="step-label">Content Creation</div>
                    </div>
                    <div class="timeline-step">
                        <div class="step-circle">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="step-label">Testing Phase</div>
                    </div>
                    <div class="timeline-step">
                        <div class="step-circle">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="step-label">Launch</div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="contact-section">
                <div class="contact-title">
                    <i class="fas fa-envelope"></i> Stay Updated
                </div>
                <p class="contact-text">
                    Want to be notified when we launch? Get in touch with us for more information about our upcoming training platform.
                </p>
                <button class="btn btn-primary-custom" onclick="showNotification()">
                    <i class="fas fa-bell me-2"></i> Notify Me
                </button>
            </div>
        </div>
    </div>
  </div>




  <script>
    function showNotification() {
        alert('Thank you for your interest! We will notify you once the training platform is live.');
    }

    // Add smooth scroll animation
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.feature-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.6s ease';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => {
            observer.observe(card);
        });
    });
</script>

@endsection


@push('styles')

<style>

    .main-container {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .content-card {
        background: white;
        border-radius: 16px;
   
        padding: 3rem;
        max-width:100%;
        width: 100%;
        margin: 0 1rem;
        position: relative;
        overflow: hidden;
    }



    .icon-container {
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
    }

    .main-icon {
        font-size: 5rem;
        color: rgb(0, 33, 64);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .construction-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgb(0, 33, 64) 0%, #444 100%);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    h1 {
        color: rgb(0, 33, 64);
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
    }

    .subtitle {
        color: #666;
        font-size: 1.2rem;
        text-align: center;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 2.5rem 0;
    }

    .feature-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        border-color: rgb(0, 33, 64);
        box-shadow: 0 5px 20px rgba(0, 33, 64, 0.1);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: rgb(0, 33, 64);
        margin-bottom: 1rem;
    }

    .feature-title {
        color: rgb(0, 33, 64);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .feature-desc {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .timeline-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid #e9ecef;
    }

    .timeline-title {
        color: rgb(0, 33, 64);
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin: 2rem 0;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .timeline-step {
        flex: 1;
        min-width: 150px;
        text-align: center;
        position: relative;
    }

    .step-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: white;
        border: 3px solid rgb(0, 33, 64);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-weight: 700;
        color: rgb(0, 33, 64);
        position: relative;
        z-index: 2;
    }

    .step-label {
        color: #333;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .contact-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 2rem;
        margin-top: 2rem;
        text-align: center;
    }

    .contact-title {
        color: rgb(0, 33, 64);
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .contact-text {
        color: #666;
        margin-bottom: 1.5rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, rgb(0, 33, 64) 0%, #444 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        color: #fff !important;
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 33, 64, 0.3);
    }

    .footer {
        background: rgb(0, 33, 64);
        color: white;
        text-align: center;
        padding: 1.5rem;
        margin-top: 3rem;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 2rem;
        }

        .subtitle {
            font-size: 1rem;
        }

        .content-card {
            padding: 2rem 1.5rem;
        }

        .main-icon {
            font-size: 4rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }

        .timeline-steps {
            flex-direction: column;
        }

        .timeline-step {
            width: 100%;
        }
    }

    .loader-dots {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin: 2rem 0;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgb(0, 33, 64);
        animation: pulse 1.5s ease-in-out infinite;
    }

    .dot:nth-child(2) {
        animation-delay: 0.3s;
    }

    .dot:nth-child(3) {
        animation-delay: 0.6s;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 0.3;
            transform: scale(0.8);
        }
        50% {
            opacity: 1;
            transform: scale(1.2);
        }
    }
</style>
    
@endpush