@extends('layouts.events')

@section('page-title', __('Edit Team'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.team') }}">{{ __('Teams') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('Edit Team') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Team</h3>
            </div>
            <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
                <hr>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-header card-body table-border-style">
                            <div class="col-xl-12">
                                <form method="POST" action="{{ route('useradmin.events.team.update', ['team_id' => $team->team_category_id]) }}" id="editForm" enctype="multipart/form-data" data-ajax="true">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="event_name" class="form-label">Event: *</label>
                                            <input type="text" class="form-control" id="event_name" value="{{ $team->event_name }}" readonly>
                                            <input type="hidden" class="form-control" name="event_id"  value="{{ $team->event_id }}">
                                        </div>
                                    </div>
                                    <div class="task-container border rounded p-2 p-md-3">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="team_name" class="team-label">Team Name: *</label>
                                                <input type="text" class="form-control" name="team_name"  value="{{ $team->team_name }}" readonly>
                                                <input type="hidden" class="form-control" name="team_category_id"  value="{{ $team->team_category_id }}">
                                            </div>
                                        </div>
                                        <div class="task-container border rounded p-2 p-md-3">
                                            <div class="row">
                                                <!-- Team Category -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="member_role" class="form-label">Member Role: *</label>
                                                        <select class="form-control" name="member_role" id="member_role">
                                                            <option value="">Select Role</option>
                                                            <option value="manager" {{ old('member_role') == 'manager' ? 'selected' : '' }}>Manager Team</option>
                                                            <option value="artist" {{ old('member_role') == 'artist' ? 'selected' : '' }}>Artist Team</option>
                                                            <option value="sales" {{ old('member_role') == 'sales' ? 'selected' : '' }}>Sales Team</option>
                                                            <option value="planner" {{ old('member_role') == 'planner' ? 'selected' : '' }}>Planner Team</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Member Name -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="member_name" class="form-label">Member Name: *</label>
                                                        <select class="form-control select1" name="member_id" id="member_name">
                                                            <option value="">Select Member</option>
                                                        </select>                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="mobile">{{ 'Phone Number*' }}</label>
                                                        <x-input id="mobile" class="form-control" type="text" name="mobile" value="{{ old('mobile') }}"
                                                            autofocus />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="status">{{ 'Status' }}</label>
                                                        <select id="status" class="form-control" name="status" autofocus>
                                                            <option value="Active" {{ old('active') == 'Active' ? 'selected' : '' }}>Active</option>
                                                            <option value="Inactive" {{ old('active') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <button type="button" class="btn btn-sm btn-primary add-member" id="addMemberBtn">
                                                    <i class="ti ti-plus"></i> Add Member
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="currentTeamTable" class="table table-bordered mt-4">
                                            <thead>
                                                <tr>
                                                    <th>Role</th>
                                                    <th>Team Member</th>
                                                    <th>Phone No.</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach ($teamMembers as $member)
                                                    <tr>
                                                        <td>{{ $member->role }}</td>
                                                        <td>{{ $member->member_name }}</td> 
                                                        <td>{{ $member->mobile }}</td>
                                                        <td>{{ $member->status }}</td>
                                                        <td>
                                                            <form action="{{ route('useradmin.events.delete_member', $member->id) }}" method="GET" class="d-inline">
                                                                @csrf
                                                                <button type="button" 
                                                                    class="btn btn-sm btn-danger show_confirms" 
                                                                    data-url="{{ route('useradmin.events.delete_member', $member->id) }}" 
                                                                    title="Delete">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <input type="hidden" name="teams_data" id="teams_data_input">
                                    </div>
                                    <br>
                                    <div class="d-flex mb-3 justify-content-end">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit" id="submitBtn">
                                                Update Team
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#member_role').on('change', function () {
                const category = $(this).val();
                $('#member_name').html('<option value="">Loading...</option>');

                if (category) {
                    $.ajax({
                        url: '{{ route('useradmin.get.members.by.category') }}',
                        method: 'GET',
                        data: { category: category },
                        success: function (response) {
                            let options = '<option value="">Select Member</option>';
                            response.forEach(function (member) {
                                options += `<option value="${member.id}">${member.name}</option>`;
                            });
                            $('#member_name').html(options).trigger('change');
                        },
                        error: function () {
                            $('#member_name').html('<option value="">Error loading members</option>');
                        }
                    });
                } else {
                    $('#member_name').html('<option value="">Select Member</option>');
                }
            });

            // Auto-fill member details on selection
            $('#member_name').on('change', function () {
                const memberId = $(this).val();
                const category = $('#member_role').val();

                if (memberId && category) {
                    $.ajax({
                        url: '{{ route('useradmin.get.member.details') }}',
                        method: 'GET',
                        data: { id: memberId, category: category },
                        success: function (response) {
                            if (response) {
                                $('#mobile').val(response.mobile);
                                let lowerStatus = status ? status.toLowerCase() : '';

                                $('#status').html(`
                                    <option value="Active" ${lowerStatus === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="Inactive" ${lowerStatus === 'inactive' ? 'selected' : ''}>Inactive</option>
                                `);

                            }
                        },
                        error: function () {
                            console.error('Failed to fetch member details.');
                        }
                    });
                }
            });
        });
        $(document).ready(function () {
            let memberCounter = 0;

            // Add new member to table
            $('#addMemberBtn').on('click', function () {
                const role = $('#member_role').val();
                const roleText = $('#member_role option:selected').text();
                const memberId = $('#member_name').val();
                const memberName = $('#member_name option:selected').text();
                const mobile = $('#mobile').val();
                const status = $('#status').val();

                if (!role || !memberId || !mobile) {
                    $('#errorMessage').text('Please fill all required fields').show();
                    return;
                }

                // Create a new table row
                const newRow = `
                    <tr class="new-member-row">
                        <td>
                            ${roleText}
                            <input type="hidden" name="new_members[${memberCounter}][role]" value="${role}">
                        </td>
                        <td>
                            ${memberName}
                            <input type="hidden" name="new_members[${memberCounter}][member_id]" value="${memberId}">
                            <input type="hidden" name="new_members[${memberCounter}][member_name]" value="${memberName}">
                        </td>
                        <td>
                            ${mobile}
                            <input type="hidden" name="new_members[${memberCounter}][mobile]" value="${mobile}">
                        </td>
                        <td>
                            ${status}
                            <input type="hidden" name="new_members[${memberCounter}][status]" value="${status}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-member" data-bs-toggle="tooltip" title="Remove">
                                Remove
                            </button>
                        </td>
                    </tr>
                `;

                let isDuplicate = false;
                const selectedMemberId = memberId;

                $('#currentTeamTable tbody tr').each(function () {
                    const hiddenInput = $(this).find('input[name*="[member_id]"]');
                    let existingMemberId = hiddenInput.length ? hiddenInput.val() : null;

                    if (!existingMemberId) {
                        const nameText = $(this).find('td').eq(1).text().trim(); 
                        if (nameText === memberName) {
                            isDuplicate = true;
                            return false; 
                        }
                    } else {
                        if (existingMemberId === selectedMemberId) {
                            isDuplicate = true;
                            return false; 
                        }
                    }
                });

                if (isDuplicate) {
                    $('#errorMessage').text('This member has already been added.').show();
                    return;
                }

                $('#currentTeamTable tbody').append(newRow);
                memberCounter++;

                // Reset the fields
                $('#member_role').val('').trigger('change');
                $('#member_name').html('<option value="">Select Member</option>');
                $('#mobile').val('');
                $('#status').val('Active').trigger('change');
            });

            // Remove dynamically added member
            $(document).on('click', '.remove-member', function () {
                $(this).closest('tr').remove();
            });

            $(document).on('click', '.show_confirms', function () {
                const deleteUrl = $(this).data('url');
                const button = $(this); // store the clicked button

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to delete this member?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                _method: 'GET',  
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                button.closest('tr').remove();
                                $('#errorMessage').hide();
                            },
                            error: function (xhr) {
                                $('#errorMessage')
                                    .text('Failed to delete member.').show();
                            }
                        });
                    }
                });
            });
            
            $('#submitBtn').on('click', function (e) {
                e.preventDefault(); 

                let newMembers = [];

                $('#currentTeamTable tbody tr.new-member-row').each(function () {
                    let role = $(this).find('input[name*="[role]"]').val();
                    let member_name = $(this).find('input[name*="[member_name]"]').val();
                    let mobile = $(this).find('input[name*="[mobile]"]').val();
                    let status = $(this).find('input[name*="[status]"]').val();

                    if (role && member_name && mobile && status) {
                        newMembers.push({ role, member_name, mobile, status });
                    }
                });

                const teamsData = {
                    event_id: $('input[name="event_id"]').val(),
                    team_category_id: $('input[name="team_category_id"]').val(),
                    team_name: $('input[name="team_name"]').val(),
                    new_members: newMembers
                };

                // Set JSON data to hidden input
                $('#teams_data_input').val(JSON.stringify(teamsData));

                document.getElementById("editForm").submit();
            });
        });
    </script>
@endsection
