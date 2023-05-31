<tr>
    <th>
        <select class="form-control product_id_class" data-counter="{{$input['counter']}}" name="product_id_{{$input['counter']}}" id="product_id_{{$input['counter']}}">
            @foreach($products as $product_row)
                <option value="{{$product_row->id}}" @if($product_row->id == $input['product_id']) {{'selected'}} @endif>{{$product_row->name}}</option>
            @endforeach
        </select>
    </th>
    <th>
        <input type="text" class="form-control rate_class"  data-counter="{{$input['counter']}}" id="rate_{{$input['counter']}}"  name="rate_{{$input['counter']}}" value="{{$input['rate']}}" readonly>
    </th>
    <th>
        <input type="text" class="form-control unit_class"  data-counter="{{$input['counter']}}" id="unit_{{$input['counter']}}"  name="unit_{{$input['counter']}}" value="{{$input['unit']}}" readonly>
    </th>
    <th>
        <input type="number" class="form-control qty_class"  data-counter="{{$input['counter']}}" id="qty_{{$input['counter']}}" placeholder="Enter Qty" name="qty_{{$input['counter']}}" value="{{$input['qty']}}">
    </th>
    <th>
        <input type="number" class="form-control discount_class" min="0"  data-counter="{{$input['counter']}}" id="discount_{{$input['counter']}}" placeholder="Enter discount" name="discount_{{$input['counter']}}" value="{{$input['discount']}}">
    </th>
    <th>
        <input type="text" class="form-control net_amount_class"  data-counter="{{$input['counter']}}" id="net_amount_{{$input['counter']}}"  name="net_amount_{{$input['counter']}}" value="{{$input['net_amount']}}" readonly>
    </th>
    <th>
        <input type="text" class="form-control total_amount_class"  data-counter="{{$input['counter']}}" id="total_amount_{{$input['counter']}}"  name="total_amount_{{$input['counter']}}" value="{{$input['total_amount']}}" readonly>
    </th>
    <th>
        <button class="btn-danger remove_btn">Remove</button>
    </th>
</tr>