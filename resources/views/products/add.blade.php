<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <style>
    .error-label-message{
        display:none;
    }
    </style>
</head>
<body>

<div class="container">
  <h2>Add Invoice</h2>
    @if(Session::has('status'))
        <div class="alert alert-success" role="alert">
            {{Session::get('message')}}
        </div>
    @endif

  <form action="javascript:void(0)" id="add_form">
    @csrf
      <input type="hidden" name="counter" id="counter" value=1>
    <div class="form-group">
      <label for="customer_name">Customer Name:</label>
      <input type="text" class="form-control" id="customer_name" placeholder="Enter Customer Name" name="customer_name">
      <label class="text-danger text-bold error-label-message" id="customer_name_error"></label>
    </div>

    <div class="form-group">
      <label for="product_id">Product:</label>
      <select  class="form-control" id="product_id"  name="product_id">
        <option value="">Select Product</option>
        @foreach($products as $row)
          <option value="{{$row->id}}">{{$row->name}}</option>
        @endforeach
      </select>
      <label class="text-danger text-bold error-label-message" id="produmct_id_error"></label>
    </div>

    <div class="form-group">
      <label for="rate">Rate:</label>
      <input type="text" class="form-control" id="rate" placeholder="Enter Rate" name="rate" readonly>
      <label class="text-danger text-bold error-label-message" id="rate_error"></label>
    </div>

    <div class="form-group">
      <label for="unit">Unit:</label>
      <input type="text" class="form-control" id="unit" placeholder="Enter Unit" name="unit" readonly>
      <label class="text-danger text-bold error-label-message" id="unit_error"></label>
    </div>

    <div class="form-group">
      <label for="qty">Qty:</label>
      <input type="number" class="form-control" id="qty" placeholder="Enter Qty" name="qty">
      <label class="text-danger text-bold error-label-message" id="qty_error"></label>
    </div>

    <div class="form-group">
      <label for="discount">Discount(%):</label>
      <input type="text" class="form-control" id="discount" placeholder="Enter Discount" name="discount">
      <label class="text-danger text-bold error-label-message" id="discount_error"></label>
    </div>

    <div class="form-group">
      <label for="net_amount">Net Amount:</label>
      <input type="text" class="form-control" id="net_amount" placeholder="Enter Net Amount" name="net_amount" readonly>
      <label class="text-danger text-bold error-label-message" id="net_amount_error"></label>
    </div>

    <div class="form-group">
      <label for="total_amount">Total Amount:</label>
      <input type="text" class="form-control" id="total_amount" placeholder="Enter Total Amount" name="total_amount" readonly>
      <label class="text-danger text-bold error-label-message" id="total_amount_error"></label>
    </div>
    <button type="button" class="btn btn-primary" id="add_btn">Add</button>
    <br>

  </form>

    <form action="javascript:void(0)" id="submit_form">
        @csrf
        <input type="hidden" name="total_row" id="total_row" >
        <div class="row mt-1">
            <div class="col-md-12">
                <table class="table table-strapped" id="grid_table" width="100%">
                    <tr id="grid_table_tr">
                        <th>Product</th>
                        <th>Rate</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Disc</th>
                        <th>Net Amt.</th>
                        <th>Total Amt.</th>
                        <th>Action</th>
                    </tr>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
    </form>
  <br/>

</div>

<script>
        $(document).ready(function () {

            // get product data
            $(document).on('change','#product_id',function () {
                var product_id = $(this).val();
                if(product_id != "")
                {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"{{url('invoice/get-product-by-id')}}",
                        method:'post',
                        data:{product_id:product_id},
                        dataType:'json',
                        success:function(response){
                             //console.log(response);

                            $('#rate').val(response.rate);
                            $('#unit').val(response.unit);

                        },
                        error:function(error){

                        }
                    });
                }

            });

            // net amount calculate
            $(document).on('keyup','#discount',function () {
                var discount = $(this).val();
                if (discount < 1)
                {
                    alert("Please enter minimum 1 %!");
                    $('#discount').val(1);
                    $('#discount').focus();
                    return false;
                }
                var rate = $('#rate').val();

                var dicount_rate = (rate * discount) /100;

                var net_amounte = rate - dicount_rate;

                var qty = $('#qty').val();
                var total_amount = net_amounte * qty;
                $('#net_amount').val(net_amounte);
                $('#total_amount').val(total_amount);
            });

            // calculate total amount
            $(document).on('keyup','#qty',function () {
                var qty = $(this).val();
                if (qty < 1)
                {
                    alert("Please enter minimum 1 Qty!");
                    $('#qty').val(1);
                    $('#qty').focus();
                    return false;
                }
                var rate = $('#rate').val();

                var discount = $('#discount').val();
                var net_amounte = rate;

                if(discount != "")
                {
                    var dicount_rate = (rate * discount) /100;
                    net_amounte = rate - dicount_rate;
                }



                var total_amount = net_amounte * qty;
                $('#net_amount').val(net_amounte);
                $('#total_amount').val(total_amount);
            });

            $(document).on('click','#add_btn',function () {

                var customer_name =  $('#customer_name').val();
                var product_id =  $('#product_id').val();
                var qty =  $('#qty').val();
                var counter = $("#counter").val();

                if(customer_name == "")
                {
                    alert("Please enter customer name!");
                    $('#customer_name').focus();
                    return false
                }

                if(product_id == "")
                {
                    alert("Please select product!");
                    $('#product_id').focus();
                    return false
                }

                if(qty == "")
                {
                    alert("Please enter qty!");
                    $('#qty').focus();
                    return false
                }

                //var tr = $('#copy_tr tbody tr').clone();

                var rate = $("#rate").val();
                var unit = $("#unit").val();
                var discount = $("#discount").val();
                var net_amount = $("#net_amount").val();
                var total_amount = $("#total_amount").val();

                var formdata = new FormData();

                formdata.append('customer_name',customer_name);
                formdata.append('product_id',product_id);
                formdata.append('rate',rate);
                formdata.append('unit',unit);
                formdata.append('qty',qty);
                formdata.append('discount',discount);
                formdata.append('net_amount',net_amount);
                formdata.append('total_amount',total_amount);
                formdata.append('counter',counter);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{route('invoice.get_row')}}",
                    method:'post',
                    data:formdata,
                    processData: false,
                    contentType: false,
                    dataType:'json',
                    cache:false,
                    success:function(response){
                         $("#grid_table").append(response.data);
                        $("#counter").val(parseInt(counter) + 1);
                        $("#total_row").val(counter);
                    },

                });
            });

            $(document).on('click','.remove_btn',function () {
                $(this).parents("tr").remove();
            });

            $(document).on('change','.product_id_class',function () {
                var counter = $(this).data('counter');
                var product_id = $(this).val();

                if(product_id != "")
                {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"{{url('invoice/get-product-by-id')}}",
                        method:'post',
                        data:{product_id:product_id},
                        dataType:'json',
                        success:function(response){
                            //console.log(response);

                            $('#rate_'+counter).val(response.rate);
                            $('#unit_'+counter).val(response.unit);

                        },
                        error:function(error){

                        }
                    });
                }

            });

            // calculate total amount
            $(document).on('keyup','.qty_class',function () {
                var counter = $(this).data('counter');
                var qty = $(this).val();
                if (qty < 1)
                {
                    alert("Please enter minimum 1 Qty!");
                    $('#qty_'+counter).val();
                    $('#qty_'+counter).focus();

                    $('#net_amount_'+counter).val(0);
                    $('#total_amount_'+counter).val(0);
                    return false;
                }
                else
                {
                    qty = parseInt($(this).val());
                    var rate = parseInt($('#rate_'+counter).val());

                    var discount = $('#discount_'+counter).val();
                    var net_amounte = rate;

                    if(discount != "")
                    {
                        var dicount_rate = (rate * discount) /100;
                        net_amounte = rate - dicount_rate;
                    }
                    var total_amount = net_amounte * qty;

                    $('#net_amount_'+counter).val(net_amounte);
                    $('#total_amount_'+counter).val(total_amount);
                }

            });

            // net amount calculate
            $(document).on('keyup','.discount_class',function () {
                var counter = $(this).data('counter');
                var discount = $(this).val();

                var qty = $('#qty_'+counter).val();
                if (qty == "")
                {
                    alert("please enter qty first!");
                    return false;
                }
                if (discount == "" && discount < 1)
                {
                    alert("Please enter minimum 1 %!");
                    $('#discount_'+counter).val(1);
                    $('#discount_'+counter).focus();
                    return false;
                }
                else {
                    discount = parseFloat($(this).val());
                    var rate = parseFloat($('#rate_'+counter).val());

                    var dicount_rate = (rate * discount) /100;

                    var net_amounte = rate - dicount_rate;

                     qty = parseFloat($('#qty_'+counter).val());
                    var total_amount = parseFloat(net_amounte) * qty;
                    $('#net_amount_'+counter).val(net_amounte);
                    $('#total_amount_'+counter).val(total_amount);
                }

            });

            $(document).on('submit','#submit_form',function () {
                $(".error-label-message").html('');
                $(".error-label-message").hide();
                var formData = new FormData(this);

                var customer_name =  $('#customer_name').val();
                formData.append('customer_name',customer_name);
                $('.error_msg').text('');
                $.ajax({
                    url:"{{route('invoice.store')}}",
                    method:'post',
                    data:formData,
                    processData: false,
                    contentType: false,
                    dataType:'json',
                    cache:false,
                    success:function(response){
                        // console.log(response);
                        window.location.href = "{{url('invoice/create')}}";
                    },
                    error:function(error){
                        if(error.status===422){
                            $(".error-label-message").show();
                            $.each(error.responseJSON.errors,function(key,value){
                                $('#'+key+'_error').text(value[0]);
                            });
                        }

                        if(error.responseJSON.message!==undefined){
                            // show_message('error',error.responseJSON.message);
                        }
                    }
                });
            });
        })
    </script>
</body>
</html>
