<x-adminheader/>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
         
          
         
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                                      <div class="card-body">
                                        <!-- Button to Open the Modal -->
                      <p class="card-title mb-0">My Profile</p>
                      <img src = "{{ URL::asset('uploads/profile/' . $user->picture) }}" class="mx-auto d-block mb-2" width="200px" alt="">
                      <form action="{{ URL::to('updateUser') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="fullname" placeholder="Name" class="form-control mb-2" value="{{$user->fullname}}" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="email" name="email" placeholder="Email" class="form-control mb-2" value="{{$user->email}}" readonly required>
                            </div>
                            <div class="col-lg-12">
                                <input type="file" name="file" class="form-control mb-2">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="password" placeholder="Password" class="form-control mb-2" required>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name = "register" class="btn btn-info">Save Changes</button>
                            </div>
                        </div>
                        </form>
                                        
                </div>
              </div>
            </div>
          </div>
        
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
   <x-adminfooter/>