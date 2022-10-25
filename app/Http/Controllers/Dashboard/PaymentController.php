<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\NotFoundUsersInInUploadPayemntSheetExport;
use App\Http\Controllers\Controller;
use App\Imports\PaymenrImport;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\NewPaymentPaid;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
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
        $this->authorize('view_payments');
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

        return view('admin.payments.create', ['publishers' => $publishers]);
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
            'to'            => 'required|date|after:from',
            'type'          => 'required|in:validation,update',
            'slip'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'note'          => 'nullable|max:255'
        ]);

        if($request->hasFile('slip')){
            $data['slip'] = uploadImage($request->file('slip'), "Payments");
        }
        
        $data['user_id'] = auth()->user()->id;
        $payment = Payment::create($data);
        userActivity('Payment', $payment->id, 'create');
        $publisher = User::findOrFail($request->publisher_id);
        Notification::send($publisher, new NewPaymentPaid($payment));
        
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
        $publishers = User::select('id', 'name')->where('position', 'publisher')->get();

        return view('admin.payments.edit', [
            'payment' => $payment,
            'publishers' => $publishers,
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
            'to'            => 'required|date|after:from',
            'type'          => 'required|in:validation,update',
            'slip'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
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
            $payment->delete();
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
        return view('admin.payments.upload');
    }

    public function upload(Request $request)
    {
        $this->authorize('create_payments');
        $request->validate([
            'payments'    => 'required|mimes:xlsx,csv',
        ]);

        

        Excel::import(new PaymenrImport(),request()->file('payments'));
        userActivity('Payment',null , 'upload');
        
        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.payments.index')->with($notification);
    }

}
