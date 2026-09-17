@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                       <h3 class="card-title"> Equipment Investment Analysis</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="form-group row">
                                <label for="equipment_name" class="col-md-4 col-form-label text-md-right">Equipment Name</label>

                                <div class="col-md-6">
                                    <select id="equipment_name" class="form-control @error('equipment_name') is-invalid @enderror" name="equipment_name" value="{{ old('equipment_name') }}" required autocomplete="equipment_name" autofocus>
                                        <option value="">Select Equipment</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('equipment_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="initial_cost" class="col-md-4 col-form-label text-md-right">Initial Cost</label>

                                <div class="col-md-6">
                                    <input id="initial_cost" type="number" class="form-control @error('initial_cost') is-invalid @enderror" name="initial_cost" value="{{ old('initial_cost') }}" required autocomplete="initial_cost" autofocus>

                                    @error('initial_cost')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="maintenance_cost" class="col-md-4 col-form-label text-md-right">Maintenance Cost</label>

                                <div class="col-md-6">
                                    <input id="maintenance_cost" type="number" class="form-control @error('maintenance_cost') is-invalid @enderror" name="maintenance_cost" value="{{ old('maintenance_cost') }}" required autocomplete="maintenance_cost" autofocus>

                                    @error('maintenance_cost')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expected_revenue" class="col-md-4 col-form-label text-md-right">Expected Revenue</label>
                                <div class="col-md-6">
                                    <input id="expected_revenue" type="number" class="form-control @error('expected_revenue') is-invalid @enderror" name="expected_revenue" value="{{ old('expected_revenue') }}" required autocomplete="expected_revenue" autofocus>
                                    @error('expected_revenue')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button  id="calculateBtn" class="btn btn-primary">
                                        {{ __('Calculate ROI') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 id="predicted_roi_result">Predicted ROI Percent: </h4>
                                        <h5 id="accuracy_result">Accuracy: </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Choices.js -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        var items = @json($items);
        document.addEventListener('DOMContentLoaded', function () {
            const equipmentSelect = document.getElementById('equipment_name');
            const choices = new Choices(equipmentSelect, {
                searchEnabled: true,
                shouldSort: false,
                placeholderValue: 'Select Equipment',
            });
            equipmentSelect.addEventListener('change', function (event) {
                const selectedValue = event.target.value;
                const selectedItem = items.find(item => item.item_id == selectedValue);
                if (selectedItem) {
                   document.getElementById('initial_cost').value = selectedItem.product_amount.toFixed(2);
                }
            });
        });
        $("#calculateBtn").click(function(event) {
            event.preventDefault(); // Prevent the default form submission
            $.ajax({
                url: "{{ route('useradmin.equipment.calculate.roi') }}",
                type: "POST",
                data: {
                    equipment_id: $("#equipment_name").val(),
                    initial_cost: $("#initial_cost").val(),
                    maintenance_cost: $("#maintenance_cost").val(),
                    expected_revenue: $("#expected_revenue").val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.predicted_roi_percent && response.accuracy_percent) {
                       $("#predicted_roi_result").text("Predicted ROI Percent: " + response.predicted_roi_percent);
                       $("#accuracy_result").text("Accuracy: " + response.accuracy_percent);

                    } else {
                        showCustomAlert("Error calculating revenue.");
                    }
                },
                error: function(xhr, status, error) {
                    showCustomAlert("An error occurred while calculating revenue.");
                }
            })
        });
    </script>
@endsection
