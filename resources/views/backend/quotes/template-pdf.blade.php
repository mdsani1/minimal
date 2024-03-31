<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $template->title }}</title>
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
                    $dateString = $template->date;
                    $formattedDate = date("F j, Y", strtotime($dateString));
                @endphp 
                <p style="margin-top: 20px">{{ $formattedDate }}</p>
              </div>
            </div>
          </div>

          <div>
            <p style="text-align: center; font-size:20px">{{ $template->title }}</p>

            <div style="width:95%; margin-left:10px; margin-top:8px">
              @foreach ($templateItems as $categoryId => $subCategories)
              @foreach ($subCategories as $subCategoryId => $templateItem)
                  <p style="font-size: 18px">
                    {{ $templateItem->first()->category->title }} 
                    @if ($templateItem->first()->subCategory != null)
                        ({{ $templateItem->first()->subCategory  ->title }})
                    @endif
                  </p>
                  <table style="margin-bottom: 30px">
                      <tr style="background-color:#bbb;">
                          <th style="text-align: center">SL </th>
                          <th style="text-align: center">ITEM</th>
                          <th style="text-align: center">SPECIFICATION</th>
                          <th style="text-align: center">QTY</th>
                          <th style="text-align: center">UNIT</th>
                          <th style="text-align: center">RATE</th>
                          <th style="text-align: center">AMOUNT</th>
                          @foreach ($templateItem->first()->templateItemValues as $data)
                              <th style="text-align: center">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                          @endforeach
                      </tr>
                      @php
                          $grandTotal = 0;
                      @endphp
                      @foreach ($templateItem as $item)
                          <tr>
                              <td style="text-align: center">{{ $item->sl }}</td>
                              <td style="text-align: center; width:30%">{{ $item->item }}</td>
                              <?php
                                      $specificationData = $item->specification;
                          
                                      // Check if $specificationData is not empty before processing it
                                      if (!empty($specificationData)) {
                                          $dom = new DOMDocument();
                                          $dom->loadHTML($specificationData);
                          
                                          // Use DOMXPath to query the document
                                          $xpath = new DOMXPath($dom);
                          
                                          // Query for the input with class 'length_feet'
                                          $length_feetinput = $xpath->query('//input[@class="form-control qtyCalculations length_feet mt-2"]')->item(0);
                                          $length_incheinput = $xpath->query('//input[@class="form-control qtyCalculations length_inche mt-2"]')->item(0);
                                          $width_feetinput = $xpath->query('//input[@class="form-control qtyCalculations width_feet mt-2"]')->item(0);
                                          $width_incheinput = $xpath->query('//input[@class="form-control qtyCalculations width_inche mt-2"]')->item(0);
                                          $height_feetinput = $xpath->query('//input[@class="form-control height_feet mt-2"]')->item(0);
                                          $height_incheinput = $xpath->query('//input[@class="form-control height_inche mt-2"]')->item(0);
                          
                                          // Check if all input fields were found
                                          if ($length_feetinput && $length_incheinput && $width_feetinput && $width_incheinput) {
                                              // Extracted dimensions
                                              $length_feetvalue = $length_feetinput->getAttribute('value');
                                              $length_inchevalue = $length_incheinput->getAttribute('value');
                                              $width_feetvalue = $width_feetinput->getAttribute('value');
                                              $width_inchevalue = $width_incheinput->getAttribute('value');
                          
                                              // Concatenate the extracted dimensions into a single string
                                              $dimensions = "Dimensions: " . $length_feetvalue . "' " . $length_inchevalue . ' (L)'."\" x " . $width_feetvalue . "' " . $width_inchevalue . ' (W)'."\"";
                          
                                              // Check if height input fields were found before adding to the dimensions string
                                              if ($height_feetinput && $height_incheinput) {
                                                  $height_feetvalue = $height_feetinput->getAttribute('value');
                                                  $height_inchevalue = $height_incheinput->getAttribute('value');
                                                  $dimensions .= " x " . $height_feetvalue . "' " . $height_inchevalue . ' (H)'."\"";
                                              }
                                          } else {
                                              // Handle case where input fields are not found
                                              $dimensions = "";
                                          }
                          
                                          // Remove <div> tags from specification data
                                          $specificationData = preg_replace('/<div[^>]*>.*?<\/div>/', '', $specificationData);
                                          $specificationData = preg_replace('/<div[^>]*>/', '', $specificationData);
                                          $specificationData = preg_replace('/<\/div>/', '', $specificationData);
                                      } else {
                                          // Set empty values if specification data is empty
                                          $specificationData = "";
                                          $dimensions = "";
                                      }
                                  ?>
                          
                                  <td style="text-align: center">{!! $specificationData !!} <br> {{ $dimensions }}</td>
                              <td style="text-align: center">{{ $item->qty }}</td>
                              <td style="text-align: center">{{ $item->unit }}</td>
                              <td style="text-align: center">{{ $item->rate }}</td>
                              <td style="text-align: center">{{ $item->amount }}</td>
                              @foreach ($item->templateItemValues as $templateItemValue)
                                  <td style="text-align: center">{{ $templateItemValue->value }}</td>
                              @endforeach
                          </tr>
                          @php
                              $grandTotal += $item->amount;
                          @endphp
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