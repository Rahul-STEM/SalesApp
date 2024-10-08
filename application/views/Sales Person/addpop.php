<span?php $uid=$user['user_id']; date_default_timezone_set("Asia/Kolkata"); ?>
    <div id="add_note" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div id="moshow" class="modal-body">
                    <div class="card row m-2">
                        <div class="col-12 col-md-12" id="new_reserach1">
                            <div class="card-header bg-info">Task Detail</div>
                            <div class="card-body">
                                Current Task : <lable id="ctname"></lable><br>
                                Last Status : <lable id="clsname"></lable><br>
                                Last Task Remark : <lable id="cremarks"></lable><br>
                                <!-- Last Task Remark : <lable id="cremarks"></lable> -->
                                Task Assigned By : <lable id="assignedBy"></lable><br>
                                Task Assigned To : <lable id="assigneTo"></lable>
                            </div>
                        </div>
                    </div>
                    <div class="card row m-2">
                        <div class="col-12 col-md-12" id="new_reserach2">
                            <input type="hidden" value="" id="test">
                            <a href="" target="_blank" id="cmplink">
                                <div class="card-header bg-info">
                                    <lable id="cname"></lable>
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="col-sm">Name : <lable id="cp"></lable>
                                </div>
                                <div class="col-sm">Designation : <lable id="designation"></lable>
                                </div>
                                <div class="col-sm">Phone No : <lable id="phoneno"></lable>
                                </div>
                                <div class="col-sm">Email id : <lable id="emailid"></lable>
                                </div>
                                <span>
                                    <a id="clink" href="" target="_blank" style="padding:7px;border-radius:20px;">
                                        <img src="https://stemlearning.in/opp/assets/image/icon/call.png"
                                            style="height:30px;"></a>
                                    <a id="wlink" href="" target="_blank" style="padding:7px;border-radius:20px;">
                                        <img src="https://stemlearning.in/opp/assets/image/icon/whatsapp.png"
                                            style="height:30px;"></a>
                                    <a id="glink" href="" target="_blank" style="padding:7px;border-radius:20px;">
                                        <img src="https://mailmeteor.com/logos/assets/PNG/Gmail_Logo_512px.png"
                                            style="height:20px;"></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card row m-2" id="taskbox">
                        <div class="col-12 col-md-12">
                            <div class="card-header bg-info">
                                <div>
                                    <p id="reaserch_message" class="mt-3 text-white"></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url(); ?>Menu/submittask1" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="ccstatus" id="cstatus">
                                    <input type="hidden" name="action_id" id="action_id">
                                    <input type="hidden" name="uid" value="<?= $uid ?>">
                                    <input type="hidden" name="cmpid" id="cmpid" value="">
                                    <input type="hidden" name="tid" id="tidd" value="">

                                    <div class="text-center">
                                        <span><b>Action Completed?</b></span>
                                        <input type="radio" id="pending" name="actontaken" Value="yes"
                                            onclick="disableOtherRadioButtons('option')">
                                        <label for="pending">YES</label>
                                        <input type="radio" id="resolved" name="actontaken" Value="no"
                                            onclick="disableOtherRadioButtons('option')">
                                        <label for="resolved">NO</label>
                                    </div>
                                    <div class="p-3" id="test1" style="display: none;">
                                    </div>
                                    <div class="p-3" id="test2" style="display: none;">
                                        <span><b>Email Send?</b></span>
                                        <input type="radio" id="yes" name="meeting" Value="yes">
                                        <label for="yes">YES</label>
                                        <input type="radio" id="no" name="meeting" Value="no">
                                        <label for="no">NO</label>
                                        <hr>
                                    </div>
                                    <div class="p-3" id="test3" style="display: none;">
                                        <label>Attach Meeting Photo</label>
                                    </div>
                                    <div class="p-3" id="test5" style="display: none;">
                                        <label>Attach Whatsapp Media</label>
                                        <input type="file" class="form-control-file" name="filname1" required>
                                        <textarea type="text" class="form-control" placeholder="Remark"
                                            required></textarea>
                                    </div>


                                    <!-- Start Meeting Form -->

                                    <div class="p-3 write_mom_section" id="test6" style="display: none;">
                                        <div class="text-center momhbox">
                                            <div> <label> <i>MINUTES OF MEETING (MoM)</i> </label>
                                                <!-- <hr style="width:200px;"> -->
                                            </div>
                                        </div>

                                        <label>Meeting done with Initiator or influencer and decision maker of the
                                            company</label>
                                        <select class="form-control" name="meetingdonewinitiator">
                                            <option value="Initiator">Initiator</option>
                                            <option value="Influencer">Influencer</option>
                                            <option value="Decision maker">Decision maker</option>
                                        </select>
                                        <hr>
                                        <label>Presentation and pitching is done for which offering :</label>
                                        <select class="form-control" name="presentation[]" multiple>
                                            <option value="MSC">MSC</option>
                                            <option value="Tinkering">Tinkering</option>
                                            <option value="Bala">Bala</option>
                                            <option value="Astronomy">Astronomy</option>
                                            <option value="DIY">DIY</option>
                                            <option value="NSP">NSP</option>
                                            <option value="Science Lab">Science Lab</option>
                                            <option value="Smart Class">Smart Class</option>
                                        </select>
                                        <hr>
                                        <input type="hidden" name="momdata" value="momdata">

                                        <div>
                                            <label>What is the client's thematic Area for Project Intervention in the
                                                current financial Year</label>
                                            <select class="form-control" id="project_intervention_select"
                                                name="project_intervention_select">
                                                <option value="Education">Education</option>
                                                <option value="Health">Health</option>
                                                <option value="Nutrition">Nutrition</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            <br>
                                            <input type="text" class="form-control" name="project_intervention"
                                                id="project_interventionText"
                                                placeholder="Please add client's thematic Area for Project Intervention in the current financial Year">
                                        </div>
                                        <hr>
                                        <div>
                                            <label>Does the client has adopted any schools ?</label>
                                            <select class="form-control" id="client_has_adopted_select" required
                                                name="client_has_adopted_select">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                            <br>
                                            <textarea type="text" class="form-control" name="client_has_adopted"
                                                placeholder="Please specify details of the schools that client has adopted"
                                                id="client_has_adoptedText" rows="3"></textarea>
                                        </div>

                                        <hr>
                                        <div>
                                            <label>Who are the approving autorities of the proposal ?</label>
                                            <textarea required class="form-control" name="approving_autorities"
                                                placeholder="Please type name and designation of the officer approving the proposal"></textarea>
                                        </div>

                                        <hr>
                                        <div>
                                            <label>What is the left over budget for the current financial year ?</label>
                                            <input type="number" required class="form-control" name="budget_for_cfyear"
                                                placeholder="Please Type budget for the current financial year">
                                        </div>

                                        <hr>
                                        <div>
                                            <label>what is the fund sanction limit at their level ?</label>
                                            <input type="number" required class="form-control"
                                                name="fund_sanstion_limit"
                                                placeholder="Please Type fund sanction limit at their level">
                                        </div>

                                        <hr>
                                        <div>
                                            <label>Any other specific remarks regards to the meeting ?</label>
                                            <textarea type="text" required class="form-control"
                                                name="other_specific_remarks"
                                                placeholder="specific remarks regards to the meeting"
                                                rows="3"></textarea>
                                        </div>

                                        <hr>
                                        <div>
                                            <label>Do we need to submit the proposal ?</label>
                                            <select class="form-control" required name="submit_proposal"
                                                id="submit_proposal_select">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                            <br>
                                            <!-- <input type="file" required class="form-control" id="submit_proposal_file" name="submit_proposal_file" placeholder="submit the proposal">
                    <small class="text-danger" id="smallProposaltext" > <i>* Proposal should be submitted through NGO/STEM/Govt Body (No of Schools/Location/Budget)</i></small> -->

                                            <div id="submit_proposal_file" class="identify_school_box">
                                                <input type="text" required class="form-control"
                                                    name="proposal_no_of_school"
                                                    placeholder="Proposed number of schools"> <br>
                                                <input type="text" required class="form-control"
                                                    name="proposal_of_budget" placeholder="Proposed budget"><br>
                                                <input type="text" required class="form-control"
                                                    name="proposal_of_location" placeholder="Proposed location"><br>

                                            </div>

                                        </div>

                                        <hr>
                                        <div>
                                            <label>Do we need to identify school ?</label>
                                            <select class="form-control" required name="identify_school"
                                                id="identify_school_select">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>

                                            <br>
                                            <div id="identify_school_box" class="identify_school_box">
                                                <div class="text-right mb-2">
                                                    <span id="add_field" class="p-2 bg-primary">+</span>
                                                </div>
                                                <input type="text" required class="form-control"
                                                    name="identify_school_state[]" placeholder="Enter Name of State">
                                                <br>
                                                <input type="text" required class="form-control"
                                                    name="identify_school_district[]"
                                                    placeholder="Enter Name of District"><br>
                                                <input type="text" required class="form-control" name="no_of_school[]"
                                                    placeholder="Enter No of School">

                                            </div>

                                        </div>

                                        <hr>
                                        <div>
                                            <label>School permission letter required ?</label>
                                            <select class="form-control" required name="permission_letter"
                                                id="permission_letter_select">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                        </div>

                                        <hr>
                                        <div>

                                            <div id="permission_letter_box" class="identify_school_box">
                                                <label>Letter should be address to whom in the organization, along with
                                                    Name and designation and Location</label>

                                                <select class="form-control" required name="permission_letter_rech">
                                                    <option value="NGO">NGO</option>
                                                    <option value="STEM">STEM</option>
                                                </select>
                                                <br>

                                                <input type="text" required class="form-control"
                                                    name="Letter_organization_name"
                                                    placeholder="Add Concern person name"> <br>
                                                <input type="text" required class="form-control"
                                                    name="Letter_organization_designation"
                                                    placeholder="Enter Name of Designation"><br>
                                                <input type="text" required class="form-control"
                                                    name="Letter_organization_location" placeholder="Enter Location">
                                            </div>
                                        </div>

                                        <hr>
                                        <div>
                                            <label>Client is interested for School Visit ?</label>
                                            <select class="form-control" required name="client_int_school_visit"
                                                id="client_int_school_select">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                            <br>
                                            <div id="client_int_school_box" class="identify_school_box">

                                                <!-- <input type="text" required class="form-control"name="client_int_type_project" placeholder="Add type of project"> -->
                                                <option value="MSC">MSC</option>
                                                <option value="Tinkering">Tinkering</option>
                                                <option value="Bala">Bala</option>
                                                <option value="Astronomy">Astronomy</option>
                                                <option value="DIY">DIY</option>
                                                <option value="NSP">NSP</option>
                                                <option value="Science Lab">Science Lab</option>
                                                <option value="Smart Class">Smart Class</option>
                                                </select>
                                                <br>
                                                <input type="date" required class="form-control"
                                                    name="client_int_school_date" placeholder="Select Date"> <br>
                                                <input type="text" required class="form-control"
                                                    name="client_int_school_state" placeholder="Enter State"> <br>
                                                <input type="text" required class="form-control"
                                                    name="client_int_school_district"
                                                    placeholder="Enter Name of District"><br>
                                            </div>

                                        </div>
                                        <hr>
                                        <div>
                                            <label>Do you need intervention from Cluster/PST/ Sales Head ?</label>
                                            <select class="form-control" required name="intervention_cm_pst_sh"
                                                id="client_int_school_select">
                                                <option value="Cluster">Cluster</option>
                                                <option value="PST">PST</option>
                                                <option value="Sales Head">Sales Head</option>
                                            </select>
                                        </div>

                                        <hr>
                                        <label>Write Short MOM Remarks</label>
                                        <textarea type="text" class="form-control" id="rpmmom" name="rpmmom" rows="3"
                                            required></textarea>
                                    </div>
                                    <!-- End Meeting Form -->

                            </div>

                            <div class="p-3" id="test8" style="display: none;">
                                <label>Social Networking</label>
                                <input type="text" class="form-control" name="LinkedIn"
                                    placeholder="LinkedIn Profile Link">
                                <input type="text" class="form-control" name="Facebook"
                                    placeholder="Facebook Profile Link">
                                <input type="text" class="form-control" name="YouTube"
                                    placeholder="YouTube Profile Link">
                                <input type="text" class="form-control" name="Instagram"
                                    placeholder="Instagram Profile Link">
                                <input type="text" class="form-control" name="OtherSocial"
                                    placeholder="Other Social Media Profile Link">
                            </div>

                            <div class="p-3" id="test9" style="display: none;">
                                <label>Social Activity</label>
                                <label>Attach Social Media Post Screenshot</label>
                                <input type="file" class="form-control-file" name="filname2" required>
                                <textarea type="text" class="form-control" placeholder="Remark" required></textarea>
                            </div>

                            <div class="p-3" id="test7" style="display: none;">
                                <label>Proposal Detail</label>
                                <select class="form-control" name="partner" required>
                                    <option>NGO</option>
                                    <option>STEM</option>
                                    <option>Govt</option>
                                </select>
                                <input type="number" class="form-control" name="noofsc" placeholder="No of Schools"
                                    min="1" required>
                                <input type="number" class="form-control" name="pbudgetme" min="1" step="0.01"
                                    placeholder="Proposal Budget" required>
                                <label>Attach Proposal</label>
                                <input type="file" class="form-control-file" name="filname" required>
                            </div>
                            <div id="noremark" class="text-center">
                                <textarea type="text" class="form-control" id="norek" name="noremark"
                                    placeholder="Remark" required></textarea>
                            </div>
                            <div id="purpose" class="text-center">
                                Current Task Purpose : <h6 id="cpurpose"></h6>
                                <span><b>Purpose Completed?</b></span>
                                <input type="radio" id="presolved" name="purpose" Value="yes"
                                    onclick="disableOtherRadioButtons('option')">
                                <label for="pending">YES</label>
                                <input type="radio" id="pnresolved" name="purpose" Value="no"
                                    onclick="disableOtherRadioButtons('option')">
                                <label for="resolved">NO</label>
                                <hr>
                            </div>

                            <div id="ifyes" style="display:none">
                                <div class="col-12 col-md-12 mb-3" id="new_reserach3">
                                    <label for="validationSample04">Next Status</label>
                                    <select type="text" class="form-control" name="ystatus" placeholder="State"
                                        id="ystatus" required>
                                    </select>
                                </div>
                                <div class="col-12 col-md-12 mb-12" id="new_reserach4">
                                    <label for="remark_msg">Remarks</label>
                                    <textarea type="text" class="form-control" name="yremark_msg" id="remark_msg"
                                        required></textarea>
                                    <div class="invalid-feedback">.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <p id="reaserch_message1" class="mt-3 p-2"></p>
                            </div>

                            <div id="ifno" style="display:none">
                                <input type="hidden" name="yaction_id" id="yaction_id">
                                <div class="col-12 col-md-12 mb-3">
                                    <label for="validationSample04">Remarks</label>
                                    <select type="text" class="form-control" id="tremark" placeholder="Remarks"
                                        required>
                                    </select>
                                </div>
                                <div class="col-12 col-md-12 mb-12">
                                    <label for="remark_msg">Remarks</label>
                                    <textarea type="text" class="form-control" id="re_mark" name="nremark_msg"
                                        readonly></textarea>
                                    <div class="invalid-feedback">.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-12 col-md-12 mb-12">
                                    <label>Next Action Date</label>
                                    <input type="date" class="form-control" name='nadate' required>
                                    <div class="invalid-feedback">.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" id="taskbtn">
                    <button type="submit" class="btn btn-primary mt-3" id="button"
                        onclick="this.form.submit();">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div> <!-- // END .modal-body -->

    </div>
    </div>
    </div>
    <!-- User details -->
    <div id="add_bim" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="card card-form col-md-12">
                        <div class="card-header bg-info text-center"><b>Create Barg in Meeting</b></div>
                        <div class="row no-gutters">
                            <div class="card-body">
                                <?= form_open('Menu/cbmeeting') ?>
                                <select id="bcytpe" name="bcytpe" class="form-control mt-2">
                                    <option value="">Select Bargin Company Type</option>
                                    <option>From Funnel</option>
                                    <option>Other</option>
                                </select>
                                <div id="bboxa" style="display: none;">
                                    <!--<input list="bcname" name="bcid" class="form-control mt-2" type="text">-->
                                    <!--<datalist id="bcname">-->
                                    <!--    <option value="">Select Company Name</option>-->
                                    <!--    <?php //$bdc=$this->Menu_model->get_cmpbybd($uid); -->
                                    //foreach($bdc as $bc){ ?>
                    <!--    <option value="<?= $bc->id ?>"><?= $bc->compname ?></option>-->
                                    <?php //} ?>
                                    <!--</datalist>-->
                                    <br>
                                    <select id="bcname" class="select2" class="form-control mt-2" name="bcid">
                                        <option value="">Select Company Name</option>
                                        <?php $bdc = $this->Menu_model->get_cmpbybd($uid);
                                        foreach ($bdc as $bc): ?>
                                            <option value="<?= $bc->id ?>"><?= $bc->compname . '/' . $bc->id ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="bboxb" style="display: none;">
                                    <lable>Meeting Location</lable>
                                    <select id="mbolocation" class="form-control mt-2">
                                        <option value="">Select Meeting Location</option>
                                        <option>Base Location</option>
                                        <option>Out Station</option>
                                    </select>
                                </div>
                                <div id="bboxc" style="display: none;">
                                    <select id="bstate" name="bstate" class="form-control mt-2">
                                        <option value="">Select State</option>
                                        <?php $state = $this->Menu_model->get_states();
                                        foreach ($state as $st) { ?>
                                            <option value="<?= $st->id ?>"><?= $st->state ?></option>
                                        <?php } ?>
                                    </select>
                                    <select id="bcity" name="bcity" class="form-control mt-2">
                                    </select>
                                </div>
                                <div class="form-control mt-2"><span><b>Plan Instant or Later?</b></span>
                                    <input type="radio" id="Instant" name="piorl" Value="Instant">
                                    <label for="Instant">Instant</label>
                                    <input type="radio" id="Later" name="piorl" Value="Later">
                                    <label for="Later">Later</label>
                                </div>
                                <div id="laterbox" style="display:none">
                                    <input type="datetime-local" name="bmdate" class="form-control mt-2"
                                        value="<?= date('Y-m-d H:i:s') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"
                                onclick="this.form.submit(); this.disabled = true;">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- // END .modal-body -->
    </div>
    </div>
    </div>

    <div id="Add_TPlan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="card card-form col-md-12">
                        <div class="card-header bg-info text-center"><b>Outstation Travel Plan</b></div>
                        <div class="row no-gutters">
                            <div class="card-body">
                                <?= form_open('Menu/cbmeeting') ?>
                                <input type="datetime-local" name="tpsdate" class="form-control mt-2">
                                <input type="datetime-local" name="tpedate" class="form-control mt-2">
                                <lable>How Many Location</lable>
                                <input type="number" name="tphmlocation" id="tphmlocation" class="form-control mt-2">
                                <hr>
                                <div id="tpscity" class="p-1">
                                    <div id="scload">
                                        <div id="headshow"></div>
                                        <select id="tpstate" name="tpstate" class="form-control mt-2">
                                            <option value="">Select State</option>
                                            <?php $state = $this->Menu_model->get_states();
                                            foreach ($state as $st) { ?>
                                                <option value="<?= $st->id ?>"><?= $st->state ?></option>
                                            <?php } ?>
                                        </select>
                                        <select id="tpcity" name="tpcity" class="form-control mt-2">
                                        </select>
                                        <lable>How Many Bargin</lable>
                                        <input type="number" name="tphmlocation" id="tphmlocation"
                                            class="form-control mt-2">
                                        <hr>
                                    </div>
                                </div>
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="heading1">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#tpcollapse1" aria-expanded="true"
                                                    aria-controls="tpcollapse1">
                                                    TYPE OF EXPENSES : Train
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="tpcollapse1" class="collapse show" aria-labelledby="heading1"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading2">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse2"
                                                    aria-expanded="false" aria-controls="tpcollapse2">
                                                    TYPE OF EXPENSES : Taxi
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse2" class="collapse" aria-labelledby="heading2"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading3">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse3"
                                                    aria-expanded="false" aria-controls="tpcollapse3">
                                                    CTYPE OF EXPENSES : Bus
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse3" class="collapse" aria-labelledby="heading3"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading4">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse4"
                                                    aria-expanded="false" aria-controls="tpcollapse4">
                                                    CTYPE OF EXPENSES : Tender Amount
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse4" class="collapse" aria-labelledby="heading4"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse5"
                                                    aria-expanded="false" aria-controls="tpcollapse5">
                                                    CTYPE OF EXPENSES : Ground Transportation
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse5" class="collapse" aria-labelledby="heading5"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse6"
                                                    aria-expanded="false" aria-controls="tpcollapse6">
                                                    CTYPE OF EXPENSES : Lodging
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse6" class="collapse" aria-labelledby="heading6"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse7"
                                                    aria-expanded="false" aria-controls="tpcollapse7">
                                                    CTYPE OF EXPENSES : Food
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse7" class="collapse" aria-labelledby="heading7"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading8">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#tpcollapse8"
                                                    aria-expanded="false" aria-controls="tpcollapse8">
                                                    CTYPE OF EXPENSES : Miscellaneious
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="tpcollapse8" class="collapse" aria-labelledby="heading8"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <input type="text" class="form-control"
                                                    placeholder="DESCRIPTION OF EXPENSES">
                                                <input type="text" class="form-control" placeholder="DAILY EXPENSES">
                                                <input type="text" class="form-control" placeholder="NO OF DAYS">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"
                                onclick="this.form.submit(); this.disabled = true;">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- // END .modal-body -->
    </div>
    </div>
    </div>



    <!-- User details -->
    <div id="add_contact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="card card-form col-md-12">
                        <div class="row no-gutters">
                            <div class="col-lg-12 card-form__body card-body">

                                <div>
                                    <center>
                                        <h5>Add Contact Detail</h5>
                                    </center>
                                    <hr>
                                    <?= form_open('Menu/addcont') ?>
                                    <input type="hidden" id="sid" name="sid">
                                    <input type="hidden" name="uid" value="<?= $uid ?>">
                                    <input type="text" name="contact_name" class="form-control p-3 mt-2"
                                        placeholder="Name">
                                    <input type="text" name="designation" class="form-control  p-3  mt-2"
                                        placeholder="Designation">
                                    <input type="text" name="contact_no" class="form-control  p-3  mt-2"
                                        placeholder="Contact No">
                                    <input type="text" name="email" class="form-control  p-3  mt-2" placeholder="Email">
                                    <button type="submit" class="btn btn-primary mt-3"
                                        onclick="this.form.submit(); this.disabled = true;">Submit</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- // END .modal-body -->

            </div>
        </div>
    </div>
    <!-- User details -->
    <div id="doaction" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="card card-form col-md-12">
                        <div class="card-header bg-info">Create Plan</div>
                        <h6 class="text-center mt-1" id="cmpname"></h6>
                        <div class="col-lg-12 card-body">
                            <?php $today = date('Y-m-d H:i:s'); ?>
                            <?= form_open('Menu/dateplan') ?>
                            <input type="hidden" name="uid" id="uid" value="<?= $uid ?>">
                            <input type="hidden" id="taskid" name="taskid">
                            <lable>Select Date Time</lable>
                            <input type="datetime-local" name="date" id="date" class="form-control p-3 mt-2 mb-2"
                                placeholder="Date" min="<?= $today ?>" value="<?= $today ?>">
                            <div id="dateremaek"></div>
                            <button type="submit" id="planbtn" class="btn btn-primary mt-3"
                                onclick="this.form.submit(); this.disabled = true;">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- // END .modal-body -->

    </div>
    </div>
    </div>




    <div id="add_startm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="card card-form col-md-12">
                        <div class="row no-gutters">
                            <div class="col-lg-12 card-form__body card-body">

                                <div>
                                    <center>
                                        <h5>Start Meeting</h5>
                                    </center>
                                    <hr>
                                    <?php date_default_timezone_set("Asia/Kolkata"); ?>
                                    <form action="<?= base_url(); ?>Menu/rpmstart" method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="uid" value="<?= $uid ?>">
                                        <input type="hidden" name="smid" value="" id="startmid">
                                        <input type="hidden" name="bscid" value="" id="bscid">
                                        <input type="hidden" id="slat" name="lat">
                                        <input type="hidden" id="slng" name="lng">
                                        <input type="hidden" name="startm" value="<?= date('Y-m-d H:i:s') ?>">
                                        <center>Meeting Started at <?= date('H:i:s') ?></center>
                                        <input type="text" name="company_name" class="form-control p-3 mt-2"
                                            id="bmcname">
                                        <input type="file" name="cphoto" accept="image/*" required
                                            class="form-control p-3 mt-2" capture="camera">

                                        <div id="location">
                                            <div id="map-container-google-3"
                                                class="z-depth-1-half map-container-3 p-3 m-3 border">
                                                <iframe style="width:100%;height:200px;" id="mylocation" src=""
                                                    frameborder="0" style="border:0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <button type="submit" id="rpmsClick"
                                            class="btn btn-primary mt-3">Submit</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- // END .modal-body -->

            </div>
        </div>
    </div>
    <div id="add_closem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title1"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="card card-form col-md-12">
                        <div class="row no-gutters">
                            <div class="col-lg-12 card-form__body card-body">

                                <div>
                                    <center>
                                        <h5>Close Meeting</h5>
                                    </center>
                                    <hr>
                                    <?= form_open('Menu/rpmclose') ?>
                                    <input type="hidden" name="uid" value="<?= $uid ?>">
                                    <input type="hidden" name="cmid" value="" id="closemid">
                                    <input type="hidden" name="bmcid" value="" id="bmcid">
                                    <input type="hidden" name="bmccid" value="" id="bmccid">
                                    <input type="hidden" name="bminid" value="" id="bminid">
                                    <input type="hidden" name="bmtid" value="" id="bmtid">
                                    <input type="hidden" id="clat" name="lat">
                                    <input type="hidden" id="clng" name="lng">
                                    <input type="hidden" name="closem" value="<?= date('Y-m-d H:i:s') ?>">
                                    <center>
                                        <p>Meeting Closed at <?= date('H:i:s') ?></p>
                                    </center>
                                    <select name="type" id="RPMorN" class="form-control" required>
                                        <option value="NO RP">No RP Meeting</option>
                                        <option value="RP">RP Meeting</option>
                                        <option value="Only Got Detail">No RP But Got Details</option>
                                    </select>
                                    <hr>
                                    <select id="updateCompanyStatus" class="form-control" name="updateCompanyStatus"
                                        required=""></select>
                                    <hr>
                                    <div id="RPMbox" style="display:none">
                                        <lable>Company Address</lable>
                                        <input type="text" id="caddress" name="caddress" class="form-control p-3 mt-2">
                                        <lable>Contact Person Name</lable>
                                        <input type="text" id="cpname" name="cpname" class="form-control p-3 mt-2">
                                        <lable>Contact Person Designation</lable>
                                        <input type="text" id="cpdes" name="cpdes" class="form-control p-3 mt-2">
                                        <lable>Contact Person Mobile No</lable>
                                        <input type="text" id="cpno" name="cpno" class="form-control p-3 mt-2">
                                        <lable>Contact Person Email ID</lable>
                                        <input type="text" id="cpemail" name="cpemail" class="form-control p-3 mt-2">

                                        <hr>
                                        <select id="priority" name="priority" class="form-control" required>
                                            <option value="no">Non Priority (Will not give business)</option>
                                            <option value="yes">Priority (Definitely Will give business)</option>
                                        </select>
                                        <hr>

                                        <select id="company_as" class="form-control" name="company_as" required>
                                            <option value="">Select About Company</option>
                                            <option value="Good Company">Good Company</option>
                                            <option value="Not a Big Company">Not a Big Company</option>
                                            <option value="other">Other</option>
                                        </select>

                                        <div id="aboutCompany">
                                            <hr><textarea name="company_descri" id="company_descri" class="form-control"
                                                placeholder="Write about the company"></textarea>
                                            <hr>
                                        </div>

                                        <hr>

                                        <div class="form-group p-3">
                                            <label>Potentional Client:</label><br>
                                            <input type="radio" id="yes" name="potentional_client" value="yes" required>
                                            <label for="male">YES</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" id="no" name="potentional_client" value="no" required>
                                            <label for="no">No</label>
                                        </div>



                                    </div>
                                    <hr>
                                    <lable id="letmeetingsremarks">
                                        <span class="text-danger">* Please provide details as to why it took you more
                                            than 30 minutes.</span>
                                        <input type="text" id="remarksInput"
                                            placeholder="* Please provide details as to why it took you more than 30 minutes."
                                            name="letmeetingsremarks" class="form-control p-3 mt-2">
                                    </lable>
                                    <hr>
                                    <div id="location">
                                        <div id="map-container-google-3"
                                            class="z-depth-1-half map-container-3 p-3 m-3 border">
                                            <iframe style="width:100%;height:200px;" id="myclocation" src=""
                                                frameborder="0" style="border:0" allowfullscreen></iframe>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3"
                                        onclick="this.form.submit(); this.disabled = true;">Submit</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- // END .modal-body -->

            </div>
        </div>
    </div>


    <!-- Script -->

    <div id="alartpopup" class="modal fade in" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content row border border-danger rounded">
                <div class="modal-header custom-modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <h3 class="text-danger text-center">Alert!</h3>
                    <div id="alsms" class="text-center"></div>
                    <div class="m-3 text-right"><img
                            src="https://stemlearning.in/wp-content/uploads/2020/07/stem-new-logo-2-1.png" width="20%">
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade MeetingFeedBackformClass" id="myModalStartMeet" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabelcmpname" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabelcmpname"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="<?= base_url(); ?>Menu/MeetingFeedBack" id="MeetingFeedBackform" method="post">

                        <input type="hidden" name="uid" value="<?= $uid ?>">
                        <input type="hidden" name="cmp_id" value="" id="cmp_id">
                        <input type="hidden" name="meeting_id" value="" id="meeting_id">

                        <hr>
                        <lable>Are you meet with Right Person or Not</lable>
                        <select class="form-control" name="meet_user_feed">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>

                        <hr>
                        <center>
                            <button type="submit" class="btn btn-primary mt-3"
                                onclick="this.form.submit(); this.disabled = true;">Submit</button>
                        </center>

                    </form>


                </div>

            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // $('.select2').select2();
            $('#aboutCompany').hide();
            $('#bcname').select2();
        });
        document.querySelector('#button').disabled = true;
        $('#norek').on('change', function a() {
            document.querySelector('#button').disabled = false;
        });
        $('#remark_msg').on('change', function a() {
            document.querySelector('#button').disabled = false;
        });
        $('#re_mark').on('change', function a() {
            document.querySelector('#button').disabled = false;
        });
        $('#rpmmom').on('change', function a() {
            document.querySelector('#button').disabled = false;
        });
        function disableOtherRadioButtons(name) {
            var radioButtons = document.getElementsByName(name);
            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    continue;
                }
                radioButtons[i].disabled = true;
            }
        }
        function mypopup() {
            $.ajax({
                url: '<?= base_url(); ?>Menu/alpopup',
                type: "POST",
                cache: false,
                success: function (result) {
                    var res = result;
                    if (res != 0) {
                        $('#alartpopup').modal('show');
                        $("#alsms").html(result);
                    }
                }
            });
        }
        var sx = document.getElementById("slat");
        var sy = document.getElementById("slng");
        var cx = document.getElementById("clat");
        var cy = document.getElementById("clng");
        var z = document.getElementById("mylocation");
        var y = document.getElementById("mylocation");
        $(document).ready(function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.value = "Geolocation is not supported by this browser.";
            }
        });
        function showPosition(position) {
            sx.value = position.coords.latitude;
            sy.value = position.coords.longitude;
            cx.value = position.coords.latitude;
            cy.value = position.coords.longitude;
            var a = position.coords.latitude;
            var b = position.coords.longitude;
            mylocation.src = "https://maps.google.com/?q=" + a + "," + b + "&t=k&z=13&ie=UTF8&iwloc=&output=embed";
            myclocation.src = "https://maps.google.com/?q=" + a + "," + b + "&t=k&z=13&ie=UTF8&iwloc=&output=embed";
        }

        $(document).ready(function () {
            $('#other_action').click(function () {
                $('#doaction').modal('show');
                var id = document.getElementById("other_action").value;
                document.getElementById("taskid").value = id;
            });

        });


    </script>

    <script type='text/javascript'>

        $('#sel').on('change', function a() {
            var sel = this.value;
            if (sel == 'Other') {
                document.getElementById("remark").readOnly = false;
            } else {
                document.getElementById("remark").value = sel;
            }
        });
        $('#tphmlocation').on('change', function a() {
            var tphl = this.value;
            for (var i = 1; i < tphl; i++) {
                document.getElementById("headshow").html = "Day" + i;
                var tpscity = document.getElementById("tpscity");
                var scload = document.getElementById("scload");
                tpscity.appendChild(scload.cloneNode(true));

            }
        });
        $('#date').on('change', function a() {
            var date = this.value;
            var uid = document.getElementById("uid").value;
            $.ajax({
                url: '<?= base_url(); ?>Menu/setdateremark',
                type: "POST",
                data: {
                    date: date,
                    uid: uid
                },
                cache: false,
                success: function a(result) {
                    var res = result;
                    alert(res);
                    if (res == 0) {
                        $("#dateremaek").html("<p>Right Time To Do this</p>");
                    } else {
                        document.getElementById("date").value = "";
                        $("#dateremaek").html("<b class='text-danger'>You Have Alrady Planed Some Other Task You Can Plan For Other Time<b>");
                    }

                }
            });
        });
        $("#purpose").hide();
        $("#noremark").hide();
        let result = document.querySelector('#result');
        document.body.addEventListener('change', function (e) {
            let target = e.target;
            let message;
            switch (target.id) {
                case 'pending':

                    var ab = document.getElementById("action_id").value;
                    if (ab == "1") {
                        $("#purpose").show();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").hide();
                    }
                    if (ab == "10") {
                        $("#purpose").show();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").hide();
                    }
                    if (ab == "2") {

                        document.querySelector('#button').disabled = false;

                        $("#test1").hide();
                        $("#test2").show();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").hide();
                    }
                    if (ab == "3") {
                        $("#test1").hide();
                        $("#test2").hide();
                        $("#test3").show();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").hide();
                    }
                    if (ab == "5") {
                        document.querySelector('#button').disabled = false;
                        $("#test1").hide();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").show();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").hide();
                    }
                    if (ab == "6") {
                        $("#test1").hide();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").show();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").hide();
                    }

                    if (ab == "13") {
                        document.querySelector('#button').disabled = false;
                        $("#test1").hide();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").show();
                        $("#test9").hide();
                    }
                    if (ab == "14") {
                        document.querySelector('#button').disabled = false;
                        $("#test1").hide();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").hide();
                        $("#test8").hide();
                        $("#test9").show();
                    }





                    if (ab == "7") {
                        document.querySelector('#button').disabled = false;
                        $("#test1").hide();
                        $("#test2").hide();
                        $("#test3").hide();
                        $("#test5").hide();
                        $("#test6").hide();
                        $("#test7").show();
                        $("#test8").hide();
                        $("#test9").hide();
                    }



                    $("#noremark").hide();
                    break;
                case 'resolved':
                    $("#purpose").hide();
                    $("#ifyes").hide();
                    $("#ifno").hide();
                    $("#noremark").show();
                    break;
            }
            result.textContent = message;
        });
        $('#RPMorN').on('change', function b() {
            var a = this.value;
            if (a == 'RP' || a == 'Only Got Detail') { $("#RPMbox").show(); }
            else { $("#RPMbox").hide(); }
        });
        $('#mbolocation').on('change', function b() {
            var a = this.value;
            if (a == 'Base Location') {
                $("#bboxc").show();
            }
            else {
                $("#bboxc").show();
            }
        });
        $('#bcytpe').on('change', function b() {
            var a = this.value;
            if (a == 'From Funnel') {
                $("#bboxa").show();
                $("#bboxb").hide();
            }
            else {
                $("#bboxb").show();
                $("#bboxa").hide();
            }
        });
        let resul = document.querySelector('#resul');
        document.body.addEventListener('change', function (f) {
            let target = f.target;
            let message;
            switch (target.id) {
                case 'presolved':
                    $("#ifyes").show();
                    $("#ifno").hide();
                    var cstatus = document.getElementById("cstatus").value;
                    $.ajax({
                        url: '<?= base_url(); ?>Menu/getstatusbd',
                        type: "POST",
                        data: {
                            cstatus: cstatus
                        },
                        cache: false,
                        success: function a(result) {
                            $("#ystatus").html(result);
                        }
                    });
                    callab();
                    break;
                case 'pnresolved':
                    $("#ifno").show();
                    $("#ifyes").hide();
                    var status_id = document.getElementById("cstatus").value;
                    $.ajax({
                        url: '<?= base_url(); ?>Menu/mainremark',
                        type: "POST",
                        data: {
                            status_id: status_id
                        },
                        cache: false,
                        success: function a(result) {
                            $("#tremark").html(result);
                        }
                    });
                    callab();
                    break;
            }
            resul.textContent = message;
        });

        $('#testdata').on('change', function c() {
            var ab = this.value;
            document.getElementById("remark_msg").value = ab;
        });
        $('#tremark').on('change', function b() {
            var tremark = document.getElementById("tremark").value;
            if (tremark == 'Other') {
                document.getElementById("re_mark").value = '';
                document.getElementById("re_mark").readOnly = false;
            } else {
                document.getElementById("re_mark").readOnly = true;
            }
        });
        $('#tremark').on('change', function b() {
            var tremark = document.getElementById("tremark").value;
            if (tremark != 'Other') { document.getElementById("re_mark").value = tremark; }
        });
        $('#bstate').on('change', function f() {
            var stid = this.value;
            $.ajax({
                url: '<?= base_url(); ?>Menu/getcity',
                type: "POST",
                data: {
                    stid: stid
                },
                cache: false,
                success: function a(result) {
                    $("#bcity").html(result);
                }
            });
        });
        $('#tpstate').on('change', function f() {
            var stid = this.value;
            $.ajax({
                url: '<?= base_url(); ?>Menu/getcity',
                type: "POST",
                data: {
                    stid: stid
                },
                cache: false,
                success: function a(result) {
                    $("#tpcity").html(result);
                }
            });
        });
        $('#nextaction').on('change', function f() {
            var action_id = document.getElementById("nextaction").value;

            $.ajax({
                url: '<?= base_url(); ?>Menu/purpose',
                type: "POST",
                data: {
                    action_id: action_id
                },
                cache: false,
                success: function a(result) {
                    $("#nextpurpose").html(result);
                }
            });
        });
        $('#nextpurpose').on('change', function g() {
            var purpose_id = document.getElementById("nextpurpose").value;

            $.ajax({
                url: '<?= base_url(); ?>Menu/actionremark',
                type: "POST",
                data: {
                    purpose_id: purpose_id
                },
                cache: false,
                success: function a(result) {
                    $("#next_action_remark").html(result);
                }
            });
        });
        $('#next_action_remark').on('change', function c() {
            var ab = this.value;
            document.getElementById("next_action_remark_msg").value = ab;
        });
    </script>
    <script type='text/javascript'>
        $(document).ready(function () {


            $('[id^="add_act"]').on('click', function () {
                $('#add_note').modal('show');
                var tid = this.value;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/cctd',
                    method: 'post',
                    data: { tid: tid },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;
                        $('#cname,#ctname').text('');
                        // console.log(response);
                        if (len > 0) {

                            var cstatus = response[0].cstatus;
                            var cname = response[0].cname;
                            var ctname = response[0].ctname;
                            var clsname = response[0].clsname;
                            // var cremarks = response[0].cremarks;
                            var cremarks = response[0].remarks;
                            var assignedBy = response[0].assignedBy;
                            var assignedTo = response[0].assignedTo;
                            var cp = response[0].cp;
                            var emailid = response[0].emailid;
                            var phoneno = response[0].phoneno;
                            var designation = response[0].designation;
                            var cpurpose = response[0].purpose_id;
                            // var cpurpose = response[0].cpurpose;
                            var actiontype_id = response[0].actiontype_id;
                            var nstatus = response[0].status_id;
                            var cmpid = response[0].cid_id;
                            var tidd = response[0].id;
                            var cmid = response[0].cmid;

                            var cpurpose_name = '';
                            if (cpurpose !== '') {
                                $.ajax({
                                    url: '<?= base_url(); ?>Menu/cctd_prupose',
                                    type: 'POST',
                                    data: { purposeId: cpurpose },
                                    success: function (response) {
                                        cpurpose_name = response;
                                        document.getElementById("cpurpose").innerHTML = cpurpose_name;
                                    }
                                });
                            } else {
                                document.getElementById("cpurpose").innerHTML = cpurpose;
                            }

                            document.getElementById("cstatus").value = cstatus;
                            document.getElementById("cname").innerHTML = cname;
                            document.getElementById("ctname").innerHTML = ctname;
                            document.getElementById("clsname").innerHTML = clsname;
                            document.getElementById("cremarks").innerHTML = cremarks;
                            document.getElementById("assignedBy").innerHTML = assignedBy;
                            document.getElementById("assignedTo").innerHTML = assignedTo;
                            document.getElementById("cp").innerHTML = cp;
                            document.getElementById("emailid").innerHTML = emailid;
                            document.getElementById("phoneno").innerHTML = phoneno;
                            document.getElementById("designation").innerHTML = designation;
                            // document.getElementById("cpurpose").innerHTML = cpurpose;
                            document.getElementById("action_id").value = actiontype_id;
                            document.getElementById("yaction_id").value = actiontype_id;
                            document.getElementById("cmpid").value = cmpid;
                            document.getElementById("tidd").value = tidd;
                            // document.getElementById("clink").href = "tel:+91"+phoneno;
                            // document.getElementById("wlink").href = "https://wa.me/91"+phoneno;
                            document.getElementById("glink").href = "mailto:" + emailid;
                            document.getElementById("cmplink").href = "CompanyDetails/" + cmid;

                            if (ctname == 'Research') {
                                $("#reaserch_message").show();
                                $("#reaserch_message").html('<h5 class="p-2">Research</h5>');
                                $("#reaserch_message1").text('* Add New Lead Please Submit this form');
                                if (cname == 'Unknown') {
                                    $("#new_reserach1").hide();
                                    $("#new_reserach2").hide();
                                    $("#new_reserach3").hide();
                                    $("#new_reserach4").hide();
                                    $('#button').removeAttr('disabled');
                                } else {
                                    $("#new_reserach1").show();
                                    $("#new_reserach2").show();
                                    $("#new_reserach3").show();
                                    $("#new_reserach4").show();
                                    $("#reaserch_message").hide();
                                    $("#reaserch_message1").hide();
                                }
                            } else {
                                $("#reaserch_message").hide();
                                $("#reaserch_message1").hide();
                            }
                            if (ctname == 'Call' || ctname == 'Whatsapp Activity') {

                                // var isMobile = window.orientation > -1;
                                // if (isMobile != 'Mobile') {
                                //     alert('You need to perform and update this task from mobile..!!');
                                //     return false;
                                // }
                                //  alert(ctname);
                                //  document.getElementById("moshow").classList.add('d-lg-none');
                                //  document.getElementById("moshow").classList.add('d-sm-block');
                                //  document.getElementById("moshow").classList.add('d-md-none');
                            }
                            if (ctname == 'Call') {
                                $("#taskbox").show();
                                $("#taskbtn").show();
                            }
                        }
                    }
                });
            });


            $('[id^="add_plan"]').on('click', function () {
                $('#doaction').modal('show');
                var tid = this.value;
                document.getElementById("taskid").value = tid;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/cctd',
                    method: 'post',
                    data: { tid: tid },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;
                        $('#cname').text('');
                        if (len > 0) {
                            // Read values
                            var cname = response[0].cname;
                            document.getElementById("cmpname").innerHTML = cname;
                        }
                    }
                });
            });
            $('[id^="startm"]').on('click', function () {
                $('#add_startm').modal('show');
                var id = this.value;
                document.getElementById("startmid").value = id;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/bmtd',
                    method: 'post',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;
                        $('#compname,#cid').text('');
                        if (len > 0) {
                            var compname = response[0].compname;
                            var cid = response[0].cid;

                            // localStorage.setItem('startMeetformSubmitted', 'true');
                            let myObjectData = { compname: compname, cid: cid, bmid: id };
                            localStorage.setItem("myObjectKey", JSON.stringify(myObjectData));

                            document.getElementById("bmcname").value = compname;
                            document.getElementById("bscid").value = cid;
                        }
                    }
                });
            });
            $('[id^="closem"]').on('click', function () {
                $('#add_closem').modal('show');
                var id = this.value;
                document.getElementById("closemid").value = id;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/bmtd',
                    method: 'post',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;
                        $('#compname,#cid,#ccid,#inid,#tid').text('');

                        if (len > 0) {

                            var compname = response[0].compname;
                            var cid = response[0].cid;
                            var ccid = response[0].ccid;
                            var inid = response[0].inid;
                            var tid = response[0].tid;
                            var address = response[0].address;
                            var contactperson = response[0].contactperson;
                            var designation = response[0].designation;
                            var phoneno = response[0].phoneno;
                            var emailid = response[0].emailid;

                            // Start Meeting 30 minute Conditions
                            var startm = response[0].startm;
                            var pastDate = new Date(startm.replace(' ', 'T'));
                            var currentDate = new Date();
                            var timeDifference = currentDate - pastDate;
                            var minutesDifference = Math.floor(timeDifference / (1000 * 60));
                            if (minutesDifference > 30) {
                                $('#letmeetingsremarks').show();
                                $('#remarksInput').attr('required', true);
                            } else {
                                $('#letmeetingsremarks').hide();
                            }
                            // End Meeting 30 minute Conditions

                            // Start Add Status
                            var cstatus = 1;
                            var meetingslct = $('#RPMorN').val();

                            if (meetingslct === 'NO RP') {
                                $.ajax({
                                    url: 'GetStatusWhenMeetClose',
                                    type: 'POST',
                                    data: { cstatus: cstatus, meetingslct: 'NO RP' },
                                    success: function (response) {
                                        $("#updateCompanyStatus").html(response);
                                    }
                                });
                            }

                            $('#RPMorN').on('change', function b() {
                                var meetingslct = this.value;  // RP,Only Got Detail

                                if (meetingslct == 'RP') {
                                    $.ajax({
                                        url: 'GetStatusWhenMeetClose',
                                        type: 'POST',
                                        data: { cstatus: cstatus, meetingslct: meetingslct },
                                        success: function (response) {
                                            $("#updateCompanyStatus").html(response);
                                        }
                                    });
                                }

                                if (meetingslct == 'Only Got Detail') {
                                    $.ajax({
                                        url: 'GetStatusWhenMeetClose',
                                        type: 'POST',
                                        data: { cstatus: cstatus, meetingslct: meetingslct },
                                        success: function (response) {
                                            $("#updateCompanyStatus").html(response);
                                        }
                                    });
                                }

                                if (meetingslct === 'NO RP') {
                                    $.ajax({
                                        url: 'GetStatusWhenMeetClose',
                                        type: 'POST',
                                        data: { cstatus: cstatus, meetingslct: 'NO RP' },
                                        success: function (response) {
                                            $("#updateCompanyStatus").html(response);
                                        }
                                    });
                                }
                            });
                            // End Status
                            // Start About Company
                            $('#company_as').on('change', function b() {
                                var company_as = this.value;
                                if (company_as == 'other') {
                                    $("#aboutCompany").show();
                                } else {
                                    $("#aboutCompany").hide();
                                }
                            });
                            // End About Company 

                            document.getElementById("bmcname").value = compname;
                            document.getElementById("bmcid").value = cid;
                            document.getElementById("bmccid").value = ccid;
                            document.getElementById("bminid").value = inid;
                            document.getElementById("bmtid").value = tid;
                            document.getElementById("caddress").value = address;
                            document.getElementById("cpname").value = contactperson;
                            document.getElementById("cpdes").value = designation;
                            document.getElementById("cpno").value = phoneno;
                            document.getElementById("cpemail").value = emailid;
                        }
                    }
                });
            });
            $('#tplan').click(function () {
                $('#Add_TPlan').modal('show');
                let result = document.querySelector('#result');
                document.body.addEventListener('change', function (e) {
                    let target = e.target;
                    let message;
                    switch (target.id) {
                        case 'Instant':
                            $("#laterbox").hide();
                            break;
                        case 'Later':
                            $("#laterbox").show();
                            break;
                    }
                    result.textContent = message;
                });
            });


            $('#cbim').click(function () {
                $('#add_bim').modal('show');
                let result = document.querySelector('#result');
                document.body.addEventListener('change', function (e) {
                    let target = e.target;
                    let message;
                    switch (target.id) {
                        case 'Instant':
                            $("#laterbox").hide();
                            break;
                        case 'Later':
                            $("#laterbox").show();
                            break;
                    }
                    result.textContent = message;
                });
            });

            $('#wlink').click(function () {
                var tid = document.getElementById("tidd").value;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/indtime',
                    method: 'post',
                    data: { tid: tid },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;

                    }
                });
            });


            $('#glink').click(function () {
                var tid = document.getElementById("tidd").value;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/indtime',
                    method: 'post',
                    data: { tid: tid },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;

                    }
                });
            });

            $('#clink').click(function () {
                var isMobile = window.orientation > -1;
                if (isMobile != 'Mobile') {
                    alert('You need to complete and update this task from mobile..!!');
                    return false;
                }
                // alert(isMobile ? 'Mobile' : 'Not mobile');
                var tid = document.getElementById("tidd").value;
                $.ajax({
                    url: '<?= base_url(); ?>Menu/indtime',
                    method: 'post',
                    data: { tid: tid },
                    dataType: 'json',
                    success: function (response) {
                        var len = response.length;
                    }
                });
                $("#taskbox").show();
                $("#taskbtn").show();
            });

        });


        $(function () {
            $('.pop').on('click', function () {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        });
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>


    <script>
        $(document).ready(function () {
            $('#smallProposaltext').hide();
            $('#identify_school_box').hide();
            $('#permission_letter_box').hide();

            $('#project_intervention_select').change(function () {
                if ($(this).val() === 'Others') {
                    $('#project_interventionText').show();
                } else {
                    $('#project_interventionText').hide();
                }
            });

            $('#client_has_adopted_select').change(function () {
                if ($(this).val() === 'yes') {
                    $('#client_has_adoptedText').show();
                } else {
                    $('#client_has_adoptedText').hide();

                }
            });

            $('#submit_proposal_select').change(function () {
                if ($(this).val() === 'yes') {
                    $('#submit_proposal_file').show();
                    $('#smallProposaltext').show();
                } else {
                    $('#submit_proposal_file').hide();
                    $('#smallProposaltext').hide();
                }
            });
            $('#identify_school_select').change(function () {
                if ($(this).val() === 'yes') {
                    $('#identify_school_box').show();
                } else {
                    $('#identify_school_box').hide();
                }
            });
            $('#client_int_school_select').change(function () {
                if ($(this).val() === 'yes') {
                    $('#client_int_school_box').show();
                } else {
                    $('#client_int_school_box').hide();
                }
            });

            $('#permission_letter_select').change(function () {
                if ($(this).val() === 'yes') {
                    $('#permission_letter_box').show();
                } else {
                    $('#permission_letter_box').hide();
                }
            });

            // Trigger the change event on page load in case "Others" is preselected
            $('#project_intervention_select').trigger('change');
            $('#client_has_adopted_select').trigger('change');
            $('#submit_proposal_select').trigger('change');
            $('#identify_school_select').trigger('change');
            $('#client_int_school_select').trigger('change');
            $('#permission_letter_select').trigger('change');
        });
    </script>
    <script>
        $("#rpmsClick").click(function () {
            var val = $("#bmcname").val();
            if (val == 'Unknown' || val == '') {
                alert("* Please Enter Valid Company Name");
                $('#bmcname').css('border', '1px solid red');
                return false;
            } else if (val !== '') {

                var inputVal = $('#bmcname').val();           // Get the value entered in the input field
                var hindiRegex = /[\u0900-\u097F]/;     // Regular expression to detect Hindi characters
                if (hindiRegex.test(inputVal)) {
                    alert('Hindi characters are not Allowed'); // Show the error message if Hindi characters are found
                    return false;
                } else {
                    return true;
                }
            } else {
                localStorage.setItem('startMeetformSubmitted', 'true');
                return true;
            }
        });
    </script>


    <script>
        $(document).ready(function () {

            if (localStorage.getItem('startMeetformSubmitted') === 'true') {
                setTimeout(function () {

                    let retrievedObject = JSON.parse(localStorage.getItem("myObjectKey"));
                    var compname = retrievedObject.compname;
                    var cid_id = retrievedObject.cid;
                    var bmid_id = retrievedObject.bmid;

                    $("#myModalLabelcmpname").text(compname);
                    $("#cmp_id").val(cid_id);
                    $("#meeting_id").val(bmid_id);

                    $('#myModalStartMeet').modal('show');
                    // Show the freeze overlay
                    $('#freezeOverlay').show();
                    localStorage.removeItem('startMeetformSubmitted');
                    // }, 3000);
                }, 600000);
            }

            $('#MeetingFeedBackform').submit(function (event) {
                // Prevent the form from submitting
                event.preventDefault();
                // Optionally: Show a message or perform other actions
                // alert('Form submission is currently disabled. Please interact with the modal.');
                // If you want to hide the freeze overlay after some time or based on an action:
                // $('#freezeOverlay').hide();
                $('.MeetingFeedBackform').on('hidden.bs.modal', function () {
                    $('#freezeOverlay').hide();
                });
            });

            // Start Add More School Data When Mom Upload 
            // Function to add a new set of fields
            $('#add_field').click(function () {
                $('#identify_school_box').append(`
                    <div class="identify_school_box mt-2">
                        <input type="text" required class="form-control" name="identify_school_state[]" placeholder="Enter Name of State"> <br>
                        <input type="text" required class="form-control" name="identify_school_district[]" placeholder="Enter Name of District"><br>
                        <input type="text" required class="form-control" name="no_of_school[]" placeholder="Enter No of School">
                        <br>
                         <span class="remove-field bg-danger mt-4">-</span>
                    </div>
                `);
            });

            // Function to remove a set of fields
            $('#identify_school_box').on('click', '.remove-field', function () {
                $(this).parent().remove();
            });
            // End Add More School Data When Mom Upload 
        });
    </script>

    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
        }

        .overlay.active {
            display: block;
        }

        body.frozen {
            overflow: hidden;
        }

        span.remove-field.bg-danger {
            padding: 6px;
            border-radius: 34%;
        }

        p#reaserch_message {
            color: green;
            font-weight: 500;
            font-size: 16px;
        }

        p#reaserch_message1 {
            color: green;
            font-weight: 500;
        }
    </style>