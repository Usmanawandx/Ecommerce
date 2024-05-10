@extends('layouts.admin')

@section('styles')

<style type="text/css">
    .order-table-wrap table#example2 {
    margin: 10px 20px;
}

</style>

@endsection


@section('content')
<?php
    $total_cost = 0;
?>
            <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Vendor PO Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Vendor PO') }}</a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Vendor PO Details') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>

                        <div class="order-table-wrap" id="print_area">
                            @include('includes.admin.form-both')
                            <button class="btn btn-sm btn-info m-1 float-right" id="print_po" onclick="PrintElem('print_area')">Print</button>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                            {{ __('Vendor Details') }}
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Shop Name') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$po->vendor->shop_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Shop Number') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$po->vendor->shop_number}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Shop Address') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$po->vendor->shop_address}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Email') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$po->vendor->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('PO Number') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$po->po_number}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('PO Date') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$po->created_at}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="footer-area">
                                            <a href="{{ route('admin-order-invoice',$order->id) }}" class="mybtn1"><i class="fas fa-eye"></i> {{ __('View Invoice') }}</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-lg-12 order-details-table">
                                        <div class="mr-table">
                                            <h4 class="title">{{ __('Order Items') }}</h4>
                                            <div class="table-responsiv">
                                                    <table id="example2" class="table table-hover dt-responsive " cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                <tr>
                                    <th>{{ __('Order No') }}</th>
                                    <th>{{ __('Product Sku') }}</th>
                                    <th width="30%">{{ __('Product Name') }}</th>
                                    <th>{{ __('Details') }}</th>
                                    <th>{{ __('Unit Cost') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Total Cost') }}</th>
                                </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                @foreach($po->po_items as $item)
                                    <tr>
                                        <td>{{$item->order_no}}</td>
                                        <td>{{$item->product_sku}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>
                                            @if (!empty($item->size) || $item->size != '' || $item->size != null)
                                                Size : {{$item->size}}
                                            @endif
                                            <br>
                                            @if (!empty($item->color) || $item->color != '' || $item->color != null)
                                                Color : {{$item->color}}
                                            @endif
                                        </td>
                                        <td>{{$item->amount/$item->quantity}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <?php
                                         $total_cost = $total_cost + $item->amount;
                                        ?>
                                        <td>{{$item->amount}}</td>
                                    </tr>
                                @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td><b>TOTAL</b></td>
                                                                <td>{{$total_cost}}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
            </div>
                    <!-- Main Content Area End -->

@endsection


@section('scripts')

<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      "pageLength": 50,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>
<script>
    function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(`<style>
    @media print{
        #print_po {
            display: none;
        }
        #example2_paginate {
            display: none;
        }
        .dataTables_length{
            display:none;
        }
    }
</style></head><body >`);
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>
@endsection
