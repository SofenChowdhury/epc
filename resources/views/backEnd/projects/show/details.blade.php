@can('view Project Details')
    <div class="tab-pane active" id="personal" role="tabpanel">

        <div class="logo row" id="logo" style="display:none;">
            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
            </div>
            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }} Project Details</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                @if( isset($editData->project_name) )
                    <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }} ({{ $editData->project_code }}-00{{ $editData->project_phase }})</h5>
                @else
                    <h5 class="card-header-text">No Project Name</h5>
                @endif
                <br>
                <button class="btn btn-success printBtn" onclick="printDiv('personal')" style="float: right; padding: 0.4em;" target="_blank">Print Details</button>

                @if($editData->project_status != 'completed')
                    <a href="{{ url('project/nextPhase',$editData->id) }}" class="btn btn-success printBtn" style="float: right; padding: 0.4em; margin: 0 2em; color: white;">Add Next Phase </a>
                @endif

                @if($editData->contract_type == 1)
                    <a href="{{ url('project/createJV',$editData->id) }}" class="btn btn-success printBtn" style="float: right; padding: 0.4em; color: white;"> Add JV Party </a>
                @endif
            </div>
            <input name="project_id" id="project_id" value="{{ $editData->id }}" hidden>
            <input name="project_name" id="project_name" value="{{ $editData->project_name }}" hidden>
            @if(isset($editData))
                <div class="card-block">
                    <div class="view-info">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="general-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table m-0" style="table-layout: fixed; width: 100%">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Project Name</th>
                                                        @if( isset($editData->project_full_name) )
                                                            <th colspan="3">{{ $editData->project_full_name }}</th>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Project ID</th>
                                                        @if( isset($editData->project_code) )
                                                            <td>{{ $editData->project_code }}-00{{ $editData->project_phase }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Contract Type</th>
                                                        @if( isset($editData->contract_type) )
                                                            <td>
                                                                @if($editData->contract_type == 3)
                                                                    Lead
                                                                @elseif($editData->contract_type == 2)
                                                                    Subconsultant
                                                                @else
                                                                    Joint Venture
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    @if( isset($editData) && $editData->contract_type==1 )
                                                        <tr>
                                                            <th scope="row">EPC Lead</th>
                                                            <td style="color: blue;">
                                                                @if( $editData->epc_lead == 1)
                                                                    Local Lead
                                                                @elseif( $editData->epc_lead == 2)
                                                                    International Lead
                                                                @else
                                                                    None
                                                                @endif
                                                            </td>

                                                            <th scope="row">EPC Share Percentage</th>
                                                            <td style="color: red;"><b>{{ $editData->epc_share_percentage }}%</b></td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <th scope="row">Project Type</th>
                                                        @if( isset($editData->project_type))
                                                            <td>{{ $editData->project_type }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Project Component</th>
                                                        @if( isset($editData->project_component))
                                                            <td>{{ $editData->components->component_name }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Procuring Entity Name</th>
                                                        @if( isset($editData->procuring_entity))
                                                            <td>{{ $editData->procuring_entity }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Procurement Entity Code</th>
                                                        @if( isset($editData->procurement_entity_code))
                                                            <td>{{ $editData->procurement_entity_code }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Procurement Entity District </th>
                                                        @if( isset($editData->procuring_entity_district))
                                                            <td>{{ $editData->procuring_entity_district }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Procurement Method </th>
                                                        @if( isset($editData->procurement_method) )
                                                            <td>{{ $editData->procurement_method }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">EOI Submitted On </th>
                                                        @if( isset($editData->eoi_submission_date))
                                                            <td>{{ date('d F, Y', strtotime($editData->eoi_submission_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Source of Fund</th>
                                                        @if( isset($editData->funded_by))
                                                            <td>
                                                                <a href="{{ route('client.show',$editData->funded_by) }}" style="font-size: 1em; text-decoration: underline;">{{ $editData->funded->client_name }}</a>
                                                            </td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">EOI Reference No </th>
                                                        @if( isset($editData->eoi_reference))
                                                            <td>{{ $editData->eoi_reference }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">EOI Selection of </th>
                                                        @if( isset($editData->eoi_selection))
                                                            <td>{{ $editData->eoi_selection }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">RFP No </th>
                                                        @if( isset($editData->rfp_no))
                                                            <td>{{ $editData->rfp_no }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Method of Selection </th>
                                                        @if( isset($editData->selection_method))
                                                            <td>{{ $editData->selection_method }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Development Partners </th>
                                                        @if( isset($editData->development_partners))
                                                            <td colspan="3">{{ $editData->development_partners }}</td>
                                                        @else
                                                            <td colspan="3">N/A</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Programme Code </th>
                                                        @if( isset($editData->programme_code))
                                                            <td>{{ $editData->programme_code }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Programme Name </th>
                                                        @if( isset($editData->programme_name))
                                                            <td>{{ $editData->programme_name }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    @if($editData->project_phase == 2)
                                                        <tr>
                                                            <th scope="row">Proposal Meeting Place </th>
                                                            @if( isset($phase_detail->proposal_meeting_place))
                                                                <td>{{ $phase_detail->proposal_meeting_place }}</td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif

                                                            <th scope="row">Proposal Meeting Date </th>
                                                            @if( isset($phase_detail->meeting_date))
                                                                <td>{{ date('d-M-Y', strtotime($phase_detail->meeting_date)) . date('h:i A', strtotime($phase_detail->meeting_time)) }}</td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif
                                                        </tr>

                                                        @if( isset($phase_detail->proposal_validity))
                                                            <tr>
                                                                <th scope="row">Proposal Validity </th>
                                                                <td>
                                                                    {{ $phase_detail->proposal_validity }}
                                                                </td>
                                                            </tr>
                                                            <td colspan="2"></td>
                                                        @endif
                                                    @endif

                                                    <tr>
                                                        <th scope="row"> Phase Publication Date</th>
                                                        @if( isset($phase_detail) )
                                                            <td>{{ date('d-M-Y', strtotime( $phase_detail->phase_start_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Phase Submission Date</th>
                                                        @if( isset($phase_detail) )
                                                            <td>{{ date('d-M-Y', strtotime($phase_detail->phase_end_date)) }} {{ date('h:i A', strtotime($phase_detail->phase_end_time)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    @if( isset($phase_detail->meeting_place))
                                                        <tr>
                                                            <th scope="row">Meeting Place </th>
                                                            <td colspan="3">{{ $phase_detail->meeting_place }}</td>
                                                        </tr>
                                                    @endif

                                                    @if( isset($phase_detail->assign_name_1))
                                                        <tr>
                                                            <th scope="row">Assignment Name 1 </th>
                                                            <td>{{ $phase_detail->assign_name_1 }} </td>
                                                            <td colspan="3">{{ $phase_detail->assign_desc_1 }}</td>
                                                        </tr>
                                                    @endif

                                                    @if( isset($phase_detail->assign_name_2))
                                                        <tr>
                                                            <th scope="row">Assignment Name 2 </th>
                                                            <td>{{ $phase_detail->assign_name_2 }} </td>>
                                                            <td colspan="3">{{ $phase_detail->assign_desc_2 }}</td>
                                                        </tr>
                                                    @endif

                                                    @if( isset($phase_detail->assign_name_3))
                                                        <tr>
                                                            <th scope="row">Assignment Name 3</th>
                                                            <td>{{ $phase_detail->assign_name_3 }} </td>
                                                            <td colspan="3">{{ $phase_detail->assign_desc_3 }}</td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <th scope="row">Phase Remarks </th>
                                                        @if( isset($phase_detail->remark))
                                                            <td colspan="3">{{ $phase_detail->remark }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Client name</th>
                                                        @if( isset($editData->client_id))
                                                            <td>
                                                                <a href="{{ route('client.show',$editData->client_id) }}" style="font-size: 1em; text-decoration: underline;">{{ $editData->clients->client_name }}</a>
                                                            </td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Ministry</th>
                                                        @if( isset($editData->client_id))
                                                            <td>{{ $editData->clients->ministry }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Division</th>
                                                        @if( isset($editData->client_id))
                                                            <td>{{ $editData->clients->division }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Agency </th>
                                                        @if( isset($editData->client_id))
                                                            <td>{{ $editData->clients->agency }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Project Director</th>
                                                        @if( isset($users) && isset($editData->project_director))
                                                            @foreach($users as $user)
                                                                @if($user->id == $editData->project_director)
                                                                    <td>
                                                                        {{ $user->name }}
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Project Supervisor</th>
                                                        @if( isset($users) && isset($editData->project_lead))
                                                            @foreach($users as $user)
                                                                @if($user->id == $editData->project_lead)
                                                                    <td>
                                                                        {{ $user->name }}
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Project Status</th>
                                                        @if( isset($editData->project_status) )
                                                            <td style="color: blue;">{{ ucwords($editData->project_status) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Advertised In</th>
                                                        @if( isset($editData->project_source) )
                                                            <td>{{ $editData->project_source }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Project Commencement Date</th>
                                                        @if( isset($editData->project_start_date) )
                                                            <td>{{ date('d-M-Y', strtotime($editData->project_start_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Project Completion Date</th>
                                                        @if( isset($editData->project_due_date) )
                                                            <td>{{ date('d-M-Y', strtotime($editData->project_due_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Actual Contract Amount</th>
                                                        @if( isset($editData->project_amount) )
                                                            <td>৳ {{ number_format($editData->project_amount,2,".",",") }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Tax/ VAT Amount</th>
                                                        @if( isset($editData->tax_amount) )
                                                            <td>৳ {{ number_format($editData->tax_amount,2,".",",") }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row"> Contract Amount After Tax/ VAT</th>
                                                        @if( isset($editData->amount_after_tax) )
                                                            <td>৳ {{ number_format($editData->amount_after_tax,2,".",",") }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Tax/ VAT Paid By</th>
                                                        @if( isset($editData->tax_by) )
                                                            <td>{{ $editData->tax_by }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row"> Name of Official</th>
                                                        @if( isset($editData->contact_person) )
                                                            <td>{{ $editData->contact_person }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th lass="fontSize" scope="row">Designation of Official</th>
                                                        @if( isset($editData->designation) )
                                                            <td>{{ $editData->designation }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Email of Official</th>
                                                        @if( isset($editData->contact_person_email) )
                                                            <td>{{ $editData->contact_person_email }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Phone Number of Official</th>
                                                        @if( isset($editData->contact_person_phone) )
                                                            <td>{{ $editData->contact_person_phone }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Address of Official</th>
                                                        @if( isset($editData->contact_person_address) )
                                                            <td colspan="3"> {{ $editData->contact_person_address }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Execution Authority</th>
                                                        @if( isset($editData->execution_authority) )
                                                            <td>{{ $editData->execution_authority }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Project Added By</th>
                                                        @if( isset($editData->created_by) )
                                                            <td>
                                                                @foreach($users as $user)
                                                                    @if( $editData->created_by == $user->id )
                                                                        {{$user->name}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Time for Study and Reporting</th>
                                                        @if( isset($editData->study_time) )
                                                            <td colspan="3" style="white-space: normal">{{ $editData->study_time }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Brief Description</th>
                                                        @if( isset($editData->description) )
                                                            <td colspan="3">{{ $editData->description }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Experience, Resources Required</th>
                                                        @if( isset($editData->description_2) )
                                                            <td colspan="3">{{ $editData->description_2 }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Association with other local/ foreign firm</th>
                                                        @if( isset($editData->association) )
                                                            <td colspan="3">{{ $editData->association }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($editData->contract_type == 1)
            @if(isset($editData->joint_ventures))
                @php $i = 1 @endphp
                @foreach( $editData->joint_ventures as $joint_venture)
                    <div class="card">
                        <div class="card-header">
                            <h5  style="font-size: 0.8rem;">
                                JV Party {{ $i++ }} . {{ $joint_venture->jv_name }} ( Percentage of Share: <b style="color: darkred;"> {{ $joint_venture->share_percentage }}% </b> )
                            </h5>
                            <a href="{{ url('project/editJV',$joint_venture->id) }}" style="float: right; padding: 0.4em; color: white;" class="btn btn-success printBtn"> Edit Joint Venture </a>
                        </div>
                        <div class="card-block">
                            <div class="view-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <tbody>
                                                            <tr>
                                                                @if( $joint_venture->jv_leading !=0 )
                                                                    <th class="fontSize" scope="row" style="font-size: 1.2em;">Lead</th>
                                                                    <td colspan="3" style="color: blue;">
                                                                        @if( $joint_venture->jv_leading == 1)
                                                                            Local Lead
                                                                        @elseif( $joint_venture->jv_leading == 2)
                                                                            International Lead
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                            </tr>

                                                            <tr>
                                                                <th lass="fontSize" scope="row">Contact Person Name</th>
                                                                @if( isset($joint_venture->contact_person) )
                                                                    <td>{{ $joint_venture->contact_person }}</td>
                                                                @else
                                                                    <td>No input given</td>
                                                                @endif

                                                                <th lass="fontSize" scope="row">Designation</th>
                                                                @if( isset($joint_venture->designation) )
                                                                    <td>{{ $joint_venture->designation }}</td>
                                                                @else
                                                                    <td>No input given</td>
                                                                @endif
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                @if( isset($joint_venture->email) )
                                                                    <td>{{ $joint_venture->email }}</td>
                                                                @else
                                                                    <td>No input given</td>
                                                                @endif

                                                                <th scope="row">Phone Number</th>
                                                                @if( isset($joint_venture->phone_number) )
                                                                    <td>{{ $joint_venture->phone_number }}</td>
                                                                @else
                                                                    <td>No input given</td>
                                                                @endif
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Address</th>
                                                                @if( isset($joint_venture->address) )
                                                                    <td colspan="3"> {{ $joint_venture->address }}</td>
                                                                @else
                                                                    <td colspan="3">No input given</td>
                                                                @endif
                                                            </tr>

                                                            <tr>
                                                                @if( isset($joint_venture->remarks) )
                                                                    <th scope="row">Remark</th>
                                                                    <td colspan="3"> {{ $joint_venture->remarks }}</td>
                                                                @endif
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif

        <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
            <div class="row">
                <div class="col">
                    <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"> </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printDiv(personal)
        {
            console.log('here');
            $('.printBtn').hide();
            $('.back_btn').hide();
            $('.logo').show();
            $('.footer').show();
            // document.getElementById('logo').style.display = "block";
            // document.getElementById('footer').style.display = "block";
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(personal).innerHTML;
            var project_id = document.getElementById('project_id').value;
            var project_name = document.getElementById('project_name').value;
            document.body.innerHTML = printContents;
            document.title=project_name + ' Details';
            window.print();
            window.location.href = "/epc/project/"+project_id;
        }
    </script>
@endcan
