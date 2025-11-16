{{-- ===================== SECTION: HERO + COUNTDOWN ===================== --}}
<section data-dce-background-overlay-color="#00000073"
         class="elementor-section elementor-top-section elementor-element elementor-element-3fa68309 elementor-section-height-min-height elementor-section-items-top elementor-section-boxed elementor-section-height-default wdp-sticky-section-no"
         data-id="3fa68309" data-element_type="section"
         {{-- Background slideshow sudah diarahkan ke public/assets/background --}}
         data-settings='{"background_background":"slideshow","background_slideshow_gallery":[{"id":107053,"url":"{{ asset('assets/background/background_2.jpeg') }}"},{"id":107033,"url":"{{ asset('assets/background/background_3.jpeg') }}"}],"background_slideshow_slide_duration":2000,"background_slideshow_transition_duration":2000,"background_slideshow_loop":"yes","background_slideshow_slide_transition":"fade","_ha_eqh_enable":false}'>
    <div class="elementor-background-overlay"></div>
    <div class="elementor-container elementor-column-gap-no">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2e9d80cb wdp-sticky-section-no"
             data-id="2e9d80cb" data-element_type="column"
             data-settings='{"background_background":"classic"}'>
            <div class="elementor-widget-wrap elementor-element-populated">
                <section class="elementor-section elementor-inner-section elementor-element elementor-element-2c047276 elementor-section-boxed elementor-section-height-default elementor-section-height-default wdp-sticky-section-no"
                         data-id="2c047276" data-element_type="section"
                         data-settings='{"_ha_eqh_enable":false}'>
                    <div class="elementor-container elementor-column-gap-default">
                        <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-72274e2b wdp-sticky-section-no"
                             data-id="72274e2b" data-element_type="column"
                             data-settings='{"background_background":"slideshow","background_slideshow_gallery":[],"background_slideshow_loop":"yes","background_slideshow_slide_duration":5000,"background_slideshow_slide_transition":"fade","background_slideshow_transition_duration":500}'>
                            <div class="elementor-widget-wrap elementor-element-populated">

                                {{-- Tombol Save the Date (biarkan) --}}
                                <section class="elementor-section elementor-inner-section elementor-element elementor-element-6f89df5f elementor-section-boxed elementor-section-height-default elementor-section-height-default wdp-sticky-section-no"
                                         data-id="6f89df5f" data-element_type="section"
                                         data-settings='{"_ha_eqh_enable":false}'>
                                    <div class="elementor-container elementor-column-gap-default">
                                        <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5f60dcd1 wdp-sticky-section-no"
                                             data-id="5f60dcd1" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div data-dce-background-color="#61CE7000"
                                                     class="elementor-element elementor-element-1a3597d9 elementor-mobile-align-left animated-slow elementor-align-left wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-button"
                                                     data-id="1a3597d9" data-element_type="widget"
                                                     data-settings='{"_animation":"fadeInUp"}'
                                                     data-widget_type="button.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-button-wrapper">
                                                            <a class="elementor-button elementor-button-link elementor-size-md"
                                                               href="https://www.google.com/calendar/render?action=TEMPLATE&text=The%20Wedding%20of%20ANDRE%20and%20YOHANI&details&dates=20260105/20260105&location=#">
                                                                <span class="elementor-button-content-wrapper">
                                                                    <span class="elementor-button-icon elementor-align-icon-left">
                                                                        <i aria-hidden="true" class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                    <span class="elementor-button-text">Save the Date</span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-250a2020 wdp-sticky-section-no"
                                             data-id="250a2020" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div class="elementor-element elementor-element-2efb0a9b animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
                                                     data-id="2efb0a9b" data-element_type="widget"
                                                     data-settings='{"_animation":"fadeInUp"}'
                                                     data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <h2 class="elementor-heading-title elementor-size-default">
                                                            Senin, 05 Januari 2026
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <div class="elementor-element elementor-element-30ef0c68 wdp-sticky-section-no elementor-widget elementor-widget-spacer"
                                     data-id="30ef0c68" data-element_type="widget"
                                     data-widget_type="spacer.default">
                                    <div class="elementor-widget-container">
                                        <div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div>
                                    </div>
                                </div>

                                <div class="elementor-element elementor-element-52821def animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
                                     data-id="52821def" data-element_type="widget"
                                     data-settings='{"_animation":"fadeInUp"}'
                                     data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h2 class="elementor-heading-title elementor-size-default">ANDRE <br>& YOHANI</h2>
                                    </div>
                                </div>

                                {{-- ===== COUNTDOWN (data-date pakai epoch) ===== --}}
@php
    // Tanggal acara: 05 Januari 2026 jam 00:00 WIB
    $targetTs = \Carbon\Carbon::create(2026, 1, 5, 0, 0, 0, 'Asia/Jakarta')->timestamp;
@endphp
                                <div class="elementor-element elementor-element-5b87fa21 animated-slow elementor-countdown--label-block wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-countdown"
                                     data-id="5b87fa21" data-element_type="widget"
                                     data-settings='{"_animation":"zoomIn"}'
                                     data-widget_type="countdown.default">
                                    <div class="elementor-widget-container">
                                        <div class="elementor-countdown-wrapper" data-date="{{ $targetTs }}">
                                            <div class="elementor-countdown-item">
    <span class="elementor-countdown-digits elementor-countdown-days"></span>
    <span class="elementor-countdown-label">Days</span>
  </div>
  <div class="elementor-countdown-item">
    <span class="elementor-countdown-digits elementor-countdown-hours"></span>
    <span class="elementor-countdown-label">Hours</span>
  </div>
  <div class="elementor-countdown-item">
    <span class="elementor-countdown-digits elementor-countdown-minutes"></span>
    <span class="elementor-countdown-label">Minutes</span>
  </div>
  <div class="elementor-countdown-item">
    <span class="elementor-countdown-digits elementor-countdown-seconds"></span>
    <span class="elementor-countdown-label">Seconds</span>
  </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ===== /COUNTDOWN ===== --}}

                            </div>
                        </div>
                    </div>
                </section>

                {{-- Bagian berikutnya tetap seperti punyamu (image + text) --}}
                <section class="elementor-section elementor-inner-section elementor-element elementor-element-24854499 elementor-section-boxed elementor-section-height-default elementor-section-height-default wdp-sticky-section-no"
                         data-id="24854499" data-element_type="section"
                         data-settings='{"_ha_eqh_enable":false}'>
                    <div class="elementor-container elementor-column-gap-default">
                        <div data-dce-background-color="#00000052"
                             class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-4293623 wdp-sticky-section-no"
                             data-id="4293623" data-element_type="column"
                             data-settings='{"background_background":"classic"}'>
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div data-dce-advanced-background-color="#FFFFFF"
                                     class="elementor-element elementor-element-4d9c5431 wdp-sticky-section-no elementor-widget elementor-widget-spacer"
                                     data-id="4d9c5431" data-element_type="widget"
                                     data-widget_type="spacer.default">
                                    <div class="elementor-widget-container">
                                        <div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div>
                                    </div>
                                </div>

                                <div class="elementor-element elementor-element-76e6584c animated-slow dce_masking-none wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-image"
                                     data-id="76e6584c" data-element_type="widget"
                                     data-settings='{"_animation":"slideInUp"}'
                                     data-widget_type="image.default">
                                    <div class="elementor-widget-container">
                                        <img fetchpriority="high" decoding="async" width="1280" height="1600"
                                             class="attachment-full size-full wp-image-107044" alt=""
                                             srcset="{{ asset('assets/mymage/IMG_9573-400w.webp') }} 400w, 
                                                     {{ asset('assets/mymage/IMG_9573-600w.webp') }} 600w, 
                                                     {{ asset('assets/mymage/IMG_9573-800w.webp') }} 800w, 
                                                     {{ asset('assets/mymage/IMG_9573-1000w.webp') }} 1000w, 
                                                     {{ asset('assets/mymage/IMG_9573-1200w.webp') }} 1200w, 
                                                     {{ asset('assets/mymage/IMG_9573-1600w.webp') }} 1600w, 
                                                     {{ asset('assets/mymage/IMG_9573-2000w.webp') }} 2000w"
                                             sizes="(max-width: 400px) 400px, 
                                                    (max-width: 600px) 600px, 
                                                    (max-width: 800px) 800px, 
                                                    (max-width: 1000px) 1000px, 
                                                    (max-width: 1200px) 1200px, 
                                                    (max-width: 1600px) 1600px, 
                                                    (min-width: 1601px) 2000px" 
                                             src="{{ asset('assets/mymage/IMG_9573.jpeg') }}" />
                                    </div>
                                </div>

                                <div class="elementor-element elementor-element-7e72021e animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
                                     data-id="7e72021e" data-element_type="widget"
                                     data-settings='{"_animation":"fadeInUp"}'
                                     data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h2 class="elementor-heading-title elementor-size-default">
                                            We have come to our new life, we want to share the joy of our marriage with all
                                            the families and friends. We write this invitation to invite all of you to share
                                            the joy with us on our wedding.
                                        </h2>
                                    </div>
                                </div>

                                <div data-dce-advanced-background-color="#FFFFFF"
                                     class="elementor-element elementor-element-1470c29e wdp-sticky-section-no elementor-widget elementor-widget-spacer"
                                     data-id="1470c29e" data-element_type="widget"
                                     data-widget_type="spacer.default">
                                    <div class="elementor-widget-container">
                                        <div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {{-- ===================== /SECTION: HERO + COUNTDOWN ===================== --}}

            </div>
        </div>
    </div>
</section>
