<?php $uid=$user['id'];?>


<!-- User details -->
  <div id="doaction" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title" aria-hidden="true">
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
                           <?=form_open('Menu/dateplan')?>
                           <input type="hidden" id="taskid" name="taskid">
                           <lable>Select Date Time</lable>
                           <input type="datetime-local" name="date" class="form-control p-3 mt-2 mb-2" placeholder="Date" value="<?=$today?>">
                           <button type="submit" class="btn btn-primary mt-3" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                           </form>
                        </div>
                        </div>
                            </div>
                        </div>
                </div> <!-- // END .modal-body -->
                
                </div></div></div>
                
<!-- User details -->             
<div id="add_note" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title" aria-hidden="true">
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
                                  <div class="col-12 col-md-12">
                                    <div class="card-header bg-info">Task Detail</div>
                                    <div class="card-body">
                                        Current Task : <lable id="ctname"></lable><br>
                                        Last Status :  <lable id="clsname"></lable><br>
                                        Last Update at :  <lable id="lupdate"></lable><br>
                                        Last Task Remark : <lable id="cremarks"></lable>
                                    </div>
                                  </div>
                                </div>
                                <div class="card row m-2">
                                  <div class="col-12 col-md-12">
                                      <input type="hidden" value="" id="test">
                                    <a href="" target="_blank" id="cmplink"><div class="card-header bg-info"><lable id="cname"></lable></div></a>
                                    <div class="card-body">
                                        <div class="col-sm">Address : <lable id="address"></lable></div>
                                        <div class="col-sm">City : <lable id="city"></lable></div>
                                        <div class="col-sm">State : <lable id="state"></lable></div>
                                        <div class="col-sm">Designation : <lable id="position"></lable></div>
                                        <div class="col-sm">Phone No : <lable id="phoneno"></lable></div>
                                        <div class="col-sm">Email id : <lable id="emailid"></lable></div>
                                            <span>
                                                <a id="clink" href="" target="_blank" style="padding:7px;border-radius:20px;">
                                                <img src="https://stemlearning.in/opp/assets/image/icon/call.png" style="height:30px;"></a>
                                                <a id="wlink" href="" target="_blank" style="padding:7px;border-radius:20px;">
                                                <img src="https://stemlearning.in/opp/assets/image/icon/whatsapp.png" style="height:30px;"></a>
                                                <a id="glink" href="" target="_blank" style="padding:7px;border-radius:20px;">
                                                <img src="https://mailmeteor.com/logos/assets/PNG/Gmail_Logo_512px.png" style="height:20px;"></a>
                                            </span>
                                    </div>
                                  </div>
                                </div>
                                <div class="card row m-2">
                                  <div class="col-12 col-md-12">
                                    <div class="card-header bg-info"></div>
                                    <div class="card-body">
                                     <form action="<?=base_url();?>Menu/submittask" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="uid" value="<?=$uid?>">
                                        <input type="hidden" name="tid" id="tid">
                                        
                                        <div class="text-center">
                                            <span><b>Action Completed?</b></span>
                                            <input type="radio" id="pending" name="actontaken" Value="yes"> 
                                            <label for="pending">YES</label>
                                            <input type="radio" id="resolved" name="actontaken" Value="no"> 
                                            <label for="resolved">NO</label>
                                        </div>
                                        <div id="purpose" class="text-center">
                                            <span><b>Purpose Completed?</b></span>
                                            <input type="radio" id="presolved" name="purpose" Value="yes"> 
                                            <label for="pending">YES</label>
                                            <input type="radio" id="pnresolved" name="purpose" Value="no"> 
                                            <label for="resolved">NO</label><hr>
                                        </div>
                                        <div id="noremark" class="text-center">
                                            <textarea type="text" class="form-control" name="noremark" placeholder="Remark"></textarea>
                                        </div>
                                        
                                        <div id="ifyes" style="display:none">
                                            <div class="col-12 col-md-12 mb-3">
                                                <label for="validationSample04">Next Status</label>
                                                <select type="text" class="form-control" name="ystatus" placeholder="State" id="ystatus" required>
                                                    <?php $position = $this->Menu_model->get_status();
                                                    foreach($position as $pos){?>
                                                    <option value="<?=$pos->id?>"><?=$pos->name?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-12 mb-12">
                                                <label for="remark_msg">Remarks</label>
                                                <textarea type="text" class="form-control" name="pyremark_msg" id="remark_msg"  required></textarea>
                                                <div class="invalid-feedback">.</div>
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                        </div>
                                        
                                        <div id="ifno" style="display:none">
                                            <div class="col-12 col-md-12 mb-12">
                                                <label for="remark_msg">Remarks</label>
                                                <textarea type="text" class="form-control" name="pnoremark_msg" id="remark_msg"  required></textarea>
                                                <div class="invalid-feedback">.</div>
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary mt-3" onclick="this.form.submit(); this.disabled = true;">Submit</button>
                                        </div>

                                </form>
                                </div>
                            </div>
                        </div>
                </div> <!-- // END .modal-body -->
                
</div></div></div>
                
        
        
 
  

  <!-- Script -->
  



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type='text/javascript'>
$(document).ready(function(){	
    $('[id^="add_plan"]').on('click', function() {
        var tid = this.value;
        $('#doaction').modal('show');
        document.getElementById("taskid").value = tid;
    });




    $('[id^="add_act"]').on('click', function() {
        var tid = this.value;
        $('#add_note').modal('show');
        $.ajax({
             url:'<?=base_url();?>Menu/cctd',
             method: 'post',
             data: {tid: tid},
             dataType: 'json',
             success: function(response){
               var len = response.length;
               $('#cname').text('');
               if(len > 0){
                 // Read values
                 var lupdate = response[0].lupdate;
                 var aname = response[0].aname;
                 var ls = response[0].ls;
                 var cs = response[0].cs;
                 var cid = response[0].cid;
                 var cname = response[0].cname;
                 var pname = response[0].pname;
                 var cemail = response[0].cemail;
                 var cmo = response[0].cmo;
                 var cwno = response[0].cwno;
                 var cifield = response[0].cifield;
                 var lupdate = response[0].lupdate;
                 var address = response[0].address;
                 var city = response[0].city;
                 var state = response[0].state;
                 
                 document.getElementById("tid").value = tid;
                 
                 document.getElementById("ctname").innerHTML = aname;
                 document.getElementById("clsname").innerHTML = ls;
                 document.getElementById("lupdate").innerHTML = lupdate;
                 document.getElementById("cremarks").innerHTML = lupdate;
                 document.getElementById("cname").innerHTML = cname;
                 document.getElementById("position").innerHTML = pname;
                 document.getElementById("phoneno").innerHTML = cmo;
                 document.getElementById("emailid").innerHTML = cemail;
                 document.getElementById("address").innerHTML = address;
                 document.getElementById("city").innerHTML = city;
                 document.getElementById("state").innerHTML = state;
                 
                 document.getElementById("clink").href = "tel:+91"+cmo;
                 document.getElementById("wlink").href = "https://wa.me/+91"+cmo;
                 document.getElementById("glink").href = "mailto:"+cemail;
                 document.getElementById("cmplink").href = "CandidateDetails/"+cid;
               }
             }
           });
            
           
      });
  
});


$("#purpose").hide();
$("#noremark").hide();

let resul1 = document.querySelector('#resul1');
document.body.addEventListener('change', function (f) {
    let target = f.target;
    let message;
    switch (target.id) {
        case 'pending':
            $("#purpose").show();
            $("#noremark").hide();
            break;
        case 'resolved':
            $("#purpose").hide();
            $("#noremark").show();
            callab();
            break;
    }
    resul.textContent = message;
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
                url:'<?=base_url();?>Menu/getstatusbd',
                type: "POST",
                data: {
                cstatus: cstatus
                },
                cache: false,
                success: function a(result){
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
                url:'<?=base_url();?>Menu/mainremark',
                type: "POST",
                data: {
                status_id: status_id
                },
                cache: false,
                success: function a(result){
                $("#tremark").html(result);
                }
                });
            callab();
            break;
    }
    resul.textContent = message;
});

</script>