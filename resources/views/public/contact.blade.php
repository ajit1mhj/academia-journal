@extends('layouts.public')
@section('title', 'Contact')

@section('content')
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <h1 class="h3 fw-bold text-primary mb-0">Contact Us</h1>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <h4 class="fw-bold mb-4" style="color:#1a3c5e">Get in Touch</h4>
                <div class="d-flex gap-3 mb-3">
                    <i class="bi bi-envelope-fill text-primary fs-4 mt-1"></i>
                    <div>
                        <div class="fw-semibold small">Email</div>
                        <div class="text-muted small">research@academiacollege.edu.np</div>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-3">
                    <i class="bi bi-telephone-fill text-primary fs-4 mt-1"></i>
                    <div>
                        <div class="fw-semibold small">Phone</div>
                        <div class="text-muted small">01-5443037</div>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-3">
                    <i class="bi bi-geo-alt-fill text-primary fs-4 mt-1"></i>
                    <div>
                        <div class="fw-semibold small">Address</div>
                        <div class="text-muted small">Gwarko-Lalitpur, Nepal</div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <i class="bi bi-clock-fill text-primary fs-4 mt-1"></i>
                    <div>
                        <div class="fw-semibold small">Office Hours</div>
                        <div class="text-muted small">Monday–Saturday, 6:30AM – 2:30 PM</div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Send a Message</h5>
                        <form>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">Your Name</label>
                                    <input type="text" class="form-control" placeholder="Full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Email Address</label>
                                    <input type="email" class="form-control" placeholder="you@example.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">Subject</label>
                                    <input type="text" class="form-control" placeholder="How can we help?">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">Message</label>
                                    <textarea class="form-control" rows="5"
                                        placeholder="Write your message here..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-send me-2"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection