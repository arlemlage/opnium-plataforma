<div class="offcanvas offcanvas-end" data-bs-scroll="false" tabindex="-1" id="offcanvas_right_button"
    aria-labelledby="offcanvasWithBackdropLabel">
    <div class="offcanvas-header justify-content-end">
        <button type="button" class="btn-close text-reset bacdropBtnClose" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <a class="mb-4 d-block canvas-logo" href="{{ route('home') }}">
            <img loading="lazy" src="{{ asset(siteSetting()->logo) }}" alt="">
        </a>
        <p class="canvas-text">{{ siteSetting()->footer_text ?? '' }}</p>
        <h4 class="canvas_inter_title">@lang('index.get_in_touch')</h4>
        <div class="footer-contact-info">            
            <div class="d-flex">
                <a href="mailto:{{ siteSetting()->email ?? '' }}">
                    <div class="footer-icon"><i class="bi bi-envelope-fill"></i></div>
                    {{ siteSetting()->email ?? '' }}
                </a>
            </div>
            <div class="d-flex">
                <a href="tel:{{ siteSetting()->phone ?? '' }}">
                    <div class="footer-icon"><i class="bi bi-telephone-fill"></i></div>
                    {{ siteSetting()->phone ?? '' }}
                </a>
            </div>
            <div class="d-flex">
                <a href="tel:{{ siteSetting()->phone ?? '' }}">
                    <div class="footer-icon"><i class="bi bi-whatsapp"></i></div>
                    {{ siteSetting()->phone ?? '' }}
                </a>
            </div>
            <div class="address-info">
                <div class="footer-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <span>{{ siteSetting()->address ?? '' }}</span>
            </div>
        </div>
        <h4 class="canvas_inter_title mt-4">@lang('index.need_more_help')</h4>
        <div class="subscribe-form">
            <form action="#" method="post" class="offcanvas-body-form">
                <input type="text" class="form-control email_subscribe_off_canvas" placeholder="@lang('index.enter_your_email')" aria-label="Enter your email">
                <button class="gt-btn" type="submit"><svg width="20" height="20"
                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_69_106)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.3159 5.69288L7.71814 10.2753L0.817145 7.97383C0.335444 7.81288 0.0109179 7.36078 0.0136895 6.85287C0.0164975 6.34496 0.344743 5.89563 0.828304 5.7403L18.4718 0.0565164C18.8912 -0.0783506 19.3515 0.0323301 19.6631 0.34398C19.9746 0.655629 20.0852 1.11608 19.9504 1.53564L14.2685 19.1851C14.1133 19.6688 13.6641 19.9972 13.1563 20C12.6486 20.0028 12.1967 19.6781 12.0358 19.1963L9.72398 12.2595L14.3159 5.69288Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_69_106">
                            <rect width="19.9932" height="20" fill="white"
                                transform="translate(0.0136719)" />
                        </clipPath>
                    </defs>
                </svg></button>
            </form>
        </div>
        <div class="social-icons-off-canvas">
            <a target="_blank" href="{{ siteSetting()->facebook_url ?? '#' }}">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.0625 9.35312V16H8.6875V9.35312H11.3906L11.9531 6.29688H8.6875V5.21562C8.6875 3.6 9.32188 2.98125 10.9594 2.98125C11.4688 2.98125 11.8781 2.99375 12.1156 3.01875V0.246875C11.6688 0.125 10.575 0 9.94375 0C6.60312 0 5.0625 1.57812 5.0625 4.98125V6.29688H3V9.35312H5.0625Z"
                        fill="#2D2C2B" />
                </svg>


            </a>
            <a target="_blank" href="{{ siteSetting()->twitter_url ?? '#' }}">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.3553 5.23856C14.3655 5.38069 14.3655 5.52284 14.3655 5.66497C14.3655 9.99997 11.066 14.9949 5.03553 14.9949C3.17766 14.9949 1.45178 14.4568 0 13.5228C0.263969 13.5533 0.51775 13.5634 0.791875 13.5634C2.32484 13.5634 3.73603 13.0457 4.86294 12.1624C3.42131 12.132 2.21319 11.1878 1.79694 9.88831C2 9.91875 2.20303 9.93906 2.41625 9.93906C2.71066 9.93906 3.00509 9.89844 3.27919 9.82741C1.77666 9.52281 0.649719 8.20303 0.649719 6.60913V6.56853C1.08625 6.81219 1.59391 6.96447 2.13194 6.98475C1.24869 6.39591 0.670031 5.39084 0.670031 4.25378C0.670031 3.64466 0.832437 3.08628 1.11672 2.59897C2.73094 4.58881 5.15734 5.88828 7.87812 6.03044C7.82737 5.78678 7.79691 5.533 7.79691 5.27919C7.79691 3.47206 9.25884 2 11.0761 2C12.0202 2 12.873 2.39594 13.472 3.03553C14.2131 2.89341 14.9238 2.61928 15.5532 2.24366C15.3096 3.00509 14.7918 3.64469 14.1116 4.05075C14.7715 3.97972 15.4111 3.79694 15.9999 3.54316C15.5533 4.19287 14.9949 4.77153 14.3553 5.23856Z"
                        fill="#2D2C2B" />
                </svg>
            </a>
            <a target="_blank" href="{{ siteSetting()->instagram_url ?? '#' }}">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_93_172)">
                        <path
                            d="M0 1.146C0 0.513 0.526 0 1.175 0H14.825C15.474 0 16 0.513 16 1.146V14.854C16 15.487 15.474 16 14.825 16H1.175C0.526 16 0 15.487 0 14.854V1.146ZM4.943 13.394V6.169H2.542V13.394H4.943ZM3.743 5.182C4.58 5.182 5.101 4.628 5.101 3.934C5.086 3.225 4.581 2.686 3.759 2.686C2.937 2.686 2.4 3.226 2.4 3.934C2.4 4.628 2.921 5.182 3.727 5.182H3.743ZM8.651 13.394V9.359C8.651 9.143 8.667 8.927 8.731 8.773C8.904 8.342 9.299 7.895 9.963 7.895C10.832 7.895 11.179 8.557 11.179 9.529V13.394H13.58V9.25C13.58 7.03 12.396 5.998 10.816 5.998C9.542 5.998 8.971 6.698 8.651 7.191V7.216H8.635L8.651 7.191V6.169H6.251C6.281 6.847 6.251 13.394 6.251 13.394H8.651Z"
                            fill="#2D2C2B" />
                    </g>
                    <defs>
                        <clipPath id="clip0_93_172">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </a>
            <a target="_blank" href="{{ siteSetting()->dribble_url ?? '#' }}">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8.375 0.203125C5.16875 0.203125 2 2.34063 2 5.8C2 8 3.2375 9.25 3.9875 9.25C4.29688 9.25 4.475 8.3875 4.475 8.14375C4.475 7.85313 3.73438 7.23438 3.73438 6.025C3.73438 3.5125 5.64687 1.73125 8.12187 1.73125C10.25 1.73125 11.825 2.94063 11.825 5.1625C11.825 6.82188 11.1594 9.93438 9.00313 9.93438C8.225 9.93438 7.55937 9.37188 7.55937 8.56563C7.55937 7.38438 8.38438 6.24063 8.38438 5.02188C8.38438 2.95313 5.45 3.32813 5.45 5.82813C5.45 6.35313 5.51562 6.93438 5.75 7.4125C5.31875 9.26875 4.4375 12.0344 4.4375 13.9469C4.4375 14.5375 4.52187 15.1188 4.57812 15.7094C4.68438 15.8281 4.63125 15.8156 4.79375 15.7563C6.36875 13.6 6.3125 13.1781 7.025 10.3563C7.40938 11.0875 8.40313 11.4813 9.19063 11.4813C12.5094 11.4813 14 8.24688 14 5.33125C14 2.22813 11.3188 0.203125 8.375 0.203125Z"
                        fill="#2D2C2B" />
                </svg>
            </a>
        </div>
    </div>
</div>
