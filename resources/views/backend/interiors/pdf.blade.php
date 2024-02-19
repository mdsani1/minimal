<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <table class="table table-bordered container">
        <thead>
          <tr>
            <th>SL#</th>
            <th class="text-center">Category</th>
            <th class="text-center">Item</th>
            <th class="text-center">Unit</th>
            <th class="text-center">Rate</th>
            <th class="text-center">Detail</th>
          </tr>
        </thead>
        <tbody>
            @php
            $sl = 0;
            @endphp
            @foreach ($interiors as $interior)
            <tr>
                <td>{{ ++$sl }}</td>
                <td class="text-center">{{ $interior->category->title ?? '' }}</td>
                <td class="text-center">{{ $interior->item ?? '' }}</td>
                <td class="text-center">{{ $interior->unit ?? '' }}</td>
                <td class="text-center">{{ $interior->rate ?? '' }}</td>
                <td class="text-center">{{ $interior->default_detail ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>