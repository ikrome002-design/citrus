@if(!$products->isEmpty())
    <div class="table-responsive vendor-product-table">
        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <td><input type="checkbox" id="select-product-input"></td>
                    <td colspan="2">Product</td>
                    <td>Categories</td>
                    <td>Quantity</td>
                    <td>Product ID</td>
                    <td>Review</td>
                    <td>Date</td>
                    <td>Actions</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
             
            @foreach ($products as $product)
                <tr>
                    <td><input type="checkbox" id="select-product-input"></td>
                    <td><img src="@if(!empty($product->cover)){{ asset('storage/'.$product->cover) }}@else{{ asset('images/placeholder-square.png') }}@endif" class="image-icon"></td>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        @foreach($categories as $category)
                            @foreach($category_products as $category_product)
                                @if($category_product->product_id == $product->id && $category_product->category_id == $category->id )
                                    {{ $category->name.',' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td>{{ $product->quantity }}</td>
                    <td># {{ $product->id }}</td>
                    <td>
                        @php $i = 0 @endphp
                        @foreach($reviews as $review)
                            @if($review->product_id == $product->id )
                                @php $i++ @endphp
                            @endif
                        @endforeach
                        {{ $i }}
                    </td>
                    <td>{{ date("d M Y",strtotime($product->created_at) ) }}</td>
                    <td style="white-space: nowrap;">
                         @if(isset(auth('admin')->user()->id)) 
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                            
                        <a  href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.edit', $product->id) }} @elseif(isset(auth('vendor')->user()->id)){{ route('products.edit', $product->id) }}@endif" class="btn btn-success btn-sm vendor-product-bt"><i class="fa fa-edit"></i></a>
                        
                       
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger vendor-product-bt"><i class="fa fa-trash"></i></button>
                        </form>

                        @else
                        <form action="{{ route('vendor.products.destroyy') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                       <input type="hidden" name="id" value={{ $product->id }}> 
                            
                        <a  href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm vendor-product-bt"><i class="fa fa-edit"></i></a>
                        
                       
                        <button type="submit" class="btn btn-danger vendor-product-bt"><i class="fa fa-trash"></i></button>
                        </form>

        
                        @endif
                    </td>
                    <td>
                        @if($product->status == 1)
                                <a  href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.update.unapprove', ['product' => $product->id]) }} @elseif(isset(auth('vendor')->user()->id)){{ route('products.update.unapprove', ['product' => $product->id]) }}@endif" class="btn btn-primary btn-sm vendor-product-bt" onclick="return confirm('Are you sure? Inactive product!')"> <i class="fa fa-eye"></i></a>
                            @else
                                <a  href="@if(isset(auth('admin')->user()->id)){{ route('admin.products.update.approve', ['product' => $product->id]) }}@elseif(isset(auth('vendor')->user()->id)){{ route('products.update.approve', ['product' => $product->id]) }}@endif" class="btn btn-danger vendor-product-bt" onclick="return confirm('Are you sure? Active product!')"><i class="fa fa-eye-slash"></i></a>
                            @endif
                            
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
