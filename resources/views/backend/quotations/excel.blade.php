<?php
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


<div>
    <div style="width:95%; margin-left:10px;">
        @foreach ($data as $key => $quoteItem)
            <div style="{{ !$loop->first ? 'page-break-before: always;' : '' }}">
                <div style="margin-bottom: 15px;">
                    <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:50%; margin-left:30%; font-size: 14px; border:2px solid #09e240">
                        <span style="background-color:#bbb; "><b>{{ $key }}</b></span>
                    </h3>
                </div>
                <table style="margin-bottom: 30px">
                    <tr style="background-color:#bbb;">
                        <th style="text-align: center;font-size: 13px;">SL </th>
                        <th style="text-align: center;font-size: 13px; width:20%">ITEM</th>
                        <th style="text-align: center;font-size: 13px; width:40%">SPECIFICATION</th>
                        <th style="text-align: center;font-size: 13px;">QTY</th>
                        <th style="text-align: center;font-size: 13px;">UNIT</th>
                        <th style="text-align: center;font-size: 13px;">RATE</th>
                        <th style="text-align: center;font-size: 13px;">AMOUNT</th>
                        @if (isset($quoteItem['category']))
                        @foreach ($quoteItem['category']->first()->quoteItemValues as $data)
                            <th style="text-align: center">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                        @endforeach
                        @endif
                        @if (isset($quoteItem['subcategory']))
                        @foreach ($quoteItem['subcategory']->first()->first()->quoteItemValues as $data)
                            <th style="text-align: center">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                        @endforeach
                        @endif
                    </tr>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @if (isset($quoteItem['category']))
                    @foreach ($quoteItem['category'] as $item)
                    
                        
                        <tr>
                            <td style="font-size:10px; text-align: center; width:5%">{{ $item->sl }}</td>
                            <td style="font-size:10px; text-align: center; width:15%">{{ $item->item }}</td>
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
                            @endphp
                        </tr>
                    @endforeach
                    @else
                    @foreach ($quoteItem['subcategory'] as $subcategory)
                        @php
                            $subTotal = 0;
                        @endphp
                        <tr style="background-color: #ddd">
                            <td colspan="7" style="text-align: center"><b>{{ $subcategory->first()->subcategory->title }}</b></td>
                        </tr>
                        @foreach ($subcategory as $item)
                        <tr>
                            <td style="font-size:10px; text-align: center; width:5%">{{ $item->sl }}</td>
                            <td style="font-size:10px; text-align: center; width:15%">{{ $item->item }}</td>
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

