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
      font-size: 15px;
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
      <h3>{{ $quotation->name }} | {{ $quotation->address }}</h3>
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
        <tr>
          <td style="text-align: center">{{ $quotation->date }}</td>
          <td style="text-align: center">V1.0</td>
          <td>- Initial quotation</td>
          <td style="text-align: center">{{ $quotation->user->name }}</td>
        </tr>
        @foreach ($quotation->changeHistories as $changeHistory)
        <tr>
          <td style="text-align: center">{{ $changeHistory->date }}</td>
          <td style="text-align: center">{{ $changeHistory->version }}</td>
          <td>- {{ $changeHistory->change }}</td>
          <td style="text-align: center">{{ $changeHistory->user->name }}</td>
        </tr>
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
          <td>{{ $quotationItem->category->title }}</td>
          <td style="text-align: center">{{ $quotationItem->amount }}</td>
        </tr>
        @php
            $total += $quotationItem->amount;
        @endphp
        @endforeach
        <tr>
          <td colspan="2" style="border: 0px solid !important; text-align:right">GRAND TOTAL</td>
          <td style="text-align: center">{{ $total }}</td>
        </tr>

      </table>
        @php
            $number = $total ?? 0;
            $numFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $totalamountofwords =  $numFormatter->format($number);
        @endphp

        <h3 style="margin-top: 20px">In Words - {{ ucwords($totalamountofwords) }}</h3>
    </div> 

    <div style="margin-top: 30px;">
      <p style="margin-left: 8px">Sincerely Yours,</p>

      <div class="row">
        <div class="column" st>

          <p style="margin-top: 50px;">...........................................................</p>
          <p><b>Nazrul Islam</b></p>
          <p>Email: nazrul@minimallimited.com</p>
          <p>Sales Manager</p>
          <p>Minimal Limited</p>
        </div>
        <div class="column" style="text-align: right">
          <p style="margin-top: 50px;">...........................................................</p>
          <p><b>A B M Shafiqul Alam</b></p>
          <p>Director</p>
          <p>Minimal Limited</p>
        </div>
      </div>
    </div>


  </div>
</body>
</html>
