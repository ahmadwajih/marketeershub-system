

<input type="hidden" name="id" value="{{ $role->id }}">
 <!--begin::Scroll-->
 <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
 data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
 data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
 data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
 <!--begin::Input group-->
 <div class="fv-row mb-10">
     <!--begin::Label-->
     <label class="fs-5 fw-bold form-label mb-2">
         <span class="required">Role name</span>
     </label>
     <!--end::Label-->
     <!--begin::Input-->
     <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" value="{{ $role->name }}" />
     <!--end::Input-->
 </div>
 <!--end::Input group-->
 <!--begin::Ablities-->
 <div class="fv-row">
     <!--begin::Label-->
     <label class="fs-5 fw-bold form-label mb-2">Role Ablities</label>
     <!--end::Label-->
     <!--begin::Table wrapper-->
     <div class="table-responsive">
         <!--begin::Table-->
         <table class="table align-middle table-row-dashed fs-6 gy-5">
             <!--begin::Table body-->
             <tbody class="text-gray-600 fw-semibold">
                 <tr>
                    <!--begin::Label-->
                    <td class="text-gray-800">Main Dashboard
                    </td>
                    <!--end::Label-->
                    <!--begin::Options-->
                    <td>
                        <!--begin::Wrapper-->
                        <div class="d-flex">
                           <label
                               class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                               <input class="form-check-input" type="checkbox"  {{ (old('view_dashboard') ?: $role->abilities->contains(App\Models\Ability::whereName('view_dashboard')->first()))? 'checked' : '' }}  value="on" name="view_dashboard" />
                               <span class="form-check-label">View</span>
                           </label>
                        </div>
                    </td>
                 </tr>
                
                 <!--end::Table row-->
                 @foreach ($models as $model)
                     <!--begin::Table row-->
                     <tr>
                         <!--begin::Label-->
                         <td class="text-gray-800">{{ ucwords(str_replace('_', ' ', $model)) }}
                         </td>
                         <!--end::Label-->
                         <!--begin::Options-->
                         <td>
                             <!--begin::Wrapper-->
                             <div class="d-flex">
                                 @foreach ($abilities as $ability)
                                     @if (strpos($ability->name, $model) !== false)
                                         <!--begin::Checkbox-->
                                         <label
                                             class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-10">
                                             <input class="form-check-input" type="checkbox"  {{ $role->abilities->contains($ability)? 'checked' : '' }} value="on" name="{{ $ability->name }}" />
                                             <span class="form-check-label">{{ str_replace(str_replace('_', ' ', $model), '', $ability->label) }}</span>
                                         </label>
                                         <!--end::Checkbox-->
                                     @endif
                                 @endforeach
                             </div>
                             <!--end::Wrapper-->
                         </td>
                         <!--end::Options-->    
                     </tr>
                     <!--end::Table row-->
                 @endforeach
             </tbody>
             <!--end::Table body-->
         </table>
         <!--end::Table-->
     </div>
     <!--end::Table wrapper-->
 </div>
 <!--end::Ablities-->
</div>
<!--end::Scroll-->
