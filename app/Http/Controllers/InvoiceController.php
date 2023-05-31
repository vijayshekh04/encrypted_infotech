<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\ProductMaster;
use Database\Seeders\ProductSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\Mime\embed;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = ProductMaster::get();
        return view('products.add',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();

        $input = $request->all();

        $total_row = $input['total_row'];

        $last_record =  InvoiceMaster::OrderBy('id', 'desc')->first();

        $invoice_number = 1;
        if (!empty($last_record))
        {
            $invoice_number = (int)$last_record['invoice_no'] + 1;
        }

        $insert_invoice_data['invoice_no'] = $invoice_number;
        $insert_invoice_data['date'] = date("Y-m-d");
        $insert_invoice_data['customer_name'] = $input['customer_name'];

        $total_amount = 0;
        for ($i=1;$i<=$total_row;$i++)
        {
            $total_amount = $total_amount + $input['total_amount_'.$i];
        }

        $insert_invoice_data['total_amount'] = $total_amount;

        $invoice_id = InvoiceMaster::create($insert_invoice_data)->id;

        for ($j=1;$j<=$total_row;$j++)
        {
            $insert_invoice_detail['invoice_Id'] = $invoice_id;
            $insert_invoice_detail['product_id'] = $input['product_id_'.$j];
            $insert_invoice_detail['rate'] = $input['rate_'.$j];
            $insert_invoice_detail['unit'] = $input['unit_'.$j];
            $insert_invoice_detail['qty'] = $input['qty_'.$j];
            $insert_invoice_detail['disc_percentage'] = $input['discount_'.$j];
            $insert_invoice_detail['net_amount'] = $input['net_amount_'.$j];
            $insert_invoice_detail['total_amount'] = $input['total_amount_'.$j];

            InvoiceDetail::create($insert_invoice_detail);
        }

        Session::flash('status',"success");
        Session::flash('message',"Data has inserted successfully");
        return response()->json(array("status"=>"success"));


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_product(Request $request)
    {
        //return $request->all();

        $product = ProductMaster::where('id',$request->product_id)->first();

        return response()->json($product);
    }

    public function get_row(Request $request)
    {

        $input = $request->all();
        $products = ProductMaster::get();
        $html = view('products.add_row',compact('products','input'))->render();

        return response()->json(array("status"=>"success","data"=>$html));

    }
}
