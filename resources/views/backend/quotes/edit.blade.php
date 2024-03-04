<x-backend.layouts.master>


    <x-slot name="page_title">
        Editable Table
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Sheet Edit
            </x-slot>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div>

        <!-- Button for scroll-to-top -->
        <button id="scrollToTopButton" aria-label="Scroll to top" title="Scroll to top" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 100;">
            <i class="fas fa-chevron-up"></i>
        </button>



        <!-- The Modal for PDF preview -->
        <div id="pdfPreviewModal" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span> <!-- Close button -->
            <iframe id="pdfPreviewIframe" style="width:100%;height:100%;"></iframe>
            </div>
        </div>

        <div class="">
            <input type="hidden" class="quotationId" value="{{ $quote->quotation_id }}">
            <h3 class="mt-5 border text-center">{{ $quote->quotation->ref }}</h3>

            <h1 class="mt-5">
                <input type="text" class="form-control quote_title" name="quote_title" style="background: none; border:none; font-size:30px" value="{{ $quote->title }}">
            </h1>

            @if ($quote->quotation != null)
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Top Sheet</button>
                </li>
                {{-- @foreach ($quoteItems as $quoteItem)
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="{{ str_replace(' ', '-', $quoteItem[0]->category->title) }}-tab" data-toggle="tab" data-target="#{{ str_replace(' ', '-', $quoteItem[0]->category->title) }}" type="button" role="tab" aria-controls="{{ str_replace(' ', '-', $quoteItem[0]->category->title) }}" aria-selected="false">{{ $quoteItem[0]->category->title }}</button>
                    </li>
                @endforeach --}}
                @foreach ($quotation->quotationItems as $quotationItem)
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="{{ str_replace(' ', '-', $quotationItem->category->title) }}-tab" data-toggle="tab" data-target="#{{ str_replace(' ', '-', $quotationItem->category->title) }}" type="button" role="tab" aria-controls="{{ str_replace(' ', '-', $quotationItem->category->title) }}" aria-selected="false">{{ $quotationItem->category->title }}</button>
                </li>
                @endforeach
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="term-tab" data-toggle="tab" data-target="#term" type="button" role="tab" aria-controls="term" aria-selected="true">Terms & Condition</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('go-to-sheet') }}" class="btn btn-danger mr-2 mt-3">Exit</a>
                    <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-warning mt-3">Quotation Edit</a>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="page">
                        <div class="row">
                            <div class="column">
                            <img src="{{ asset('backend/images/organization/'.$organization->image ?? '') }}" alt="" style="width: 70%">
                            <h4>Ref: {{ $quote->quotation->ref }}</h4>
                            <h4>To</h4>
                            <h4>{{ $quote->quotation->name }}</h4>
                            <h4>{{ $quote->quotation->address }}</h4>
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
                                    $dateString = $quote->quotation->date;
                                    $formattedDate = date("F j, Y", strtotime($dateString));
                                @endphp 
                                <p style="margin-top: 20px">{{ $formattedDate }}</p>
                            </div>
                            </div>
                        </div>
                        
                        <div style="background-color:#bbb; text-align:center; border:3px solid #09e240; width:100%;">
                            <h4>Financial Proposal For Residence Interior & Electrical Works</h4>
                            <h4>Of</h4>
                            <h3>{{ $quote->quotation->name }} | {{ $quote->quotation->address }}</h3>
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
                            <tr>
                                <td style="text-align: center">{{ $quote->quotation->date }}</td>
                                <td style="text-align: center">V1.0</td>
                                <td>- Initial quotation</td>
                                <td style="text-align: center">{{ $quote->quotation->user->name }}</td>
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
                            @foreach ($quote->quotation->quotationItems as $quotationItem)
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
                </div>
            </div>
            {{-- @foreach ($quoteItems as $quoteItem)
                <div class="tab-pane fade" id="{{ str_replace(' ', '-', $quoteItem[0]->category->title) }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '-', $quoteItem[0]->category->title) }}-tab">
                    <div class="mt-4 mb-4 d-flex justify-content-between">
                        <div>
                            <button class="btn btn-success addRowBtn" id="">Add Row</button>
                            <button class="btn btn-info addColumnBtn" id="">Add Column</button>
                            <!-- Button to trigger PDF preview -->
                            <button class="btn btn-warning pdfPreviewButton" id="">Preview PDF</button>
    
                            <!-- Button to download the PDF directly -->
                            <button class="btn btn-primary downloadPdfButton" id="">Download PDF</button>
                        </div>
                        <div>
                            <a href="{{ route('go-to-sheet') }}" class="btn btn-danger">Exit</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table editableTable" id="" style="background: #fff">
                            <thead>
                                <input type="hidden" class="categoryId" value="{{ $quoteItem[0]->category_id }}">
                                <tr>
                                    <th style="background-color: #198754; color:#fff">SL</th>
                                    <th style="background-color: #198754; color:#fff">ITEM</th>
                                    <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                                    <th style="background-color: #198754; color:#fff">QTY</th>
                                    <th style="background-color: #198754; color:#fff">UNIT</th>
                                    <th style="background-color: #198754; color:#fff">RATE</th>
                                    <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                    @foreach ($quoteItem[0]->quoteItemValues as $data)
                                        <th style="background-color: #198754; color:#fff">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quoteItem as $item)  
                                <tr>
                                    <td class="sl">{{ $item->sl }}</td>
                                    <td class="item" contenteditable="true">{{ $item->item }}</td>
                                    <td class="specification" contenteditable="true">{{ $item->specification }}</td>
                                    <td class="qty" contenteditable="true">{{ $item->qty }}</td>
                                    <td class="unit" contenteditable="true">{{ $item->unit }}</td>
                                    <td class="rate" contenteditable="true">{{ $item->rate }}</td>
                                    <td class="amount" contenteditable="true">{{ $item->amount }}</td>
                                    @foreach ($item->quoteItemValues as $quoteItemValue)
                                        <td class="" contenteditable="true">{{ $quoteItemValue->value }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
    
                    <div class="d-flex justify-content-end mb-3">
                        <button id="" type="button" class="btn btn-success mr-2 save" style="width: 250px">Save</button>
                    </div>
                </div>
            @endforeach --}}
            @foreach ($quotation->quotationItems as $quotationItem)
            <div class="tab-pane fade" id="{{ str_replace(' ', '-', $quotationItem->category->title) }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '-', $quotationItem->category->title) }}-tab">

                <div class="mt-4 mb-4 d-flex justify-content-between">
                    <div>
                        <button class="btn btn-success addRowBtn" id="">Add Row</button>
                        <button class="btn btn-info addColumnBtn" id="">Add Column</button>
                        <!-- Button to trigger PDF preview -->
                        <button class="btn btn-warning pdfPreviewButton" id="">Preview PDF</button>

                        <!-- Button to download the PDF directly -->
                        <button class="btn btn-primary downloadPdfButton" id="">Download PDF</button>
                    </div>
                    <div>
                        <a href="{{ route('go-to-sheet') }}" class="btn btn-danger">Exit</a>
                    </div>
                </div>
                @php
                    $check = false;
                @endphp
                @foreach ($quoteItems as $quoteItem)
                @if ($quoteItem[0]->category->title == $quotationItem->category->title)
                    @php
                        $check = true;
                    @endphp
                    <div class="table-responsive">
                        <table class="table editableTable" id="" style="background: #fff">
                            <thead>
                                <input type="hidden" class="categoryId" value="{{ $quoteItem[0]->category_id }}">
                                <tr>
                                    <th style="background-color: #198754; color:#fff">SL</th>
                                    <th style="background-color: #198754; color:#fff">ITEM</th>
                                    <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                                    <th style="background-color: #198754; color:#fff">QTY</th>
                                    <th style="background-color: #198754; color:#fff">UNIT</th>
                                    <th style="background-color: #198754; color:#fff">RATE</th>
                                    <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                    @foreach ($quoteItem[0]->quoteItemValues as $data)
                                        <th class="saveData" style="background-color: #198754; color:#fff">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quoteItem as $item)  
                                <tr>
                                    <td class="sl">{{ $item->sl }}</td>
                                    <td class="item saveData" contenteditable="true">{{ $item->item }}</td>
                                    <td class="specification saveData" contenteditable="true">{{ $item->specification }}</td>
                                    <td class="qty saveData" contenteditable="true">{{ $item->qty }}</td>
                                    <td class="unit saveData" contenteditable="true">{{ $item->unit }}</td>
                                    <td class="rate saveData" contenteditable="true">{{ $item->rate }}</td>
                                    <td class="amount saveData" contenteditable="true">{{ $item->amount }}</td>
                                    @foreach ($item->quoteItemValues as $quoteItemValue)
                                        <td class=" saveData" contenteditable="true">{{ $quoteItemValue->value }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                @endif
                @endforeach

                @if ( $check == false)
                <div class="table-responsive">
                    <table class="table editableTable" id="" style="background: #fff">
                        <input type="hidden" class="categoryId" value="{{ $quotationItem->work_scope }}">
                        <thead>
                            <tr>
                                <th style="background-color: #198754; color:#fff">SL</th>
                                <th style="background-color: #198754; color:#fff">ITEM</th>
                                <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                                <th style="background-color: #198754; color:#fff">QTY</th>
                                <th style="background-color: #198754; color:#fff">UNIT</th>
                                <th style="background-color: #198754; color:#fff">RATE</th>
                                <th style="background-color: #198754; color:#fff">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sl">1</td>
                                <td class="item saveData" contenteditable="true"></td>
                                <td class="specification saveData" contenteditable="true"></td>
                                <td class="qty saveData" contenteditable="true"></td>
                                <td class="unit saveData" contenteditable="true"></td>
                                <td class="rate saveData" contenteditable="true"></td>
                                <td class="amount saveData" contenteditable="true"></td>
                            </tr>
                            <tr>
                                <td class="sl">2</td>
                                <td class="item saveData" contenteditable="true"></td>
                                <td class="specification saveData" contenteditable="true"></td>
                                <td class="qty saveData" contenteditable="true"></td>
                                <td class="unit saveData" contenteditable="true"></td>
                                <td class="rate saveData" contenteditable="true"></td>
                                <td class="amount saveData" contenteditable="true"></td>
                            </tr>
                            <tr>
                                <td class="sl">3</td>
                                <td class="item saveData" contenteditable="true"></td>
                                <td class="specification saveData" contenteditable="true"></td>
                                <td class="qty saveData" contenteditable="true"></td>
                                <td class="unit saveData" contenteditable="true"></td>
                                <td class="rate saveData" contenteditable="true"></td>
                                <td class="amount saveData" contenteditable="true"></td>
                            </tr>
                            <tr>
                                <td class="sl">4</td>
                                <td class="item saveData" contenteditable="true"></td>
                                <td class="specification saveData" contenteditable="true"></td>
                                <td class="qty saveData" contenteditable="true"></td>
                                <td class="unit saveData" contenteditable="true"></td>
                                <td class="rate saveData" contenteditable="true"></td>
                                <td class="amount saveData" contenteditable="true"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- <div class="d-flex justify-content-end mb-3">
                    <button id="" type="button" class="btn btn-success mr-2 save" style="width: 250px">Save</button>
                </div> --}}
            </div>
            @endforeach
            <div class="tab-pane fade" id="term" role="tabpanel" aria-labelledby="term-tab">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('go-to-sheet') }}" class="btn btn-danger mr-2 mt-3">Exit</a>
                    <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-warning mt-3">Quotation Edit</a>
                </div>
                <div class="d-flex justify-content-center">
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

                        <p class="mt-2 text-dark" style="font-weight: 900">Special Note: This quotation might change due to addition, reduction and/or change of design and excution, human errors which will be setteled later in concern of both parties.</p>

                        <p class="mt-2 text-dark">Sincerely Yours,</p>

                        <p class="mt-4 text-dark">A.B.M Shafiqul Alam</p>
                        <p class="text-dark">Director</p>
                        <p class="text-dark">Minimal Limited</p>

                    </div>
                </div>
            </div>
            @endif
            
        </div>
        

        {{-- <div class="">
            <h1 class="mt-5">
                <input type="text" class="form-control quote_title" name="quote_title" style="background: none; border:none; font-size:30px" value="{{ $quote->title }}">

                <input type="hidden" id="quoteId" value="{{ $quote->id }}">
            </h1>
            <div class="table-responsive">
                <table class="table" id="editableTable" style="background: #fff">
                    <thead>
                        <tr>
                            <th style="background-color: #198754; color:#fff">SL</th>
                            <th style="background-color: #198754; color:#fff">ITEM</th>
                            <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                            <th style="background-color: #198754; color:#fff">QTY</th>
                            <th style="background-color: #198754; color:#fff">UNIT</th>
                            <th style="background-color: #198754; color:#fff">RATE</th>
                            <th style="background-color: #198754; color:#fff">AMOUNT</th>
                            @foreach ($externalMenus as $header)
                                <th style="background-color: #198754; color:#fff" contenteditable="true">{{ ucwords(str_replace('_', ' ', $header)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quote->quoteItems as $quoteItem)
                            <tr>
                                <input type="hidden" class="quoteItem" value="{{ $quoteItem->id }}">
                                <td class="sl">{{ $quoteItem->sl }}</td>
                                <td class="item">{{ $quoteItem->item }}</td>
                                <td class="specification">{{ $quoteItem->specification }}</td>
                                <td class="qty" contenteditable="true">{{ $quoteItem->qty }}</td>
                                <td class="unit">{{ $quoteItem->unit }}</td>
                                <td class="rate" contenteditable="true">{{ $quoteItem->rate }}</td>
                                <td class="amount" contenteditable="true">{{ $quoteItem->amount }}</td>
                                @foreach ($quoteItem->quoteItemValues as $quoteItemValue)
                                    <td contenteditable="true">
                                        <input type="hidden" class="quoteItemValue" value="{{ $quoteItemValue->id }}">
                                        {{ $quoteItemValue->value }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mb-3">
                <button id="save" type="button" class="btn btn-success mr-2" style="width: 250px">Save New</button>
                <button id="update" type="button" class="btn btn-warning" style="width: 250px">Update</button>
            </div>
        </div> --}}
    </div>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href={{asset("ui/dist/css/adminlte.min.css")}}>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <style>
            .page {
                width: 21cm;
                height: 29.7cm;
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
        <script src="{{ asset('js/pdfHandler.js') }}"></script>
        <script src="{{ asset('js/scrollToTop.js') }}"></script>
        <script src="{{ asset('js/keyBoardShortcut.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#sidebarToggle').trigger('click');
                // $(document).on('click', '.save', triggerCreate);
                $(document).on('input', '.saveData', triggerCreate);
                // $(document).on('click', '#update', triggerUpdate);
            });
        </script>
        <script>
            // function reqData(event) {
            //     let table = $(event.target).closest('.tab-pane').find('.editableTable'); // Use event.target to refer to the element that triggered the event

            //     const data = {
            //         quote_title: $('.quote_title').val(),
            //         quotationId: $('.quotationId').val(),
            //         category_id: table.find('.categoryId').val(),
            //         item_data: [],
            //         missing_data: [],
            //     };

            //     const columnCount = table.find('tr:first th').length || table.find('tr:first td').length;
            //     table.find('tbody tr').each(function (index, tr) {
            //         let  item = {};
            //         // Loop through each td in the current tr
            //         $(tr).find('td').each(function (tdIndex, td) {
            //             let thValue = table.find('thead th').eq(tdIndex).text().trim().replace(/\s+/g, '_').toLowerCase(); // Use table.find() to search within the table
            //             // Set the class based on thValue to each td
            //             $(td).attr('class', thValue);
            //         });
            //     });

            //     // Iterate over each row in the table body
            //     table.find('tbody tr').each(function (index, tr) {
            //         let item = {};
            //         let missingItem = {};
            //         item['category_id'] = table.find('.categoryId').val();
            //         // Loop through each td in the current row
            //         $(tr).find('td').each(function (tdIndex, td) {
            //             // Get the text content of the corresponding th and clean it
            //             let thText = table.find('thead th').eq(tdIndex).text().trim().replace(/\s+/g, '_').toLowerCase(); // Use table.find() to search within the table
            //             // Get the value of the current cell and assign it to the corresponding property in item
            //             if(thText == 'sl' || thText == 'item' || thText == 'specification' || thText == 'qty' || thText == 'unit' || thText == 'rate' || thText == 'amount') {
            //                 item[thText] = $(td).text().trim();
            //             } else {
            //                 missingItem[thText] = $(td).text().trim();
            //             }
            //         });
            //         // Push the constructed item to item_data array
            //         data.item_data.push(item);
            //         data.missing_data.push(missingItem);
            //     });

            //     return data;
            // }


            // const triggerCreate = (event)=>{

            //     let 
            //         el      = event.target,
            //         payload = reqData(event);
            //         console.log(payload);
                
            //     $.ajax({
            //         url         : `/api/quotes/store`,
            //         method      : "POST",
            //         dataType    : "JSON",
            //         data        : payload,
            //         enctype     : 'multipart/form-data',
            //         headers: {
            //             "X-CSRF-TOKEN": $(document).find('[name="_token"]').val()
            //         },
            //         beforeSend  : function(){
            //             $(el).html(`Processing ...`).prop('disabled', true);  
            //         },
            //         success(response){
            //             if (response.error !== undefined) { // Check if error is defined in the response
            //                 Swal.fire({
            //                     icon: "error",
            //                     title: response.error, // Show error message
            //                     showConfirmButton: false,
            //                     timer: 1500
            //                 });
            //             } else {
            //                 Swal.fire({
            //                     icon: "success",
            //                     title: response.message, // Show success message
            //                     showConfirmButton: false,
            //                     timer: 1500
            //                 });
            //             }

            //             $(el).html(`Save`).prop("disabled", false);


            //             // Swal.fire({
            //             //     icon: "success",
            //             //     title: response.message,
            //             //     showConfirmButton: false,
            //             //     timer: 1500
            //             // }).then(() => {
            //             //     window.location.href = '/go-to-sheet';
            //             // });
            //         },
            //         error(error){
            //             Swal.fire({
            //                 icon: "error",
            //                 title: error.responseJSON.message,
            //                 showConfirmButton: false,
            //                 timer: 1500
            //             })
            //             $(el).html(`Save`).prop("disabled", false);
            //         }
            //     });
            // }

            function reqData(event) {
                let table = $(event.target).closest('.tab-pane').find('.editableTable'); // Use event.target to refer to the element that triggered the event

                const data = {
                    quote_title: $('.quote_title').val(),
                    quotationId: $('.quotationId').val(),
                    category_id: table.find('.categoryId').val(),
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
                            item[thText] = $(td).text().trim();
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


            const triggerCreate = (event)=>{

                let 
                    el      = event.target,
                    payload = reqData(event);
                    console.log(payload);
                
                $.ajax({
                    url         : `/api/quotes/store`,
                    method      : "POST",
                    dataType    : "JSON",
                    data        : payload,
                    enctype     : 'multipart/form-data',
                    headers: {
                        "X-CSRF-TOKEN": $(document).find('[name="_token"]').val()
                    },
                    // beforeSend  : function(){
                    //     $(el).html(`Processing ...`).prop('disabled', true);  
                    // },
                    success(response){
                        if (response.error !== undefined) { // Check if error is defined in the response
                            Swal.fire({
                                icon: "error",
                                title: response.error, // Show error message
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                        // Swal.fire({
                        //     icon: "success",
                        //     title: response.message,
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // }).then(() => {
                        //     window.location.href = '/go-to-sheet';
                        // });
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

            function updateReqData() {
                const data = {
                    quote_id    : $('#quoteId').val(),
                    quote_title : $('.quote_title').val(),
                    item_data   : [],
                    missing_data: [],
                };

                const columnCount = $('#editableTable tr:first th').length || $('#editableTable tr:first td').length;

                $('#editableTable tbody tr').each(function (index, tr) {
                    let  item = {};
                    // Loop through each td in the current tr
                    $(tr).find('td').each(function (tdIndex, td) {
                        let thValue = $('#editableTable thead th').eq(tdIndex).text().trim().replace(/\s+/g, '_').toLowerCase();
                        // Set the class based on thValue to each td
                        $(td).attr('class', thValue);
                    });
                });

                // Iterate over each row in the table body
                $('#editableTable tbody tr').each(function (index, tr) {
                    let item = {};
                    let missingItem = [];

                    // Assign the quote ID to the item
                    item['quote_id'] = $(tr).find('.quoteItem').val();

                    // Loop through each cell in the current row
                    $(tr).find('td').each(function (tdIndex, td) {
                        let data = {};
                        let thText = $('#editableTable thead th').eq(tdIndex).text().trim().replace(/\s+/g, '_').toLowerCase();

                        // For standard fields, directly assign the cell content to the item
                        if (thText == 'sl' || thText == 'item' || thText == 'specification' || thText == 'qty' || thText == 'unit' || thText == 'rate' || thText == 'amount') {
                            item[thText] = $(td).text().trim();
                        } else {
                            // For quoteItemValue, collect input values if exists
                            let input = $(td).find('input');
                            if (input.length > 0) {
                                data['quoteItemValue'] = input.val();
                            } else {
                                data[thText] = $(td).text().trim();
                            }
                            data[thText] = $(td).text().trim();
                            missingItem.push(data);
                        }
                    });

                    // Push the constructed item and missing data to respective arrays
                    data.item_data.push(item);
                    data.missing_data.push(missingItem);
                });


                return data;
            }

            const triggerUpdate = (event)=>{

                let 
                    el      = event.target,
                    payload = updateReqData();
                
                $.ajax({
                    url         : `/api/quotes/update/${$('#quoteId').val()}`,
                    method      : "PUT",
                    dataType    : "JSON",
                    data        : payload,
                    enctype     : 'multipart/form-data',
                    headers: {
                        "X-CSRF-TOKEN": $(document).find('[name="_token"]').val()
                    },
                    beforeSend  : function(){
                        $(el).html(`Processing ...`).prop('disabled', true);  
                    },
                    success(response){
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '/go-to-sheet';
                        });
                    },
                    error(error){
                        Swal.fire({
                            icon: "error",
                            title: error.responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $(el).html(`Update`).prop("disabled", false);
                    }
                });
            }
        </script>
    @endpush
</x-backend.layouts.master>