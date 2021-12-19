<div class="modal" tabindex="-1" role="dialog" id='modal{{ $offer->id }}'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('To Continue you must agree to the T&Cs') }}</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="english" dir="ltr">
                    <h2>Restrictions</h2>
                    <ul>
                        <li>You may not bid on any of the
                            <b>{{ $offer->name }}</b> terms or variations in paid search ads, such as Google Adwords, Google PPC, and FaceBook Ads.
                        </li>
                        <li>You may not use the
                            <b>{{ $offer->name }}</b> name or any of its variations in pop-ups and pop-unders, as the name of your newsletter, in retargeting campaigns, in your app push notifications ads, or in wrong or misleading messages.
                        </li>
                        <li>You may not use methods such as cookie stuffing.</li>
                        <li>ou may not promote
                            <b>{{ $offer->name }}</b> in any sexually explicit materials, violent materials, libelous or defamatory materials, or any illegal activities.
                        </li>
                        <li>You may not promote
                            <b>{{ $offer->name }}</b> if you employ discriminatory practices, based on race, sex, religion, nationality, disability, sexual orientation, or age.
                        </li>
                        <li>You may not use a link to
                            <b>{{ $offer->name }}</b> which includes a redirecting link, that is generated or displayed on a Search Engine in response to a general Internet keyword search query, whether those links appear through your submission of data to that site or otherwise.
                        </li>
                    </ul>
                </div>
                <div class="arabic text-right" dir="rtl">
                    <h2>تقييدات</h2>
                    <ul>
                        <li>لا يحق لك المُزايدة على أي من عبارات ومُصطلحات
                            <b>{{ $offer->name }}</b> المدفوعة مُسبقًا على شبكة البحث, مثل- Google Adwords, Google PPC و إعلانات فيسبوك.
                        </li>
                        <li>لا يجوز لك استخدام اسم
                            <b>{{ $offer->name }}</b> أو أي من أشكاله في نوافذ الإعلانات المُنبثقة في الأعلى وفي الخلف, مثل اسم نشرتك الإعلانية لإعادة توجيه الحملات, في إعلانات تطبيق إشعارات الدّفع, أو من خلال رسائل خاطئة ومُضلّلة.
                        </li>
                        <li>لا يجوز لك استخدام أساليب كحشو الْــ cookie.</li>
                        <li>للا يجوز لك التّرويج لِـــ
                            <b>{{ $offer->name }}</b> في أي مواد جنسية واضحة أو مواد عنيفة أو مواد تشهيريّة أو أي افتراء أو نشاط غير قانوني.
                        </li>
                        <li>لا يجوز لك التّرويج لِـــ
                            <b>{{ $offer->name }}</b> إذا كنت تستخدم عادات تمييزية, على أساس العرق, الجنس, الدين, القومية, الإعاقة الجسدية, التوجّه الجنسي أو العمر.
                        </li>
                        <li>للا يجوز لك استخدام رابط لِــ
                            <b>{{ $offer->name }}</b> يحتوي على رابط إعادة توجيه, يتم إنشاؤه أو عرضه على مُحرّك البحث استجابة لطلب بحث الكلمة الرئيسيّة على الانترنت, سواء كانت هذه الروابط تظهر خلال إرسال المعلومات إلى الموقع أو غير ذلك.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer text-center">
                @if($offer->type == 'link_tracking')
                    <button type="button" class="btn btn-primary request-codes" data-offer="{{ $offer->id }}">{{ __('Request Link') }}</button>
                @elseif($offer->type == 'coupon_tracking')
                    <button type="button" class="btn btn-primary request-codes" data-offer="{{ $offer->id }}">{{ __('Request Codes') }}</button>
                @endif

            </div>
        </div>
    </div>
</div>