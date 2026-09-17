<!-- Filter Modal -->

<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-mn">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filterModalLabel">{{ __('Filter by Date') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('useradmin.emp.job.amount.filter') }}" method="GET">
          <div class="modal-body">
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Start Date : *') }}</label>
                <input id="start_date" name="start_date" class="form-control" type="date" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('End Date : *') }}</label>
                <input id="end_date" name="end_date" class="form-control" type="date" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Payment Status') }}</label>
                <select id="payment_status" name="payment_status" class="form-control">
                    <option value="">{{ __('All') }}</option>
                    <option value="Pending">{{ __('Pending') }}</option>
                    <option value="Paid">{{ __('Paid') }}</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('Apply Filter') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>  
  
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

  