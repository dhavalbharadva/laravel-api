@extends('frontend.layouts.default')

@section('content')
<section class="page-content">
    <div class="container">
        <div class="heading">
            <div class="content">
                <h1 class="page-title">Welcome {!! auth()->user()->name; !!}</h1>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <table class="table">
                            <thead>
                              <tr>
                                <th>Order Id</th>
                                <th>Items</th>
                                <th>Created Date</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if(count($orders))
                                @foreach ($orders as $data)
                                    <tr>
                                        <td>{!! $data->id !!}</td>
                                        <td>
                                            @foreach($data->orderDetail as $key => $val)
                                            {!! $val->item->title.'<br>' !!}
                                            @endforeach
                                        </td>
                                        <td>{!! date('m/d/Y h:i:s A',strtotime($data->created_at)) !!}</td>
                                  </tr>
                                @endforeach
                                @else
                                    <tr>
                                    <td colspan="3" class="text-center">No records available</td>
                                  </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop