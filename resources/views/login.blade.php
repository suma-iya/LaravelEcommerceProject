<x-header />

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-6 col-md-6 mx-auto">
                <div class="section-title">
                    <h2>Login to account</h2>
                </div>
                <div class="contact__form">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <!-- Corrected syntax for displaying session message -->
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            <!-- Corrected syntax for displaying session message -->
                            <p>{{ Session::get('error') }}</p>
                        </div>
                    @endif
                    <!-- Corrected action attribute syntax -->
                    <form action="{{ URL::to('/loginUser') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="site-btn">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<x-footer />
