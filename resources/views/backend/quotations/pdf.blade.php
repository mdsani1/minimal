<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Quotation</title>
  <style>
    * {
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
      /* border: 1px solid; */
      font-size: 12px;
      padding: 5px;
    }

    .table, td, th {
      border: 1px solid;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }
  </style>
</head>
<body>
    <div style="page-break-after: always;">
        <div style="margin-left: 10px; margin-bottom:15px">
        <h4 style="font-size: 12px">Ref: {{ $quotation->ref }}</h4>
            <h4 style="font-size: 12px">To</h4>
            <h4 style="font-size: 12px">{{ $quotation->name }}</h4>
            <h4 style="font-size: 12px">{{ $quotation->address }}</h4>
        </div>

        <div style="background-color:#bbb; text-align:center; border:3px solid #09e240; width:94%; margin-left:10px">
        <h4 style="font-size: 13px">Financial Proposal For Residence Interior & Electrical Works</h4>
        <h4 style="font-size: 13px">Of</h4>
        <h3 style="font-size: 18px">{{ $quotation->name }} | {{ $quotation->area }}</h3>
        </div>

        <div style="margin-top: 20px;">
        <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:40%; margin-left:30%; font-size: 12px"><span style="background-color:#bbb; ">Quotation Version Change History</span></h3>
        </div>
        <div style="width:95%; margin-left:10px; margin-top:8px">
        <table class="table">
            <tr style="background-color:#bbb;">
            <th style="text-align: center; font-size: 15px; width:20%">Revision Date </th>
            <th style="text-align: center; font-size: 15px; width:15%">Version</th>
            <th style="text-align: center; font-size: 15px">Changes</th>
            <th style="text-align: center; font-size: 15px; width:15%">Created By</th>
            </tr>
            @foreach ($quotation->sheets as $sheet)
                @if ($loop->first)
                <tr>
                    @php
                        $date = date_create($quotation->date); // $quotation->date ke Date/Time object e convert kora
                        $formatted_date = date_format($date, 'd-m-Y'); // Date/Time object ke desired format e format kora
                    @endphp
                    <td style="text-align: center; font-size: 12px">{{ $formatted_date }}</td>
                    <td style="text-align: center; font-size: 12px">{{ $sheet->version }}</td>
                    <td style="font-size: 12px">{{ $sheet->change }}</td>
                    <td style="text-align: center; font-size: 12px">{{ $quotation->user->name }}</td>
                </tr>
                @else
                <tr>
                    @php
                        $date = date_create($sheet->date); // $quotation->date ke Date/Time object e convert kora
                        $formatted_date = date_format($date, 'd-m-Y'); // Date/Time object ke desired format e format kora
                    @endphp
                    <td style="text-align: center; font-size: 12px">{{ $formatted_date }}</td>
                    <td style="text-align: center; font-size: 12px">{{ $sheet->version }}</td>
                    <td>{{ $sheet->change }}</td>
                    <td style="text-align: center; font-size: 12px">{{ $sheet->user->name }}</td>
                </tr>
                @endif
            @endforeach
        </table>
        </div>

        <div style="margin-top: 20px;">
        <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:40%; margin-left:30%; font-size: 12px;"><span style="background-color:#bbb; ">Zonewise Budget Summary
        </span></h3>
        </div>

        <div style="width:95%; margin-left:10px; margin-top:8px">
        <table class="table">
            <tr style="background-color:#bbb;">
            <th style="text-align: center; font-size: 15px">SL </th>
            <th style="text-align: center; font-size: 15px">Work Scope</th>
            <th style="text-align: center; font-size: 15px">Amount</th>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach ($quotation->quotationItems as $quotationItem)
            <tr>
            <td style="text-align: center; font-size: 14px"><b>{{ $loop->iteration }}</b></td>
            <td style="font-size: 14px"><b>{{ $quotationItem->category->title ?? '' }}</b></td>
            @php
                $valueCheck = false;
            @endphp
            @foreach ($groupedItems as $index => $value)
                @if ($index == $quotationItem->work_scope)
                    <td style="text-align: right; font-size: 14px"><b>{{ number_format($value, 2, '.', ',') ?? 0.0 }}</b></td>
                    @php
                        $total += $value;
                        $valueCheck = true;
                    @endphp
                @endif
            @endforeach
            @if ($valueCheck == false)
            <td style="text-align: right; font-size: 14px"><b>0.0</b></td>
            @endif
            </tr>
            @endforeach
            <tr>
            <td colspan="2" style="border: 0px solid !important; text-align:right; font-size: 14px; border-bottom:0px solid !important"><b>GRAND TOTAL</b></td>
            <td style="text-align: right; font-size: 14px"><b>{{ number_format($total, 2, '.', ',') }}</b></td>
            </tr>

        </table>
            {{-- @php
                $number = round($total ?? 0, 0);
                $numFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                $totalamountofwords =  $numFormatter->format($number);
            @endphp --}}

            <?php

            // function convertNumberToWord($num = false)
            // {
            //     $num = str_replace(array(',', ' '), '' , trim($num));
            //     if(! $num) {
            //         return false;
            //     }
            //     $num = (int) $num;
            //     $words = array();
            //     $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            //         'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            //     );
            //     $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
            //     $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            //         'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            //         'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
            //     );
            //     $num_length = strlen($num);
            //     $levels = (int) (($num_length + 2) / 3);
            //     $max_length = $levels * 3;
            //     $num = substr('00' . $num, -$max_length);
            //     $num_levels = str_split($num, 3);
            //     for ($i = 0; $i < count($num_levels); $i++) {
            //         $levels--;
            //         $hundreds = (int) ($num_levels[$i] / 100);
            //         $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            //         $tens = (int) ($num_levels[$i] % 100);
            //         $singles = '';
            //         if ( $tens < 20 ) {
            //             $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            //         } else {
            //             $tens = (int)($tens / 10);
            //             $tens = ' ' . $list2[$tens] . ' ';
            //             $singles = (int) ($num_levels[$i] % 10);
            //             $singles = ' ' . $list1[$singles] . ' ';
            //         }
            //         $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
            //     } //end for loop
            //     $commas = count($words);
            //     if ($commas > 1) {
            //         $commas = $commas - 1;
            //     }
            //     return implode(' ', $words);
            // }

            function convertNumberToWord(float $number)
            {
                $decimal = round($number - ($no = floor($number)), 2) * 100;
                $hundred = null;
                $digits_length = strlen($no);
                $i = 0;
                $str = array();
                $words = array(0 => '', 1 => 'one', 2 => 'two',
                    3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                    7 => 'seven', 8 => 'eight', 9 => 'nine',
                    10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                    13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                    16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                    19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                    40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                    70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
                $digits = array('', 'hundred','thousand','lakh', 'crore');
                while( $i < $digits_length ) {
                    $divider = ($i == 2) ? 10 : 100;
                    $number = floor($no % $divider);
                    $no = floor($no / $divider);
                    $i += $divider == 10 ? 1 : 2;
                    if ($number) {
                        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                        $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                    } else $str[] = null;
                }
                $Rupees = implode('', array_reverse($str));
                $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
                return ($Rupees ? $Rupees . 'Taka Only.' : '') . $paise;
            }

            // Example usage:
            $total = round($total ?? 0, 0);
            // $totalamountofwords = numberToWords($total);
            $totalamountofwords = convertNumberToWord($total);

            ?>

            <h3 style="margin-top: 20px; font-size:13px">In Words - {{ ucwords($totalamountofwords) }}</h3>
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
            <div class="column2" style="text-align: {{ $quote->quotation->third_person == null ? 'left' : 'left' }}">
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
            <div class="column2" style="text-align: {{ $quote->quotation->fourth_person == null ? 'left' : 'left' }}">
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
            <div class="column2" style="text-align: {{ $quote->quotation->fifth_person == null ? 'left' : 'left' }}">
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
        <div style="width:95%; margin-left:10px;">
            @foreach ($data as $key => $quoteItem)
                <div style="{{ !$loop->first ? 'page-break-before: always;' : '' }}">
                    <div style="margin-bottom: 15px;">
                        <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:50%; margin-left:23%; font-size: 14px; border:2px solid #09e240">
                            <span style="background-color:#bbb; "><b>{{ $key }}</b></span>
                        </h3>
                    </div>
                    <table style="margin-bottom: 30px">
                        <tr style="background-color:#bbb;">
                            <th style="text-align: center;font-size: 13px;">SL </th>
                            <th style="text-align: center;font-size: 13px; width:20%">ITEM</th>
                            <th style="text-align: center;font-size: 13px; width:40%">SPECIFICATION</th>
                            <th style="text-align: center;font-size: 13px; min-width:60px">QTY</th>
                            <th style="text-align: center;font-size: 13px; min-width:60px">UNIT</th>
                            <th style="text-align: center;font-size: 13px; min-width:60px">RATE</th>
                            <th style="text-align: center;font-size: 13px; min-width:100px">AMOUNT</th>
                            @if (isset($quoteItem['category']))
                            @foreach ($quoteItem['category']->first()->quoteItemValues as $data)
                                <th style="text-align: center; width:100px">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                            @endforeach
                            @endif
                            @if (isset($quoteItem['subcategory']))
                            @foreach ($quoteItem['subcategory']->first()->first()->quoteItemValues as $data)
                                <th style="text-align: center; width:100px">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                            @endforeach
                            @endif
                        </tr>
                        @php
                            $grandTotal = 0;
                        @endphp
                        @if (isset($quoteItem['category']))
                        @php
                            $checkItem = '';
                            $extraStyle = '';
                            $categorySl = 1;


                        @endphp
                        @foreach ($quoteItem['category'] as $item)

                            @php
                                // Initialize the style variable
                                $extraStyle = '';
                                // Check the condition and set the style
                                if($item->item == $checkItem) {
                                    $extraStyle = 'border-top: 2px solid white';
                                }
                            @endphp

                            <tr>
                                <td style="font-size:10px; text-align: center; width:5%">{{ $categorySl++ }}</td>
                                <td style="font-size:10px; text-align: center; width:15%; {{ $extraStyle }}">
                                    {{ $item->item == $checkItem ? '' : $item->item }}
                                </td>

                                <?php
                                    $specificationData = $item->specification;

                                    // Check if $specificationData is not empty before processing it
                                    if (!empty($specificationData)) {

                                        $dom = new DOMDocument();
                                        $dom->loadHTML($specificationData);

                                        // Use DOMXPath to query the document
                                        $xpath = new DOMXPath($dom);

                                        $dimensions = "";

                                        $length_feetvalue = "";
                                        $length_inchevalue = "";
                                        $height_feetvalue = "";
                                        $height_inchevalue = "";
                                        $width_feetvalue = "";
                                        $width_inchevalue = "";
                                        $depth_feetvalue = "";
                                        $depth_inchevalue = "";

                                        // Query for the input with class 'length_feet'
                                        $length_feetinput = $xpath->query('//input[@class="form-control qtyCalculations length_feet mt-2"]')->item(0);
                                        $length_incheinput = $xpath->query('//input[@class="form-control qtyCalculations length_inche mt-2"]')->item(0);
                                        $height_feetinput = $xpath->query('//input[@class="form-control qtyCalculations height_feet mt-2"]')->item(0);
                                        $height_incheinput = $xpath->query('//input[@class="form-control qtyCalculations height_inche mt-2"]')->item(0);
                                        $width_feetinput = $xpath->query('//input[@class="form-control qtyCalculations width_feet mt-2"]')->item(0);
                                        $width_incheinput = $xpath->query('//input[@class="form-control qtyCalculations width_inche mt-2"]')->item(0);
                                        $depth_feetinput = $xpath->query('//input[@class="form-control qtyCalculations depth_feet mt-2"]')->item(0);
                                        $depth_incheinput = $xpath->query('//input[@class="form-control qtyCalculations depth_inche mt-2"]')->item(0);

                                        if ($length_feetinput) {
                                            $length_feetvalue = $length_feetinput->getAttribute('value');
                                        }
                                        if ($length_incheinput) {
                                            $length_inchevalue = $length_incheinput->getAttribute('value');
                                        }

                                        if ($height_feetinput) {
                                            $height_feetvalue = $height_feetinput->getAttribute('value');
                                        }
                                        if ($height_incheinput) {
                                            $height_inchevalue = $height_incheinput->getAttribute('value');
                                        }

                                        if ($width_feetinput) {
                                            $width_feetvalue = $width_feetinput->getAttribute('value');
                                        }
                                        if ($width_incheinput) {
                                            $width_inchevalue = $width_incheinput->getAttribute('value');
                                        }

                                        if ($depth_feetinput) {
                                            $depth_feetvalue = $depth_feetinput->getAttribute('value');
                                        }
                                        if ($depth_incheinput) {
                                            $depth_inchevalue = $depth_incheinput->getAttribute('value');
                                        }

                                        if (is_numeric($length_feetvalue) && is_numeric($length_inchevalue)) {
                                            $dimensions .= "Dimensions: " . $length_feetvalue . "' " . $length_inchevalue . '"' . ' (L)';
                                        }
                                        if (is_numeric($height_feetvalue) && is_numeric($height_inchevalue)) {
                                            $dimensions .= " X " . $height_feetvalue . "' " . $height_inchevalue . '"' . ' (H)';
                                        }
                                        if(is_numeric($width_feetvalue) && is_numeric($width_inchevalue)){
                                        $dimensions .= " X " . $width_feetvalue . "' " . $width_inchevalue . '"' . ' (W)';

                                        }
                                        if(is_numeric($depth_feetvalue) && is_numeric($depth_inchevalue)){ {
                                            $dimensions .= " X " . $depth_feetvalue . "' " . $depth_inchevalue . '"' . ' (D)';
                                        }

                                    }

                                        // Remove <div> tags from specification data
                                        $specificationData = preg_replace('/<div[^>]*>/', '', $specificationData);
                                        $specificationData = preg_replace('/<\/div>/', '', $specificationData);
                                        $specificationData = preg_replace('/<label[^>]*>.*?<\/label>/', '', $specificationData);
                                        $specificationData = preg_replace('/<label[^>]*>.*?<\/label>/', '', $specificationData);
                                        $specificationData = preg_replace('/<input[^>]*>/', '', $specificationData);

                                    } else {
                                        // Set empty values if specification data is empty
                                        $specificationData = "";
                                        $dimensions = "";
                                    }

                                ?>

                                <td style="font-size:10px; text-align: left; width:50%">{!! $specificationData !!} <br> <b>{{ $dimensions }}</b></td>
                                <td style="font-size:10px; text-align: center">{{ $item->qty }}</td>
                                <td style="font-size:10px; text-align: center">{{ $item->unit }}</td>
                                <td style="font-size:10px; text-align: center">{{ $item->rate }}</td>
                                <td style="font-size:10px; text-align: right">{{ number_format($item->amount, 2, '.', ',') }}</td>
                                @foreach ($item->quoteItemValues as $quoteItemValue)
                                    <td style="font-size:10px; text-align: center">{{ $quoteItemValue->value }}</td>
                                @endforeach
                                @php
                                    $grandTotal += $item->amount;
                                    $checkItem = $item->item;
                                @endphp
                            </tr>
                        @endforeach
                        @else
                            @php
                                $subcategorySl = 1;
                            @endphp
                        @foreach ($quoteItem['subcategory'] as $subcategory)


                            @php
                                $subTotal = 0;
                            @endphp
                            <tr style="background-color: #ddd">
                                <td colspan="7" style="text-align: center"><b>{{ $subcategory->first()->subcategory->title }}</b></td>
                            </tr>
                            @php
                                $checkSubItem = '';
                                $extraSubStyle = '';
                            @endphp
                            @foreach ($subcategory as $item)
                            @php
                                // Initialize the style variable
                                $extraSubStyle = '';
                                // Check the condition and set the style
                                if($item->item == $checkSubItem) {
                                    $extraSubStyle = 'border-top: 2px solid white';
                                }
                            @endphp
                            <tr>
                                <td style="font-size:10px; text-align: center; width:5%">{{ $subcategorySl++ }}</td>
                                <td style="font-size:10px; text-align: center; width:15%; {{ $extraSubStyle }}">
                                    {{ $item->item == $checkSubItem ? '' : $item->item }}
                                </td>

                                <?php
                                    $specificationData = $item->specification;

                                    // Check if $specificationData is not empty before processing it
                                    if (!empty($specificationData)) {

                                        $dom = new DOMDocument();
                                        $dom->loadHTML($specificationData);

                                        // Use DOMXPath to query the document
                                        $xpath = new DOMXPath($dom);

                                        $dimensions = "";

                                        $length_feetvalue = "";
                                        $length_inchevalue = "";
                                        $height_feetvalue = "";
                                        $height_inchevalue = "";
                                        $width_feetvalue = "";
                                        $width_inchevalue = "";
                                        $depth_feetvalue = "";
                                        $depth_inchevalue = "";

                                        // Query for the input with class 'length_feet'
                                        $length_feetinput = $xpath->query('//input[@class="form-control qtyCalculations length_feet mt-2"]')->item(0);
                                        $length_incheinput = $xpath->query('//input[@class="form-control qtyCalculations length_inche mt-2"]')->item(0);
                                        $height_feetinput = $xpath->query('//input[@class="form-control qtyCalculations height_feet mt-2"]')->item(0);
                                        $height_incheinput = $xpath->query('//input[@class="form-control qtyCalculations height_inche mt-2"]')->item(0);
                                        $width_feetinput = $xpath->query('//input[@class="form-control qtyCalculations width_feet mt-2"]')->item(0);
                                        $width_incheinput = $xpath->query('//input[@class="form-control qtyCalculations width_inche mt-2"]')->item(0);
                                        $depth_feetinput = $xpath->query('//input[@class="form-control qtyCalculations depth_feet mt-2"]')->item(0);
                                        $depth_incheinput = $xpath->query('//input[@class="form-control qtyCalculations depth_inche mt-2"]')->item(0);

                                        if ($length_feetinput) {
                                            $length_feetvalue = $length_feetinput->getAttribute('value');
                                        }
                                        if ($length_incheinput) {
                                            $length_inchevalue = $length_incheinput->getAttribute('value');
                                        }

                                        if ($height_feetinput) {
                                            $height_feetvalue = $height_feetinput->getAttribute('value');
                                        }
                                        if ($height_incheinput) {
                                            $height_inchevalue = $height_incheinput->getAttribute('value');
                                        }

                                        if ($width_feetinput) {
                                            $width_feetvalue = $width_feetinput->getAttribute('value');
                                        }
                                        if ($width_incheinput) {
                                            $width_inchevalue = $width_incheinput->getAttribute('value');
                                        }

                                        if ($depth_feetinput) {
                                            $depth_feetvalue = $depth_feetinput->getAttribute('value');
                                        }
                                        if ($depth_incheinput) {
                                            $depth_inchevalue = $depth_incheinput->getAttribute('value');
                                        }

                                        if (is_numeric($length_feetvalue) && is_numeric($length_inchevalue)) {
                                            $dimensions .= "Dimensions: " . $length_feetvalue . "' " . $length_inchevalue . '"' . ' (L)';
                                        }
                                        if (is_numeric($height_feetvalue) && is_numeric($height_inchevalue)) {
                                            $dimensions .= " X " . $height_feetvalue . "' " . $height_inchevalue . '"' . ' (H)';
                                        }
                                        if(is_numeric($width_feetvalue) && is_numeric($width_inchevalue)){
                                        $dimensions .= " X " . $width_feetvalue . "' " . $width_inchevalue . '"' . ' (W)';

                                        }
                                        if(is_numeric($depth_feetvalue) && is_numeric($depth_inchevalue)){ {
                                            $dimensions .= " X " . $depth_feetvalue . "' " . $depth_inchevalue . '"' . ' (D)';
                                        }

                                    }

                                        // Remove <div> tags from specification data
                                        $specificationData = preg_replace('/<div[^>]*>/', '', $specificationData);
                                        $specificationData = preg_replace('/<\/div>/', '', $specificationData);
                                        $specificationData = preg_replace('/<label[^>]*>.*?<\/label>/', '', $specificationData);
                                        $specificationData = preg_replace('/<label[^>]*>.*?<\/label>/', '', $specificationData);
                                        $specificationData = preg_replace('/<input[^>]*>/', '', $specificationData);

                                    } else {
                                        // Set empty values if specification data is empty
                                        $specificationData = "";
                                        $dimensions = "";
                                    }

                                ?>

                                <td style="font-size:10px; text-align: left; width:50%">{!! $specificationData !!} <br> <b>{{ $dimensions }}</b></td>
                                <td style="font-size:10px; text-align: center">{{ $item->qty }}</td>
                                <td style="font-size:10px; text-align: center">{{ $item->unit }}</td>
                                <td style="font-size:10px; text-align: center">{{ $item->rate }}</td>
                                <td style="font-size:10px; text-align: right">{{ number_format($item->amount, 2, '.', ',') }}</td>
                                @foreach ($item->quoteItemValues as $quoteItemValue)
                                    <td style="font-size:10px; text-align: center">{{ $quoteItemValue->value }}</td>
                                @endforeach
                                @php
                                    $grandTotal += $item->amount;
                                    $subTotal += $item->amount;
                                    $checkSubItem = $item->item;
                                @endphp
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" style="text-align: right; border-left:none"><b>Subtotal</b></td>
                                <td style="text-align: right" class="grandTotal"><b>{{ number_format($subTotal, 2, '.', ',') }}</b></td>
                            </tr>
                        @endforeach
                        @endif
                        <?php
                            // Example usage:
                            $total = round($grandTotal ?? 0, 0);
                            // $totalamountofwords = numberToWords($total);
                            $grandtotalamountofwords = convertNumberToWord($total);
                        ?>

                        <tfoot>
                        <tr>
                            <td colspan="6" style="text-align: right; font-size:16px"><b>GRAND TOTAL</b></td>
                            <td style="text-align: right; font-size:16px" class="grandTotal"><b>{{ number_format($grandTotal, 2, '.', ',') }}</b></td>
                        </tr>
                        </tfoot>
                    </table>
                    <h3 style="margin-top: 20px; font-size:13px">In Words - {{ ucwords($grandtotalamountofwords) }}</h3>
                </div>
            @endforeach
        </div>
    </div>

    <div style="page-break-before: always;">
        <div class="page termSection">
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
