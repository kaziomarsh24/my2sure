@extends('admin.layout')
@section('title','Edit Games')
@push('styles')

    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="css/table-responsive.css" rel="stylesheet">
@endpush
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> {{ $pageTitle   }} - Game</h3>

            <div class="row mt">

                <div class="col-lg-12">
                    <div class="content-panel  col-md-12">
                        <h4> {{ $pageTitle   }}</h4>
                        <hr/>
                        <form action="{{route('admin.games.update' , ['game' => $objData->id])}}" method="POST"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" value="{{$objData->name}}" class="form-control" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">In-Active</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>End Date</label>
                                <input type="date" value="{{date('Y-m-d',strtotime($objData->end_date))}}"
                                       class="form-control" name="end_date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Details</label>
                                <input type="text" value="{{$objData->details}}" class="form-control" name="details"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Game Logo</label>
                                <input type="file" class="form-control" name="logo">
                            </div>
                            <div class="form-group col-md-6">
                                <img height="200" width="200" src="{{asset('uploads/'.$objData->logo)}}">
                            </div>

                            <div class="form-group col-md-12 pull-right ">
                                <input type="submit" value="SUBMIT" class="btn btn-lg btn-success pull-right">
                            </div>
                        </form>
                    </div>

                    <div class="content-panel  col-md-12"
                    style="max-width: 100%; overflow-x: scroll;">

                        <div class="col-md-12">
                            <h1>Game Schedule</h1>
                            <div class="p-4 mb-3">
                                <label for="initialStartTime">Initial Start Time:
                                    <span id="startDisplay">00:00</span></label>


                                <label for="slotDuration">Slot Duration:</label>
                                <select id="slotDuration" class="form-control d-inline" style="max-width: 100px; display: inline;">
                                </select>

                                <button id="addSlotButton" class="btn btn-primary" disabled onclick="addSlot()">Add Slot</button>
                                <!-- Generate schedule button -->
                                <button id="generateButton" class="btn btn-primary"
                                         onclick="generateSchedule()">
                                    Update Schedule
                                </button>

                                <button class="btn btn-primary" onclick="resetSchedule()">Reset Schedule</button>
                            </div>
                            <br>
                            <br>
                            <table class="table tabls-sm">
                                <thead>
                                <tr>
                                    <th>Start Time</th>
                                    <th>Slot Duration</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Rows will be added dynamically using JavaScript -->
                                </tbody>
                            </table>
                            <!-- Display the result -->
                            <div id="result"></div>
                        </div>

                    </div>
                    <!-- /content-panel -->
                </div>
                <!-- /col-lg-12 -->
            </div>
            <!-- /row -->
        </section>
        <!-- /wrapper -->
    </section>
    <script>

        let totalDuration = 0;
        let remainingTime = 1440; // 24 hours in minutes;
        let previousEndTime = 0;
        let selectedDuration = 0; // Store the selected duration

        function updateSlotDurationOptions() {
            const slotDurationSelect = document.getElementById('slotDuration');
            slotDurationSelect.innerHTML = '';

            const maxAllowedDuration = Math.min(remainingTime / 60, 24 - totalDuration);
            for (let i = 1; i <= maxAllowedDuration; i++) {
                const endTime = calculateEndTime(i);
                slotDurationSelect.innerHTML += `<option value="${i}">${endTime}</option>`;
            }
        }

        function calculateEndTime(duration) {
            const endTimeHours = Math.floor(previousEndTime / 60) + Math.floor(duration);
            const endTimeMinutes = previousEndTime % 60 + (duration % 1) * 60;

            const formattedEndTime = `${endTimeHours < 10 ? '0' : ''}${endTimeHours}:${endTimeMinutes < 10 ? '0' : ''}${endTimeMinutes}`;
            return formattedEndTime;
        }

        function addSlot() {
            selectedDuration = parseInt(document.getElementById('slotDuration').value);
            if (totalDuration + selectedDuration > 24) {
                alert('Total duration cannot exceed 24 hours.');
                return;
            }

            const newRow = document.createElement('tr');
            const slotId = totalDuration;

            let startTimeHours;
            let startTimeMinutes;
            if (slotId === 0) {
                const initialStartTime = document.getElementById('startDisplay').textContent;
                startTimeHours = parseInt(initialStartTime.split(':')[0]);
                startTimeMinutes = parseInt(initialStartTime.split(':')[1]);
            } else {
                startTimeHours = Math.floor(previousEndTime / 60);
                startTimeMinutes = previousEndTime % 60;
            }

            const formattedStartTime = `${startTimeHours < 10 ? '0' : ''}${startTimeHours}:${startTimeMinutes < 10 ? '0' : ''}${startTimeMinutes + 1}`;
            document.getElementById('startDisplay').textContent = calculateEndTime(selectedDuration);

            const startTimeCell = document.createElement('td');
            startTimeCell.textContent = formattedStartTime;
            newRow.appendChild(startTimeCell);

            const slotDurationCell = document.createElement('td');
            const endTime = calculateEndTime(selectedDuration);
            slotDurationCell.textContent = endTime;
            newRow.appendChild(slotDurationCell);

            for (let i = 0; i < 7; i++) {
                const day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][i];
                const inputCell = document.createElement('td');
                inputCell.innerHTML = `<input type="text" id="${day}_${slotId}" placeholder="Enter Game Name" class="form-control">`;
                newRow.appendChild(inputCell);
            }

            document.querySelector('tbody').appendChild(newRow);

            totalDuration += selectedDuration;
            remainingTime -= selectedDuration * 60;
            previousEndTime = startTimeHours * 60 + startTimeMinutes + selectedDuration * 60;

            if (totalDuration === 24) {
                document.getElementById('generateButton').style.display = 'block';
                document.getElementById('addSlotButton').style.display = 'none';
                document.getElementById('slotDuration').style.display = 'none';
            }

            updateSlotDurationOptions();
        }

        function generateSchedule() {
            const schedule = [];

            const tableBody = document.querySelector('tbody');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');

                const startTime = cells[0].textContent;
                const endTime = cells[1].textContent;

                const timeslot = {
                    startTime: startTime,
                    endTime: endTime,
                    days: {}
                };

                for (let i = 2; i < cells.length; i++) {
                    const day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][i - 2];
                    const input = cells[i].querySelector('input');
                    timeslot.days[day] = input.value;
                }

                schedule.push(timeslot);
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            route= `{{route('admin.save_schedule')}}`;
            $.ajax({

                type:"POST",
                url:route,
                data:{
                    game_id:`{{$objData->id}}`,
                    schedule:schedule,
                },
                // dataType: 'json',
                success: function(data) {
                if(data.trim() == 'true'){
                    alert("Game Schedule Updated Successfully");

                }else {
                    alert("Failed to Updated Schedule");
                }

                }
            });



        }

        updateSlotDurationOptions();
        document.getElementById('slotDuration').addEventListener('change', () => {
            const selectedDuration = parseInt(document.getElementById('slotDuration').value);
            document.getElementById('addSlotButton').disabled = isNaN(selectedDuration) || selectedDuration <= 0;
        });


        function generateTableFromData(scheduleData) {
            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = ''; // Clear existing table rows

            scheduleData.forEach(timeslot => {
                const newRow = document.createElement('tr');

                const startTimeCell = document.createElement('td');
                startTimeCell.textContent = timeslot.startTime;
                newRow.appendChild(startTimeCell);

                const slotDurationCell = document.createElement('td');
                slotDurationCell.textContent = timeslot.endTime;
                newRow.appendChild(slotDurationCell);

                for (const day in timeslot.days) {
                    if (timeslot.days.hasOwnProperty(day)) {
                        const inputCell = document.createElement('td');
                        inputCell.innerHTML = `<input type="text" value="${timeslot.days[day]}" id="${day}_${timeslot.startTime.replace(':', '')}">`;
                        newRow.appendChild(inputCell);
                    }
                }

                tableBody.appendChild(newRow);
            });
        }

        function resetSchedule() {
            totalDuration = 0;
            remainingTime = 1440;
            previousEndTime = 0;
            selectedDuration = 0;

            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = '';

            document.getElementById('startDisplay').textContent = '00:00';
            document.getElementById('addSlotButton').style.display = 'inline-block';
            // document.getElementById('generateButton').style.display = 'none';
            document.getElementById('slotDuration').style.display = 'inline-block';

            updateSlotDurationOptions();
            document.getElementById('addSlotButton').disabled = true;

            document.getElementById('result').innerText = '';
        }



        data=`{{$objData->schedule}}`;
        const decodedData = data.replace(/&quot;/g, '"');
        const jsonData = JSON.parse(decodedData);
        if(data.length>0) {generateTableFromData(jsonData)}


    </script>
@endsection

@push('script')

@endpush
