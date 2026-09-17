<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form>
   <div class="form-group">
       <label for="package_name" class="form-label">Package Name   *</label>
       <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name') }}"  maxlength="100" required>
   </div>
   <div class="form-group">
        <label for="category" class="form-label">{{ ('Category  *') }}</label>
        <select id="category" class="form-control" name="category" required>
            <option value="">Select Category</option>
            @foreach ($packageCategories as $category)
                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="package_status" class="form-label">{{ ('Display Package Items On Order  *') }}</label>
        <select id="package_status" class="form-control" name="package_status" required>
            <option value="Active">Yes</option>
            <option value="Inactive">No</option>
        </select>
    </div>
    <button type="button" class="btn btn-primary from-prevent-multiple-submits" id="saveBtn">Save</button>
</form>
<script>
    function savePackage() {
        var predefinedPackage = [];
        //  Check if already added in localstorage
        if (localStorage.getItem('predefinedPackage')) {
            // Delete existing package
            delete localStorage.predefinedPackage;
        }
        predefinedPackage.push({
            package_name: $('#package_name').val(),
            category: $('#category').val(),
            package_status: $('#package_status').val(),
            package_id: '',
        })
        // Save in local storage
        localStorage.setItem('predefinedPackage', JSON.stringify(predefinedPackage));

        $('#commanModel').modal('hide');

    }
    $(document).ready(function() {
        // Save Button Click
        $("#saveBtn").click(function() {
            savePackage();
        })
    });
</script>
