<section
    class="elementor-section elementor-inner-section elementor-element elementor-element-1b7cded2 elementor-section-height-min-height elementor-section-boxed elementor-section-height-default wdp-sticky-section-no wishes-section"
    data-id="1b7cded2" data-element_type="section"
    data-settings='{"background_background":"classic","_ha_eqh_enable":false}'>

    <div class="elementor-background-overlay"></div>

    <div class="elementor-container elementor-column-gap-default">
        <div data-dce-background-color="#00000052"
             class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-588f9b6 wdp-sticky-section-no"
             data-id="588f9b6" data-element_type="column"
             data-settings='{"background_background":"classic"}'>

            <div class="elementor-widget-wrap elementor-element-populated">
                <div class="elementor-element elementor-element-8bf928f animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
                     data-id="8bf928f" data-element_type="widget"
                     data-settings='{"_animation":"fadeInUp"}'
                     data-widget_type="heading.default">
                    <div class="elementor-widget-container">

                        <h2 class="elementor-heading-title elementor-size-default">WISHES</h2>

                        {{-- FORM WISHES --}}
                        <div id="wishes-form" class="wishes-form">
                            <form method="POST"
                                  action="{{ route('invite.wishes.store', $invitation) }}"
                                  class="wishes-form-inner">
                                @csrf

                                <div class="wf-group">
                                    <label class="wf-label">
                                        Nama <span class="wf-req">*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           class="wf-input"
                                           placeholder="Nama"
                                           value="{{ old('name', $guestName) }}"
                                           required>
                                </div>

                                <div class="wf-group">
                                    <label class="wf-label">
                                        Ucapan <span class="wf-req">*</span>
                                    </label>
                                    <textarea name="message"
                                              rows="4"
                                              class="wf-input"
                                              placeholder="Tulis ucapan terbaikmu…"
                                              required>{{ old('message') }}</textarea>
                                </div>

                                <div class="wf-actions">
                                    <button type="submit" class="wf-btn">Kirim Ucapan</button>
                                </div>

                                {{-- ALERT SUKSES / ERROR --}}
                                @if(session('wish_success'))
                                    <div class="wish-alert wish-alert-success">
                                        {{ session('wish_success') }}
                                    </div>
                                @endif

                                @if ($errors->has('name') || $errors->has('message'))
                                    <div class="wish-alert wish-alert-error">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        </div>

                        {{-- DAFTAR WISHES (UCAPAN) --}}
                        @php
                            /** @var \Illuminate\Support\Collection|\App\Models\Wish[] $wishes */
                            $publicWishes = $wishes; // sudah difilter is_public=true di controller
                        @endphp

                        @if($publicWishes->isNotEmpty())
                            <div class="wishes-list-wrapper">
                                <div class="wishes-list-title">
                                    Ucapan & Doa
                                </div>
                                <ul class="wishes-list">
                                    @foreach($publicWishes as $wish)
                                        <li class="wishes-list-item">
                                            <div class="wishes-list-name">
                                                {{ $wish->name }}
                                            </div>
                                            <div class="wishes-list-message">
                                                {{ $wish->message }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- STYLE KHUSUS WISHES --}}
    <style>
        .wishes-section .elementor-heading-title {
            color: #fff;
        }

        .wishes-section .wf-label {
            color: #fff;
            font-weight: 500;
            font-size: .9rem;
            letter-spacing: .03em;
        }

        .wishes-section .wf-req {
            color: #ffbcbc;
        }

        .wishes-section .wf-input {
            width: 100%;
            background: rgba(0,0,0,.45);
            border: 1px solid rgba(255,255,255,.4);
            color: #fff;
            border-radius: 8px;
            padding: .55rem .75rem;
            font-size: .9rem;
        }

        .wishes-section .wf-input::placeholder {
            color: rgba(255,255,255,.6);
        }

        .wishes-section .wf-input:focus {
            outline: none;
            box-shadow: 0 0 0 1px rgba(255,255,255,.6);
        }

        .wishes-section .wf-group {
            margin-bottom: .8rem;
        }

        .wishes-section .wf-btn {
            background: #ffffff;
            color: #000000;
            border-radius: 999px;
            padding: .55rem 2.3rem;
            border: none;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
        }

        .wishes-section .wf-btn:hover {
            filter: brightness(0.9);
        }

        .wishes-section .wish-alert {
            margin-top: .9rem;
            padding: .55rem .8rem;
            border-radius: 10px;
            font-size: .85rem;
            color: #fff;
            background: rgba(0,0,0,.55);
            border: 1px solid rgba(255,255,255,.2);
        }

        .wishes-section .wish-alert-success {
            border-color: rgba(144,238,144,.8);
        }

        .wishes-section .wish-alert-error {
            border-color: rgba(255,99,132,.85);
        }

        .wishes-section .wishes-list-wrapper {
            margin-top: 1.5rem;
            padding: .75rem 1rem;
            border-radius: 12px;
            background: rgba(0,0,0,.5);
            border: 1px solid rgba(255,255,255,.25);
            max-height: 260px;      /* tinggi box ucapan */
            overflow-y: auto;       /* scroll kalau banyak */
        }

        .wishes-section .wishes-list-title {
            font-size: .9rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: .4rem;
            color: rgba(255,255,255,.8);
        }

        .wishes-section .wishes-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .wishes-section .wishes-list-item {
            padding: .45rem 0;
            border-bottom: 1px dashed rgba(255,255,255,.18);
        }

        .wishes-section .wishes-list-item:last-child {
            border-bottom: none;
        }

        .wishes-section .wishes-list-name {
            font-weight: 600;
            color: #fff;
            margin-bottom: .1rem;
        }

        .wishes-section .wishes-list-message {
            font-size: .9rem;
            color: rgba(255,255,255,.9);
        }
    </style>

</section>
