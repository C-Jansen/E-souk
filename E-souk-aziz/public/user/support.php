<?php



?>


<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar would be included here -->
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Customer Support Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>How to Get Support</h5>
                        <p>Our customer support team is available to assist you with any questions or concerns you may have regarding your orders, products, or account.</p>
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><i class="fas fa-envelope me-2"></i>Email Support</h6>
                                <p>For general inquiries: <strong>support@e-souk.com</strong></p>
                                <p>For urgent matters: <strong>urgent@e-souk.com</strong></p>
                                <p>Response time: Within 24 hours</p>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><i class="fas fa-phone me-2"></i>Phone Support</h6>
                                <p>Customer Service: <strong>+1-800-123-4567</strong></p>
                                <p>Hours: Monday to Friday, 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><i class="fas fa-comment me-2"></i>Live Chat</h6>
                                <p>Available on our website during business hours</p>
                                <p>Hours: Monday to Saturday, 10:00 AM - 8:00 PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Frequently Asked Questions</h5>
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        How do I track my order?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You can track your order in your account dashboard under "Orders" section. Click on the order number to view detailed tracking information.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        What is your return policy?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        We accept returns within 30 days of purchase. Items must be in original condition with tags attached.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h5>Your Previous Support Tickets</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Subject</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#123</td>
                                    <td>Example Subject</td>
                                    <td>Technical Support</td>
                                    <td>
                                        <span class="badge bg-success">Open</span>
                                    </td>
                                    <td>May 15, 2023</td>
                                    <td>
                                        <a href="view_ticket.php?id=123" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
