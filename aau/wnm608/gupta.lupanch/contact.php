<?php
$page_title = 'Contact Us - LG Cool Store';
$page_description = 'Get in touch with LG Cool Store. We\'re here to help!';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you!</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-layout">
            <!-- Contact Form -->
            <div class="contact-form-container">
                <h2>Send Us a Message</h2>
                <form id="contactForm" class="contact-form">
                    <div class="form-group">
                        <label for="contactName">Name *</label>
                        <input type="text" id="contactName" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contactEmail">Email *</label>
                        <input type="email" id="contactEmail" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contactSubject">Subject *</label>
                        <input type="text" id="contactSubject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contactMessage">Message *</label>
                        <textarea id="contactMessage" name="message" rows="6" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Get In Touch</h2>
                
                <div class="info-block">
                    <h3>📧 Email</h3>
                    <p><a href="mailto:support@lgcoolstore.com">support@lgcoolstore.com</a></p>
                </div>
                
                <div class="info-block">
                    <h3>📱 Phone</h3>
                    <p><a href="tel:+15551234567">+1 (555) 123-4567</a></p>
                </div>
                
                <div class="info-block">
                    <h3>🏢 Address</h3>
                    <p>123 Streetwear Avenue<br>San Francisco, CA 94103</p>
                </div>
                
                <div class="info-block">
                    <h3>⏰ Business Hours</h3>
                    <p>Monday - Friday: 9:00 AM - 6:00 PM<br>
                    Saturday: 10:00 AM - 4:00 PM<br>
                    Sunday: Closed</p>
                </div>
                
                <div class="social-links-contact">
                    <h3>Follow Us</h3>
                    <div class="social-icons">
                        <a href="#">📷 Instagram</a>
                        <a href="#">📘 Facebook</a>
                        <a href="#">🐦 Twitter</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <h3>What is your return policy?</h3>
                    <p>We offer a 30-day return policy on all unused items in original packaging.</p>
                </div>
                <div class="faq-item">
                    <h3>How long does shipping take?</h3>
                    <p>Standard shipping takes 5-7 business days. Express options available.</p>
                </div>
                <div class="faq-item">
                    <h3>Do you ship internationally?</h3>
                    <p>Currently, we only ship within the United States.</p>
                </div>
                <div class="faq-item">
                    <h3>How can I track my order?</h3>
                    <p>You'll receive a tracking number via email once your order ships.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Thank you for your message! We\'ll get back to you soon.');
    this.reset();
});
</script>

<?php include 'parts/footer.php'; ?>