<x-backend.layouts.master>


    <x-slot name="page_title">
        Editable Table
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Template Edit
            </x-slot>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div>

        <div class="">
            <input type="hidden" class="quotationId" value="{{ $template->quotation_id }}">
            <h3 class="mt-5 border text-center ">{{ $template->quotation->ref ?? '' }} ({{ $template->version }})</h3>

            <h1 class="mt-5">
                <input type="text" class="form-control template_title" name="template_title" style="background: none; border:none; font-size:30px" value="{{ $template->title }}">
                <input type="hidden" id="templateId" value="{{ $template->id }}">
            </h1>

            @if ($template->quotation != null)
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Top Sheet</button>
                </li>
                @foreach ($quotation->quotationItems as $quotationItem)
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="work-scope{{ $quotationItem->category->id }}-tab" data-toggle="tab" data-target="#tab-{{ $quotationItem->category->id }}" type="button" role="tab" aria-controls="tab-{{ $quotationItem->category->id }}" aria-selected="false">{{ $quotationItem->category->title ?? '' }}</button>
                </li>
                @endforeach
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="term-tab" data-toggle="tab" data-target="#term" type="button" role="tab" aria-controls="term" aria-selected="true">Terms & Condition</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('template') }}" class="btn btn-warning mr-2 mt-3">Exit</a>
                        {{-- <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-warning mr-2 mt-3">Quotation Edit</a> --}}
                        <a href="/template-pdf/{{ $template->id }}" class="btn btn-info mr-2 mt-3">Pdf</a>
                        <a href="/template-pdf/{{ $template->id }}" class="btn btn-primary mr-2 mt-3 copyLink">Copy</a>
    
                        <form style="display: inline;" action="/template-delete/{{ $template->id }}" method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-danger mt-3" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Delete Full Sheet</button>
                        </form>                
                    </div>
    
                    <div class="d-flex justify-content-center">
                        <div class="page">
                            <div class="row">
                                <div class="column">
                                <img src="{{ asset('backend/images/organization/'.$organization->image ?? '') }}" alt="" style="width: 70%">
                                <h4>Ref: {{ $template->quotation->ref }}</h4>
                                <h4>To</h4>
                                <h4>{{ $template->quotation->name }}</h4>
                                <h4>{{ $template->quotation->address }}</h4>
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
                                        $dateString = $template->quotation->date;
                                        $formattedDate = date("F j, Y", strtotime($dateString));
                                    @endphp 
                                    <p style="margin-top: 20px" data-toggle="modal" data-target="#quotationDate">{{ $formattedDate }}</p>
                                    <!-- Modal -->
                                    <div class="modal fade" id="quotationDate" tabindex="-1" aria-labelledby="quotationDateLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" style="min-width:60%">
                                        <div class="modal-content">
                                            <form action="{{ route('quotaion-date-update',$template->quotation->id) }}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="quotationDateLabel">Quotation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="">Date</label>
                                                        <input type="date" class="form-control" name="date" id="date" value="{{ $template->quotation->date }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                            <div style="background-color:#bbb; text-align:center; border:3px solid #09e240; width:100%;">
                                <h4 data-toggle="modal" data-target="#quotationTitle">{{ $template->quotation->title }}</h4>
                                <h4>Of</h4>
                                <h3>{{ $template->quotation->name }} | {{ $template->quotation->area }}</h3>
                            </div>
                        
                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:60%;"><span style="background-color:#bbb; ">Quotation Version Change History</span></h3>
                            </div>
    
                            <div style="width:100%; margin-top:8px">
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
                                        <td style="text-align: center" data-toggle="modal" data-target="#SheetDate{{ $sheet->id }}">{{ $sheet->date }}</td>
                                        <td style="text-align: center">{{ $sheet->version }}</td>
                                        <td data-toggle="modal" data-target="#sheetChange{{ $sheet->id }}">{{ $sheet->change }}</td>
                                        <td style="text-align: center">{{ $quotation->user->name }}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td style="text-align: center" data-toggle="modal" data-target="#SheetDate{{ $sheet->id }}">{{ $sheet->date }}</td>
                                        <td style="text-align: center">{{ $sheet->version }}</td>
                                        <td data-toggle="modal" data-target="#sheetChange{{ $sheet->id }}">{{ $sheet->change }}</td>
                                        <td style="text-align: center">{{ $sheet->user->name }}</td>
                                    </tr>
                                    @endif
                                    <!-- Modal -->
                                    <div class="modal fade" id="SheetDate{{ $sheet->id }}" tabindex="-1" aria-labelledby="SheetDate{{ $sheet->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" style="min-width:60%">
                                        <div class="modal-content">
                                            <form action="{{ route('sheet-date-update',$sheet->id) }}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="SheetDate{{ $sheet->id }}Label">Quotation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="">Date</label>
                                                        <input type="date" class="form-control" name="date" id="date" value="{{ $sheet->date }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
    
                                    <!-- Modal -->
                                    <div class="modal fade" id="sheetChange{{ $sheet->id }}" tabindex="-1" aria-labelledby="sheetChange{{ $sheet->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" style="min-width:60%">
                                        <div class="modal-content">
                                            <form action="{{ route('sheet-change-update',$sheet->id) }}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="sheetChange{{ $sheet->id }}Label">Quotation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="">Change</label>
                                                        <input type="text" class="form-control" name="change" id="change" value="{{ $sheet->change }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                                </table>
                            </div>
                        
                            <div class="d-flex justify-content-center" style="margin-top: 20px;">
                                <h3 style="padding: 8px; text-align:center; background-color:#bbb; width:60%;"><span style="background-color:#bbb; ">Zonewise Budget Summary
                                </span></h3>
                            </div>
                        
                            <div style="width:100%; margin-top:8px">
                                <table>
                                <tr style="background-color:#bbb;">
                                    <th style="text-align: center">SL </th>
                                    <th style="text-align: center">Work Scope</th>
                                    <th style="text-align: center">Amount</th>
                                </tr>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($template->quotation->quotationItems as $quotationItem)
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
                                {{-- @php
                                    $number = round($total ?? 0, 0);
                                    $numFormatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                    $totalamountofwords =  $numFormatter->format($number);
                                @endphp --}}
    
                                <?php
                                function numberToWords($number) {
                                    $words = array(
                                        '0' => 'zero',
                                        '1' => 'one',
                                        '2' => 'two',
                                        '3' => 'three',
                                        '4' => 'four',
                                        '5' => 'five',
                                        '6' => 'six',
                                        '7' => 'seven',
                                        '8' => 'eight',
                                        '9' => 'nine',
                                        '10' => 'ten',
                                        '11' => 'eleven',
                                        '12' => 'twelve',
                                        '13' => 'thirteen',
                                        '14' => 'fourteen',
                                        '15' => 'fifteen',
                                        '16' => 'sixteen',
                                        '17' => 'seventeen',
                                        '18' => 'eighteen',
                                        '19' => 'nineteen',
                                        '20' => 'twenty',
                                        '30' => 'thirty',
                                        '40' => 'forty',
                                        '50' => 'fifty',
                                        '60' => 'sixty',
                                        '70' => 'seventy',
                                        '80' => 'eighty',
                                        '90' => 'ninety',
                                    );
    
                                    if ($number < 21) {
                                        return $words[$number];
                                    }
    
                                    if ($number < 100) {
                                        $tens = floor($number / 10) * 10;
                                        $units = $number % 10;
                                        return $words[$tens] . ($units ? '-' . $words[$units] : '');
                                    }
    
                                    if ($number < 1000) {
                                        $hundreds = floor($number / 100);
                                        $remainder = $number % 100;
                                        return $words[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
                                    }
    
                                    // Add more cases as needed
    
                                    return 'number out of range';
                                }
    
                                // Example usage:
                                $total = round($total ?? 0, 0);
                                $totalamountofwords = numberToWords($total);
                                ?>
    
                        
                                <h3 style="margin-top: 20px">In Words - {{ ucwords($totalamountofwords) }}</h3>
                            </div> 
                        
                            <div style="margin-top: 30px;">
                                <p style="margin-left: 8px">Sincerely Yours,</p>
                        
                                <div class="row" style="display: flex; justify-content:space-around">
                                    <div class="column2">
                                        <p style="margin-top: 50px;">
                                            <span style="border-bottom: 1px dotted #ddd; display: inline-block; padding: 5px;">
                                                @isset($template->quotation->first_person_signature)
                                                    <img src="{{ asset('images/' . $template->quotation->first_person_signature) }}" alt="" style="width: 200px; height: 100px">
                                                @endisset                                        </span>
                                        </p>
                                        <p>{!! $template->quotation->first_person !!}</p>
                                    </div>
                                    @if ($template->quotation->second_person != null  && $template->quotation->second_person != '')
                                    <div class="column2" style="text-align: right">
                                        <p style="margin-top: 50px;">
                                            <span style="border-bottom: 1px dotted #ddd; display: inline-block; padding: 5px;">
                                                @isset($template->quotation->second_person_signature)
                                                    <img src="{{ asset('images/' . $template->quotation->second_person_signature) }}" alt="" style="width: 200px; height: 100px">
                                                @endisset                                        </span>
                                        </p>
                                        <p><b>{!! $template->quotation->second_person !!}</b></p>
                                    </div>
                                    @endif
                                    @if ($template->quotation->third_person != null  && $template->quotation->third_person != '')
                                    <div class="column2" style="text-align: right">
                                        <p style="margin-top: 50px;">
                                            <span style="border-bottom: 1px dotted #ddd; display: inline-block; padding: 5px;">
                                                @isset($template->quotation->third_person_signature)
                                                    <img src="{{ asset('images/' . $template->quotation->third_person_signature) }}" alt="" style="width: 200px; height: 100px">
                                                @endisset                                          </span>
                                        </p>
                                        <p><b>{!! $template->quotation->third_person !!}</b></p>
                                    </div>
                                    @endif
                                    @if ($template->quotation->fourth_person != null  && $template->quotation->fourth_person != '')
                                    <div class="column2" style="text-align: right">
                                        <p style="margin-top: 50px;">
                                            <span style="border-bottom: 1px dotted #ddd; display: inline-block; padding: 5px;">
                                                @isset($template->quotation->fourth_person_signature)
                                                    <img src="{{ asset('images/' . $template->quotation->fourth_person_signature) }}" alt="" style="width: 200px; height: 100px">
                                                @endisset                                          </span>
                                        </p>
                                        <p><b>{!! $template->quotation->fourth_person !!}</b></p>
                                    </div>
                                    @endif
                                    @if ($template->quotation->fifth_person != null  && $template->quotation->fifth_person != '')
                                    <div class="column2" style="text-align: right">
                                        <p style="margin-top: 50px;">
                                            <span style="border-bottom: 1px dotted #ddd; display: inline-block; padding: 5px;">
                                                @isset($template->quotation->fifth_person_signature)
                                                    <img src="{{ asset('images/' . $template->quotation->fifth_person_signature) }}" alt="" style="width: 200px; height: 100px">
                                                @endisset                                          </span>
                                        </p>
                                        <p><b>{!! $template->quotation->fifth_person !!}</b></p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($quotation->quotationItems as $quotationItem)
                <div class="tab-pane category fade" id="tab-{{ $quotationItem->category->id }}" role="tabpanel" aria-labelledby="work-tab{{ $quotationItem->category->id }}">
    
                    <div class="mt-4 mb-4 d-flex justify-content-between">
                        <div>
                            <button class="btn btn-success addRowBtn" id="">Add Row</button>
                            <button class="btn btn-info addColumnBtn" id="">Add Column</button>
                            <!-- Button to trigger PDF preview -->
                            {{-- <button class="btn btn-warning pdfPreviewButton" id="">Preview PDF</button> --}}
    
                            <!-- Button to download the PDF directly -->
                            {{-- <button class="btn btn-primary downloadPdfButton" id="">Download PDF</button> --}}
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('quotations.index') }}" class="btn btn-warning mr-2">Exit</a>
                            <a href="/template-pdf/{{ $template->id }}" class="btn btn-info mr-2">Pdf</a>
                            <a href="/template-pdf/{{ $template->id }}" class="btn btn-primary mr-2 copyLink">Copy</a>
                            <form style="display: inline;" action="/template-delete/{{ $quotationItem->id }}" method="POST">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-danger" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Delete</button>
                            </form>     
                        </div>
                    </div>
                    @php
                        $check = false;
                    @endphp
    
                    @if (isset($templateItems))
                    @foreach ($templateItems as $templateItem)
                    @if (($templateItem[0]->category ?? null) && ($quotationItem->category ?? null) && ($templateItem[0]->category->title == $quotationItem->category->title))
                        @php
                            $check = true;
                        @endphp
                        @if (count($quotationItem->category->subcategory) > 0)
                            <ul class="nav nav-tabs border-info" id="myTab" role="tablist">
                                @foreach ($quotationItem->category->subcategory as $subcategory)
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="home-tab-{{ $subcategory->id }}" data-toggle="tab" data-target="#home{{ $subcategory->id }}" type="button" role="tab" aria-controls="home{{ $subcategory->id }}" aria-selected="true">{{ $subcategory->title }}</button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                @foreach ($quotationItem->category->subcategory as $subcategory)
                                    <div class="tab-pane zone fade {{ $loop->first ? 'show active' : '' }}" id="home{{ $subcategory->id }}" role="tabpanel" aria-labelledby="home-tab-{{ $subcategory->id }}">
                                        <div class="d-flex justify-content-end mt-3">
                                            <div>
                                                <form style="display: inline;" action="/template-delete/{{ $quotationItem->id }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Zone Delete</button>
                                                </form>
                                                  
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-4">
                                            <table class="table editableTable" id="" style="background: #fff">
                                                <thead>
                                                    <input type="hidden" class="categoryId" value="{{ $templateItem[0]->category_id }}">
                                                    <input type="hidden" class="subCategoryId" value="{{ $subcategory->id }}">
                                                    <tr>
                                                        <th style="background-color: #198754; color:#fff">SL</th>
                                                        <th style="background-color: #198754; color:#fff; width:20%">ITEM</th>
                                                        <th style="background-color: #198754; color:#fff; width:40%">SPECIFICATION</th>
                                                        <th style="background-color: #198754; color:#fff">QTY</th>
                                                        <th style="background-color: #198754; color:#fff">UNIT</th>
                                                        <th style="background-color: #198754; color:#fff">RATE</th>
                                                        <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                                        @foreach ($templateItem[0]->templateItemValues as $data)
                                                            <th id="{{ $data->unique_header }}" class="saveDataTd extracolumnTd" style="background-color: #198754; color:#fff">
                                                                <span contenteditable="true" class="newcloumnHeader saveData extracolumn" style="background-color: #198754; color:#fff">{{ ucwords(str_replace('_', ' ', $data->header)) }}</span>
                                                                <button class="btn text-danger removeColumn" style="position: relative; top: -12px; right: 5px;">X</button>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $grandTotal = 0;
                                                    @endphp
                                                    @foreach ($templateItem as $item)  
                                                    @if ($item->sub_category_id == $subcategory->id)
                                                    <tr>
                                                        <td class="sl">
                                                            <span class="slNo">{{ $item->sl }}</span>
                                                            <button class="btn rowColumn text-danger" style="position: relative; top: -12px; right: 5px;">X</button>
                                                        </td>
                                                        <td class="item saveData" contenteditable="true">{{ $item->item }}</td>
                                                        <td class="specification saveData" contenteditable="true">{!! $item->specification !!}</td>
                                                        <td class="qty saveData" contenteditable="true">{{ $item->qty }}</td>
                                                        <td class="unit saveData" contenteditable="true">{{ $item->unit }}</td>
                                                        <td class="rate saveData" contenteditable="true">{{ $item->rate }}</td>
                                                        <td class="amount saveData">{{ $item->amount }}</td>
                                                        @foreach ($item->templateItemValues as $templateItemValue)
                                                            <td class="saveData {{ $templateItemValue->unique_header }}" contenteditable="true">
                                                                <input type="hidden" class="templateItemValue" value="{{ $templateItemValue->unique_header }}">
                                                                {{ $templateItemValue->value }}
                                                            </td>
                                                        @endforeach
                                                        @php
                                                            $grandTotal += $item->amount;
                                                        @endphp
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6" style="border:none"> Total</td>
                                                        <td class="grandTotal">{{ $grandTotal }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else 
                            <div class="table-responsive mt-4">
                                <table class="table editableTable" id="" style="background: #fff">
                                    <thead>
                                        <input type="hidden" class="categoryId" value="{{ $templateItem[0]->category_id }}">
                                        <input type="hidden" class="subCategoryId" value="{{ null }}">
                                        <tr>
                                            <th style="background-color: #198754; color:#fff">SL</th>
                                            <th style="background-color: #198754; color:#fff; width:20%">ITEM</th>
                                            <th style="background-color: #198754; color:#fff; width:40%">SPECIFICATION</th>
                                            <th style="background-color: #198754; color:#fff">QTY</th>
                                            <th style="background-color: #198754; color:#fff">UNIT</th>
                                            <th style="background-color: #198754; color:#fff">RATE</th>
                                            <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                            @foreach ($templateItem[0]->templateItemValues as $data)
                                                <th id="{{ $data->unique_header }}" class="saveDataTd extracolumnTd" style="background-color: #198754; color:#fff">
                                                    <span contenteditable="true" class="newcloumnHeader saveData extracolumn" style="background-color: #198754; color:#fff">{{ ucwords(str_replace('_', ' ', $data->header)) }}</span>
                                                    <button class="btn text-danger removeColumn" style="position: relative; top: -12px; right: 5px;">X</button>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $grandTotal = 0;
                                        @endphp
                                        @foreach ($templateItem as $item)  
                                        <tr>
                                            <td class="sl">
                                                <span class="slNo">{{ $item->sl }}</span>
                                                <button class="btn rowColumn text-danger" style="position: relative; top: -12px; right: 5px;">X</button>
                                            </td>
                                            <td class="item saveData" contenteditable="true">{{ $item->item }}</td>
                                            <td class="specification saveData" contenteditable="true">{!! $item->specification !!}</td>
                                            <td class="qty saveData" contenteditable="true">{{ $item->qty }}</td>
                                            <td class="unit saveData" contenteditable="true">{{ $item->unit }}</td>
                                            <td class="rate saveData" contenteditable="true">{{ $item->rate }}</td>
                                            <td class="amount saveData">{{ $item->amount }}</td>
                                            @foreach ($item->templateItemValues as $templateItemValue)
                                                <td class="saveData {{ $templateItemValue->unique_header }}" contenteditable="true">
                                                    <input type="hidden" class="templateItemValue" value="{{ $templateItemValue->unique_header }}">
                                                    {{ $templateItemValue->value }}
                                                </td>
                                            @endforeach
                                            @php
                                                $grandTotal += $item->amount;
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="border:none"> Total</td>
                                            <td class="grandTotal">{{ $grandTotal }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> 
                        @endif
    
                    @endif
                    @endforeach
                    @endif
    
                    @if ($check == false)
                    @if (count($quotationItem->category->subcategory) > 0)
                            <ul class="nav nav-tabs border-info" id="myTab" role="tablist">
                                @foreach ($quotationItem->category->subcategory as $subcategory)
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="home-tab-{{ $subcategory->id }}" data-toggle="tab" data-target="#home{{ $subcategory->id }}" type="button" role="tab" aria-controls="home{{ $subcategory->id }}" aria-selected="true">{{ $subcategory->title }}</button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                @foreach ($quotationItem->category->subcategory as $subcategory)
                                    <div class="tab-pane zone fade {{ $loop->first ? 'show active' : '' }}" id="home{{ $subcategory->id }}" role="tabpanel" aria-labelledby="home-tab-{{ $subcategory->id }}">
                                        <div class="d-flex justify-content-end mt-3">
                                            <div>
                                                <form style="display: inline;" action="/template-delete/{{ $quotationItem->id }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Zone Delete</button>
                                                </form>
                                                  
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-4">
                                            <table class="table editableTable" id="" style="background: #fff">
                                                <thead>
                                                    <input type="hidden" class="categoryId" value="{{ $quotationItem->category->id }}">
                                                    <input type="hidden" class="subCategoryId" value="{{ $subcategory->id }}">
                                                    <tr>
                                                        <th style="background-color: #198754; color:#fff">SL</th>
                                                        <th style="background-color: #198754; color:#fff; width:20%">ITEM</th>
                                                        <th style="background-color: #198754; color:#fff; width:40%">SPECIFICATION</th>
                                                        <th style="background-color: #198754; color:#fff">QTY</th>
                                                        <th style="background-color: #198754; color:#fff">UNIT</th>
                                                        <th style="background-color: #198754; color:#fff">RATE</th>
                                                        <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    @php
                                                        $grandTotal = 0;
                                                    @endphp
                                                    <tr>
                                                        <td colspan="6" style="border:none"> Total</td>
                                                        <td class="grandTotal">{{ $grandTotal }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    @else 
                        <div class="table-responsive mt-4">
                            <table class="table editableTable" id="" style="background: #fff">
                                <thead>
                                    <input type="hidden" class="categoryId" value="{{ $quotationItem->category->id }}">
                                    <input type="hidden" class="subCategoryId" value="{{ null }}">
                                    <tr>
                                        <th style="background-color: #198754; color:#fff">SL</th>
                                        <th style="background-color: #198754; color:#fff; width:20%">ITEM</th>
                                        <th style="background-color: #198754; color:#fff; width:40%">SPECIFICATION</th>
                                        <th style="background-color: #198754; color:#fff">QTY</th>
                                        <th style="background-color: #198754; color:#fff">UNIT</th>
                                        <th style="background-color: #198754; color:#fff">RATE</th>
                                        <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    @php
                                        $grandTotal = 0;
                                    @endphp
                                    <tr>
                                        <td colspan="6" style="border:none"> Total</td>
                                        <td class="grandTotal">{{ $grandTotal }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> 
                    @endif
                    @endif
    
                </div>
                @endforeach

            <div class="tab-pane  fade" id="term" role="tabpanel" aria-labelledby="term-tab">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('template') }}" class="btn btn-danger mr-2 mt-3">Exit</a>
                    {{-- <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-warning mt-3">Quotation Edit</a> --}}
                </div>
                <div class="d-flex justify-content-center">
                    <div class="page termSection">
                        <div class="row">
                            <div class="column"> 
                                <img src="{{ asset('backend/images/organization/'.$organization->image ?? '') }}" alt="" style="width: 70%">
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

                        <h5 class="text-dark mt-3"><span style=""><u>Terms & Conditions</u></span></h5>

                        @foreach ($terms as $term)
                           <p class="text-dark"><b style="font-weight: 900">{{ $loop->iteration }}</b>. {{ $term->title }}</p>
                        @endforeach

                        <p class="mt-2 text-dark" style="font-weight: 900" data-toggle="modal" data-target="#terminfoEdittModal">Special Note: {{ $termInfo->note }}
                        <p class="mt-2 text-dark">Sincerely Yours,</p>

                        <p class="mt-4 text-dark" data-toggle="modal" data-target="#terminfoEdittModal">{{ $termInfo->name }}</p>
                        @if ($termInfo->email != null)
                        <p class="mt-4 text-dark" data-toggle="modal" data-target="#terminfoEdittModal">{{ $termInfo->email }}</p>
                        @endif
                        <p class="text-dark" data-toggle="modal" data-target="#terminfoEdittModal">{{ $termInfo->designation }}</p>
                        <p class="text-dark">Minimal Limited</p>

                    </div>
                </div>
            </div>
            @endif
            
        </div>

    </div>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href={{asset("ui/dist/css/adminlte.min.css")}}>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <style>
            .page {
                width: 21cm;
                height: 40cm;
                margin: 0;
                background-color: #fff;
                padding: 20px;
                margin-top: 30px;
                margin-bottom: 30px;
            }
            /* Create two equal columns that float next to each other */
            .column {
                float: left;
                width: 50%;
                padding: 10px;
            }

            <?php
            if ($template->quotation->first_person !== null && $template->quotation->first_person !== '' &&
                $template->quotation->second_person !== null && $template->quotation->second_person !== '' &&
                $template->quotation->third_person !== null && $template->quotation->third_person !== '' &&
                $template->quotation->fourth_person !== null && $template->quotation->fourth_person !== '' &&
                $template->quotation->fifth_person !== null && $template->quotation->fifth_person !== '') {
                echo '.column2 { float: left; width: 20%; padding: 10px; }';
            } elseif ($template->quotation->first_person !== null && $template->quotation->first_person !== '' &&
                $template->quotation->second_person !== null && $template->quotation->second_person !== '' &&
                $template->quotation->third_person !== null && $template->quotation->third_person !== '' &&
                $template->quotation->fourth_person !== null && $template->quotation->fourth_person !== '') {
                echo '.column2 { float: left; width: 25%; padding: 10px; }';
            } elseif ($template->quotation->first_person !== null && $template->quotation->first_person !== '' &&
                $template->quotation->second_person !== null && $template->quotation->second_person !== '' &&
                $template->quotation->third_person !== null && $template->quotation->third_person !== '') {
                echo '.column2 { float: left; width: 33.3%; padding: 10px; }';
            } elseif ($template->quotation->first_person !== null && $template->quotation->first_person !== '' &&
                $template->quotation->second_person !== null && $template->quotation->second_person !== '') {
                echo '.column2 { float: left; width: 50%; padding: 10px; }';
            } else {
                echo '.column2 { float: left; width: 100%; padding: 10px; }';
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
                font-size: 15px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                color: #fff !important;
                background-color: #198754;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <!-- Include the JsPDF library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <!-- Include the html2canvas library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="{{ asset('js/autosuggestions.js') }}"></script>
        <script src="{{ asset('js/tableManipulation.js') }}"></script>
        {{-- <script src="{{ asset('js/pdfHandler.js') }}"></script> --}}
        <script src="{{ asset('js/scrollToTop.js') }}"></script>
        <script src="{{ asset('js/keyBoardShortcut.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#sidebarToggle').trigger('click');
                // $(document).on('input', '.saveData', triggerCreate);
                // $(document).on('change || keyup', '.saveData', triggerCreate);
                $(document).on('click', '.autosuggestion-dropdown li', function(event) {
                    triggerCreate(event);
                });

                $(document).on('input change keyup', '.saveData', function(event) {
                    triggerCreate(event);
                });

                $(document).on('input change keyup', '.rate', function(event) {
                    subTotal(event);
                });

                $(document).on('input change keyup', '.qty', function(event) {
                    subTotal(event);
                });

                // $(document).on('click', '#update', triggerUpdate);

                $(document).on('click', '.copyLink', function() {
                    // Retrieve the base URL
                    let baseUrl = window.location.origin;
                    let pdfUrl = $(this).attr('href');
                    
                    // Concatenate base URL and PDF URL
                    let fullUrl = baseUrl + pdfUrl;
                    
                    // Notify the user that the full URL has been copied
                    navigator.clipboard.writeText(fullUrl)
                        .then(function() {
                            // Notify the user that the URL has been copied
                            Swal.fire({
                                icon: "success",
                                title: 'Copy Link', // Show error message
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .catch(function(error) {
                            console.error('Failed to copy full URL: ', error);
                        });
                    
                    // Prevent default link behavior
                    return false;
                });
            });
        </script>
        <script>

            const subTotal = event => {

                let 
                    el = event.target,
                    tr = $(el).closest('tr'),
                    tbody = $(el).closest('tbody'),
                    rate = parseFloat($(tr).find('.rate').text()), // Parsing as float for decimal values
                    qty = parseInt($(tr).find('.qty').text()); // Parsing as integer

                $(tr).find('.amount').text(rate*qty);

                // Calculate and update grand total
                let grandTotal = 0;
                $(tbody).find('.amount').each(function() {
                    if (!isNaN(parseFloat($(this).text()))) {
                        grandTotal += parseFloat($(this).text());
                    }
                });

                // Update the grand total in the footer
                $(tbody).closest('table').find('.grandTotal').text(grandTotal);
            }

            function reqData() {

                
                let table

                if($('#myTabContent .category.active.show .zone.active.show').find('.editableTable').length > 0) {
                    table = $('#myTabContent .category.active.show .zone.active.show').find('.editableTable');
                } else {
                    table = $('#myTabContent .category.active.show').find('.editableTable');
                }

                const data = {
                    template_title: $('.template_title').val(),
                    quotationId: $('.quotationId').val(),
                    category_id: table.find('.categoryId').val(),
                    sub_category_id: table.find('.subCategoryId').val(),
                    item_data: [],
                    missing_data: [],
                };

                const columnCount = table.find('tr:first th').length || table.find('tr:first td').length;
                table.find('tbody tr').each(function (index, tr) {
                    let  item = {};
                    // Loop through each td in the current tr
                    $(tr).find('td').each(function (tdIndex, td) {
                        let thValue = table.find('thead th').eq(tdIndex).text().trim().replace(/\s+/g, '_').toLowerCase(); // Use table.find() to search within the table
                        // Set the class based on thValue to each td
                        $(td).attr('class', thValue + ' saveData');
                    });
                });

                // Iterate over each row in the table body
                table.find('tbody tr').each(function (index, tr) {
                    let item = {};
                    let missingItem = [];
                    item['category_id'] = table.find('.categoryId').val();
                    // Loop through each td in the current row
                    $(tr).find('td').each(function (tdIndex, td) {
                        let data = {};
                        // Get the text content of the corresponding th and clean it
                        let thText = table.find('thead th').eq(tdIndex).text().trim().replace(/\s+/g, '_').toLowerCase(); // Use table.find() to search within the table
                        
                        // Get the value of the current cell and assign it to the corresponding property in item
                        if(thText == 'sl' || thText == 'item' || thText == 'specification' || thText == 'qty' || thText == 'unit' || thText == 'rate' || thText == 'amount') {
                            var tdText = $(td).clone()           // Clone the td element
                                            .children()          // Select the children elements
                                            .remove()            // Remove them
                                            .end()               // Go back to the cloned td element
                                            .text()              // Get the text
                                            .trim();             // Trim any leading/trailing whitespace

                            item[thText] = tdText;
                        } else {
                            // missingItem[thText] = $(td).text().trim();
                            let input = $(td).find('input');
                            if (input.length > 0) {
                                data['uniqueHeader'] = input.val();
                            } else {
                                data[thText] = $(td).text().trim();
                            }
                            data[thText] = $(td).text().trim();
                            missingItem.push(data);
                        }
                    });
                    // Push the constructed item to item_data array
                    data.item_data.push(item);
                    data.missing_data.push(missingItem);
                });

                return data;
            }


            const triggerCreate = ()=>{

                let 
                    payload = reqData();
                    console.log(payload);
                
                $.ajax({
                    url         : `/api/template/update/${$('#templateId').val()}`,
                    method      : "PUT",
                    dataType    : "JSON",
                    data        : payload,
                    enctype     : 'multipart/form-data',
                    headers: {
                        "X-CSRF-TOKEN": $(document).find('[name="_token"]').val()
                    },
                    success(response){
                        if (response.error !== undefined) { // Check if error is defined in the response
                            Swal.fire({
                                icon: "error",
                                title: response.error, // Show error message
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error(error){
                        Swal.fire({
                            icon: "error",
                            title: error.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        </script>
    @endpush
</x-backend.layouts.master>