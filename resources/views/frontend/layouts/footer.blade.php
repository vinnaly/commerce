<!--================ Start footer Area  =================-->
<footer class="footer">
      <div class="footer-area">
        <div class="container">
          <div class="row section_gap">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="single-footer-widget tp_widgets">
                <h4 class="footer_title large_title">Our Mission</h4>
                  <p>Kami berkomitmen untuk menyediakan produk berkualitas tinggi yang dapat dipercaya oleh pelanggan</p>
                  <p>Kami percaya bahwa kepuasan pelanggan adalah prioritas utama</p>
              </div>
            </div>
            <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
              <div class="single-footer-widget tp_widgets">
                <h4 class="footer_title">Quick Links</h4>
                <ul class="list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('product.collection') }}">All Collection</a></li>
                <li><a href="{{ auth()->check() ? route('account.index') : route('login') }}">Account</a></li>
                <li><a href="{{ auth()->check() ? route('cart.index') : route('login') }}">Cart</a></li>
              </ul>
              </div>
            </div>
            <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
              <div class="single-footer-widget tp_widgets">
                <h4 class="footer_title">Contact Us</h4>
                <div class="ml-40">
                  <p class="sm-head">
                    <span class="fa fa-location-arrow"></span>
                   Alamat Kami
                  </p>
                  <p>Jln.raya santong kec.kayangan, kab.lombok utara</p>

                  <p class="sm-head">
                    <span class="fa fa-phone"></span>
                   Hubungi Kami
                  </p>
                  <p>
                    +123 456 7890 <br />
                  </p>

                  <p class="sm-head">
                    <span class="fa fa-envelope"></span>
                    Email
                  </p>
                  <p>
                    tutiktsh@gmail.com <br />
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!--================ End footer Area  =================-->