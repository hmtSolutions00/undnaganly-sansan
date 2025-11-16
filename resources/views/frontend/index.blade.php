<!DOCTYPE html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

@include('partials.fe.head')


<body class="wp-singular post-template post-template-elementor_canvas single single-post postid-107013 single-format-standard wp-embed-responsive wp-theme-generatepress wp-child-theme-generatepress_child right-sidebar nav-float-right separate-containers header-aligned-left dropdown-hover featured-image-active elementor-default elementor-template-canvas elementor-kit-6 elementor-page elementor-page-107013">
	<div data-elementor-type="wp-post" data-elementor-id="107013" class="elementor elementor-107013"
		data-elementor-post-type="post">
		{{-- Save THE DATE --}}
		@include('partials.fe.savedate')

		{{-- End DATE AND SAVE THE DATE --}}

		{{-- Data backgounrd di butuhkan  --}}
			@include('partials.fe.slider')
		{{-- End data backgournd --}}

		{{-- Section Groom dan bride --}}
		@include('partials.fe.grombride')
		{{-- End section groom and bride --}}
	

		{{-- space --}}
		<section data-dce-background-color="#000000"
			class="elementor-section elementor-top-section elementor-element elementor-element-0cef454 elementor-section-boxed elementor-section-height-default elementor-section-height-default wdp-sticky-section-no"
			data-id="0cef454" data-element_type="section"
			data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;_ha_eqh_enable&quot;:false}">
			<div class="elementor-container elementor-column-gap-no">
				<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-c5e2c87 wdp-sticky-section-no"
					data-id="c5e2c87" data-element_type="column">
					<div class="elementor-widget-wrap elementor-element-populated">
						<div class="elementor-element elementor-element-e8d8b04 wdp-sticky-section-no elementor-widget elementor-widget-spacer"
							data-id="e8d8b04" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-widget-container">
								<div class="elementor-spacer">
									<div class="elementor-spacer-inner"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		{{-- space --}}
		{{-- Section holy natrimony detail acara --}}
			@include('partials.fe.holy')
		{{-- End section holy natrimony --}}

		{{-- Gelery --}}
		@include('partials.fe.galery')
		{{-- End galery --}}

		{{-- Wedding Gift  and wishes--}}
		<section data-dce-background-overlay-color="#00000082"
	class="elementor-section elementor-top-section elementor-element elementor-element-4bc32b50 elementor-section-height-min-height elementor-section-items-top elementor-section-boxed elementor-section-height-default wdp-sticky-section-no"
	data-id="4bc32b50" data-element_type="section"
	{{-- Gambar slideshow dipanggil dari public/background --}}
	data-settings="{&quot;background_background&quot;:&quot;slideshow&quot;,
		&quot;background_slideshow_gallery&quot;:[
			{&quot;id&quot;:107028,&quot;url&quot;:&quot;{{ asset('assets/bottom_bg/B_bg1.jpeg') }}&quot;},
			{&quot;id&quot;:107043,&quot;url&quot;:&quot;{{ asset('assets/bottom_bg/b_bg2.jpeg') }}&quot;}
		],
		&quot;background_slideshow_slide_duration&quot;:2000,
		&quot;background_slideshow_transition_duration&quot;:2000,
		&quot;background_slideshow_loop&quot;:&quot;yes&quot;,
		&quot;background_slideshow_slide_transition&quot;:&quot;fade&quot;,
		&quot;_ha_eqh_enable&quot;:false}">
	<div class="elementor-background-overlay"></div>
	<div class="elementor-container elementor-column-gap-no">
		<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6abdb50d wdp-sticky-section-no"
			data-id="6abdb50d" data-element_type="column"
			data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
			<div class="elementor-widget-wrap elementor-element-populated">

		{{-- Section Gift  --}}
				@include('partials.fe.gift')
		{{-- End section gift --}}
		{{-- Section rsvp --}}
				@include('partials.fe.rsvp')	
		{{-- End section rsvp --}}
{{-- section wishes --}}
				@include('partials.fe.wishes')
{{-- end section wishes --}}
						{{-- Section terimakasih  --}}
						<section
							class="elementor-section elementor-inner-section elementor-element elementor-element-6128294f elementor-section-height-min-height elementor-section-boxed elementor-section-height-default wdp-sticky-section-no"
							data-id="6128294f" data-element_type="section"
							data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;_ha_eqh_enable&quot;:false}">
							<div class="elementor-background-overlay"></div>
							<div class="elementor-container elementor-column-gap-default">
								<div data-dce-background-color="#00000052"
									class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-67b41093 wdp-sticky-section-no"
									data-id="67b41093" data-element_type="column"
									data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
									<div class="elementor-widget-wrap elementor-element-populated">
										<section
											class="elementor-section elementor-inner-section elementor-element elementor-element-4d3f3d5 elementor-section-boxed elementor-section-height-default elementor-section-height-default wdp-sticky-section-no"
											data-id="4d3f3d5" data-element_type="section"
											data-settings="{&quot;_ha_eqh_enable&quot;:false}">
											<div class="elementor-container elementor-column-gap-no">
												<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6675b8e4 wdp-sticky-section-no"
													data-id="6675b8e4" data-element_type="column">
													<div class="elementor-widget-wrap elementor-element-populated">
														<div class="elementor-element elementor-element-3fe23a25 animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
															data-id="3fe23a25" data-element_type="widget"
															data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
															data-widget_type="heading.default">
															<div class="elementor-widget-container">
																<h2
																	class="elementor-heading-title elementor-size-default">
																	TERIMA</h2>
															</div>
														</div>
													</div>
												</div>
												<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1958ede0 wdp-sticky-section-no"
													data-id="1958ede0" data-element_type="column">
													<div class="elementor-widget-wrap elementor-element-populated">
														<div class="elementor-element elementor-element-1110dc9c animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
															data-id="1110dc9c" data-element_type="widget"
															data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
															data-widget_type="heading.default">
															<div class="elementor-widget-container">
																<h2
																	class="elementor-heading-title elementor-size-default">
																	Kasih</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</section>
										<div class="elementor-element elementor-element-6f0012db animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
											data-id="6f0012db" data-element_type="widget"
											data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
											data-widget_type="heading.default">
											<div class="elementor-widget-container">
												<h2 class="elementor-heading-title elementor-size-default">Merupakan
													suatu kehormatan bagi kami atas kehadiran dan doa restu
													Bapak/Ibu/Saudara/i. Atas kehadiran dan doa restu
													Bapak/Ibu/Saudara/i, kami sampaikan terima kasih.</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
						{{-- End section terimakasih --}}
					</div>
				</div>
			</div>
		</section>

		<section data-dce-background-color="#000000"
			class="elementor-section elementor-top-section elementor-element elementor-element-2a28eb7b elementor-section-boxed elementor-section-height-default elementor-section-height-default wdp-sticky-section-no"
			data-id="2a28eb7b" data-element_type="section"
			data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;_ha_eqh_enable&quot;:false}">
			<div class="elementor-container elementor-column-gap-no">
				<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-31d493f3 wdp-sticky-section-no"
					data-id="31d493f3" data-element_type="column">
					<div class="elementor-widget-wrap elementor-element-populated">
						<section data-dce-background-overlay-color="#00000080"
							class="elementor-section elementor-inner-section elementor-element elementor-element-1e30f7e7 elementor-section-height-min-height elementor-section-boxed elementor-section-height-default wdp-sticky-section-no"
							data-id="1e30f7e7" data-element_type="section"
							data-settings="{&quot;background_background&quot;:&quot;slideshow&quot;,
						&quot;background_slideshow_gallery&quot;:[
							{&quot;id&quot;:107037,&quot;url&quot;:&quot;{{ asset('assets/bottom_bg/bg_b1.jpeg') }}&quot;},
							{&quot;id&quot;:107032,&quot;url&quot;:&quot;{{ asset('assets/bottom_bg/bg_b2.jpeg') }}&quot;}
						],
						&quot;background_slideshow_slide_duration&quot;:2000,
						&quot;background_slideshow_transition_duration&quot;:2000,
						&quot;background_slideshow_loop&quot;:&quot;yes&quot;,
						&quot;background_slideshow_slide_transition&quot;:&quot;fade&quot;,
						&quot;_ha_eqh_enable&quot;:false}">
							<div class="elementor-background-overlay"></div>
							<div class="elementor-container elementor-column-gap-no">
								<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-2530582b wdp-sticky-section-no"
									data-id="2530582b" data-element_type="column">
									<div class="elementor-widget-wrap elementor-element-populated">
										<div class="elementor-element elementor-element-3da979ee animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
											data-id="3da979ee" data-element_type="widget"
											data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
											data-widget_type="heading.default">
											<div class="elementor-widget-container">
												<h2 class="elementor-heading-title elementor-size-default">ANDRE<br>&
													YOHANI</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</section>
		{{-- Section footer --}}
		@include('partials.fe.footer')
		{{-- End section footer --}}
		{{-- Mungkin section autoplay music --}}
		@include('partials.fe.autoplay')
		{{-- End section auto play --}}
	</div>
	{{-- Start js and libbracy call --}}
	@include('partials.fe.js')
</body>
</html>
