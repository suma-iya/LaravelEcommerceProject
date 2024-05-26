<x-adminheader/>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
         
          
         
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                                      <div class="card-body">
                                        <!-- Button to Open the Modal -->
                      <p class="card-title mb-0">Top Products</p>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewModel">
                        Add New
                      </button>

                      <!-- The Modal -->
                      <div class="modal" id="addNewModel">
                        <div class="modal-dialog">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Add New Product</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                            <form action="{{ URL::to('AddNewProduct') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <label for="">Title</label>
                                <input type="text" name="title" placeholder="Enter Title" class="form-control mb-2" id="" >
                                <label for="">Price</label>
                                <input type="text" name="price" placeholder="Enter Price ($)" class="form-control mb-2" id="" >
                                <label for="">Quantity</label>
                                <input type="number" name="quantity" placeholder="Enter Quantity" class="form-control mb-2" id="" >
                                <label for="">Picture</label>
                                <input type="file" name="file" class="form-control mb-2" id="">
                                <label for="">Description</label>
                                <input type="text" name="description" placeholder="Enter description" class="form-control mb-2" id="">
                                <label for="">Category</label>
                                <select name="category" id="" class="form-control mb-2">
                                  <option value="">Select Category</option>
                                  <option value="Rack">Racks</option>
                                  <option value="Basket">Baskets</option>
                                  <option value="Jar">Jars</option>
                                </select>
                                <label for="">Type</label>
                                <select name="type" id="" class="form-control mb-2">
                                  <option value="">Select Type</option>
                                  <option value="Best Sellers">Best Sellers</option>
                                  <option value="new-arrivals">New Arrivals</option>
                                  <option value="sale">Sale</option>
                                </select>
                                <input type="submit" name="save" class="btn btn-success" value="Save Now" id="">
                              </form>
                            </div>

                          </div>
                        </div>
                      </div>
                 
                  <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Picture</th>
                          <th>price</th>
                          <th>Quantity</th>
                          <th>Category</th>
                          <th>Type</th>
                          <th>Update</th>
                          <th>Delete</th>
                        </tr>  
                      </thead>
                      <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach($products as $item)
                        @php
                            $i++;
                        @endphp
                        <tr>
                          <td>{{$item->title}}</td>
                          <td><img src="{{URL::asset('uploads/profile/products/'.$item->picture)}}" width ="100px" alt=""></td>
                          <td class="font-weight-bold">{{$item->price}}</td>
                          <td>{{$item->quantity}}</td>
                          <td class="font-weight-medium"><div class="badge badge-success">{{$item->category}}</div></td>
                          <td class="font-weight-medium"><div class="badge badge-info">{{$item->type}}</div></td>
                          <td class="font-weight-medium">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModel{{ $i }}">
                            Update
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="updateModel{{ $i }}">
                              <div class="modal-dialog">
                                <div class="modal-content">

                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Update Product</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>

                                  <!-- Modal body -->
                                  <div class="modal-body">
                                  <form action="{{ URL::to('UpdateProduct') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <label for="">Title</label>
                                      <input type="text" name="title" value="{{$item->title}}" placeholder="Enter Title" class="form-control mb-2" id="" >
                                      <label for="">Price</label>
                                      <input type="text" name="price" value="{{$item->price}}" placeholder="Enter Price ($)" class="form-control mb-2" id="" >
                                      <label for="">Quantity</label>
                                      <input type="number" name="quantity" value="{{$item->quantity}}" placeholder="Enter Quantity" class="form-control mb-2" id="" >
                                      <label for="">Picture</label>
                                      <input type="file" name="file" class="form-control mb-2" id="">
                                      <label for="">Description</label>
                                      <input type="text" name="description" value="{{$item->description}}" placeholder="Enter description" class="form-control mb-2" id="">
                                      <label for="">Category</label>
                                      <select name="category" id="" class="form-control mb-2">
                                        <option value="{{$item->category}}">{{$item->category}}</option>
                                        <option value="Rack">Racks</option>
                                        <option value="Basket">Baskets</option>
                                        <option value="Jar">Jars</option>
                                      </select>
                                      <label for="">Type</label>
                                      <select name="type" id="" class="form-control mb-2">
                                        <option value="{{$item->type}}">{{$item->type}}</option>
                                        <option value="Best Sellers">Best Sellers</option>
                                        <option value="new-arrivals">New Arrivals</option>
                                        <option value="sale">Sale</option>
                                      </select>
                                      <input type="hidden" name="id" value="{{$item->id}}">
                                      <input type="submit" name="save" class="btn btn-success" value="Save Changes" id="">
                                    </form>
                                  </div>

                                </div>
                              </div>
                            </div>
                      
                          </td>
                          <td>
                            <a href="{{URL::to('deleteProduct/'.$item->id)}}" class="btn btn-danger">Delete</a>
                          </td>
                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
   <x-adminfooter/>