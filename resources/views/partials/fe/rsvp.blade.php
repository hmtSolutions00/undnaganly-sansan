<section
    class="elementor-section elementor-inner-section elementor-element elementor-element-273388c1 elementor-section-height-min-height elementor-section-boxed elementor-section-height-default wdp-sticky-section-no rsvp-section"
    data-id="273388c1" data-element_type="section"
    data-settings='{"background_background":"classic","_ha_eqh_enable":false}'>

    <div class="elementor-background-overlay"></div>

    <div class="elementor-container elementor-column-gap-default">
        <div data-dce-background-color="#00000052"
             class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-596556b3 wdp-sticky-section-no"
             data-id="596556b3" data-element_type="column"
             data-settings='{"background_background":"classic"}'>

            <div class="elementor-widget-wrap elementor-element-populated">

                {{-- Judul --}}
                <div class="elementor-element elementor-element-467eb498 animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
                     data-id="467eb498" data-element_type="widget"
                     data-settings='{"_animation":"fadeInUp"}'
                     data-widget_type="heading.default">
                    <div class="elementor-widget-container">
                        <h2 class="elementor-heading-title elementor-size-default">RSVP</h2>
                    </div>
                </div>

                <div class="elementor-element elementor-element-66974fc9 animated-slow wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-heading"
                     data-id="66974fc9" data-element_type="widget"
                     data-settings='{"_animation":"fadeInUp"}'
                     data-widget_type="heading.default">
                    <div class="elementor-widget-container">
                        <h2 class="elementor-heading-title elementor-size-default">
                            Dimohon untuk mengisi konfirmasi kehadiran di bawah ini.
                        </h2>
                    </div>
                </div>

                {{-- FORM RSVP --}}
                <div class="elementor-element elementor-element-139fc9f4 fluentform-widget-submit-button-center animated-slow fluent-form-widget-step-header-yes fluent-form-widget-step-progressbar-yes fluentform-widget-submit-button-custom wdp-sticky-section-no elementor-invisible elementor-widget elementor-widget-fluent-form-widget"
                     data-id="139fc9f4" data-element_type="widget"
                     data-settings='{"_animation":"fadeInUp"}'
                     data-widget_type="fluent-form-widget.default">

                    <div class="elementor-widget-container">

                        <div class="fluentform-widget-wrapper fluentform-widget-align-default">
                            <div class="fluentform fluentform_wrapper_1583">

                                <form
                                    id="rsvp_form"
                                    method="POST"
                                    action="{{ route('invite.rsvp.store', $invitation) }}"
                                    class="frm-fluent-form fluent_form_1583 ff-el-form-top ff_form_instance_1583_1"
                                >
                                    @csrf

                                    <fieldset style="border:none!important;margin:0!important;padding:0!important;background-color:transparent!important;box-shadow:none!important;outline:none!important;min-inline-size:100%;">
                                        <legend class="ff_screen_reader_title"
                                                style="display:block;margin:0!important;padding:0!important;height:0!important;text-indent:-999999px;width:0!important;overflow:hidden;">
                                            RSVP {{ $guestName ?? '' }}
                                        </legend>

                                        {{-- NAMA --}}
                                        <div class="ff-el-group">
                                            <div class="ff-el-input--label ff-el-is-required asterisk-right">
                                                <label for="rsvp_name" aria-label="Nama">Nama</label>
                                            </div>
                                            <div class="ff-el-input--content">
                                                <input
                                                    type="text"
                                                    name="name"
                                                    id="rsvp_name"
                                                    class="ff-el-form-control"
                                                    placeholder="Nama"
                                                    value="{{ old('name', $guestName) }}"
                                                    aria-required="true"
                                                    required
                                                >
                                            </div>
                                        </div>

                                        {{-- KONFIRMASI KEHADIRAN --}}
                                        <div class="ff-el-group">
                                            <div class="ff-el-input--label ff-el-is-required asterisk-right">
                                                <label for="rsvp_status" aria-label="Konfirmasi Kehadiran">
                                                    Konfirmasi Kehadiran
                                                </label>
                                            </div>
                                            <div class="ff-el-input--content">
                                                <select
                                                    name="status"
                                                    id="rsvp_status"
                                                    class="ff-el-form-control"
                                                    aria-required="true"
                                                    required
                                                >
                                                    <option value="">- Select -</option>
                                                    <option value="hadir" @selected(old('status') === 'hadir')>
                                                        Hadir
                                                    </option>
                                                    <option value="tidak_hadir" @selected(old('status') === 'tidak_hadir')>
                                                        Tidak Hadir
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- JUMLAH ORANG --}}
                                        <div class="ff-el-group">
                                            <div class="ff-el-input--label ff-el-is-required asterisk-right">
                                                <label for="rsvp_jumlah" aria-label="Jumlah">Jumlah</label>
                                            </div>
                                            <div class="ff-el-input--content">
            <select
                name="total_attendees"
                id="rsvp_jumlah"
                class="ff-el-form-control"
                aria-required="true"
                required
            >
                <option value="">- Select -</option>
                <option value="1" @selected(old('total_attendees') == 1)>1 Orang</option>
                <option value="2" @selected(old('total_attendees') == 2)>2 Orang</option>
                <option value="3" @selected(old('total_attendees') == 3)>3 Orang</option>
                <option value="4" @selected(old('total_attendees') == 4)>4 Orang</option>
            </select>
        </div>
    </div>

    {{-- TOMBOL SUBMIT --}}
    <div class="ff-el-group ff-text-left ff_submit_btn_wrapper">
        <button type="submit"
                class="ff-btn ff-btn-submit ff-btn-md ff_btn_style">
            Submit Form
        </button>
    </div>

    {{-- ALERT SUKSES / ERROR --}}
    @if(session('rsvp_success'))
        <div class="rsvp-alert rsvp-alert-success">
            {{ session('rsvp_success') }}
        </div>
    @endif

    @if ($errors->has('name') || $errors->has('status') || $errors->has('total_attendees'))
        <div class="rsvp-alert rsvp-alert-error">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</fieldset>
</form>

@php
    /** @var \Illuminate\Support\Collection|\App\Models\Rsvp[] $rsvps */
    $rsvpHadir = $rsvps->where('status', 'hadir');
@endphp

{{-- DAFTAR ORANG YANG HADIR --}}
@if($rsvpHadir->isNotEmpty())
    <div class="rsvp-list-wrapper">
        <div class="rsvp-list-title">
            Konfirmasi Kehadiran
        </div>
        <ul class="rsvp-list">
            @foreach($rsvpHadir as $item)
                <li class="rsvp-list-item">
                    {{ $item->name }} <span>- Hadir</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif

                            </div> {{-- .fluentform_wrapper_1583 --}}
                        </div> {{-- .fluentform-widget-wrapper --}}

                    </div> {{-- .elementor-widget-container --}}
                </div> {{-- widget form --}}
            </div>
        </div>
    </div>

    {{-- STYLE KHUSUS RSVP (scoped ke .rsvp-section) --}}
    <style>
        .rsvp-section .elementor-heading-title {
            color: #fff;
        }

        .rsvp-section .ff-el-input--label label {
            color: #fff;
            font-weight: 500;
            letter-spacing: .03em;
        }

        .rsvp-section .ff-el-form-control {
            background: rgba(0,0,0,.45);
            border: 1px solid rgba(255,255,255,.4);
            color: #fff;
            border-radius: 8px;
        }

        .rsvp-section .ff-el-form-control::placeholder {
            color: rgba(255,255,255,.6);
        }

        .rsvp-section .ff-el-form-control:focus {
            outline: none;
            box-shadow: 0 0 0 1px rgba(255,255,255,.6);
        }

        .rsvp-section .ff-btn-submit {
            background: #ffffff;
            color: #000000;
            border-radius: 999px;
            padding: .6rem 2.5rem;
            border: none;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .rsvp-section .ff-btn-submit:hover {
            filter: brightness(0.9);
        }

        .rsvp-section .rsvp-alert {
            margin-top: 1rem;
            padding: .6rem .9rem;
            border-radius: 10px;
            font-size: .85rem;
            color: #fff;
            background: rgba(0,0,0,.55);
            border: 1px solid rgba(255,255,255,.2);
        }

        .rsvp-section .rsvp-alert-success {
            border-color: rgba(144,238,144,.8);
        }

        .rsvp-section .rsvp-alert-error {
            border-color: rgba(255,99,132,.85);
        }

        .rsvp-section .rsvp-list-wrapper {
            margin-top: 1.5rem;
            padding: .75rem 1rem;
            border-radius: 12px;
            background: rgba(0,0,0,.5);
            border: 1px solid rgba(255,255,255,.25);
            max-height: 220px;       /* tinggi tetap */
            overflow-y: auto;        /* scroll kalau banyak */
        }

        .rsvp-section .rsvp-list-title {
            font-size: .9rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: .4rem;
            color: rgba(255,255,255,.8);
        }

        .rsvp-section .rsvp-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .rsvp-section .rsvp-list-item {
            padding: .2rem 0;
            font-size: .9rem;
            color: #fff;
            border-bottom: 1px dashed rgba(255,255,255,.18);
        }

        .rsvp-section .rsvp-list-item:last-child {
            border-bottom: none;
        }

        .rsvp-section .rsvp-list-item span {
            margin-left: .25rem;
            opacity: .85;
            font-style: italic;
        }
    </style>

</section>
