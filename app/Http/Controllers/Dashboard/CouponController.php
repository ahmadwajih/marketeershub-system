<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\CouponImport;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
            $coupons = getModelData('Coupon', $request, ['offer', 'user']);
            return response()->json($coupons);
        }
        return view('admin.coupons.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_coupons');
        return view('admin.coupons.create',[
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereStatus("active")->whereIn('position', ['team_leader','account_manager','publisher'])->whereIn('team', ['media_buying','influencer','affiliate'])->get(),
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
        userActivity('Coupon', $coupon->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index');
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
        return view('admin.coupons.show', ['coupon' => $coupon]);
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

        return view('admin.coupons.edit', [
            'coupon' => $coupon,
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereStatus("active")->whereIn('position', ['team_leader','account_manager','publisher'])->whereIn('team', ['media_buying','influencer','affiliate'])->get(),
        
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

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index');
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
        $this->authorize('create_coupons');
        return view('admin.coupons.upload',[
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
        $this->authorize('create_coupons');
        Excel::import(new CouponImport($request->offer_id),request()->file('coupons'));
        userActivity('Coupon',null , 'upload');
        
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index');
    }
}
