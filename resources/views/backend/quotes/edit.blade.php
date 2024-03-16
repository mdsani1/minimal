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
        {{-- <button id="scrollToTopButton" aria-label="Scroll to top" title="Scroll to top" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 100;">
            <i class="fas fa-chevron-up"></i>
        </button> --}}



        <!-- The Modal for PDF preview -->
        {{-- <div id="pdfPreviewModal" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span> <!-- Close button -->
            <iframe id="pdfPreviewIframe" style="width:100%;height:100%;"></iframe>
            </div>
        </div> --}}

        <div class="">
            <input type="hidden" class="quotationId" value="{{ $quote->quotation_id }}">
            <h3 class="mt-5 border text-center">{{ $quote->quotation->ref }} ({{ $quote->version }})</h3>

            <h1 class="mt-5">
                <input type="text" class="form-control quote_title" name="quote_title" style="background: none; border:none; font-size:30px" value="{{ $quote->title }}">
                <input type="hidden" id="quoteId" value="{{ $quote->id }}">
            </h1>

            @if ($quote->quotation != null)
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Top Sheet</button>
                </li>
                @foreach ($quotation->quotationItems as $quotationItem)
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="{{ str_replace(' ', '-', $quotationItem->category->title ?? '') }}-tab" data-toggle="tab" data-target="#{{ str_replace(' ', '-', $quotationItem->category->title ?? '') }}" type="button" role="tab" aria-controls="{{ str_replace(' ', '-', $quotationItem->category->title ?? '') }}" aria-selected="false">{{ $quotationItem->category->title ?? '' }}</button>
                </li>
                @endforeach
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="term-tab" data-toggle="tab" data-target="#term" type="button" role="tab" aria-controls="term" aria-selected="true">Terms & Condition</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('quotations.index') }}" class="btn btn-primary mr-2 mt-3">Exit</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success mr-2 mt-3" data-toggle="modal" data-target="#addzone">
                        Add Zone
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addzone" tabindex="-1" aria-labelledby="addzoneLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="min-width: 80%;">
                        <form action="{{ route('zone.store') }}" method="POST" style="min-width: 100%">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="addzoneLabel">Add Zone</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <x-backend.form.select name="category_id" label="Category" :option="$categories"/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{ old('title') }}" required>
                                                @error("title")
                                                    <span class="sm text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary closeBtn" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>

                    <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-warning mr-2 mt-3">Quotation Edit</a>
                    <a href="/sheet-pdf/{{ $quote->id }}" class="btn btn-info mr-2 mt-3">Pdf</a>
                    <a href="/sheet-pdf/{{ $quote->id }}" class="btn btn-primary mr-2 mt-3 copyLink">Copy</a>
                    {{-- <button type="button" class="btn btn-success mr-2 mt-3 template" value="{{ $quote->id }}"><i class="fa-solid fa-bookmark"></i> Template</button> --}}
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success mr-2 mt-3" data-toggle="modal" data-target="#exampleModal2">
                        <i class="fa-solid fa-bookmark"></i> Template
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal2Label">Template</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="title" id="templateTitle" value="{{ $quote->title }}">
                                <input type="hidden" id="quoteId" value="{{ $quote->id }}">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeBtn" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary template">Submit</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <form style="display: inline;" action="/sheet-delete/{{ $quote->id }}" method="POST">
                        @csrf
                        @method('delete')
                        <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-danger mt-3" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Remove</button>
                    </form>                
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
                            @foreach ($quotation->sheets as $sheet)
                                @if ($loop->first)
                                <tr>
                                    <td style="text-align: center">{{ $quotation->date }}</td>
                                    <td style="text-align: center">{{ $sheet->version }}</td>
                                    <td>- Initial quotation</td>
                                    <td style="text-align: center">{{ $quotation->user->name }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td style="text-align: center">{{ $sheet->date }}</td>
                                    <td style="text-align: center">{{ $sheet->version }}</td>
                                    <td>- Change Update </td>
                                    <td style="text-align: center">{{ $sheet->user->name }}</td>
                                </tr>
                                @endif
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
                                <td>{{ $quotationItem->category->title ?? '' }}</td>
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

            @foreach ($quotation->quotationItems as $quotationItem)
            <div class="tab-pane category fade" id="{{ str_replace(' ', '-', $quotationItem->category->title ?? '') }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '-', $quotationItem->category->title ?? '') }}-tab">

                <div class="mt-4 mb-4 d-flex justify-content-between">
                    <div>
                        <button class="btn btn-success addRowBtn" id="">Add Row</button>
                        <button class="btn btn-info addColumnBtn" id="">Add Column</button>
                        <!-- Button to trigger PDF preview -->
                        <button class="btn btn-warning pdfPreviewButton" id="">Preview PDF</button>

                        <!-- Button to download the PDF directly -->
                        <button class="btn btn-primary downloadPdfButton" id="">Download PDF</button>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('quotations.index') }}" class="btn btn-primary mr-2">Exit</a>
                        <a href="/sheet-pdf/{{ $quote->id }}" class="btn btn-info mr-2">Pdf</a>
                        <a href="/sheet-pdf/{{ $quote->id }}" class="btn btn-primary mr-2 copyLink">Copy</a>
                        <form style="display: inline;" action="/sheet-delete/{{ $quote->id }}" method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-danger" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Remove</button>
                        </form>     
                    </div>
                </div>
                @php
                    $check = false;
                @endphp
                @foreach ($quoteItems as $quoteItem)
                @if (($quoteItem[0]->category ?? null) && ($quotationItem->category ?? null) && ($quoteItem[0]->category->title == $quotationItem->category->title))
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
                                    <div class="table-responsive mt-4">
                                        <table class="table editableTable" id="" style="background: #fff">
                                            <thead>
                                                <input type="hidden" class="categoryId" value="{{ $quoteItem[0]->category_id }}">
                                                <input type="hidden" class="subCategoryId" value="{{ $subcategory->id }}">
                                                <tr>
                                                    <th style="background-color: #198754; color:#fff">SL</th>
                                                    <th style="background-color: #198754; color:#fff">ITEM</th>
                                                    <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                                                    <th style="background-color: #198754; color:#fff">QTY</th>
                                                    <th style="background-color: #198754; color:#fff">UNIT</th>
                                                    <th style="background-color: #198754; color:#fff">RATE</th>
                                                    <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                                    @foreach ($quoteItem[0]->quoteItemValues as $data)
                                                        <th id="{{ $data->unique_header }}" class="saveData extracolumn" style="background-color: #198754; color:#fff">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($quoteItem as $item)  
                                                @if ($item->sub_category_id == $subcategory->id)
                                                <tr>
                                                    <td class="sl">{{ $item->sl }}</td>
                                                    <td class="item saveData" contenteditable="true">{{ $item->item }}</td>
                                                    <td class="specification saveData" contenteditable="true">{{ $item->specification }}</td>
                                                    <td class="qty saveData" contenteditable="true">{{ $item->qty }}</td>
                                                    <td class="unit saveData" contenteditable="true">{{ $item->unit }}</td>
                                                    <td class="rate saveData" contenteditable="true">{{ $item->rate }}</td>
                                                    <td class="amount saveData" contenteditable="true">{{ $item->amount }}</td>
                                                    @foreach ($item->quoteItemValues as $quoteItemValue)
                                                        <td class=" saveData" contenteditable="true">
                                                            <input type="hidden" class="quoteItemValue" value="{{ $quoteItemValue->unique_header }}">
                                                            {{ $quoteItemValue->value }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                       @else 
                       <div class="table-responsive mt-4">
                            <table class="table editableTable" id="" style="background: #fff">
                                <thead>
                                    <input type="hidden" class="categoryId" value="{{ $quoteItem[0]->category_id }}">
                                    <input type="hidden" class="subCategoryId" value="{{ null }}">
                                    <tr>
                                        <th style="background-color: #198754; color:#fff">SL</th>
                                        <th style="background-color: #198754; color:#fff">ITEM</th>
                                        <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                                        <th style="background-color: #198754; color:#fff">QTY</th>
                                        <th style="background-color: #198754; color:#fff">UNIT</th>
                                        <th style="background-color: #198754; color:#fff">RATE</th>
                                        <th style="background-color: #198754; color:#fff">AMOUNT</th>
                                        @foreach ($quoteItem[0]->quoteItemValues as $data)
                                            <th id="{{ $data->unique_header }}" class="saveData extracolumn" style="background-color: #198754; color:#fff">{{ ucwords(str_replace('_', ' ', $data->header)) }}</th>
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
                                            <td class=" saveData" contenteditable="true">
                                                <input type="hidden" class="quoteItemValue" value="{{ $quoteItemValue->unique_header }}">
                                                {{ $quoteItemValue->value }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    @endif

                @endif
                @endforeach

            </div>
            @endforeach
            <div class="tab-pane  fade" id="term" role="tabpanel" aria-labelledby="term-tab">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('quotations.index') }}" class="btn btn-danger mr-2 mt-3">Exit</a>
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
                           <p class="text-dark" data-toggle="modal" data-target="#paymentEdittModal"><b style="font-weight: 900">{{ $loop->iteration }}</b>. {{ $payment->title }}</p>
                        @endforeach

                        <!-- Modal -->
                        <div class="modal fade" id="paymentEdittModal" tabindex="-1" aria-labelledby="paymentEdittModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="min-width: 60%">
                            <form action="{{ route('payment.update') }}" method="POST" style="min-width: 100%">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="paymentEdittModalLabel">Payment Schedule</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th class="text-center">Title</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="paymentTbody">
                                                @foreach ($payments as $payment)
                                                    <tr>
                                                        <td class="paymentSl">{{ $loop->iteration }}</td>
                                                        <td class="text-center">
                                                            <input type="hidden" name="paymentId[]" id="paymentId" value="{{ $payment->id }}">
                                                            <input type="text" class="form-control" name="title[]" value="{{ $payment->title }}">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success addPaymentRow"><i class="fas fa-plus-circle"></i></button>
                                                            <button type="button" class="btn btn-danger deletePaymentRow" value="{{ $payment->id }}"><i class="fas fa-times-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>

                        <h5 class="text-dark mt-3"><span style=""><u>Bank Account Information</u></span></h5>

                        <table class="table terTable" style="width: 70%; border: 0px solid #fff;">
                            <tr>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Bank Name</td>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;" data-toggle="modal" data-target="#bankeditModal">: {{ $bank->bank_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Branch Name</td>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;" data-toggle="modal" data-target="#bankeditModal">: {{ $bank->branch_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Account Name</td>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;" data-toggle="modal" data-target="#bankeditModal">: {{ $bank->account_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50%; border: 0px solid #fff;">Account Number</td>
                                <td class="text-dark mb-0 mt-0 pt-0 pb-0 ml-0 pl-0" style="width: 50% ;border: 0px solid #fff;" data-toggle="modal" data-target="#bankeditModal">: {{ $bank->account_number }}</td>
                            </tr>
                        </table>

                        <!-- Modal -->
                        <div class="modal fade" id="bankeditModal" tabindex="-1" aria-labelledby="bankeditModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="min-width: 80%">
                            <form action="{{ route('bank.update', ['bank' => $bank->id]) }}" method="POST" style="min-width: 100%">
                                @csrf
                                @method('patch')
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="bankeditModalLabel">Bank Account Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" class="form-control mt-2" name="bank_name" placeholder="Enter Bank Name" value="{{ old('bank_name', $bank->bank_name) }}" required>
                                                    @error("bank_name")
                                                        <span class="sm text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="branch_name">Branch Name</label>
                                                    <input type="text" class="form-control mt-2" name="branch_name" placeholder="Enter Branch Name" value="{{ old('branch_name', $bank->branch_name) }}" required>
                                                    @error("branch_name")
                                                        <span class="sm text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="account_name">Account Name</label>
                                                    <input type="text" class="form-control mt-2" name="account_name" placeholder="Enter Account Name" value="{{ old('account_name', $bank->account_name) }}" required>
                                                    @error("account_name")
                                                        <span class="sm text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="account_number">Account Number</label>
                                                    <input type="text" class="form-control mt-2" name="account_number" placeholder="Enter Account Number" value="{{ old('account_number', $bank->account_number) }}" required>
                                                    @error("account_number")
                                                        <span class="sm text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>

                        <h5 class="text-dark mt-3"><span style=""><u>Terms & Conditions</u></span></h5>

                        @foreach ($terms as $term)
                           <p class="text-dark" data-toggle="modal" data-target="#termEdittModal"><b style="font-weight: 900">{{ $loop->iteration }}</b>. {{ $term->title }}</p>
                        @endforeach

                        <!-- Modal -->
                        <div class="modal fade" id="termEdittModal" tabindex="-1" aria-labelledby="termEdittModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="min-width: 60%">
                            <form action="{{ route('term.update') }}" method="POST" style="min-width: 100%">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="termEdittModalLabel">Payment Schedule</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th class="text-center">Title</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="termTbody">
                                                @foreach ($terms as $term)
                                                    <tr>
                                                        <td class="termSl">{{ $loop->iteration }}</td>
                                                        <td class="text-center">
                                                            <input type="hidden" name="termId[]" id="termId" value="{{ $term->id }}">
                                                            <input type="text" class="form-control" name="title[]" value="{{ $term->title }}">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success addTermRow"><i class="fas fa-plus-circle"></i></button>
                                                            <button type="button" class="btn btn-danger deleteTermRow" value="{{ $term->id }}"><i class="fas fa-times-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>

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

    </div>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href={{asset("ui/dist/css/adminlte.min.css")}}>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <style>
            .page {
                width: 21cm;
                height: 33.7cm;
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
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="{{ asset('js/autosuggestions.js') }}"></script>
        <script src="{{ asset('js/tableManipulation.js') }}"></script>
        {{-- <script src="{{ asset('js/pdfHandler.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/scrollToTop.js') }}"></script> --}}
        <script src="{{ asset('js/keyBoardShortcut.js') }}"></script>
        <script>
            $(document).ready(function () {
                // $('select').select2();
                $('#sidebarToggle').trigger('click');
                $(document).on('click', '.template', templateCreate);
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

                function updatePayementSerialNumbers() {
                    $('#paymentTbody tr').each(function(index) {
                        $(this).find('.paymentSl').text(index + 1);
                    });
                }

                // Add new row
                $('.addPaymentRow').click(function() {
                    var newRow = '<tr>' +
                        '<td class="paymentSl"></td>' +
                        '<td class="text-center">' +
                        '<input type="hidden" name="paymentId[]" class="paymentId">' +
                        '<input type="text" class="form-control title" name="title[]">' +
                        '</td>' +
                        '<td class="text-center">' +
                        // '<button type="button" class="btn btn-success addPaymentRow"><i class="fas fa-plus-circle"></i></button>' +
                        '<button type="button" class="btn btn-danger deletePaymentRow ml-1"><i class="fas fa-times-circle"></i></button>' +
                        '</td>' +
                        '</tr>';
                    $('#paymentTbody').append(newRow);
                    updatePayementSerialNumbers(); // Update SL numbers
                });

                // Delete row
                $(document).on('click', '.deletePaymentRow', function() {
                    $(this).closest('tr').remove();
                    updatePayementSerialNumbers(); // Update SL numbers
                });

                // Initial SL number update
                updatePayementSerialNumbers();

                function updateTermSerialNumbers() {
                    $('#termTbody tr').each(function(index) {
                        $(this).find('.termSl').text(index + 1);
                    });
                }

                // Add new row
                $('.addTermRow').click(function() {
                    var newRow = '<tr>' +
                        '<td class="termSl"></td>' +
                        '<td class="text-center">' +
                        '<input type="hidden" name="termId[]" class="termId">' +
                        '<input type="text" class="form-control title" name="title[]">' +
                        '</td>' +
                        '<td class="text-center">' +
                        '<button type="button" class="btn btn-danger deleteTermRow ml-1"><i class="fas fa-times-circle"></i></button>' +
                        '</td>' +
                        '</tr>';
                    $('#termTbody').append(newRow);
                    updateTermSerialNumbers(); // Update SL numbers
                });

                // Delete row
                $(document).on('click', '.deleteTermRow', function() {
                    $(this).closest('tr').remove();
                    updateTermSerialNumbers(); // Update SL numbers
                });

                // Initial SL number update
                updateTermSerialNumbers();
            });
        </script>
        <script>

            const subTotal = event => {

                let 
                    el = event.target,
                    tr = $(el).closest('tr'),
                    rate = parseFloat($(tr).find('.rate').text()), // Parsing as float for decimal values
                    qty = parseInt($(tr).find('.qty').text()); // Parsing as integer

                    console.log('in', rate, qty);

                $(tr).find('.amount').text(rate*qty);
            }

            function templateCreate(event) {

                $.ajax({
                    method: "POST",
                    url: "/api/add-template/" + $('#quoteId').val(),
                    data: {
                        'title': $('#templateTitle').val()
                    },
                    headers: {
                        "X-CSRF-TOKEN": $(document).find('[name="_token"]').val()
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: 'Template Add Successfully.', // Show error message
                            showConfirmButton: false,
                            timer: 1500
                        });
                        
                        $('.closeBtn').click();
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

            function reqData() {

                
                let table

                if($('#myTabContent .category.active.show .zone.active.show').find('.editableTable').length > 0) {
                    table = $('#myTabContent .category.active.show .zone.active.show').find('.editableTable');
                } else {
                    table = $('#myTabContent .category.active.show').find('.editableTable');
                }

                const data = {
                    quote_title: $('.quote_title').val(),
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
                    url         : `/api/quotes/update/${$('#quoteId').val()}`,
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