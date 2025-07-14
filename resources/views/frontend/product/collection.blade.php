@extends('frontend.layouts.app')

@section('content')
    <!-- ================ Collection section start ================= -->
    <section class="section-margin--small mb-5">
      <!-- NAV CATEGORY -->
      @include('frontend.layouts.navcategory', ['categories' => $categories])
      <!-- END NAV CATEGORY -->

        </div>
          <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
              <div class="row">
              @foreach ($products as $product)
              <div class="col-md-6 col-lg-4">
                <div class="card text-center card-product">
                  <div class="card-product__img">
                    <img class="card-img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" />
                    <ul class="card-product__imgOverlay">
                      </li>
                        <form action="{{ route('cart.add') }}" method="POST">
                          @csrf
                          <input type="hidden" name="product_id" value="{{ $product->id }}">
                          <input type="hidden" name="quantity" value="1">
                          <button type="submit"><i class="ti-shopping-cart"></i></button>
                      </form>
                    </ul>
                  </div>
                  <div class="card-body">
                    
                    <h4 class="card-product__title">
                    <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h4>
                    <p class="card-product__price">Rp {{ number_format($product->price, ) }}</p>
                    <span  class="text-green-600 font-medium">tersedia {{ $product->stock }}</span>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
            </section>
            <!-- End Best Seller -->
          </div>
        </div>
      </div>
    </section>
    <!-- ================ Collection section end ================= -->
     @push('styles')
<style>
  .card-product__img {
      height: 220px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .card-product__img img {
      max-height: 100%;
      object-fit: contain;
  }

  .card-product__title {
      min-height: 48px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
  }
</style>
@endpush

@endsection