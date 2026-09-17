<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.customer.store') }}" id="customerForm" data-ajax="true" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="name">{{ ' Name*' }}</label>
                <x-input id="customer_name" class="form-control" type="text" name="customer_name"
                    value="{{ old('customer_name') }}"  />
                <span class="text-danger" id="nameError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="company_name">{{ ' Company Name' }}</label>
                <x-input id="company_name" class="form-control" type="text" name="company_name"
                    value="{{ old('company_name') }}"  />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="customer_phone">{{ ' Phone Number*' }}</label>
                <x-input id="customer_phone" class="form-control" type="text" value="{{ old('customer_phone') }}"
                    name="customer_phone" />
                <span class="text-danger" id="phoneError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="location">{{ ' Location' }}</label>
                <x-input id="location" class="form-control" type="text" name="location" value="{{ old('location') }}"   />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="nic">{{ ' NIC' }}</label>
                <input id="nic" class="form-control" type="text" name="nic" value="{{ old('nic') }}" />
                <span class="text-danger" id="nicError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="address">{{ ' Address' }}</label>
                <x-input id="address" class="form-control" type="text" name="address" value="{{ old('address') }}"   />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="city">{{ 'City' }}</label>
                <x-input id="city" class="form-control" type="text" name="city" value="{{ old('city') }}"
                    />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="status">{{ 'Status' }}</label>
                <select id="status" class="form-control" name="status" value="{{ old('status') }}" >
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="register_date">{{ 'Register Date' }}</label>
                <x-input id="register_date" class="form-control" type="text" name="register_date"
                    value="{{ now()->format('Y-m-d') }}"  />
            </div>
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit">
                {{ ('Add Customer')}} </button>
        </div>
    </div>
</form>
<div class="form-group mb-3" id="message-parser">
   <textarea id="customer-message" placeholder="Paste customer details here" class="form-control" cols="15" rows="5"></textarea>
    <button  class="btn btn-primary mt-2" id="parse-btn">Extract Information</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        flatpickr("#register_date", {
            dateFormat: "Y-m-d",
        });

         $('#parse-btn').click(function(event) {
            event.preventDefault();
            const message = document.getElementById('customer-message').value;

           $.ajax({
               type: 'POST',
               url: '/useradmin/parse-customer-details',
               headers: {
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
               },
               data: JSON.stringify({ message: message }),
               contentType: 'application/json',
               dataType: 'json',
               success: function(data) {
                 // Clear existing fields
                 const fieldsToClear = ['customer_phone', 'customer_name', 'nic', 'address', 'city', 'company_name', 'location'];
                 // Clear the selected fields values
                 fieldsToClear.forEach((field) => {
                   document.getElementById(field).value = '';
                 });
                   if (data.phone) {
                       document.getElementById('customer_phone').value = data.phone;
                   }
                   if (data.name) {
                       document.getElementById('customer_name').value = data.name;
                   }
                   if(data.nic){
                       document.getElementById('nic').value = data.nic;
                   }
                   if( data.address){
                       document.getElementById('address').value = data.address;
                   }
                   if( data.city){
                       document.getElementById('city').value = data.city;
                   }
                   if( data.company){
                       document.getElementById('company_name').value = data.company;
                   }
                   if( data.location){
                       document.getElementById('location').value = data.location;
                   }
               },
               error: function(xhr, status, error) {
                    showCustomAlert(error);
               }
           });
       });

    });
</script>
