@extends('layouts.events')

@section('page-title', __('Events Teams'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.create_team') }}">{{ __('Create Teams') }}</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Create Teams</h3>
                </div>
                <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.events.create_team_name') }}"
                        data-size="md" data-ajax-popup="true" data-title="{{ __('Create Team Name') }}">
                    <i title="Create Team Name"></i> {{ __('Create Team Name') }}
                    </button>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-header card-body table-border-style">
                            <div class="col-xl-12">
                                <form method="POST" action="{{ route('useradmin.events.team.store') }}" id="teamForm" enctype="multipart/form-data" data-ajax="true">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="event_name" class="form-label">Event: *</label>
                                            <select class="form-control select2" name="event_id" id="event_name" required>
                                            <option value="">Select Event</option>
                                            @foreach ($events as $event)
                                                <option value="{{ $event->eid }}"
                                                    {{ old('event_id', $selectedEventId ?? '') == $event->eid ? 'selected' : '' }}>
                                                    {{ $event->event_name }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="task-container border rounded p-2 p-md-3">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="team_name" class="team-label">Team Name: *</label>
                                                <select class="form-control select1" name="team_category_id" id="team_name" required>
                                                    <option value="">Select Team Name</option>
                                                </select>
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
                                                            <option  value="Active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="Inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                    <!-- Team Members Table -->
                                    <p><b>Team Name: </b><span id="selected-team-name"></span></p>
                                    <div class="table-responsive">
                                        <table id="currentTeamTable" class="table table-bordered mt-4">
                                            <thead>
                                                <tr>
                                                    <th>Role</th>
                                                    <th>Team Member</th>
                                                    <th>Phone No.</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Dynamic team member rows -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex mb-3 justify-content-end">
                                        <div class="d-grid">
                                            <button class="btn btn-primary mt-3" type="button" id="addteamBtn">
                                                Add Team
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="teams_data" id="teams_data">
                                    <br>
                                    <p><b>Event Name: </b><span id="selectedEventName"></span>
                                    <div class="table-responsive">
                                        <table id="teamListTable" class="table table-bordered mt-4">
                                            <thead>
                                                <tr>
                                                    <th>Team Name</th>
                                                    <th>Member Role</th>
                                                    <th>Member Name</th>
                                                    <th>Member Phone No.</th>
                                                    <th>Member Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="teamListBody">
                                                <!-- All teams will be listed here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex mb-3 justify-content-end">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit" id="submitBtn">
                                                Create Team
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
    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">{{ __('Add Teams') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display errors here -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

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
            $(document).ready(function () {
                $('#event_name').on('change', function () {
                    var selectedText = $("#event_name option:selected").text();
                    $('#selectedEventName').text(selectedText !== 'Select Event' ? selectedText : 'None');
                });
                $('#event_name').trigger('change');
            });
            $('#event_name').on('change', function () {
                const eventId = $(this).val();
                $('#team_name').html('<option value="">Loading...</option>');

                if (eventId) {
                    $.ajax({
                        url: '{{ route('useradmin.get.teams.name') }}',
                        method: 'GET',
                        data: { eventId: eventId },
                        success: function (response) {
                            let options = '<option value="">Select Team Name</option>';
                            response.forEach(function (team) {
                                options += `<option value="${team.id}">${team.team_name}</option>`;
                            });
                            $('#team_name').html(options).trigger('change');
                        },
                        error: function () {
                            $('#team_name').html('<option value="">Error loading teams</option>');
                        }
                    });
                } else {
                    $('#team_name').html('<option value="">Select Team Name</option>');
                }
            });
            $('#team_name').on('change', function () {
                const selectedText = $('#team_name option:selected').text();
                $('#selected-team-name').text(selectedText);
            });

            let currentTeamMembers = [];

            $('#addMemberBtn').on('click', function () {
                const role = $('#member_role').val();
                const roleText = $('#member_role option:selected').text();
                const memberId = $('#member_name').val();
                const memberName = $('#member_name option:selected').text();
                const mobile = $('#mobile').val();
                const status = $('#status').val();
                const statusText = $('#status option:selected').text();               

                if (!role || !memberId || !mobile) {
                    $('#errorMessage').text('Please fill all required fields').show();
                    return;
                }

                // Check for duplicates
                const isDuplicate = currentTeamMembers.some(member => member.memberId === memberId);
                if (isDuplicate) {
                    $('#errorMessage').text('This member is already added to the team.').show();
                    return;
                }

                // Hide any previous error
                $('#errorMessage').hide();

                currentTeamMembers.push({
                    role,
                    memberId,
                    memberName,
                    mobile,
                    status
                });

                $('#currentTeamTable tbody').append(`
                    <tr>
                        <td>${roleText}</td>
                        <td>${memberName}</td>
                        <td>${mobile}</td>
                        <td>${status}</td>
                    </tr>
                `);

                // Optional: Clear fields
                $('#member_role').val('').trigger('change');
                $('#member_name').html('<option value="">Select Member</option>');
                $('#mobile').val('');
                $('#status').val('Active');
            });

            let allTeams = [];

            $('#addteamBtn').on('click', function (e) {
                e.preventDefault(); // prevent form submission

                // Clear previous error
                $('#errorMessage').hide().text('');

                const eventId = $('#event_name').val();
                const eventName = $('#event_name option:selected').text();
                const teamId = $('#team_name').val();
                const teamName = $('#team_name option:selected').text();

                if (!eventId || !teamId || currentTeamMembers.length === 0) {
                    $('#errorMessage').text('Select event, team and add at least one member.').show();
                    return;
                }

                const isDuplicate = allTeams.some(team => team.eventId === eventId && team.teamId === teamId);
                if (isDuplicate) {
                    $('#errorMessage').text(`A team named "${teamName}" has already been added for the event "${eventName}".`).show();
                    return;
                }

                allTeams.push({
                    eventId,
                    eventName,
                    teamId,
                    teamName,
                    members: currentTeamMembers
                });

                // Append all members to the team list table
                currentTeamMembers.forEach(member => {
                    $('#teamListBody').append(`
                        <tr>
                            <td>${teamName}</td>
                            <td>${member.role}</td>
                            <td>${member.memberName}</td>
                            <td>${member.mobile}</td>
                            <td>${member.status}</td>
                        </tr>
                    `);
                });

                // Clear team name select field
                $('#team_name').val('');
                
                // Clear current team data
                currentTeamMembers = [];
                $('#currentTeamTable tbody').html('');
            });
            $('#submitBtn').on('click', function (e) {
                e.preventDefault();

                if (allTeams.length === 0) {
                    $('#errorMessage').text('Please add at least one team before submitting.').show();
                    return;
                }

                // Fill the hidden input with JSON data
                $('#teams_data').val(JSON.stringify(allTeams));

                // Submit the form
                $('#teamForm')[0].submit();
            });
        });
    </script>
@endsection
