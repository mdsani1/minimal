<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Quotation</title>
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

    <?php
      if ($quote->quotation->first_person !== null && $quote->quotation->first_person !== '' &&
          $quote->quotation->second_person !== null && $quote->quotation->second_person !== '' &&
          $quote->quotation->third_person !== null && $quote->quotation->third_person !== '' &&
          $quote->quotation->fourth_person !== null && $quote->quotation->fourth_person !== '' &&
          $quote->quotation->fifth_person !== null && $quote->quotation->fifth_person !== '') {
          echo '.column2 { float: left; width: 20%; padding: 0px; }';
      } elseif ($quote->quotation->first_person !== null && $quote->quotation->first_person !== '' &&
          $quote->quotation->second_person !== null && $quote->quotation->second_person !== '' &&
          $quote->quotation->third_person !== null && $quote->quotation->third_person !== '' &&
          $quote->quotation->fourth_person !== null && $quote->quotation->fourth_person !== '') {
          echo '.column2 { float: left; width: 25%; padding: 0px; }';
      } elseif ($quote->quotation->first_person !== null && $quote->quotation->first_person !== '' &&
          $quote->quotation->second_person !== null && $quote->quotation->second_person !== '' &&
          $quote->quotation->third_person !== null && $quote->quotation->third_person !== '') {
          echo '.column2 { float: left; width: 33.3%; padding: 0px; }';
      } elseif ($quote->quotation->first_person !== null && $quote->quotation->first_person !== '' &&
          $quote->quotation->second_person !== null && $quote->quotation->second_person !== '') {
          echo '.column2 { float: left; width: 50%; padding: 0px; }';
      } else {
          echo '.column2 { float: left; width: 100%; padding: 0px; }';
      }
      ?>
    
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
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }
  </style>
</head>
<body>
  <div style="page-break-after: always;">
    <div class="row">
      <div class="column">
        <img src="{{ public_path('backend/images/organization/'.$organization->image ?? '') }}" alt="" style="width: 70%">
        <h4>Ref: {{ $quotation->ref }}</h4>
        <h4>To</h4>
        <h4>{{ $quotation->name }}</h4>
        <h4>{{ $quotation->address }}</h4>
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
              $dateString = $quotation->date;
              $formattedDate = date("F j, Y", strtotime($dateString));
          @endphp 
          <p style="margin-top: 20px">{{ $formattedDate }}</p>
        </div>
      </div>
    </div>
  
    <div style="background-color:#bbb; text-align:center; border:3px solid #09e240; width:94%; margin-left:10px">
      <h4>Financial Proposal For Residence Interior & Electrical Works</h4>
      <h4>Of</h4>
      <h3>{{ $quotation->name }} | {{ $quotation->area }}</h3>
    </div>

    <div style="margin-top: 20px;">
      <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:32%; margin-left:30%"><span style="background-color:#bbb; ">Quotation Version Change History</span></h3>
    </div>
    <div style="width:95%; margin-left:10px; margin-top:8px">
      <table>
        <tr style="background-color:#bbb;">
          <th style="text-align: center">Revision Date </th>
          <th style="text-align: center">Version</th>
          <th style="text-align: center">Changes</th>
          <th style="text-align: center">Created By</th>
        </tr>
        @foreach ($quotation->sheets as $sheet)
            @if ($loop->first)
              <tr>
                <td style="text-align: center">{{ $quotation->date }}</td>
                <td style="text-align: center">{{ $sheet->version }}</td>
                <td>{{ $sheet->change }}</td>
                <td style="text-align: center">{{ $quotation->user->name }}</td>
              </tr>
              @else
              <tr>
                <td style="text-align: center">{{ $sheet->date }}</td>
                <td style="text-align: center">{{ $sheet->version }}</td>
                <td>{{ $sheet->change }}</td>
                <td style="text-align: center">{{ $sheet->user->name }}</td>
              </tr>
            @endif
        @endforeach
      </table>
    </div>

    <div style="margin-top: 20px;">
      <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:30%; margin-left:30%"><span style="background-color:#bbb; ">Zonewise Budget Summary
      </span></h3>
    </div>

    <div style="width:95%; margin-left:10px; margin-top:8px">
      <table>
        <tr style="background-color:#bbb;">
          <th style="text-align: center">SL </th>
          <th style="text-align: center">Work Scope</th>
          <th style="text-align: center">Amount</th>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach ($quotation->quotationItems as $quotationItem)
        <tr>
          <td style="text-align: center">{{ $loop->iteration }}</td>
          <td>{{ $quotationItem->category->title ?? '' }}</td>
          @foreach ($groupedItems as $index => $value)
              @if ($index == $quotationItem->work_scope)
                  <td style="text-align: center">{{ $value ?? 0 }}</td>
                  @php
                      $total += $value;
                  @endphp
              @endif
          @endforeach
        </tr>
        @endforeach
        <tr>
          <td colspan="2" style="border: 0px solid !important; text-align:right">GRAND TOTAL</td>
          <td style="text-align: center">{{ $total }}</td>
        </tr>

      </table>
        @php
            $number = round($total ?? 0, 0);
            $numFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $totalamountofwords =  $numFormatter->format($number);
        @endphp

        <h3 style="margin-top: 20px">In Words - {{ ucwords($totalamountofwords) }}</h3>
    </div> 

    <div style="margin-top: 30px;">
      <p style="margin-left: 8px">Sincerely Yours,</p>

      <div class="row">
          <div class="column2">
              <p style="margin-top: 50px;">
                  <span>
                    @if ($quote && $quote->quotation && $quote->quotation->first_person_signature)
                        <img src="{{ public_path('images/' . $quote->quotation->first_person_signature) }}" alt="" style="width: 200px; height: 100px">
                    @endif                                
                  </span>
              </p>
              <p>{!! $quote->quotation->first_person !!}</p>
          </div>
          @if ($quote->quotation->second_person != null  && $quote->quotation->second_person != '')
          <div class="column2" style="text-align: right">
              <p style="margin-top: 50px;">
                  <span>
                      @isset($quote->quotation->second_person_signature)
                          <img src="{{ public_path('images/' . $quote->quotation->second_person_signature) }}" alt="" style="width: 200px; height: 100px">
                      @endisset                                        </span>
              </p>
              <p>{!! $quote->quotation->second_person !!}</p>
          </div>
          @endif
          @if ($quote->quotation->third_person != null  && $quote->quotation->third_person != '')
          <div class="column2" style="text-align: right">
              <p style="margin-top: 50px;">
                  <span>
                      @isset($quote->quotation->third_person_signature)
                          <img src="{{ public_path('images/' . $quote->quotation->third_person_signature) }}" alt="" style="width: 200px; height: 100px">
                      @endisset                                          </span>
              </p>
              <p>{!! $quote->quotation->third_person !!}</p>
          </div>
          @endif
          @if ($quote->quotation->fourth_person != null  && $quote->quotation->fourth_person != '')
          <div class="column2" style="text-align: right">
              <p style="margin-top: 50px;">
                  <span>
                      @isset($quote->quotation->fourth_person_signature)
                          <img src="{{ public_path('images/' . $quote->quotation->fourth_person_signature) }}" alt="" style="width: 200px; height: 100px">
                      @endisset                                          </span>
              </p>
              <p>{!! $quote->quotation->fourth_person !!}</p>
          </div>
          @endif
          @if ($quote->quotation->fifth_person != null  && $quote->quotation->fifth_person != '')
          <div class="column2" style="text-align: right">
              <p style="margin-top: 50px;">
                  <span>
                      @isset($quote->quotation->fifth_person_signature)
                          <img src="{{ public_path('images/' . $quote->quotation->fifth_person_signature) }}" alt="" style="width: 200px; height: 100px">
                      @endisset                                          </span>
              </p>
              <p>{!! $quote->quotation->fifth_person !!}</p>
          </div>
          @endif
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
                          <td style="text-align: center">{!! $item->specification !!}</td>
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

  <div style="page-break-before: always;">
    <div class="page termSection">
      <div class="row">
          <div class="column"> 
              <p></p>
          </div>
          <div class="column organization-details">
          <div class="text-dark">
              {!! $organization->address !!}
          </div>
          <div>
              <p class="text-dark">{{ $organization->phone }}</p>
              <p class="text-dark">{{ $organization->email }}</p>
              <p class="text-dark"><a href="{{ $organization->facebook }}">{{ $organization->facebook }}</a></p>
              <p class="text-dark"><a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a></p>
          </div>
          </div>
      </div>
      <h5 class="text-dark"><span style=""><u>Payment Schedule</u></span></h5>
      @foreach ($payments as $payment)
         <p class="text-dark"><b style="font-weight: 900">{{ $loop->iteration }}</b>. {{ $payment->title }}</p>
      @endforeach

      @if ($quotation->active_bank == 0)
      <h5 class="text-dark mt-3"><span style=""><u>Bank Account Information</u></span></h5>

      <table class="table terTable" style="width: 70%; border: 0px solid #fff;">
          <tr>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Bank Name</td>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;">: {{ $bank->bank_name }}</td>
          </tr>
          <tr>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Branch Name</td>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;">: {{ $bank->branch_name }}</td>
          </tr>
          <tr>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Account Name</td>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;">: {{ $bank->account_name }}</td>
          </tr>
          <tr>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Account Number</td>
              <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;">: {{ $bank->account_number }}</td>
          </tr>
      </table>
      @endif


      <h5 class="text-dark mt-3"><span style=""><u>Terms & Conditions</u></span></h5>

      @foreach ($terms as $term)
         <p class="text-dark"><b style="font-weight: 900">{{ $loop->iteration }}</b>. {{ $term->title }}</p>
      @endforeach

      <p class="mt-2 text-dark" style="font-weight: 900">Special Note: {{ $termInfo->note }}</p>

      <p class="mt-2 text-dark" style="margin-top: 10px">Sincerely Yours,</p>

      <p class="mt-4 text-dark" style="margin-top: 10px">{{ $termInfo->name }}</p>
      @if ($termInfo->email != null)
      <p class="text-dark">{{ $termInfo->email }}</p>
      @endif
      <p class="text-dark">{{ $termInfo->designation }}</p>
      <p class="text-dark">Minimal Limited</p>

  </div>
  </div>
</body>
</html>
