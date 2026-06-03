@if($productratings)
    <table class="display nowrap dataTable dtr-inline collapsed" id="myTable">
        <thead>
            <tr>
                <td></td>
                <td>Comment</td>
                <td>Product name</td>
                <td>Date</td>
                <td>Rating</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($productratings as $product)
                <tr>
                    <td>
                       @if($product->avatar!='')         
                          <img height="50" width="50" src="{{ asset( 'storage/profile/customer/'.$product->user_id.'/'.$product->avatar.'') }}"> 
                       @endif
                       
                    </td>
                     <td>
                        {{ $product->review }}
                    </td>
                    <td>
                       {{$product->name}}
                    </td>
                    <td>
                       {{ date('m-Y', strtotime($product->created_at)) }}
                    </td>
                    <td>
                        @for ($i = 0; $i <  $product->rating; $i++)
                            <i class="fa fa-star"></i>
                        @endfor
                        @for ($i = 0; $i <  (5-$product->rating); $i++)
                            <i class="fa fa-star-o"></i>
                        @endfor
                    </td>
                </tr>
            @endforeach
            </tbody>
    </table>
@endif
     


