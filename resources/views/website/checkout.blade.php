@extends('website.layouts.app')

@section('title')
CheckOut
@stop
@section('content')

<section id="check-out">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">CheckOut</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-8 col-12">
                <h3>Billing Details</h3>
                
                <form id="checkout-form" method="post" action="#">
                    @csrf
                    <div class="form-row pt-4">
                        <div class="form-group col-md-6">
                            <label for="inputfirst">First Name <span class="required-mark">*</span></label>
                            <input type="text" name="first_name" class="form-control">
                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputllast">Last Name <span class="required-mark">*</span></label>
                            <input type="text" name="last_name" class="form-control">
                        </div>
                    </div>
                    
                    
                    <div class="form-group pt-4">
                        <label for="inputcountry">Country <span class="required-mark">*</span></label>
                        <select name="country" class="custom-select custom-select mb-3">
                            <option selected>Nepal</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputDistrict">District <span class="required-mark">*</span></label>
                        <select name="district" class="custom-select custom-select mb-3" >
                            <option selected value="kathmandu">kathmandu</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputtown">Town / City <span class="required-mark">*</span></label>
                        <input name="city" type="text" class="form-control">
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputstreet">Street Address <span class="required-mark">*</span></label>
                        <input name="street_address" type="text" class="form-control">
                        
                    </div>
                    
                    <div class="form-row pt-4">
                        <div class="form-group col-md-6">
                            <label for="inputphone">Phone <span class="required-mark">*</span></label>
                            <input name="phone" type="text" class="form-control">
                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email <span class="required-mark">*</span></label>
                            <input name="email" type="email" class="form-control">
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4 col-12 bg1">
                    <h3 class="pt-5">Your Order</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            
                            <div class="row pt-2">
                                <div class="col-md-9 col-12">
                                    <h6>Product</h6>
                                    <p>Car</p>
                                </div>
                                <div class="col-md-3 col-12">
                                    <h6>Total</h6>
                                    <p>Rs 0.5</p>
                                </div>
                            </div>
                            
                            <div class="row pt-2">
                                <div class="col-md-9 col-12">
                                    <h6>Product</h6>
                                    <p>Bike</p>
                                </div>
                                <div class="col-md-3 col-12">
                                    <h6>Total</h6>
                                    <p>Rs 0.5</p>
                                </div>
                            </div>
                            
                        </li>
                        <li class="list-group-item">
                            <div class="row pt-2">
                                <div class="col-md-9 col-12">
                                    <h6>SubTotal</h6>
                                </div>
                                <div class="col-md-3 col-12">
                                    <p>Rs 1</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row pt-2">
                                <div class="col-md-9 col-12">
                                    <h6>Total</h6>
                                    
                                </div>
                                <div class="col-md-3 col-12">
                                    <p>Rs 1</p>
                                </div>
                            </div>   
                        </li>
                    </ul>
                    
                    <div class="form-group form-check pt-4">
                        <input type="checkbox" class="form-check-input" id="terms">
                        <label class="form-check-label" for="Check1">
                            
                            I’ve read and accept the terms & conditions </label>
                        </div>
                        <button type="submit" id="khalti" class="btn btn-danger checkout_btn" style="background-color: #41a124; border-color: #41a124;">Pay With eSewa</button>
                        
                    </form>
                </section>
                <!--check-out-->
                
                @endsection
                
                @push('footer')
                <script src="{{ asset('frontend/jquery/jquery.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
                <script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $(function(){
                        $('#khalti').click(function(e) {
                            e.preventDefault();
                            let form = document.getElementById('checkout-form');
                            let data = {
                                firstname: form['first_name'].value,
                                lastname: form['last_name'].value,
                                country: form['country'].value,
                                district: form['district'].value,
                                city: form['city'].value,
                                street_address: form['street_address'].value,
                                phone: form['phone'].value,
                                email: form['email'].value,
                            };
                            
                            axios.post("{{ route('api.esewa.checkout') }}", data).then(res => {
                                
                                if(res.data.id === 'undefined'){
                                    return false;
                                }
                                var path = "https://esewa.com.np/epay/main";
                                var params = {
                                    amt: res.data.total_price,
                                    psc: 0,
                                    pdc: 0,
                                    txAmt: 0,
                                    tAmt: res.data.total_price,
                                    pid: res.data.ref_id,
                                    scd: "Dummy Merchant ID", // please use your merchant id here...
                                    su: "http://esewa-payment-integration.test/success",
                                    fu: "http://esewa-payment-integration.test/checkout/failure"
                                }
                                var form = document.createElement("form");
                                form.setAttribute("method", "POST");
                                form.setAttribute("action", path);
                                
                                for (var key in params) {
                                    var hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", key);
                                    hiddenField.setAttribute("value", params[key]);
                                    form.appendChild(hiddenField);
                                }
                                
                                document.body.appendChild(form);
                                form.submit();   
                            });
                        });                            
                    });                            
                </script>
                
                @endpush