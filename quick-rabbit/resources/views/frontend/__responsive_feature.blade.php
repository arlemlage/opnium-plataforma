<div class="feature-section-wrap feature-section-wrap-responsive d-none" data-aos="fade-left" data-aos-easing="linear"
    data-aos-duration="1500">
    <div class="feature-section">
        <div class="feature-card">
            <div class="feature-body">
                <div class="icon">
                    <img src="{{ featureSetting()[0]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[0]['icon']) : asset('assets/frontend/img/core-img/ai_powered.svg') }}"
                        alt="" class="icon-image">
                </div>
                <div class="content">
                    <h5 class="">{{ featureSetting()[0]['title'] }}</h5>
                    <p class="mb-0">
                        {{ featureSetting()[0]['description'] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-body">
                <div class="icon">
                    <img src="{{ featureSetting()[1]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[1]['icon']) : asset('assets/frontend/img/core-img/knowledgebase.svg') }}"
                        alt="" class="icon-image">
                </div>
                <div class="content">
                    <h5 class="">{{ featureSetting()[1]['title'] }}</h5>
                    <p class="mb-0">{{ featureSetting()[1]['description'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-section">
        <div class="feature-card">
            <div class="feature-body">
                <div class="icon">
                    <img src="{{ featureSetting()[2]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[2]['icon']) : asset('assets/frontend/img/core-img/support.svg') }}"
                        alt="" class="icon-image">
                </div>
                <div class="content">
                    <h5 class="">{{ featureSetting()[2]['title'] }}</h5>
                    <p class="mb-0">{{ featureSetting()[2]['description'] }}</p>
                </div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-body">
                <div class="icon">
                    <img src="{{ featureSetting()[3]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[3]['icon']) : asset('assets/frontend/img/core-img/live_chat.svg') }}"
                        alt="" class="icon-image">
                </div>
                <div class="content">
                    <h5 class="">{{ featureSetting()[3]['title'] }}</h5>
                    <p class="mb-0">{{ featureSetting()[3]['description'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-section">
        <div class="feature-card">
            <div class="feature-body">
                <div class="icon">
                    <img src="{{ featureSetting()[4]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[4]['icon']) : asset('assets/frontend/img/core-img/crm.svg') }}"
                        alt="" class="icon-image">
                </div>
                <div class="content">
                    <h5 class="">{{ featureSetting()[4]['title'] }}</h5>
                    <p class="mb-0">{{ featureSetting()[4]['description'] }}</p>
                </div>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-body">
                <div class="icon">
                    <img src="{{ featureSetting()[5]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[5]['icon']) : asset('assets/frontend/img/core-img/forum.svg') }}"
                        alt="" class="icon-image">
                </div>
                <div class="content">
                    <h5 class="">{{ featureSetting()[5]['title'] }}</h5>
                    <p class="mb-0">{{ featureSetting()[5]['description'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
