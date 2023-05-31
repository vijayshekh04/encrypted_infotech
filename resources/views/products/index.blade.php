<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product Table</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>List</h2>       
  <a href="{{route('invoice.create')}}" class="btn btn-primary text-end">Add</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>City Name</th>
        <th>State Name</th>
      </tr>
    </thead>
    <tbody>
    @foreach($employees as $row)
    <tr>
        <td>{{$row->name}}</td>
        <td>{{$row->city->name}}</td>
        <td>{{$row->state->name}}</td>
      </tr>
    @endforeach
  
    </tbody>
  </table>
</div>

</body>
</html>

