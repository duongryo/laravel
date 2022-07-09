@php
$theme = config('app.theme');
$appUrl = env('APP_URL');
@endphp
@extends('layouts.index')

@section('content')
    <div id="fullpage">
        @include('pages.home.resources.section_home')

        @include('pages.home.resources.section_product', ['data' => $data->ourProducts])

        @include('pages.home.resources.section_team_members', ['data' => $data->teamMembers])

        @include('pages.home.resources.section_our_visions')

        @include('pages.home.resources.section_blog', ['data' => $data->posts])
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Animation
            const {
                gsap: {
                    timeline,
                    set,
                    registerPlugin
                },
                ScrollTrigger
            } = window;

            registerPlugin(ScrollTrigger);

            // const INTRO_EL = document.querySelector(".section-product");
            // const getPos = (el, pos) => {
            //     const BOUND = el.getBoundingClientRect();
            //     return BOUND.top + BOUND.height * pos;
            // };

            window.addEventListener("scroll", showHeight);

            function showHeight() {
                console.log(this.scrollY);
            }

            const INTRO = () =>
                timeline({
                    scrollTrigger: {
                        scrub: 0.5,
                        trigger: ".section-product",
                        pin: ".section-product",
                        start: "top top",
                        end: "bottom -5%"
                    }
                })
                .set(".section-product .col-left-description .text", { y: "+=100%", opacity: 0 })
                .to(".section-product .col-left-description", {
                    scrollTrigger: {
                        scrub: 0.5,
                        trigger: ".section-product",
                        start: "top top",
                        end: "top -=25%",
                        onUpdate: (self) => 
                        document.documentElement.style.setProperty( "--alpha", self.progress / 2 )
                    }
                })
                .to(".section-product .col-left-description .text", {
                    y: 0,
                    opacity: 1,
                    stagger: 0.1,
                    scrollTrigger: {
                        scrub: 0.5,
                        trigger: ".section-product",
                        start: () => 1300,
                        end: () => 2400
                    }
                });
            timeline().add(INTRO());

            // Animation

            var distanceTop = 215;
            var heigtScreen = $(window).height() - distanceTop;
            if (heigtScreen > 0) {
                $(".content-right-our-vision").css("height", heigtScreen);
                $(".content-right-blog").css("height", heigtScreen);
            }

            // $('#fullpage').fullpage({
            //     css3: true,
            //     verticalCentered: false,
            //     normalScrollElements: '.col-right-blog, .col-right-visions, .col-right-members'
            // });

            $('.content-right-product').slick({
                dots: false,
                infinite: true,
                speed: 0,
                fade: true,
                cssEase: 'linear'
            });

            $('.content-right-product').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                $('.slide-item-' + currentSlide).removeClass('active');
                $('.slide-item-' + nextSlide).addClass('active');
            })

            $('.pre-next .pre').click(function(e) {
                e.preventDefault();
                $('button.slick-prev').click();
            })

            $('.pre-next .next').click(function(e) {
                e.preventDefault();
                $('button.slick-next').click();
            })

            $(".scroll-down").click(function() {
                $('.section-home').removeClass('active');
                $('.section-product').addClass('active');
            });

            $('#toggle').click(function() {
                $(this).toggleClass('active');
                $('#overlay').toggleClass('open');
            });
        });
    </script>
@endsection
