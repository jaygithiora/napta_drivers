@extends('layouts.app')

@section('content')
    <div class="container-fluid bg">
        <div class="row d-flex align-items-center dark">
            <div class="col-sm-12  pt-5 pb-5">

                <div class="container">
                    <div class='row d-flex align-items-cente'>
                        <div class="col-md-6">
                            <h1 class='big'>NAPTA <span class='text-warning'>Professional</span> Drivers</h1>
                            <h2 class='mb-3 mt-3'>Improving public transport through
                                <span class='no-bold text-warning'>research</span>, <span
                                    class='no-bold text-warning'>innovation</span>,
                                <span class='no-bold text-warning'>training</span>, <span
                                    class='no-bold text-warning'>advocacy</span>
                                and <span class='no-bold text-warning'>investments</span>.
                            </h2>
                            <div class='pt-3'>
                                <a href='{{ url('register?role=user') }}' class='btn btn-warning m-2'><i
                                        class='fas fa-search'></i>
                                    Find a Driver</a>&nbsp;
                                <a href='{{ url('register?role=driver') }}' class='btn btn-white m-2'><i
                                        class='fas fa-user-plus'></i> Join as Driver</a>
                            </div>
                        </div>

                        <div class="d-none d-md-block col-md-6">
                            <img src='{{ asset('images/order_ride.svg') }}' class='img-fluid' />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='container'>
        <div class='row pt-5 pb-5'>
            <div class="col-md-6 p-5">
                <img src='{{ asset('images/order_ride.svg') }}' class='img-fluid' />
            </div>
            <div class='col-md-6 p-5'>
                <h4><i class='fas fa-info-circle'></i> &nbsp;About Napta Drivers</h4>
                <p>
                    Napta Drivers Limited (NDL) is a subsidiary of the National Public Transport
                    Alliance –Napta, a non-profit organization working to improve public transport through
                    research, innovation, training, advocacy and investments. Napta was incorporated in
                    2021 under the Companies Act 2015 Laws of Kenya as a Company limited by
                    guarantee.</p>
                <p>The objective of the Napta Drivers Limited is to Recruit, Train and Deploy
                    professional drivers to the transport sector.</p>
                <p>We provide you with an experienced, reliable, and respected partner in your
                    transportation business. We provide support to both our drivers and customers. Our
                    culture is focused on safety, efficiency and productivity, which is exemplified by our
                    record and a client satisfaction.
                </p>
            </div>
        </div>
    </div>

    <div class='container-fluid bg-warning'>
        <div class='container'>
            <div class='row pt-5 pb-5 text-white'>
                <div class="col-sm-4 text-center">
                    <span class='big'>Our Clients</span>
                    <div class="counter" id="counter1" data-target="133">0</div>
                </div>
                <div class="col-sm-4 text-center">
                    <span class='big'>Our Drivers</span>
                    <div class="counter" id="counter2" data-target="140">0</div>
                </div>
                <div class="col-sm-4 text-center">
                    <span class='big'>Our Partners</span>
                    <div class="counter" id="counter3" data-target="155">0</div>
                </div>
            </div>
        </div>
    </div>

    <div class='container-fluid bg-white'>
        <div class='row pt-5 pb-5'>
            <div class="col-md-12">
                <h4 class='pt-4 pb-4 text-center'>DRIVE WITH US</h4>
                <div class='container alert bg-white shadow-lg'>
                    <div class='row'>
                        <div class='col-sm-6'>
                            <img src='{{ asset('images/updated_resume.svg') }}' class='card-img-top' />
                        </div>
                        <div class='col-sm-6 p-3'>
                            <!--<div class='d-flex justify-content-center mb-3'>
                                            <div
                                                class='myCircleDiv bg-warning text-white d-flex align-items-center justify-content-center'>
                                                <i class='fas fa-briefcase fa-2x'></i>
                                            </div>
                                        </div>-->
                            <h4>Find Driving Jobs</h4>
                            <p>NDL can help you find the best driving job. From truck driving to executive chauffer,
                                we
                                can link you up with our clients who need qualified, reliable and professional
                                drivers.
                                Sign up today.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class='container alert bg-white shadow-lg'>
            <div class='row'>
                <div class='col-sm-6'>
                    <img src='{{ asset('images/city_driver.svg') }}' class='img-fluid' />
                </div>
                <div class='col-sm-6 p-3'>
                    <h4>Driving With NDL</h4>
                    <p>You’ve got experience. While you’re concentrating on the road, are you thinking about
                        what’s next? NDL can help. NDL has a team of dedicated, responsive recruiters who
                        will work with you. With support every step of the way, NDL makes it easy for you to
                        find
                        your perfect next position fast.</p>
                </div>
            </div>
        </div>

        <div class='container alert bg-white shadow-lg'>
            <div class='row'>
                <div class='col-sm-6'>
                    <img src='{{ asset('images/done_checking.svg') }}' class='img-fluid' />
                </div>
                <div class='col-sm-6 p-3'>
                    <h4>Driver Appreciation - Respect the Drive Program</h4>
                    <p>We’re excited to announce our program built just for our drivers called Respect the
                        Drive Program. This exciting initiative is to celebrate our amazing drivers. It’s
                        all about
                        you and honoring the work you do day in and day out.
                        At NDL, our drivers are like our family and the focus of everything we do. You are
                        the
                        heart of the road and our lifeline to keep our country moving. We want to honor the
                        dedication that you put behind the wheel every day by Respecting the Drive.</p>
                </div>
            </div>
        </div>
        <div class='col-sm-6'>
            <div class='card  m-3'>
                <div class='card-body'>
                    <div class='d-flex justify-content-center mb-3'>
                        <div class='myCircleDiv bg-warning text-white d-flex align-items-center justify-content-center'>
                            <i class='fas fa-briefcase fa-2x'></i>
                        </div>
                    </div>
                    <h4>Continuous Professional Development &amp; Training</h4>
                    <p>NDL Drivers undergo a rigorous Continuous Professional Development &amp; Training
                        program. The training is based on the EAC Standard Curriculum for Commercial
                        (Freight &amp; Passenger) Curriculum. The program takes 21 days to complete. The
                        instructors are highly qualified individuals certified by the National Industrial
                        Training
                        Authority (NITA). Upon successful completion, they are awarded a CERTIFICATE OF
                        COMPETENCE. The Certificate is recognized by NITA and NTSA.
                    </p>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>
    </div>

    <div class='container-fluid'>
        <div class='row'>
            <div class='col-sm-12'>

                <div class='container'>
                    <div class='row pt-5 pb-5 d-flex align-items-center'>
                        <div class='col-sm-6 p-5'>
                            <h4><i class='fas fa-mobile'></i> &nbsp;Meet the NDL Driver Mobile App</h4>
                            <p>Stay connected and engaged with our new mobile app for you – our drivers.
                                We want to
                                ensure you stay connected and engaged as an NDL driver. Our app allows
                                you to view
                                time, paychecks, access safety and training information, refer other
                                great drivers and
                                provide regular feedback. You can also track hours towards your Respect
                                the Drive
                                milestones directly in the app. Like most apps, we’ll continue to add
                                new functionality as
                                requested by drivers!</p>
                            <button class='btn btn-dark btn-round m-3'>
                                <i class='fab fa-google-play'></i> Google
                                Play
                            </button>
                            <button class='btn btn-dark btn-round m-3'>
                                <i class='fab fa-app-store'></i> Apple Store
                            </button>
                        </div>
                        <div class='col-sm-6 p-3'>
                            <img src='{{ asset('images/mobile.svg') }}' class='img-fluid' />
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.counter');

            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }

            function animateCounters() {
                counters.forEach(counter => {
                    if (isElementInViewport(counter) && counter.innerHTML === "0") {
                        const targetCount = parseInt(counter.dataset.target, 10);
                        let currentCount = 0;

                        const counterInterval = setInterval(() => {
                            counter.innerHTML = currentCount++;
                            if (currentCount > targetCount) {
                                clearInterval(counterInterval);
                            }
                        }, 10);

                        counter.style.opacity = 1;
                        counter.style.transform = 'translateY(0)';
                    }
                });
            }

            window.addEventListener('scroll', animateCounters);
            animateCounters(); // Initial check in case counters are already in view on page load
        });
        $(document).ready(function() {

            /*$(document).ready(function() {
                var header = $(".navbar");
                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();

                    if (scroll >= 30) {
                        header.addClass('bg-light');
                        header.removeClass('navbar-dark');
                        header.addClass('navbar-light');
                        header.addClass('shadow-sm');
                    } else {
                        header.removeClass('bg-light');
                        header.addClass('navbar-dark');
                        header.removeClass('navbar-light');
                        header.removeClass('shadow-sm');
                    }
                });*/
        });
    </script>
@endpush
