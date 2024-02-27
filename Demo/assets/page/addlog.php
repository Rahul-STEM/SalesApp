<div id="add_note" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title" aria-hidden="true">
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
                                    <form method="post" action="#">
                                        
                                        <input type="hidden" name="spdid" value="">
                                        <input type="hidden" name="lastCFID" value="">
                                        <div class="was-validated">

                                            <div class="form-row">

                                                 <div id="prev_action" class="form-row">
                                                     <div class="row md-12" style="margin-left:20px;"><label>Action Completed?</label><br>
                                                   <div class="col-6 col-md-6 mb-6" style="margin:auto;">
                                                    <label for="validationSample04">NO</label>
                                                    <input type="radio" style="padding:30px;" checked name="action_taken" onchange="check_remark();" value="no" placeholder="State" required="">


                                                </div>

                                                    <div class="col-6 col-md-6 mb-6" style="margin:auto;">
                                                    <label for="validationSample04">YES</label>
                                                    <input type="radio" style="padding:30px;"  name="action_taken" onchange="check_remark();" value="yes"  required="">
                                                    </div>
                                                </div>
                                                 <div class="col-12 col-md-12 mb-3">
                                                    <label for="validationSample04">Status</label>
                                                    <select type="text" onchange="getRemark();" class="form-control" id="currentStatus" name="status" placeholder="State" required="">
                                                        <option value="1">New School</option>
                                                        <option value="8">FTTP Done</option>
                                                        <option value="2">Active School</option>
                                                        <option value="3">Average School</option>
                                                        <option value="6">Good School</option>
                                                        <option value="9">Model School</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="validationSample04">Meeting Type &nbsp;
                                                          
                                                    </label>
                                                    <select type="text" class="form-control" required onchange="if(this.value=='NA'){ live_location.value='   ';live_location.setAttribute('readonly','readonly'); }else{ live_location.value=''; live_location.removeAttribute('readonly'); live_location.focus(); live_location.setAttribute('required','required'); }"  name="meeting_type" id="meeting_type"  >
                                                        <option value=""></option>
                                                        <option value="NA">NA</option>
                                                        <option value="Virtual">Virtual</option>
                                                        <option value="Physical">Physical</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks <good></good>!</div>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="validationSample04">Live Location URL &nbsp;
                                                          
                                                    </label>
                                                    <textarea type="text" class="form-control"  name="live_location" id="live_location"  ></textarea>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks <good></good>!</div>
                                                </div>
                                                
                                                 <div class="row md-12 col-md-12" style="margin-left:20px;">
                                                     <div class="col-md-12">
                                                         <label>MOM Received</label>
                                                     </div>
                                                   <div class="col-6 col-md-6 mb-6" style="margin:auto;">
                                                    <label for="validationSample04">NO</label>
                                                    <input type="radio" style="padding:30px;" checked name="mom_received"  value="no" placeholder="State" required="">


                                                </div>

                                                     <div class="col-6 col-md-6 mb-6" style="margin:auto;">
                                                    <label for="validationSample04">YES</label>
                                                    <input type="radio" style="padding:30px;"  name="mom_received" value="yes"  required="">

                                                </div>
                                                         </div>

                                                 <div class="col-12 col-md-12 mb-3">
                                                    <label for="validationSample04">Remarks &nbsp;
                                                          
                                                    </label>
                                                    <select type="text" class="form-control"  name="remark" id="remarks" onchange="check_remark();" placeholder="State" required="">

                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks <good></good>!</div>
                                                </div>

                                                   <div class="col-12 col-md-12 mb-12">
                                                    <label for="remark_msg">Remarks&nbsp;&nbsp;&nbsp;
                                                    <label for="validationSample04">Customize</label>&nbsp;
                                                    <input type="checkbox" style="padding:30px;"  name="customized_remarks[]" onchange="check_remark();" value="no" placeholder="State" >

                                                    </label>
                                                    <textarea type="text" class="form-control" readonly="readonly"  name="remark_msg" id="remark_msg"  required="">

                                                    </textarea>
                                                    <div class="invalid-feedback">.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>

                                                  <div class="col-12 col-md-6 mb-3" style="margin-top:14px">
                                                      <label for="remark_msg"></label>

                                                    <input type="checkbox" style="width:30px;height:30px;"  readonly="readonly"  name="proposal_sent" value="yes"  >

                                                      <label for="remark_msg">Proposal Sent</label>

                                                </div>
                                                <div class="col-12 col-md-6 mb-3" style="margin-top:14px">
                                                      <label for="remark_msg"></label>

                                                    <select name="proposal_type" class="form-cotroller">
                                                        <option value="NA">NA</option>
                                                        <option value="MSC">MSC</option>
                                                    </select>

                                                      <label for="remark_msg">Proposal Type</label>

                                                </div>
                                                <div class="col-12 col-md-12 mb-3">
                                                    <label for="remark_msg">Proposal Amount</label>
                                                    <input type="text" placeholder="Amount" class="form-control"   name="proposal_amt">
                                                </div>

                                                 <div class="col-12 col-md-12 mb-3">
                                                    <label for="remark_msg">Description</label>
                                                    <input type="text" placeholder="Description" class="form-control"   name="proposal_description">
                                                </div>
                                            </div>
                                                 <div style="display:none;" id="next_action_form" class="form-row row">

                                                       <div class="col-12 col-md-6 mb-3">
                                                    <label for="validationSample04">Action Date</label>
                                                    <input type="date" class="form-control" id="action_date" onchange="check_date_activity(this.value);" name="action_date"  value="" min="" placeholder="State" required="">
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>


                                                </div>

                                                 <div class="col-6 col-md-3 mb-3">
                                                    <label for="validationSample04">HOURS</label>
                                                    <select class="form-control"  name="action_hour" value="" placeholder="State"  required="">
                                                        <option>00</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                        <option>05</option>
                                                        <option>06</option>
                                                        <option>07</option>
                                                        <option>08</option>
                                                        <option>09</option>
                                                        <option>10</option>
                                                        <option>11</option>
                                                        <option>12</option>
                                                        <option>13</option>
                                                        <option>14</option>
                                                        <option>15</option>
                                                        <option>16</option>
                                                        <option>17</option>
                                                        <option>18</option>
                                                        <option>19</option>
                                                        <option>20</option>
                                                        <option>21</option>
                                                        <option>22</option>
                                                        <option>23</option>
                                                    </select>

                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                <div class="col-6 col-md-3 mb-3">
                                                    <label for="validationSample04">MINUTS</label>

                                                     <select class="form-control" name="action_min" value="" placeholder="State"  required="">
                                                        <option>00</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                        <option>05</option>
                                                        <option>06</option>
                                                        <option>07</option>
                                                        <option>08</option>
                                                        <option>09</option>
                                                        <option>10</option>
                                                        <option>11</option>
                                                        <option>12</option>
                                                        <option>13</option>
                                                        <option>14</option>
                                                        <option>15</option>
                                                        <option>16</option>
                                                        <option>17</option>
                                                        <option>18</option>
                                                        <option>19</option>
                                                        <option>20</option>
                                                        <option>21</option>
                                                        <option>22</option>
                                                        <option>23</option>
                                                        <option>24</option>
                                                         <option>25</option>
                                                         <option>26</option>
                                                         <option>27</option>
                                                         <option>28</option>
                                                         <option>29</option>
                                                         <option>30</option>
                                                         <option>31</option>
                                                         <option>32</option>
                                                         <option>33</option>
                                                         <option>34</option>
                                                         <option>35</option>
                                                         <option>36</option>
                                                         <option>37</option>
                                                         <option>38</option>
                                                         <option>39</option>
                                                         <option>40</option>
                                                         <option>41</option>
                                                         <option>42</option>
                                                         <option>43</option>
                                                         <option>44</option>
                                                         <option>45</option>
                                                         <option>46</option>
                                                         <option>47</option>
                                                         <option>48</option>
                                                         <option>49</option>
                                                         <option>50</option>
                                                         <option>51</option>
                                                         <option>52</option>
                                                         <option>53</option>
                                                         <option>54</option>
                                                         <option>55</option>
                                                         <option>56</option>
                                                         <option>57</option>
                                                         <option>58</option>
                                                         <option>59</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                      <div id="activity_msg" class="col-12 col-md-12 mb-3"></div>

                                                 <div class="col-12 col-md-12 mb-12">
                                                    <label for="validationSample03">Assign to</label>
                                                    <select type="text" class="form-control" name="assign_to" id="id_creator"  required="">
                                                            <option value=""></option>
                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid city.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>

                                                 <div class="col-12 col-md-6 mb-3">
                                                    <label for="validationSample04">Action Type</label>
                                                    <select type="text" class="form-control" id="action_type" onchange="get_purpose();" name="action" placeholder="State" required="">
                                                        
                                                        <option value=""></option>
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>

                                                 <div class="col-12 col-md-6 mb-3">
                                                    <label for="purpose">Purpose</label>
                                                    <select type="text" class="form-control" id="purpose" onchange="get_next_action();" name="purpose" placeholder="State" required="">

                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>

                                                 <div class="col-12 col-md-12 mb-12">
                                                    <label for="next_action">Next Action</label>
                                                    <select type="text" class="form-control"  name="next_action_id" onchange="next_action_msg.value=$('#next_action  option:selected').text();" id="next_action" placeholder="State" required="">

                                                    </select>
                                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>

                                                     <div class="col-12 col-md-12 mb-12">
                                                    <label for="next_action">Next Action Remark</label>
                                                    <textarea type="text" class="form-control"  name="next_action" id="next_action_msg" placeholder="State" required="">

                                                    </textarea>
                                                    <div class="invalid-feedback">Please provide a valid action.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                </div>



                                            </div>
                                        </div>
                                        <button type="button" id="" style="display:none;float:left;" onclick="$('#next_action_form').hide();$('.next_action_form_submit').hide();$('#next_action_form_button').show();$('#prev_action').show();" class="btn btn-primary next_action_form_submit"><< Last Action </button>
                                        <button type="Submit"  style="display:none;float:right;" class="btn btn-success next_action_form_submit">Submit</button>
                                        <button type="button" id="next_action_form_button" onclick="$('#next_action_form').show();$('.next_action_form_submit').show();$('#next_action_form_button').hide();$('#prev_action').hide();" class="btn btn-primary">Next Action >></button>

                                    </form>
                                </div>
                            </div>
                        </div>
                </div> <!-- // END .modal-body -->
                
</div></div></div>
                
 
  <!-- User details -->
  <div id="add_contact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title" aria-hidden="true">
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
                                    
   <div >
   <form action='https://stemlearning.in/opp/Menu/addcont' method="POST">
   id : <input type="text" id="id" name="sid"><br/>
   <input type="text" name="contact_name">
   <input type="text" name="designation">
   <input type="text" name="contact_no">
   <input type="text" name="email">
   <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled = true;">Submit</button>
   </form>
  </div>
  
  </div>
                            </div>
                        </div>
                </div> <!-- // END .modal-body -->
                
                </div></div></div>

  <!-- Script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type='text/javascript'>
  $(document).ready(function(){
		
   $('#sel_user').click(function(){
    $('#add_contact').modal('show');
    var id = document.getElementById("sel_user").value;
    $.ajax({
     url:'https://stemlearning.in/opp/Menu/sd',
     method: 'post',
     data: {id: id},
     dataType: 'json',
     success: function(response){
       var len = response.length;
       $('#suname,#sname,#semail').text('');
       if(len > 0){
         // Read values
         var id = response[0].id;
         var uname = response[0].sname;
         var name = response[0].slocation;
         var email = response[0].email;
 
         document.getElementById("id").value = id;
         document.getElementById("suname").value = uname;
         document.getElementById("sname").value = name;
         document.getElementById("semail").value = email;
 
       }
 
     }
   });
  });
 });
 
 function add_log(){
  $('#add_note').modal('show');
  }
 </script>