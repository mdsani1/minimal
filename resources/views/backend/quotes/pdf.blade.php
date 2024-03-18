<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $quote->title }}</title>
    <style>
        * {
          margin: 0px;
          padding: 0px;
          box-sizing: border-box;
        }
        
        /* Create two equal columns that float next to each other */
        .column {
          float: left;
          width: 46%;
          padding: 10px;
        }
        
        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }
        
        p {
          padding: 0px;
          margin: 2px;
        }
        
        /* Apply text alignment to the organization details */
        .organization-details {
          text-align: right;
        }
    
        h4 {
          padding: 0px;
          margin: 4px;
        }
    
        h3 {
          padding: 0px;
          margin: 4px;
        }
    
        table, td, th {
          border: 1px solid;
        }
    
        table {
          width: 100%;
          border-collapse: collapse;
        }
      </style>
</head>
<body>
    <div>
        <div class="row">
            <div class="column">
              <img src="{{ public_path('backend/images/organization/'.$organization->image ?? '') }}" alt="" style="width: 70%">
            </div>
            <div class="column organization-details">
              <div>
                {!! $organization->address !!}
              </div>
              <div>
                <p>{{ $organization->phone }}</p>
                <p>{{ $organization->email }}</p>
                <p><a href="{{ $organization->facebook }}">{{ $organization->facebook }}</a></p>
                <p><a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a></p>
                @php
                    $dateString = $quote->date;
                    $formattedDate = date("F j, Y", strtotime($dateString));
                @endphp 
                <p style="margin-top: 20px">{{ $formattedDate }}</p>
              </div>
            </div>
          </div>

          <div>
            <p style="text-align: center; font-size:20px">{{ $quote->title }}</p>

            <div style="width:95%; margin-left:10px; margin-top:8px">
              @foreach ($quoteItems as $categoryId => $subCategories)
                  @foreach ($subCategories as $subCategoryId => $quoteItem)
                      <p style="font-size: 18px">
                        {{ $quoteItem->first()->category->title ?? '' }} 
                        @if ($quoteItem->first()->subCategory != null)
                            ({{ $quoteItem->first()->subCategory->title }})
                        @endif
                      </p>
                      <table style="margin-bottom: 30px">
                          <tr style="background-color:#bbb;">
                              <th style="text-align: center">SL </th>
                              <th style="text-align: center; width:20%">ITEM</th>
                              <th style="text-align: center; width:40%">SPECIFICATION</th>
                              <th style="text-align: center">QTY</th>
                              <th style="text-align: center">UNIT</th>
                              <th style="text-align: center">RATE</th>
                              <th style="text-align: center">AMOUNT</th>
                              @foreach ($quoteItem->first()->quoteItemValues as $data)
                                  <th style="text-align: center">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                              @endforeach
                          </tr>
                          @php
                              $grandTotal = 0;
                          @endphp
                          @foreach ($quoteItem as $item)
                              <tr>
                                  <td style="text-align: center">{{ $item->sl }}</td>
                                  <td style="text-align: center; width:30%">{{ $item->item }}</td>
                                  <td style="text-align: center">{{ $item->specification }}</td>
                                  <td style="text-align: center">{{ $item->qty }}</td>
                                  <td style="text-align: center">{{ $item->unit }}</td>
                                  <td style="text-align: center">{{ $item->rate }}</td>
                                  <td style="text-align: center">{{ $item->amount }}</td>
                                  @foreach ($item->quoteItemValues as $quoteItemValue)
                                      <td style="text-align: center">{{ $quoteItemValue->value }}</td>
                                  @endforeach
                                  @php
                                      $grandTotal += $item->amount;
                                  @endphp
                              </tr>
                          @endforeach
                          <tfoot>
                            <tr>
                                <td colspan="6" style="text-align: right"> Total</td>
                                <td style="text-align: center" class="grandTotal">{{ $grandTotal }}</td>
                            </tr>
                        </tfoot>
                      </table>
                  @endforeach
              @endforeach

              </div>
          </div>
    </div>
</body>
</html>