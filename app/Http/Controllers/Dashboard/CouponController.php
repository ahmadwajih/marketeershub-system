<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\CouponImport;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\User;
use App\Notifications\CodeRecycled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_coupons');
        if($request->ajax()){
            $coupons = Coupon::with(['offer', 'user']);
            return DataTables::of($coupons)->make(true);
        }
        $offers = Offer::whereHas('coupons')->get();
        return view('new_admin.coupons.index', ['offers' => $offers]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_coupons');
        return view('new_admin.coupons.create',[
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereIn('position', ['publisher'])->whereIn('team', ['media_buying','influencer','affiliate', 'prepaid'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_coupons');

        $data = $request->validate([
            'coupon'          => 'required|max:255',
            'offer_id'        => 'required|numeric|exists:offers,id',
            'user_id'        => 'nullable|numeric|exists:users,id',
        ]);
        $data['coupon'] = strtolower(trim(str_replace(' ','', trim($request->coupon))));
       
        $coupon = Coupon::create($data);
        // dd($coupon->user);/
        //  if($request->user_id){
        //     try {
        //         Notification::send($coupon->user, new CodeRecycled($coupon));
        //     } catch (\Throwable $th) {
        //         Log::debug($th);
        //     }
            
        // }
        userActivity('Coupon', $coupon->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.coupons.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_coupons');
        $coupon = Coupon::withTrashed()->findOrFail($id);
        userActivity('Coupon', $coupon->id, 'show');
        return view('new_admin.coupons.show', ['coupon' => $coupon]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update_coupons');

        return view('new_admin.coupons.edit', [
            'coupon' => $coupon,
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereStatus("active")->whereIn('position', ['publisher'])->whereIn('team', ['media_buying','influencer','affiliate', 'prepaid'])->get(),
        
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('update_coupons');
        $data = $request->validate([
            'coupon'          => 'required|max:255',
            'offer_id'        => 'required|numeric|exists:offers,id',
            'user_id'        => 'nullable|numeric|exists:users,id',
        ]);

        $coupon->update($data);
        userActivity('Coupon', $coupon->id, 'update');
        if($request->user_id){
            try {
                Notification::send($coupon->user, new CodeRecycled($coupon));
            } catch (\Throwable $th) {
                Log::debug($th);
            }
            
        }
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        $this->authorize('delete_coupons');
        if($request->ajax()){
            userActivity('Coupon', $coupon->id, 'delete');
            $coupon->delete();
        }
    }


     /**
     * Show the form for uploading a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadForm()
    {
        $this->authorize('view_upload_coupons');
        return view('new_admin.coupons.upload',[
            'offers' => Offer::whereStatus("active")->get()
        ]);
    }

    
     /**
     * Show the form for uploading a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->authorize('view_upload_coupons');
        $request->validate([
            'team'       => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'offer_id'   => 'required|exists:offers,id',
            'coupons'    => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new CouponImport($request->offer_id, $request->team),request()->file('coupons'));
        userActivity('Coupon',null , 'upload');
        
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index');
    }

    public function changeStatus(Request $request){
        $this->authorize('update_coupons');
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'active' ? 'active' : 'unactive';
        $coupon->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

    
    public function bulkChangeRevenue(Request $request){
        return $request->all();
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'active' ? 'active' : 'unactive';
        $coupon->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

}
