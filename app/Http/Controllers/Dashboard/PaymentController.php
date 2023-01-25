<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\NotFoundUsersInInUploadPayemntSheetExport;
use App\Http\Controllers\Controller;
use App\Imports\PaymenrImport;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\NewPaymentPaid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $payments = Payment::all(); 
        // $arr = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        // foreach($payments as $index => $payment){
        //     $month = $arr[rand(1,11)];
        //     $year = rand(2,4);
        //     $payment->from = '202'.$year.'-'.$month.'-01';
        //     $payment->to = '202'.$year.'-'.$month.'-01';
        //     $payment->save();
        // }
        // dd($arr);
        $this->authorize('view_payments');
        $query = Payment::query();
     
         $tableLength = session('table_length') ?? config('app.pagination_pages');

        // Filter

        if (isset($request->publisher_id) && $request->publisher_id  != null || session('payments_filter_publisher_id')) {
            $query->where('publisher_id', $request->publisher_id);
            session()->put('payments_filter_publisher_id', $request->publisher_id);
        } elseif (session('payments_filter_publisher_id')) {
            $query->where('publisher_id', session('payments_filter_publisher_id'));
        }

        if (isset($request->from) && $request->from  != null) {
            $query->where('from', $request->from);
            session()->put('payments_filter_from', $request->from);
        } elseif (session('payments_filter_from')) {
            $query->where('from', session('payments_filter_from'));
        }

        if (isset($request->to) && $request->to  != null) {
            $query->where('to', $request->to);
            session()->put('payments_filter_to', $request->to);
        } elseif (session('payments_filter_to')) {
            $query->where('to', session('payments_filter_to'));
        }

        if (isset($request->type) && $request->type  != null) {
            $query->where('type', $request->type);
            session()->put('payments_filter_type', $request->type);
        } elseif (session('payments_filter_type')) {
            $query->where('type', session('payments_filter_type'));
        }

        if (isset($request->search) && $request->search  != null) {
            $query->where('coupon', $request->search);
        }

        $publisherForFilter = User::whereId(session('payments_filter_publisher_id'))->first();
        $payments = $query->select(
            'id', 
            'slip', 
            'amount_paid', 
            'publisher_id', 
            'from', 
            'to', 
            'note', 
            'type', 
            'user_id'
            )
            ->orderBy('id', 'desc')
            ->with(['publisher', 'user'])
            ->paginate($tableLength);

            $totals = DB::table('payments')
            ->select(
                DB::raw('COUNT(payments.id) as transactions_count'),
                DB::raw('SUM(payments.amount_paid) as total_amount_paid')
            )->first();

        return view('new_admin.payments.index', [
            'payments' => $payments,
            'publisherForFilter' => $publisherForFilter,
            'totals' => $totals,
        ]);

        if ($request->ajax()){
            $payments = getModelData('Payment' , $request, ['user', 'publisher']);
            return response()->json($payments);
        }
        return view('admin.payments.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_payments');
        $publishers = User::select('id', 'name')->where('position', 'publisher')->get();

        return view('new_admin.payments.create', ['publishers' => $publishers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_payments');
        $data = $request->validate([
            'amount_paid'   => 'required|numeric|min:100',
            'publisher_id'  => 'required|exists:users,id',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'type'          => 'required|in:validation,update',
            'slip'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'note'          => 'nullable|max:255'
        ]);

        if($request->hasFile('slip')){
            $data['slip'] = uploadImage($request->file('slip'), "Payments");
        }
        
        $data['user_id'] = auth()->user()->id;
        $payment = Payment::create($data);
        userActivity('Payment', $payment->id, 'create');
        // $publisher = User::findOrFail($request->publisher_id);
        // Notification::send($publisher, new NewPaymentPaid($payment));
        
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.payments.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        if($payment->publisher_id  != auth()->user()->id){
            $this->authorize('view_payments');
        }
        userActivity('Payment', $payment->id, 'show');
        return view('admin.payments.show', ['payment' => $payment]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $this->authorize('update_payments');
        return view('new_admin.payments.edit', [
            'payment' => $payment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $this->authorize('update_payments');
        $data = $request->validate([
            'amount_paid'   => 'required|numeric|min:100',
            'publisher_id'  => 'required|exists:users,id',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'type'          => 'required|in:validation,update',
            'slip'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'note'          => 'nullable|max:255'
        ]);

       
        $data['slip'] = $payment->slip;
        if($request->hasFile('slip')){
            deleteImage($payment->slip, 'Payments');
            $data['slip'] = uploadImage($request->file('slip'), "Payments");
        }
        userActivity('Payment', $payment->id, 'update', $data, $payment);

        $payment->update($data);

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Payment $payment)
    {
        $this->authorize('delete_payments');
        if($request->ajax()){
            userActivity('Payment', $payment->id, 'delete');
            $payment->forceDelete();
        }
    }

    /** Upload Payments */
    /**
     * Show the form for upload a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadForm()
    {
        $this->authorize('create_payments');
        return view('new_admin.payments.upload');
    }

    public function upload(Request $request)
    {
        $this->authorize('create_payments');
        $request->validate([
            'payments'    => 'required|mimes:xlsx,csv',
        ]);
     
        Excel::import(new PaymenrImport(),request()->file('payments'));

        if($request->hasFile('slips')){
            foreach($request->slips as $slip){
                uploadImage($slip, "Payments", false);
            }
        }

        userActivity('Payment',null , 'upload');
        
        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.payments.index')->with($notification);
    }

    public function clearFilterSeassoions()
    {
        session()->forget('payments_filter_publisher_id');
        session()->forget('payments_filter_from');
        session()->forget('payments_filter_to');
        session()->forget('payments_filter_type');
        return redirect()->route('admin.payments.index');
    }


}
