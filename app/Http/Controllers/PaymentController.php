<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::latest()->get();
        return view('backend.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        try{

            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/payment', $filename);
            }

            $paymentData = $request->except('image');
            if ($filename) {
                $paymentData['image'] = $filename;
            }

            $payment = Payment::create(['created_by' => auth()->user()->id] + $paymentData);

            return redirect()->route('payments.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return view('backend.payments.show',compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        return view('backend.payments.edit',compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        try{
            $payment = Payment::find($id);
            
            $filename = null;
            
            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/payment', $filename);
            }
            $paymentData = $request->except('image');
            if ($filename) {
                $paymentData['image'] = $filename;
            }

            $payment->update(['updated_by' => auth()->user()->id] + $paymentData);

            return redirect()->route('payments.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function paymentUpdate(UpdatePaymentRequest $request)
    {
        try{
            // Retrieve all payment IDs submitted through the form
            $paymentIds = $request->input('paymentId');
            
            // Retrieve all titles submitted through the form
            $titles = $request->input('title');
            
            // Loop through the submitted payment IDs and titles
            foreach ($paymentIds as $key => $paymentId) {
                // If payment ID exists, update the corresponding payment record
                if ($paymentId) {
                    $payment = Payment::find($paymentId);
                    if ($payment) {
                        $payment->title = $titles[$key];
                        $payment->sequence = $key;
                        $payment->save();
                    }
                } else {
                    // If payment ID doesn't exist, create a new payment record
                    $newPayment = new Payment();
                    $newPayment->title = $titles[$key];
                    $newPayment->sequence = $key;
                    $newPayment->save();
                }
            }
            
            // Delete payments which were not updated or created
            Payment::whereNotIn('id', $paymentIds)->delete();

            return redirect()->back()->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $payment = Payment::find($id);
            $payment->update(['deleted_by' => auth()->user()->id]);
            $payment->delete();

            return redirect()->route('payments.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
