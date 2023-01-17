@extends('publishers.layouts.app')
@section('title', 'Offers')
@section('subtitle', 'View')
@section('content')


    <div class="content flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="d-flex flex-wrap flex-stack pb-7">
			<!--begin::Title-->
			<div class="d-flex flex-wrap align-items-center my-1">
				<h3 class="fw-bold me-5 my-1">{{__('Offers')}} ({{ $offers->count() }})</h3>
			</div>
			<!--end::Title-->
			<!--begin::Controls-->
			<div class="d-flex flex-wrap my-1">
				<!--begin::Tab nav-->
				<ul class="nav nav-pills me-6 mb-2 mb-sm-0" role="tablist">
					<li class="nav-item m-0" role="presentation">
						<a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary me-3" data-bs-toggle="tab" href="#kt_project_users_card_pane" aria-selected="false" role="tab" tabindex="-1">
							<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
										<rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
										<rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
										<rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
									</g>
								</svg>
							</span>
							<!--end::Svg Icon-->
						</a>
					</li>
					<li class="nav-item m-0" role="presentation">
						<a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary active" data-bs-toggle="tab" href="#kt_project_users_table_pane" aria-selected="true" role="tab">
							<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
							<span class="svg-icon svg-icon-2">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor"></path>
									<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor"></path>
								</svg>
							</span>
							<!--end::Svg Icon-->
						</a>
					</li>
				</ul>
				<!--end::Tab nav-->
				<!--begin::Actions-->
				<div class="d-flex my-0">

					<!--begin::Select-->
					<select name="status" data-control="select2" data-hide-search="true" data-placeholder="Export" class="form-select form-select-sm border-body bg-body w-100px select2-hidden-accessible" data-select2-id="select2-data-13-50i3" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
						<option value="1" data-select2-id="select2-data-15-9qcx">Excel</option>
						<option value="1">PDF</option>
						<option value="2">Print</option>
					</select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-14-h4hb" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-sm border-body bg-body w-100px" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-status-wj-container" aria-controls="select2-status-wj-container"><span class="select2-selection__rendered" id="select2-status-wj-container" role="textbox" aria-readonly="true" title="Excel">Excel</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
					<!--end::Select-->
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Controls-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Tab Content-->
		<div class="tab-content">
			<!--begin::Tab pane-->
			<div id="kt_project_users_card_pane" class="tab-pane fade" role="tabpanel">
				<!--begin::Row-->
				<div class="row g-6 g-xl-9">
					@forelse($offers as $offer)
					<!--begin::Col-->
					<div class="col-md-6 col-xxl-4">
						<!--begin::Card-->
						<div class="card">
							<!--begin::Card body-->
							<div class="card-body d-flex flex-center flex-column pt-12 p-9" style="border-bottom: solid 2px green">

								<!--begin::Name-->
								<div class="fs-4 my-2 text-gray-800 text-hover-primary fw-bold">{{ $offer->name }}</div>
								<!--end::Name-->
								<!--begin::Position-->
								<!-- <div class="fw-semibold text-gray-400 mb-6">Art Director at Novica Co.</div> -->
								<!--end::Position-->
								<!--begin::Info-->
								<div class="d-flex flex-center flex-wrap">
									<!--begin::Stats-->
									<div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
										<div class="fs-6 fw-bold text-gray-700">{{ $offer->discount}}</div>
										<div class="fw-semibold text-gray-400">Discount</div>
									</div>
									<!--end::Stats-->
									<!--begin::Stats-->
									<div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
										<div class="fs-6 fw-bold text-gray-700">{{ $offer->payout ?? 0 }}</div>
										<div class="fw-semibold text-gray-400">Payout</div>
									</div>
									<!--end::Stats-->

								</div>
								<!--end::Info-->
							</div>
							<!--end::Card body-->
						</div>
						<!--end::Card-->
					</div>
					<!--end::Col-->
					@empty
                        <div class="text-center alert-info py-4 fw-bold me-5">
                            No offers
                        </div>
                    @endforelse


				</div>
				<!--end::Row-->

			</div>
			<!--end::Tab pane-->
			<!--begin::Tab pane-->
			<div id="kt_project_users_table_pane" class="tab-pane fade active show" role="tabpanel">
				<!--begin::Card-->
				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body pt-0">
						<!--begin::Table container-->
						<div class="table-responsive">
                            <!--begin::Table-->
                            <div id="kt_project_users_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="table-responsive">
                                    <table id="kt_project_users_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold dataTable no-footer">
                                        <!--begin::Head-->
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr>
                                                <th class="min-w-50px text-start sorting" tabindex="0" aria-controls="kt_project_users_table" rowspan="1" colspan="1" aria-label="Id: activate to sort column ascending" style="width: 0px;">ID</th>
                                                <th class="min-w-250px sorting" tabindex="0" aria-controls="kt_project_users_table" rowspan="1" colspan="1" aria-label="Manager: activate to sort column ascending" style="width: 0px;">Name</th>
                                                <th class="min-w-150px sorting" tabindex="0" aria-controls="kt_project_users_table" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 0px;">Status</th>
                                                <th class="min-w-90px sorting" tabindex="0" aria-controls="kt_project_users_table" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending" style="width: 0px;">Discount</th>
                                                <th class="min-w-50px text-end sorting_disabled" rowspan="1" colspan="1" aria-label="Details" style="width: 0px;">Payout</th></tr>
                                        </thead>
                                        <!--end::Head-->
                                        <!--begin::Body-->
                                        <tbody class="fs-6">

                                            @foreach($offers as $offer)
                                            <tr class="odd">
                                                <td>
                                                    {{ $offer->id }}
                                                </td>
                                                <td>
                                                    <!--begin::User-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Info-->
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <div class="mb-1 text-gray-800 text-hover-primary">{{ $offer->name }}</div>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                </td>
                                                <td data-order="{{ $offer->status }}">
                                                    <button class="btn btn-light-success btn-sm  active-btn-{{ $offer->id }} {{ $offer->status == 'active' ?: 'd-none' }}">Active</button>
                                                    <button class="btn btn-light-danger btn-sm inactive-btn-{{ $offer->id }} {{ $offer->status != 'active' ?: 'd-none' }}">Inactive</button>
                                                </td>
                                                <td>{{ $offer->discount }}</td>

                                                <td class="text-end">
                                                    {{ $offer->payout ?? 0 }}
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <!--end::Body-->
                                    </table>
                                </div>
                            </div>
                            <!--end::Table container-->
					<!--end::Card body-->
				</div>
				<!--end::Card-->
                @if(!count($offers))
                <div class="text-center py-4 fw-bold me-5">
                    No offers
                </div>
                @endif
			</div>
			<!--end::Tab pane-->

		</div>
		<!--end::Tab Content-->

	</div>

    <div class="my-4">
        <div class="d-flex justify-content-between">
            <div>
                @include('new_admin.components.table_length')
            </div>
            <div>
                {!! $offers->links() !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    let route = "{{route('admin.offers.index')}}";
    let search = "{{ request()->search }}";
</script>
{{-- <script src="{{ asset('new_dashboard') }}/js/datatables/offers/table.js"></script> --}}
<script src="{{ asset('new_dashboard') }}/js/datatables/offers/delete.js"></script>

<script src="{{ asset('new_dashboard') }}/js/datatables/offers/change-status.js"></script>

<script>
    $(document).ready(function() {
        $('#main_form_check').change(function(){
            if(this.checked) {
                $('.table-checkbox').prop('checked', true);
                $('#delete_btn').removeClass('d-none');
                $('#add_btn').addClass('d-none');
            }else{
                $('.table-checkbox').prop('checked', false);
                $('#delete_btn').addClass('d-none');
                $('#add_btn').removeClass('d-none');
            }
            var numberOfChecked = $('.table-checkbox:checked').length;
            $('#selected_count').html(numberOfChecked);
        });

        $('.table-checkbox').change(function(){
            var numberOfChecked = $('.table-checkbox:checked').length;
            if(this.checked) {
                $('#delete_btn').removeClass('d-none');
                $('#add_btn').addClass('d-none');
            }else{
                if(numberOfChecked == 0){
                    $('#delete_btn').addClass('d-none');
                    $('#add_btn').removeClass('d-none');
                }
            }
            numberOfChecked = $('.table-checkbox:checked').length;
            $('#selected_count').html(numberOfChecked);
        });
    });
</script>
<script src="{{ asset('new_dashboard') }}/js/datatables/search.js?v=60112212022"></script>
@endpush
