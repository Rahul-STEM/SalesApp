from django.shortcuts import render, HttpResponse, redirect
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.db.models import Q
from . import models
from . import forms
import datetime

# reportssql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id"
# reportssql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id"
reportssql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id"
# Create your views here.
def login_page(request):
    if request.user.is_authenticated:
        return redirect('/homepage')
    else:
        return render(request, 'login.html')


def login_validator(request):
    if request.method == "POST":
        user = authenticate(username=request.POST['username'], password=request.POST['password'])
        if user is not None:
            if user.is_active:
                login(request, user)
                return redirect('/homepage')
            else:
                return HttpResponse("User is not active")
        else:
            return render(request, 'login.html',{"msg":"Username or password did not match!"})
    else:
        return HttpResponse(status=404)


def logout_user(request):
    logout(request)
    return redirect('/')

def check_notification(request):
    if request.user.is_superuser:
        notifications=models.notification.objects.raw("select * from notification where status='pending' ")
    else:
        notifications=models.notification.objects.raw("select * from notification where user='"+str(request.user.id)+"' and status='pending' ")
    if len(notifications)>0:
        return HttpResponse('<span class="badge badge-danger">new</span>')
    else:
        return HttpResponse(request.user.last_name[:1])

def update_notification(request,id):
    models.notification.objects.filter(id=id).update(status='read')
    return HttpResponse('ok')
        
@login_required(login_url='/')
def notifications(request):
    if request.user.is_superuser:
        notifications=models.notification.objects.raw("select * from notification where status='pending' order by id desc")
    else:
        notifications=models.notification.objects.raw("select * from notification where user='"+str(request.user.id)+"' and status='pending' order by id desc ")
    return render(request,'notifications.html',{"notifications":notifications})
    

@login_required(login_url='/')
def homepage(request):
    notifications=models.notification.objects.raw("select * from notification where user='"+str(request.user.id)+"' and status='pending' ")
    sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
    
    if request.user.is_superuser:

        return redirect('/Admin-dashboard')
    else:
        if request.method == "POST":
            from datetime import datetime, date
            date = date.today()

            from_date = request.POST['from'] + " 00:00:00"
            to_date = request.POST['to'] + " 23:59:59"
            user = models.users.objects.get(user=request.user)
            if user.type_id == 1:
                users = models.users.objects.filter()
            elif user.type_id == 2:
                users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                    status='active')
            else:
                users = models.users.objects.filter(user=request.user).filter(status='active')
            usrs = []
            for us in users:
                usrs.append(us.user_id)
            if user.type_id == 3:
                data = models.tblcallevents.objects.raw(
                    'SELECT  company_master.*,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id WHERE t1.assignedto_id =' + str(
                        request.user.id) + ' and t1.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  and nextCFID=0 and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id)   order by t1.appointmentdatetime ASC')
            else:
                data = models.tblcallevents.objects.raw(
                    'SELECT  company_master.*,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id WHERE t1.assignedto_id in %s' % (
                        tuple(
                            usrs),) + ' and t1.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  and nextCFID=0 and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id)   order by t1.appointmentdatetime ASC')
            emails = []
            calls = []
            meets = []
            for dt in data:
                if dt.actiontype_id == 1:
                    calls.append(dt)
                elif dt.actiontype_id == 2:
                    emails.append(dt)
                elif dt.actiontype_id == 3:
                    meets.append(dt)

            if user.type_id == 2:
                # sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
                opentoreachoutquery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='8' and next_event.status_id='2')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                opentoopen_rpemquery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='1' and next_event.status_id='8')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                reachouttotentetivequery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='2' and next_event.status_id='3')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                tentativetopositivequery = "WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                positivetoverypositivequery = "WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='6' and next_event.status_id='9')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                positivetoclosurequery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='6' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                verypositivetoclosurequery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='9' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                others = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (  cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')"
                # return HttpResponse(sql+others)
                opentoreachout = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
                opentoopen_rpem = models.tblcallevents.objects.raw(sql + opentoopen_rpemquery)
                reachouttotentetive = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
                tentativetopositive = models.tblcallevents.objects.raw(sql + tentativetopositivequery)
                positivetoclosure = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
                positivetoverypositive = models.tblcallevents.objects.raw(
                    sql + positivetoverypositivequery)
                verypositivetoclosure = models.tblcallevents.objects.raw(
                    sql + verypositivetoclosurequery)
                others = models.tblcallevents.objects.raw(
                    sql + others)
            elif user.type_id == 3:
                # sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
                opentoreachoutquery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='8' and next_event.status_id='2')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                opentoopen_rpemquery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='1' and next_event.status_id='8')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                reachouttotentetivequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='2' and next_event.status_id='3')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                tentativetopositivequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                positivetoverypositivequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='6' and next_event.status_id='9')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                positivetoclosurequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='6' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                verypositivetoclosurequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='9' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + "')"
                others = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (  cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')"
                # return HttpResponse(sql+others)
                opentoreachout = models.tblcallevents.objects.raw(
                    sql + opentoreachoutquery)
                opentoopen_rpem = models.tblcallevents.objects.raw(
                    sql + opentoopen_rpemquery)
                reachouttotentetive = models.tblcallevents.objects.raw(
                    sql + reachouttotentetivequery)
                tentativetopositive = models.tblcallevents.objects.raw(
                    sql + tentativetopositivequery)
                positivetoclosure = models.tblcallevents.objects.raw(
                    sql + positivetoclosurequery)
                positivetoverypositive = models.tblcallevents.objects.raw(
                    sql + positivetoverypositivequery)
                verypositivetoclosure = models.tblcallevents.objects.raw(
                    sql + verypositivetoclosurequery)
                others = models.tblcallevents.objects.raw(
                    sql + others)

            return render(request, "dashboard.html",
                          {"from_date": request.POST['from'],"notifications":len(notifications), "to_date": request.POST['to'],
                           "current_date": date.strftime('%Y-%m-%d'), "data": data,
                           "emails": emails, "calls": calls, "meets": meets, "datacount": len(data),
                           "emailscount": len(emails), "callscount": len(calls), "meetscount": len(meets),
                           "opentoreachout": len(opentoreachout), "opentoopen_rpem": len(opentoopen_rpem),
                           "reachouttotentetive": len(reachouttotentetive),
                           "tentativetopositive": len(tentativetopositive), "positivetoclosure": len(positivetoclosure),
                           "positivetoverypositive":len(positivetoverypositive),"verypositivetoclosure":len(verypositivetoclosure),"others": len(others)})
        else:
            from datetime import date
            date = date.today()
            from_date = date.strftime('%y-%m-%d') + ' 00:00:00'
            to_date = date.strftime('%y-%m-%d') + ' 23:59:59'
            user = models.users.objects.get(user=request.user)
            if user.type_id == 1:
                users = models.users.objects.filter()
            elif user.type_id == 2:
                users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                    status='active')
            else:
                users = models.users.objects.filter(user=request.user).filter(status='active')
            usrs = []
            for us in users:
                usrs.append(us.user_id)

            if user.type_id == 3:
                data = models.tblcallevents.objects.raw(
                    'SELECT  company_master.*,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id WHERE t1.assignedto_id =' + str(
                        request.user.id) + ' and t1.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  and nextCFID=0 and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by t1.appointmentdatetime ASC')
            else:
                data = models.tblcallevents.objects.raw(
                    'SELECT  company_master.*,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id WHERE t1.assignedto_id in %s' % (
                        tuple(
                            usrs),) + ' and t1.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  and nextCFID=0 and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by t1.appointmentdatetime ASC')
            emails = []
            calls = []
            meets = []
            for dt in data:
                if dt.actiontype_id == 1:
                    calls.append(dt)
                elif dt.actiontype_id == 2:
                    emails.append(dt)
                elif dt.actiontype_id == 3:
                    meets.append(dt)
            if user.type_id == 2:
                # sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
                opentoreachoutquery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='8' and next_event.status_id='2')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                opentoopen_rpemquery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='1' and next_event.status_id='8')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                reachouttotentetivequery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='2' and next_event.status_id='3')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                tentativetopositivequery = "WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                positivetoverypositivequery = "WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='6' and next_event.status_id='9')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                positivetoclosurequery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='6' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                verypositivetoclosurequery = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and ( (cr_event.status_id='9' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                others = " WHERE cr_event.assignedto_id in %s " % (tuple(
                    usrs),) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (  cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')"
                # return HttpResponse(sql+others)
                opentoreachout = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
                opentoopen_rpem = models.tblcallevents.objects.raw(sql + opentoopen_rpemquery)
                reachouttotentetive = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
                tentativetopositive = models.tblcallevents.objects.raw(sql + tentativetopositivequery)
                positivetoclosure = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
                positivetoverypositive = models.tblcallevents.objects.raw(
                    sql + positivetoverypositivequery)
                verypositivetoclosure = models.tblcallevents.objects.raw(
                    sql + verypositivetoclosurequery)
                others = models.tblcallevents.objects.raw(
                    sql + others)
            elif user.type_id == 3:
                # sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
                opentoreachoutquery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='8' and next_event.status_id='2')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                opentoopen_rpemquery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='1' and next_event.status_id='8')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                reachouttotentetivequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='2' and next_event.status_id='3')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                tentativetopositivequery = "WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                positivetoclosurequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='6' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                positivetoverypositivequery = "WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='6' and next_event.status_id='9')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                verypositivetoclosurequery = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and ( (cr_event.status_id='9' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
                others = " WHERE cr_event.assignedto_id=" + str(
                    request.user.id) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (  cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')"
                # return HttpResponse(sql+others)
                opentoreachout = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
                opentoopen_rpem = models.tblcallevents.objects.raw(sql + opentoopen_rpemquery)
                reachouttotentetive = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
                tentativetopositive = models.tblcallevents.objects.raw(sql + tentativetopositivequery)
                positivetoclosure = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
                positivetoverypositive = models.tblcallevents.objects.raw(
                    sql + positivetoverypositivequery)
                verypositivetoclosure = models.tblcallevents.objects.raw(
                    sql + verypositivetoclosurequery)
                others = models.tblcallevents.objects.raw(
                    sql + others)

            return render(request, "dashboard.html",
                          {"from_date": date.strftime('%Y-%m-%d'),"notifications":len(notifications), "to_date": date.strftime('%Y-%m-%d'), "data": data,
                           "emails": emails, "calls": calls, "current_date": date.strftime('%Y-%m-%d'), "meets": meets,
                           "datacount": len(data),
                           "emailscount": len(emails), "callscount": len(calls), "meetscount": len(meets),
                           "opentoreachout": len(opentoreachout), "opentoopen_rpem": len(opentoopen_rpem),
                           "reachouttotentetive": len(reachouttotentetive),
                           "tentativetopositive": len(tentativetopositive), "positivetoclosure": len(positivetoclosure),
                           "positivetoverypositive":len(positivetoverypositive),"verypositivetoclosure":len(verypositivetoclosure),"others": len(others)})


@login_required(login_url='/')
def admin_dashboard(request):
    notifications=models.notification.objects.raw("select * from notification where status='pending' ")
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()

        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        data = models.tblcallevents.objects.raw(
            'SELECT  company_master.*,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id WHERE t1.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  and nextCFID=0 and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by t1.appointmentdatetime ASC')
        emails = []
        calls = []
        meets = []
        for dt in data:
            if dt.actiontype_id == 1:
                calls.append(dt)
            elif dt.actiontype_id == 2:
                emails.append(dt)
            elif dt.actiontype_id == 3:
                meets.append(dt)
        sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
        opentoreachoutquery = " WHERE ( (cr_event.status_id='8' and next_event.status_id='2')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        opentoopen_rpemquery = " WHERE ( (cr_event.status_id='1' and next_event.status_id='8')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        reachouttotentetivequery = " WHERE ( (cr_event.status_id='2' and next_event.status_id='3')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        tentativetopositivequery = "WHERE ( (cr_event.status_id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        positivetoclosurequery = " WHERE ( (cr_event.status_id='6' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        positivetoverypositivequery = "WHERE ( (cr_event.status_id='6' and next_event.status_id='9')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        verypositivetoclosurequery = " WHERE ( (cr_event.status_id='9' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        others = " WHERE  not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        opentoreachout = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
        opentoopen_rpem = models.tblcallevents.objects.raw(sql + opentoopen_rpemquery)
        reachouttotentetive = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
        tentativetopositive = models.tblcallevents.objects.raw(sql + tentativetopositivequery)
        positivetoclosure = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
        positivetoverypositive = models.tblcallevents.objects.raw(sql + positivetoverypositivequery)
        verypositivetoclosure = models.tblcallevents.objects.raw(sql + verypositivetoclosurequery)
        others = models.tblcallevents.objects.raw(sql + others)

        return render(request, "super-admin/dashboard.html",
                      {"from_date": from_date, "to_date": request.POST['to'],"notifications":len(notifications), "data": data, "emails": emails,
                       "calls": calls, "meets": meets, "datacount": len(data),
                       "emailscount": len(emails), "callscount": len(calls), "meetscount": len(meets),
                       "opentoreachout": len(opentoreachout), "opentoopen_rpem": len(opentoopen_rpem),
                       "reachouttotentetive": len(reachouttotentetive),
                       "tentativetopositive": len(tentativetopositive), "positivetoclosure": len(positivetoclosure),"positivetoverypositive":len(positivetoverypositive),"verypositivetoclosure":len(verypositivetoclosure),
                       "others": len(others)})
    else:
        from datetime import date
        date = date.today()
        from_date = date.strftime('%Y-%m-%d') + ' 00:00:00'
        to_date = date.strftime('%Y-%m-%d') + ' 23:59:59'

        data = models.tblcallevents.objects.raw(
            'SELECT  company_master.*,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id WHERE t1.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  and nextCFID=0 and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by t1.appointmentdatetime ASC')
        emails = []
        calls = []
        meets = []
        for dt in data:
            if dt.actiontype_id == 1:
                calls.append(dt)
            elif dt.actiontype_id == 2:
                emails.append(dt)
            elif dt.actiontype_id == 3:
                meets.append(dt)
        strdate = date.today().strftime('%Y-%m-%d')
        sql = "select * from tblcallevents cr_event join tblcallevents next_event on cr_event.nextCFID=next_event.id "
        opentoreachoutquery = " WHERE ( (cr_event.status_id='8' and next_event.status_id='2')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        opentoopen_rpemquery = " WHERE ( (cr_event.status_id='1' and next_event.status_id='8')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        reachouttotentetivequery = " WHERE ( (cr_event.status_id='2' and next_event.status_id='3')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        tentativetopositivequery = "WHERE ( (cr_event.status_id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        positivetoclosurequery = " WHERE ( (cr_event.status_id='6' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        positivetoverypositivequery = "WHERE ( (cr_event.status_id='6' and next_event.status_id='9')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        verypositivetoclosurequery = " WHERE ( (cr_event.status_id='9' and next_event.status_id='7')) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        others = " WHERE not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (cr_event.appointmentdatetime between '" + from_date + "' and '" + to_date + " 23:59:59')"
        opentoreachout = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
        opentoopen_rpem = models.tblcallevents.objects.raw(sql + opentoopen_rpemquery)
        reachouttotentetive = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
        tentativetopositive = models.tblcallevents.objects.raw(sql + tentativetopositivequery)
        positivetoclosure = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
        positivetoverypositive = models.tblcallevents.objects.raw(sql + positivetoverypositivequery)
        verypositivetoclosure = models.tblcallevents.objects.raw(sql + verypositivetoclosurequery)
        others = models.tblcallevents.objects.raw(sql + others)

        return render(request, "super-admin/dashboard.html",
                      {"from_date": date.strftime('%Y-%m-%d'), "to_date": date.strftime('%Y-%m-%d'),"notifications":len(notifications), "data": data,
                       "emails": emails, "calls": calls, "meets": meets, "datacount": len(data),
                       "emailscount": len(emails), "callscount": len(calls), "meetscount": len(meets),
                       "opentoreachout": len(opentoreachout), "opentoopen_rpem": len(opentoopen_rpem),
                       "reachouttotentetive": len(reachouttotentetive),
                       "tentativetopositive": len(tentativetopositive), "positivetoclosure": len(positivetoclosure),"positivetoverypositive":len(positivetoverypositive),"verypositivetoclosure":len(verypositivetoclosure),
                       "others": len(others)})


@login_required(login_url='/')
def new_lead(request):
    add_leadform = forms.add_leadForm
    add_company = forms.add_companyForm
    add_companycontact = forms.add_companycontact
    states = models.state.objects.filter()
    all_users = models.users.objects.filter()
    action = models.actions.objects.filter()
    status = models.status.objects.filter()
    date = datetime.datetime.now()
    return render(request, "add_new_lead.html",
                  {"states": states, "status": status, "date": date, 'action': action, 'add_company': add_company,
                   'add_companycontact': add_companycontact, 'add_lead': add_leadform, "all_users": all_users})


@login_required(login_url='/')
def get_city(request, id):
    city = models.city.objects.filter(state_id=id)
    html = "<option value=''>Select City</select>"
    for ct in city:
        html = html + "<option value=" + str(ct.city) + ">" + ct.city + "</option>"
    return HttpResponse(html)


@login_required(login_url='/')
def add_company_data(request):
    compname = request.GET['compname']
    city = request.GET['city']
    draft = request.GET['draft']
    budget = request.GET['budget']
    state = request.GET['state']
    address = request.GET['address']
    country = request.GET['country']
    website = request.GET['website']
    partnerType = request.GET['partnerType']
    # state_d = models.state.objects.get(id=state)
    form = models.company_master(compname=compname, city=city, draft=draft, budget=budget, state=state, address=address,
                                 country=country, website=website, partnerType_id=partnerType)
    form.save()
    import json
    returnstatus = '{"status":"200","id":"' + str(form.id) + '","title":"' + form.compname + '"}'
    return HttpResponse(returnstatus)


@login_required(login_url='/')
def get_company_contact(request):
    company_contact = models.company_contact_master.objects.filter(company_id=request.GET['comp_id'])
    html = ""
    for ct in company_contact:
        html = html + "<option value=" + str(ct.id) + ">" + ct.contactperson + "</option>"
    return HttpResponse(html)


@login_required(login_url='/')
def add_contact(request):
    if request.method == "POST":
        compname = request.POST['compname']
        emailid = request.POST['emailid']
        phoneno = request.POST['phoneno']
        draft = request.POST['draft']
        compconname = request.POST['compconname']
        designation = request.POST['designation']

        form = models.company_contact_master(company_id=compname, contactperson=compconname, emailid=emailid,
                                             draft=draft, phoneno=phoneno,
                                             designation=designation)
        form.save()

        return redirect('/company/' + str(compname))
    else:
        compname = request.GET['compname']
        emailid = request.GET['emailid']
        phoneno = request.GET['phoneno']
        draft = request.GET['draft']
        compconname = request.GET['compconname']
        designation = request.GET['designation']

        form = models.company_contact_master(company_id=compname, contactperson=compconname, emailid=emailid,
                                             draft=draft, phoneno=phoneno,
                                             designation=designation)
        form.save()
        returnstatus = '{"status":200}'
        return HttpResponse(returnstatus)


@login_required(login_url='/')
def get_remark(request):
    remark = models.todays_remark.objects.filter(status_id=request.GET['status'])
    html = '<option value="">Select Remark</option>'
    for dt in remark:
        html = html + '<option value="' + str(dt.id) + '">' + dt.name + '</option>'
    return HttpResponse(html)


@login_required(login_url='/')
def get_purpose(request):
    purpose = models.purpose.objects.filter(status_id=request.GET['status']).filter(action_id=request.GET['action'])
    html = '<option value="">Select Purpose</option>'
    for dt in purpose:
        html = html + '<option value="' + str(dt.id) + '">' + dt.name + '</option>'
    return HttpResponse(html)


@login_required(login_url='/')
def get_next_action(request):
    next_action = models.next_action.objects.filter(purpose_id=request.GET['purpose'])
    html = '<option value="">Select Next Action</option>'
    for dt in next_action:
        html = html + '<option value="' + str(dt.id) + '">' + dt.name + '</option>'
    return HttpResponse(html)


@login_required(login_url='/')
def add_new_lead(request):
    compname = request.POST['compname']
    company_contact = request.POST['company_contact']
    assign_to = request.POST['assign_to']
    action_date = request.POST['action_date']
    action_hour = request.POST['action_hour']
    action_min = request.POST['action_min']
    status = request.POST['status']
    remark = request.POST['remark_msg']
    action = request.POST['action']
    purpose = request.POST['purpose']
    next_action = request.POST['next_action']
    next_action_date = action_date + ' ' + action_hour + ':' + action_min + ':00'
    form3 = models.tblcalls(cmpid_id=compname, draft=remark, creator=request.user, proposal='no', topspender='no')
    form3.save()
    form4 = models.tblcallevents(cid_id=form3.id, user=request.user, nextCFID=0, draft=remark, status_id=status,
                                 event='', purpose_id=purpose, remarks=remark, fwd_date=next_action_date,
                                 appointmentdatetime=next_action_date, actiontype_id=action, actontaken='no',
                                 assignedto_id=assign_to, nextaction=next_action)
    form4.save()
    models.tblcallevents.objects.filter(id=form4.id).update(lastCFID=form4.id)
    return redirect('/')


@login_required(login_url='/')
def company_details(request, company_id):
    company_details = models.tblcalls.objects.filter(cmpid=company_id)[:1].get()
    events = models.tblcallevents.objects.filter(cid=company_details).order_by('-id')
    events_id = models.tblcallevents.objects.filter(cid=company_details).order_by('-id')[:1].get()
    logs = models.tblcallevents.objects.filter(cid=company_details).count()
    current_status = models.tblcallevents.objects.filter(cid=company_details).order_by('-id')[:1].get()
    open = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=1).count()
    open_rpem = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=8).count()
    reachout = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=2).count()
    tentative = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=3).count()
    will_do = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=4).count()
    ni = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=5).count()
    positive = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=6).count()
    very_positive = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=9).count()
    closure = models.tblcallevents.objects.filter(cid=company_details).filter(status_id=7).count()
    asc_events = models.tblcallevents.objects.filter(cid=company_details).order_by('id')
    last_status = ''
    last_date = ''
    next_status = ''
    next_date = ''

    last_status_count = 0
    conversions = []
    for ae in asc_events:
        if len(conversions) > 0 or last_status != '':
            if next_status != '':
                if next_status == ae.status:
                    last_status_count = last_status_count + 1
                    next_date = ae.fwd_date
                else:
                    conversions.append({'last_status': last_status, 'last_date': last_date, 'next_status': next_status,
                                        'next_date': next_date, 'count': last_status_count})
                    last_status = next_status
                    last_date = next_date
                    next_status = ae.status
                    next_date = ae.fwd_date
                    last_status_count = 0
            else:
                next_status = ae.status
                next_date = ae.fwd_date
                last_status_count = 1

        else:
            last_status = ae.status
            last_date = ae.fwd_date
    conversions.append(
        {'last_status': last_status, 'last_date': last_date, 'next_status': next_status, 'next_date': next_date,
         'count': last_status_count})

    company_contact = models.company_contact_master.objects.filter(company_id=company_id)
    all_users = models.users.objects.filter()
    action = models.actions.objects.filter()
    status = models.status.objects.filter()

    date = datetime.datetime.now()
    return render(request, "company_details.html",
                  {"conversions": conversions, "open": open, "open_rpem": open_rpem, "reachout": reachout,
                   "tentative": tentative, "will_do": will_do, "ni": ni,
                   "positive": positive,"very_positive":very_positive, "closure": closure, "events_id": events_id, "all_users": all_users,
                   "action": action, "status": status, "date": date, "logs": logs, "current_status": current_status,
                   "events": events, "company": company_details, "company_contact": company_contact})


@login_required(login_url='/')
def get_event_details(request):
    data = models.tblcallevents.objects.filter(id=request.GET['event_id'])[:1].get()
    odatacount = models.tblcallevents.objects.filter(id=data.id)[:1].count()
    if odatacount > 0:
        odata = models.tblcallevents.objects.filter(id=data.id)[:1].get()
        return HttpResponse('{"nextactiondate":"' + str(odata.appointmentdatetime.strftime(
            "%Y-%m-%d")) + '","actiontype":"' + data.actiontype.name + '","status":"' + data.status.name + '","purpose":"' + data.purpose.name + '","remark":"' + data.remarks + '","nextaction":"' + data.nextaction + '"}')
    else:
        return HttpResponse(
            '{"nextactiondate":"0000-00-00","actiontype":"' + data.actiontype.name + '","status":"' + data.status.name + '","purpose":"' + data.purpose.name + '","remark":"' + data.remarks + '","nextaction":"' + data.nextaction.name + '"}')


@login_required(login_url='/')
def all_companies(request):
    user = models.users.objects.get(user=request.user)
    status = models.status.objects.filter()
    if request.method == "POST":

        if request.POST['datetype'] == '2':

            if user.type_id == 1:
                users = models.users.objects.filter()
            elif user.type_id == 2:
                users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                    status='active')
            else:
                users = models.users.objects.filter(user=request.user).filter(status='active')
            us = []
            for urs in users:
                us.append(urs.user_id)

            from_date = request.POST['from'] + ' 00:00:00'
            to_date = request.POST['to'] + ' 23:59:59'
            if request.POST['from'] != '' and request.POST['to'] != '':

                if request.POST['user'] != '':
                    data = models.tblcalls.objects.raw(
                        'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id left join action on action.id=t1.actiontype_id WHERE t1.assignedto_id =' +
                        request.POST[
                            "user"] + ' and company_master.createddate between "' + from_date + '" and "' + to_date + '"   and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc'
                    )
                    # return HttpResponse('SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id WHERE t1.assignedto_id ='+request.POST["user"] + ' and company_master.createddate between "' + from_date + '" and "' + to_date + '"   and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
                else:
                    if user.type_id == 3:
                        data = models.tblcalls.objects.raw(
                            'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id left join action on action.id=t1.actiontype_id WHERE t1.assignedto_id =' + str(
                                request.user.id) + ' and company_master.createddate between "' + from_date + '" and "' + to_date + '"   and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
                    else:
                        data = models.tblcalls.objects.raw(
                            'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id left join action on action.id=t1.actiontype_id WHERE t1.assignedto_id in %s' % (
                                tuple(
                                    us),) + ' and company_master.createddate between "' + from_date + '" and "' + to_date + '"   and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
                        # return HttpResponse('select con.*,company_master.*,company_master.id as cmpny_id,user_details.name,(select status.name from tblcallevents left join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id) as totaltask,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets,(select status.id from tblcallevents left join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as status_id,(select remarks from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as last_remark from company_contact_master con left join company_master on con.company_id=company_master.id left join init_call on init_call.cmpid_id=company_master.id left join user_details on init_call.creator_id=user_details.user_id WHERE init_call.creator_id in %s' % (tuple(usrs),) + ' and company_master.createddate between "' + from_date + '" and "' + to_date + '" order by company_master.id DESC')
            else:
                if request.POST['user'] != '':
                    data = models.tblcalls.objects.raw(
                        'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id left join action on action.id=t1.actiontype_id WHERE t1.assignedto_id =' +
                        request.POST[
                            "user"] + '  and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
                    # return HttpResponse('SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id WHERE t1.assignedto_id ='+request.POST["user"]+'  and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
                else:

                    if user.type_id == 3:
                        data = models.tblcalls.objects.raw(
                            'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id left join action on action.id=t1.actiontype_id WHERE t1.assignedto_id =' + str(
                                request.user.id) + '  and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
                    else:

                        data = models.tblcalls.objects.raw(
                            'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 left join init_call on t1.cid_id=init_call.id  left join company_master on init_call.cmpid_id=company_master.id left join company_contact_master on company_contact_master.company_id=company_master.id left join partner_master on company_master.partnerType_id=partner_master.id left join user_details on t1.assignedto_id=user_details.user_id left join status on t1.status_id=status.id left join action on action.id=t1.actiontype_id WHERE t1.assignedto_id in %s' % (
                                tuple(
                                    us),) + '  and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
            srdata = []
            if request.POST['status'] != '':
                for dt in data:
                    if dt.status_id == int(request.POST['status']):
                        srdata.append(dt)
                data = srdata

            total = 0
            open = 0
            open_rpem = 0
            reachout = 0
            tentative = 0
            will_do_later = 0
            ni = 0
            positive=0
            very_positive = 0
            closure = 0
            totaltask = 0
            calls = 0
            emails = 0
            meets = 0
            for st in data:
                total = total + 1

                calls = calls + st.calls
                emails = emails + st.emails
                meets = meets + st.meets
                if st.status_id == 1:
                    open = open + 1
                elif st.status_id == 8:
                    open_rpem = open_rpem + 1
                elif st.status_id == 2:
                    reachout = reachout + 1
                elif st.status_id == 3:
                    tentative = tentative + 1
                elif st.status_id == 4:
                    will_do_later = will_do_later + 1
                elif st.status_id == 5:
                    ni = ni + 1
                elif st.status_id == 6:
                    positive = positive + 1
                elif st.status_id == 9:
                    very_positive = very_positive + 1
                elif st.status_id == 7:
                    closure = closure + 1

            return render(request, "created_wise_companies.html",
                          {"data": data, "total": total, "users": users, "status": status, "open": open,
                           "open_rpem": open_rpem,
                           "reachout": reachout, "tentative": tentative, "will_do_later": will_do_later, "ni": ni,
                           "positive": positive,"very_positive": very_positive, "closure": closure, "totaltask": totaltask, "calls": calls,
                           "emails": emails, "meets": meets, "from": request.POST['from'], "to": request.POST['to']})
        elif request.POST['datetype'] == '1':
            ddataquery='SELECT cr_event.id,(select status.id from status join tblcallevents g1 on g1.status_id=status.id where g1.id=(select max(id) from tblcallevents h1 where h1.cid_id=cr_event.cid_id ) ) as status_id,(select status.name from status join tblcallevents g1 on g1.status_id=status.id where g1.id=(select max(id) from tblcallevents h1 where h1.cid_id=cr_event.cid_id ) ) as current_status from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id'
            if user.type_id == 1:
                users = models.users.objects.filter()
            elif user.type_id == 2:
                users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                    status='active')
            else:
                users = models.users.objects.filter(user=request.user).filter(status='active')
            us = []
            for urs in users:
                us.append(urs.user_id)

            from_date = request.POST['from'] + ' 00:00:00'
            to_date = request.POST['to'] + ' 23:59:59'
            if request.POST['from'] != '' and request.POST['to'] != '':
                if request.POST['user'] != '':
                    data = models.tblcalls.objects.raw(
                        'SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.assignedto_id =' +
                        request.POST[
                            "user"] + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id)) and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  GROUP by cr_event.id  order by init_call.id desc'
                    )
                    ddata = models.tblcalls.objects.raw(
                        ddataquery+' WHERE cr_event.assignedto_id =' +
                        request.POST[
                            "user"] + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id)) and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '"  GROUP by cr_event.cid_id  order by init_call.id desc'
                    )
                else:
                    if user.type_id == 3:
                        data = models.tblcalls.objects.raw(
                            'SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.assignedto_id =' + str(
                                request.user.id) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id)) and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '"    GROUP by cr_event.id  order by init_call.id desc')
                        ddata = models.tblcalls.objects.raw(
                            ddataquery+' WHERE cr_event.assignedto_id =' + str(
                                request.user.id) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id)) and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '"    GROUP by cr_event.cid_id  order by init_call.id desc')
                    else:
                        ddata = models.tblcalls.objects.raw(
                            ddataquery+' WHERE cr_event.assignedto_id in %s' % (
                                tuple(
                                    us),) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id)) and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '"   GROUP by cr_event.cid_id  order by init_call.id desc')
                        data = models.tblcalls.objects.raw(
                            'SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.assignedto_id in %s' % (
                                tuple(
                                    us),) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id)) and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '"   GROUP by cr_event.id  order by init_call.id desc')

            else:
                if request.POST['user'] != '':
                    ddata = models.tblcalls.objects.raw(
                        ddataquery+' WHERE cr_event.assignedto_id =' +
                        request.POST[
                            "user"] + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id))  GROUP by cr_event.cid_id  order by init_call.id desc')
                    data = models.tblcalls.objects.raw(
                        'SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.assignedto_id =' +
                        request.POST[
                            "user"] + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id))  GROUP by cr_event.id  order by init_call.id desc')
                    # return HttpResponse('select con.*,company_master.*,company_master.id as cmpny_id,user_details.name,(select status.name from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id) as totaltask,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets,(select status.id from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as status_id,(select remarks from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as last_remark from company_contact_master con join company_master on con.company_id=company_master.id JOIN init_call on init_call.cmpid_id=company_master.id join user_details on init_call.creator_id=user_details.user_id WHERE init_call.creator_id =' +request.POST["user"] + '   order by company_master.id DESC')
                else:
                    if user.type_id == 3:
                        ddata = models.tblcalls.objects.raw(
                            ddataquery+' WHERE cr_event.assignedto_id =' + str(
                                request.user.id) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id))   GROUP by cr_event.cid_id  order by init_call.id desc')
                        data = models.tblcalls.objects.raw(
                            'SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.assignedto_id =' + str(
                                request.user.id) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id))   GROUP by cr_event.id  order by init_call.id desc')
                        # return HttpResponse('select con.*,company_master.*,company_master.id as cmpny_id,init_call.creator_id,user_details.name,(select assignedto_id from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as assignedto,(select status.name from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id) as totaltask,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets,(select status.id from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as status_id,(select remarks from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as last_remark from company_contact_master con join company_master on con.company_id=company_master.id JOIN init_call on init_call.cmpid_id=company_master.id join user_details on init_call.creator_id=user_details.user_id WHERE init_call.creator_id =' + str(
                        #         request.user.id) + '   order by company_master.id DESC')
                    else:
                        ddata = models.tblcalls.objects.raw(
                            ddataquery+' WHERE cr_event.assignedto_id in %s' % (
                                tuple(
                                    us),) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id))  GROUP by cr_event.cid_id  order by init_call.id desc')
                        data = models.tblcalls.objects.raw(
                            'SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id WHERE cr_event.assignedto_id in %s' % (
                                tuple(
                                    us),) + ' and cr_event.assignedto_id=(SELECT t3.assignedto_id from tblcallevents t3 where t3.id=(select max(id) from tblcallevents t2 WHERE t2.cid_id=cr_event.cid_id))  GROUP by cr_event.id  order by init_call.id desc')
            srdata = []
            if request.POST['status'] != '':
                for dt in data:
                    if dt.status_id == int(request.POST['status']):
                        srdata.append(dt)
                data = srdata

            total = 0
            open = 0
            open_rpem = 0
            reachout = 0
            tentative = 0
            will_do_later = 0
            ni = 0
            very_positive = 0
            positive=0
            closure = 0
            totaltask = 0
            calls = 0
            emails = 0
            meets = 0
            for sst in data:
                total = total + 1
                if sst.actiontype_id == 1:
                    calls = calls + 1
                if sst.actiontype_id == 2:
                    emails = emails + 1
                if sst.actiontype_id == 3:
                    meets = meets + 1
            for st in ddata:
                
                if st.status_id == 1:
                    open = open + 1
                elif st.status_id == 8:
                    open_rpem = open_rpem + 1
                elif st.status_id == 2:
                    reachout = reachout + 1
                elif st.status_id == 3:
                    tentative = tentative + 1
                elif st.status_id == 4:
                    will_do_later = will_do_later + 1
                elif st.status_id == 5:
                    ni = ni + 1
                elif st.status_id == 6:
                    positive = positive + 1
                elif st.status_id == 9:
                    very_positive = very_positive + 1
                elif st.status_id == 7:
                    closure = closure + 1

            return render(request, "planned_reports.html",
                          {"data": data, "total": total, "users": users, "status": status, "open": open,
                           "open_rpem": open_rpem,
                           "reachout": reachout, "tentative": tentative, "will_do_later": will_do_later, "ni": ni,
                           "positive": positive,"very_positive": very_positive, "closure": closure, "totaltask": totaltask, "calls": calls,
                           "emails": emails, "meets": meets, "from": request.POST['from'], "to": request.POST['to']})
    else:
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        us = []
        for urs in users:
            us.append(urs.user_id)
        from datetime import date
        date = date.today()
        if user.type_id == 3:
            data = models.tblcalls.objects.raw(
                'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id join action on action.id=t1.actiontype_id WHERE t1.assignedto_id =' + str(
                    request.user.id) + '  and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc')
            # return HttpResponse('select con.*,company_master.*,company_master.id as cmpny_id,user_details.name,(select assignedto_id from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as assignedto,(select status.name from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id) as totaltask,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets,(select status.id from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as status_id,(select remarks from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by tblcallevents.id DESC LIMIT 1) as last_remark from company_contact_master con join company_master on con.company_id=company_master.id JOIN init_call on init_call.cmpid_id=company_master.id join user_details on init_call.creator_id=user_details.user_id WHERE init_call.creator_id =' + str(
            #         request.user.id) + '  order by init_call.id desc')
        else:
            data = models.tblcalls.objects.raw(
                'SELECT company_contact_master.contactperson,company_contact_master.emailid,company_contact_master.designation,company_contact_master.phoneno , company_master.*,company_master.id as company_id_id,partner_master.name as partner_type,init_call.*,t1.*,user_details.name,status.name as current_status,action.name as current_action,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id ) as totalLogs,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets from tblcallevents t1 join init_call on t1.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on t1.assignedto_id=user_details.user_id JOIN status on t1.status_id=status.id join action on action.id=t1.actiontype_id WHERE t1.assignedto_id in %s' % (
                    tuple(
                        us),) + '  and t1.id=(SELECT max(id) from tblcallevents t2 WHERE t2.cid_id=t1.cid_id) GROUP by company_master.id  order by init_call.id desc limit 250')
        total = 0
        open = 0
        open_rpem = 0
        reachout = 0
        tentative = 0
        will_do_later = 0
        ni = 0
        very_positive = 0
        positive=0
        closure = 0
        totaltask = 0
        calls = 0
        emails = 0
        meets = 0

        for st in data:
            total = total + 1
            calls = calls + st.calls
            emails = emails + st.emails
            meets = meets + st.meets
            if st.status_id == 1:
                open = open + 1
            elif st.status_id == 8:
                open_rpem = open_rpem + 1
            elif st.status_id == 2:
                reachout = reachout + 1
            elif st.status_id == 3:
                tentative = tentative + 1
            elif st.status_id == 4:
                will_do_later = will_do_later + 1
            elif st.status_id == 5:
                ni = ni + 1
            elif st.status_id == 6:
                positive = positive + 1
            elif st.status_id == 9:
                very_positive = very_positive + 1
            elif st.status_id == 7:
                closure = closure + 1

        return render(request, "companies.html",
                      {"data": data, "users": users, "status": status, "total": total, "open": open,
                       "open_rpem": open_rpem,
                       "reachout": reachout, "tentative": tentative, "will_do_later": will_do_later, "ni": ni,
                       "very_positive": very_positive,"positive": positive, "closure": closure, "totaltask": totaltask, "calls": calls,
                       "emails": emails, "meets": meets})


@login_required(login_url='/')
def reports(request):
    if request.method != "POST":
        user = models.users.objects.get(user=request.user)
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        status = models.status.objects.filter()
        return render(request, "filter_page.html", {"users": users, "status": status})
    else:
        formdata = []
        for fd in request.POST:
            formdata.append(fd + '<br>')
        assign_to = request.POST.getlist('assign_to')
        userquery = ' where'
        if assign_to[0] == '':
            user = models.users.objects.get(user=request.user)
            if user.type_id == 1:
                users = models.users.objects.filter()
                us = []
                for urs in users:
                    us.append(urs.user_id)

                userquery = userquery + ' user_details.user_id in %s' % (tuple(us),)
            elif user.type_id == 2:
                users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                    status='active')
                us = []
                for urs in users:
                    us.append(urs.user_id)

                userquery = userquery + ' user_details.user_id in %s' % (tuple(us),)
            else:
                userquery = userquery + ' user_details.user_id =' + str(request.user.id)


        else:
            if len(assign_to) > 0 and assign_to[0] != '':
                userquery = userquery + ' ( user_details.user_id=' + assign_to[0]

            if len(assign_to) > 1:
                for at in assign_to:
                    userquery = userquery + ' or user_details.user_id=' + at
            if len(assign_to) > 0 and assign_to[0] != '':
                userquery = userquery + ' )'
            elif len(assign_to) == 0:
                userquery = ' where'

        if request.POST['date_type'] != '':

            date_type = request.POST['date_type'].split(',')
            date_type_tables = request.POST['date_type_tables'].split(',')
            from_date = request.POST['from_date']
            to_date = request.POST['to_date']
            # if len(assign_to) > 0 and assign_to[0] != '':
            #     datequery=' and ( '

            # else:
            #     datequery=' ( '
            datequery = ' and ( '
            if len(date_type) > 0:
                datequery = datequery + ' ( ' + date_type_tables[
                    0] + ' between "' + from_date + ' 00:00:00" and "' + to_date + ' 23:59:59" ) '
            count = 0
            if len(date_type) > 1:
                for dt in date_type_tables:
                    datequery = datequery + ' or ( ' + dt + ' between "' + from_date + ' 00:00:00" and "' + to_date + ' 23:59:59" ) '
                    count = count + 1
            if len(date_type) > 0:
                datequery = datequery + ' ) '
            else:
                datequery = ''
        else:
            datequery = ''

        if request.POST['action_type'] != '':

            action_type = request.POST['action_type'].split(',')
            action_typequery = ' and ( '
            if len(action_type) > 0:
                action_typequery = action_typequery + ' cr_action.name = "' + action_type[0] + ' " '
            if len(action_type) > 1:
                for at in action_type:
                    action_typequery = action_typequery + ' or cr_action.name = "' + at + ' " '
            if len(action_type) > 0:
                action_typequery = action_typequery + ' ) '
            else:
                action_typequery = ''
        else:
            action_typequery = ''

        if request.POST['company_category'] != '':
            company_category = request.POST['company_category'].split(',')
            company_categoryquery = ' and ( '
            if len(company_category) > 0:
                company_categoryquery = company_categoryquery + ' company_master.partnerType_id = "' + company_category[
                    0] + '"'
            if len(company_category) > 1:
                for cc in company_category:
                    company_categoryquery = company_categoryquery + ' or company_master.partnerType_id = "' + cc + '" '
            if len(company_category) > 0:
                company_categoryquery = company_categoryquery + ' ) '
            else:
                company_categoryquery = ''
        else:
            company_categoryquery = ''

        if request.POST['action_taken'] != '':
            action_taken = request.POST['action_taken'].split(',')

            if len(action_taken) == 1:
                action_takenquery = " and cr_event.actontaken = '" + action_taken[0] + "'"
            elif len(action_taken):
                action_takenquery = " and ( cr_event.actontaken = '" + action_taken[
                    0] + "' or cr_event.actontaken = '" + action_taken[1] + "' )"
            else:
                action_takenquery = ''
        else:
            action_takenquery = ''

        if request.POST['proposal_sent'] != '':

            proposal_sent = request.POST['proposal_sent'].split(',')

            if len(proposal_sent) == 1:
                proposal_sentquery = " and proposal = '" + proposal_sent[0] + "'"
            elif len(proposal_sent):
                proposal_sentquery = " and ( proposal = '" + proposal_sent[0] + "' or proposal = '" + proposal_sent[
                    1] + "' )"
            else:
                proposal_sentquery = ''
        else:
            proposal_sentquery = ''

        if request.POST['top_spender'] != '':

            top_spender = request.POST['top_spender'].split(',')

            if len(top_spender) == 1:
                top_spenderquery = " and topspender = '" + top_spender[0] + "'"
            elif len(top_spender):
                top_spenderquery = " and ( topspender = '" + top_spender[0] + "' or topspender = '" + top_spender[
                    1] + "' )"
            else:
                top_spenderquery = ''
        else:
            top_spenderquery = ''

        from_status = request.POST['from_status']
        to_status = request.POST['to_status']
        if from_status != '' and to_status != '':
            status_conversion_query = ' and ( cr_status.id="' + from_status + '" and next_status.id="' + to_status + '" )'
        else:
            status_conversion_query = ''


        condition = userquery + datequery + action_typequery + company_categoryquery + action_takenquery + proposal_sentquery + top_spenderquery + status_conversion_query
        query = reportssql + condition + "  group by cr_event.id order by cr_event.appointmentdatetime desc"
        # return HttpResponse(query)
        from datetime import date
        date = date.today()
        data = models.tblcallevents.objects.raw(query)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def get_company_status(request):
    dt = models.tblcallevents.objects.filter(cid=request.GET['calls_id']).order_by('-id')[:1].get()
    dtcalls = models.tblcalls.objects.filter(id=request.GET['calls_id']).order_by('-id')[:1].get()
    contact = models.company_contact_master.objects.filter(company=dtcalls.cmpid)[:1].get()
    return HttpResponse(
        '{"status":"' + dt.status.name + '","remark":"' + dt.remarks + '","contactperson":"' + contact.contactperson + '","emailid":"' + contact.emailid + '","phoneno":"' + contact.phoneno + '","designation":"' + contact.designation + '"}')


@login_required(login_url='/')
def synopsis(request):
    if request.method != "POST":
        user = models.users.objects.get(user=request.user)
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        usrs = []
        for us in users:
            usrs.append(us.user_id)
        from datetime import date
        date = date.today()
        date = date.strftime('%Y-%m-%d')
        from_date = date + " 00:00:00"
        to_date = date + " 23:59:59"
        dataaa = models.tblcallevents.objects.filter(appointmentdatetime__range=(from_date, to_date)).filter(
            Q(assignedto__in=usrs)).filter(Q(actontaken='yes') | Q(actontaken='no'))
        all_data_count = len(dataaa)

        emails = []
        calls = []
        meets = []
        for dt in dataaa:
            if dt.actiontype_id == 1:
                calls.append(dt)
            elif dt.actiontype_id == 2:
                emails.append(dt)
            elif dt.actiontype_id == 3:
                meets.append(dt)
        dataa = models.tblcallevents.objects.filter(appointmentdatetime__range=(from_date, to_date)).filter(
            nextCFID='0').filter(
            Q(assignedto__in=usrs)).filter(Q(actontaken='yes') | Q(actontaken='no'))
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        wiil_do_later = []
        ni = []
        positive = []
        very_positive=[]
        closure = []
        for dtt in dataa:
            if dtt.status_id == 1:
                open.append(dtt)
            elif dtt.status_id == 8:
                open_rpem.append(dtt)
            elif dtt.status_id == 2:
                reachout.append(dtt)
            elif dtt.status_id == 3:
                tentative.append(dtt)
            elif dtt.status_id == 4:
                wiil_do_later.append(dtt)
            elif dtt.status_id == 5:
                ni.append(dtt)
            elif dtt.status_id == 6:
                positive.append(dtt)
            elif dtt.status_id == 9:
                very_positive.append(dtt)
            elif dtt.status_id == 7:
                closure.append(dtt)
        open = len(open)
        open_rpem = len(open_rpem)
        reachout = len(reachout)
        tentative = len(tentative)
        wiil_do_later = len(wiil_do_later)
        ni = len(ni)
        positive = len(positive)
        very_positive=len(very_positive)
        closure = len(closure)

        # for uss in users:
        # dt=models.users.objects.raw("SELECT  a.*, (SELECT Count(*) FROM tblcallevents t1 WHERE t1.assignedto_id = a.user_id and t1.appointmentdatetime between '"+from_date+"' and '"+to_date+"') as totaltaks      , (SELECT Count(*) FROM tblcallevents c1 WHERE c1.assignedto_id = a.user_id and c1.actontaken='yes' and c1.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as completed, (SELECT Count(*) FROM tblcallevents c2 WHERE c2.assignedto_id = a.user_id and c2.actontaken='no' and c2.appointmentdatetime between '"+from_date+"' and '"+to_date+"') as pending, (SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.nextCFID='0' and I1.appointmentdatetime between '"+from_date+"' and '"+to_date+"') as open      , (SELECT Count(I2.status_id) FROM tblcallevents I2 WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.nextCFID='0' and I2.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as reachout      , (SELECT Count(I3.status_id) FROM tblcallevents I3 WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.nextCFID='0' and I3.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as tantative      , (SELECT Count(I4.status_id) FROM tblcallevents I4 WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.nextCFID='0' and I4.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as will_do_later      , (SELECT Count(I5.status_id) FROM tblcallevents I5 WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.nextCFID='0' and I5.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as not_interested      , (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.nextCFID='0' and I6.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as positive      , (SELECT Count(I7.status_id) FROM tblcallevents I7 WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.nextCFID='0' and I7.appointmentdatetime between '"+from_date+"' and '"+to_date+"' ) as closure FROM user_details a where a.id='"+str(uss.user_id)+"'")
        # data.append(dt)
        if user.type_id == 3:
            query = "SELECT  a.*, (SELECT Count(id) FROM tblcallevents t1 WHERE (t1.actontaken='no' or t1.actontaken='yes' ) and t1.assignedto_id = a.user_id  and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as totaltaks      , (SELECT Count(*) FROM tblcallevents c1 WHERE c1.assignedto_id = a.user_id and c1.actontaken='yes' and c1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as completed, (SELECT Count(*) FROM tblcallevents c12 WHERE c12.assignedto_id = a.user_id and c12.actontaken='no' and c12.nextCFID!='0' and c12.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as completed_with_no,(SELECT Count(*) FROM tblcallevents c2 WHERE c2.assignedto_id = a.user_id and c2.actontaken='no' and c2.nextCFID='0' and c2.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as pending, (SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as open      ,(SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as open_rpem      , (SELECT Count(I2.status_id) FROM tblcallevents I2 WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.nextCFID='0' and I2.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as reachout      , (SELECT Count(I3.status_id) FROM tblcallevents I3 WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.nextCFID='0' and I3.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tantative      , (SELECT Count(I4.status_id) FROM tblcallevents I4 WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.nextCFID='0' and I4.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as will_do_later      , (SELECT Count(I5.status_id) FROM tblcallevents I5 WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.nextCFID='0' and I5.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as not_interested      , (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive,(SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as very_positive      , (SELECT Count(I7.status_id) FROM tblcallevents I7 WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.nextCFID='0' and I7.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as closure FROM user_details a where a.status='active' and a.user_id = " + str(
                request.user.id) + ""
            # return HttpResponse(query)

        else:
            query = "SELECT  a.*, (SELECT Count(*) FROM tblcallevents t1 WHERE (t1.actontaken='no' or t1.actontaken='yes' ) and t1.assignedto_id = a.user_id  and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as totaltaks      , (SELECT Count(*) FROM tblcallevents c1 WHERE c1.assignedto_id = a.user_id and c1.actontaken='yes' and c1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as completed, (SELECT Count(*) FROM tblcallevents c12 WHERE c12.assignedto_id = a.user_id and c12.actontaken='no' and c12.nextCFID!='0' and c12.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as completed_with_no,(SELECT Count(*) FROM tblcallevents c2 WHERE c2.assignedto_id = a.user_id and c2.actontaken='no' and c2.nextCFID='0' and c2.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as pending, (SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as open      ,(SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_date + "' and '" + to_date + "') as open_rpem      , (SELECT Count(I2.status_id) FROM tblcallevents I2 WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.nextCFID='0' and I2.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as reachout      , (SELECT Count(I3.status_id) FROM tblcallevents I3 WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.nextCFID='0' and I3.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tantative      , (SELECT Count(I4.status_id) FROM tblcallevents I4 WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.nextCFID='0' and I4.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as will_do_later      , (SELECT Count(I5.status_id) FROM tblcallevents I5 WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.nextCFID='0' and I5.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as not_interested      , (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive,(SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as very_positive      , (SELECT Count(I7.status_id) FROM tblcallevents I7 WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.nextCFID='0' and I7.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as closure FROM user_details a where a.status='active' and a.user_id in %s" % (
                tuple(usrs),)

        # return HttpResponse(query)
        data = models.users.objects.raw(query)
        return render(request, "synopsis.html",
                      {"open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "wiil_do_later": wiil_do_later,
                       "ni": ni, "positive": positive,"very_positive":very_positive, "closure": closure, "total": all_data_count, "users": data,
                       "emails": len(emails),
                       "calls": len(calls), "meets": len(meets), "from": date, "to": date})

    else:
        user = models.users.objects.get(user=request.user)
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        usrs = []
        for us in users:
            usrs.append(us.user_id)
        from datetime import date

        from_data = request.POST["from"] + " 00:00:00"
        to_data = request.POST["to"] + " 23:59:59"
        dataaa = models.tblcallevents.objects.filter(appointmentdatetime__range=(from_data, to_data)).filter(
            Q(assignedto__in=usrs)).filter(Q(actontaken='yes') | Q(actontaken='no'))
        all_data_count = len(dataaa)
        emails = []
        calls = []
        meets = []
        for dt in dataaa:
            if dt.actiontype_id == 1:
                calls.append(dt)
            elif dt.actiontype_id == 2:
                emails.append(dt)
            elif dt.actiontype_id == 3:
                meets.append(dt)
        dataa = models.tblcallevents.objects.filter(appointmentdatetime__range=(from_data, to_data)).filter(
            nextCFID='0').filter(
            Q(assignedto__in=usrs)).filter(Q(actontaken='yes') | Q(actontaken='no'))
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        wiil_do_later = []
        ni = []
        positive = []
        very_positive=[]
        closure = []

        for dtt in dataa:
            if dtt.status_id == 1:
                open.append(dtt)
            elif dtt.status_id == 8:
                open_rpem.append(dtt)
            elif dtt.status_id == 2:
                reachout.append(dtt)
            elif dtt.status_id == 3:
                tentative.append(dtt)
            elif dtt.status_id == 4:
                wiil_do_later.append(dtt)
            elif dtt.status_id == 5:
                ni.append(dtt)
            elif dtt.status_id == 6:
                positive.append(dtt)
            elif dtt.status_id == 9:
                very_positive.append(dtt)
            elif dtt.status_id == 7:
                closure.append(dtt)
        open = len(open)
        open_rpem = len(open_rpem)
        reachout = len(reachout)
        tentative = len(tentative)
        wiil_do_later = len(wiil_do_later)
        ni = len(ni)
        positive = len(positive)
        very_positive = len(very_positive)
        closure = len(closure)

        if user.type_id == 3:
            query = "SELECT  a.*, (SELECT Count(*) FROM tblcallevents t1 WHERE (t1.actontaken='no' or t1.actontaken='yes' ) and t1.assignedto_id = a.user_id  and t1.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as totaltaks      , (SELECT Count(*) FROM tblcallevents c1 WHERE c1.assignedto_id = a.user_id and c1.actontaken='yes' and c1.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as completed, (SELECT Count(*) FROM tblcallevents c12 WHERE c12.assignedto_id = a.user_id and c12.actontaken='no' and c12.nextCFID!='0' and c12.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as completed_with_no,(SELECT Count(*) FROM tblcallevents c2 WHERE c2.assignedto_id = a.user_id and c2.actontaken='no' and c2.nextCFID='0' and c2.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as pending, (SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as open      ,(SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as open_rpem      , (SELECT Count(I2.status_id) FROM tblcallevents I2 WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.nextCFID='0' and I2.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as reachout      , (SELECT Count(I3.status_id) FROM tblcallevents I3 WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.nextCFID='0' and I3.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as tantative      , (SELECT Count(I4.status_id) FROM tblcallevents I4 WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.nextCFID='0' and I4.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as will_do_later      , (SELECT Count(I5.status_id) FROM tblcallevents I5 WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.nextCFID='0' and I5.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as not_interested      , (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as positive, (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as very_positive      , (SELECT Count(I7.status_id) FROM tblcallevents I7 WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.nextCFID='0' and I7.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as closure FROM user_details a where a.status='active' and a.user_id = (" + str(
                request.user.id) + ")"

        else:
            query = "SELECT  a.*, (SELECT Count(*) FROM tblcallevents t1 WHERE (t1.actontaken='no' or t1.actontaken='yes' ) and t1.assignedto_id = a.user_id  and t1.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as totaltaks      , (SELECT Count(*) FROM tblcallevents c1 WHERE c1.assignedto_id = a.user_id and c1.actontaken='yes' and c1.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as completed, (SELECT Count(*) FROM tblcallevents c12 WHERE c12.assignedto_id = a.user_id and c12.actontaken='no' and c12.nextCFID!='0' and c12.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as completed_with_no,(SELECT Count(*) FROM tblcallevents c2 WHERE c2.assignedto_id = a.user_id and c2.actontaken='no' and c2.nextCFID='0' and c2.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as pending, (SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as open      ,(SELECT Count(I1.status_id) FROM tblcallevents I1 WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.nextCFID='0' and I1.appointmentdatetime between '" + from_data + "' and '" + to_data + "') as open_rpem      , (SELECT Count(I2.status_id) FROM tblcallevents I2 WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.nextCFID='0' and I2.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as reachout      , (SELECT Count(I3.status_id) FROM tblcallevents I3 WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.nextCFID='0' and I3.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as tantative      , (SELECT Count(I4.status_id) FROM tblcallevents I4 WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.nextCFID='0' and I4.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as will_do_later      , (SELECT Count(I5.status_id) FROM tblcallevents I5 WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.nextCFID='0' and I5.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as not_interested      , (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as positive, (SELECT Count(I6.status_id) FROM tblcallevents I6 WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.nextCFID='0' and I6.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as very_positive      , (SELECT Count(I7.status_id) FROM tblcallevents I7 WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.nextCFID='0' and I7.appointmentdatetime between '" + from_data + "' and '" + to_data + "' ) as closure FROM user_details a where a.status='active' and a.user_id in %s" % (
                tuple(usrs),)

        data = models.users.objects.raw(query)
        return render(request, "synopsis.html",
                      {"open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "wiil_do_later": wiil_do_later,
                       "ni": ni, "positive": positive,"very_positive":very_positive, "closure": closure, "total": all_data_count, "users": data,
                       "emails": len(emails), "calls": len(calls), "meets": len(meets), "from": request.POST["from"],
                       "to": request.POST["to"]})


@login_required(login_url='/')
def check_remark(request):
    data = models.todays_remark.objects.get(id=request.GET["remark"])
    if data.id == 13 or data.id == 17 or data.id == 20 or data.id == 23 or data.id == 30 or data.id == 35 or data.id == 36 or data.id == 39 or data.id == 42 or data.id == 51:
        return HttpResponse('{"status":false,"msg":"' + data.name + '"}')
    else:
        return HttpResponse('{"status":true,"msg":"' + data.name + '"}')


@login_required(login_url='/')
def add_call_log(request):
    if request.method == "POST":
        cid = request.POST['cid']
        lastCFID = request.POST['lastCFID']
        action_taken = request.POST['action_taken']
        assign_to = request.POST['assign_to']
        action_date = request.POST['action_date']
        action_hour = request.POST['action_hour']
        action_min = request.POST['action_min']
        meeting_type=request.POST['meeting_type']
        live_loaction=request.POST['live_location']

        status = request.POST['status']
        remark = request.POST['remark']
        remark_msg = request.POST['remark_msg']
        proposal_sent = request.POST.get('proposal_sent', False)
        proposal_description = request.POST['proposal_description']
        action = request.POST['action']
        proposal_type=request.POST['proposal_type']
        purpose = request.POST['purpose']
        next_action = request.POST['next_action']
        mom_received=request.POST['mom_received']
        proposal_amt=request.POST['proposal_amt']
        next_action_date = action_date + ' ' + action_hour + ':' + action_min + ':00'
        from datetime import datetime
        date = datetime.now()
        if proposal_sent != False:
            models.tblcalls.objects.filter(cmpid_id=cid).update(draft=proposal_description, proposal=proposal_sent,proposal_type=proposal_type,proposal_amt=proposal_amt,proposaldate=date.today())
        dt = models.tblcalls.objects.filter(cmpid_id=cid)[:1].get()
        if lastCFID:
            lastevent = models.tblcallevents.objects.filter(id=lastCFID)[:1].get()
            count = models.tblcallevents.objects.filter(cid=lastevent.cid).filter(actontaken='no').count()
            if count > 1:
                models.tblcallevents.objects.filter(id=lastCFID).update(draft=proposal_description,
                                                                        actontaken=action_taken, )
            else:
                models.tblcallevents.objects.filter(id=lastCFID).update(draft=proposal_description,
                                                                        actontaken=action_taken)

        form4 = models.tblcallevents(cid_id=dt.id, user=request.user, lastCFID=lastCFID, nextCFID=0, draft=remark,
                                     status_id=status,
                                     event='', purpose_id=purpose,meeting_type=meeting_type,live_loaction=live_loaction,mom_received=mom_received, remarks=remark_msg, fwd_date=date,
                                     appointmentdatetime=next_action_date,
                                     actiontype_id=action, actontaken='no', assignedto_id=assign_to,
                                     nextaction=next_action)
        form4.save()
        models.tblcallevents.objects.filter(id=lastCFID).update(nextCFID=form4.id)
        return redirect('/company/' + cid)
    else:
        return HttpResponse(status=404)


@login_required(login_url='/')
def opentoopenrpem(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"

        if user.type_id == 3:
            # sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " WHERE user_details.user_id = " + str(
                request.user.id) + " and (  (cr_status.id='1' and next_event.status_id='8')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            # sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and (  (cr_status.id='1' and next_event.status_id='8')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"

        # return HttpResponse(sql + opentoreachoutquery)
        data = models.tblcallevents.objects.raw(reportssql + opentoreachoutquery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)

            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        if user.type_id == 3:
            opentoreachoutquery = " where user_details.status='active' and user_details.user_id = " + str(
                request.user.id) + " and ( (cr_status.id='1' and next_event.status_id='8')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + " 23:59:59' group by cr_event.id"
        else:
            # sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " where user_details.status='active' and user_details.user_id in %s " % (tuple(
                usrs),) + " and ( (cr_status.id='1' and next_event.status_id='8')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + " 23:59:59' group by cr_event.id"
        data = models.tblcallevents.objects.raw(reportssql + opentoreachoutquery)
        # return HttpResponse(sql + opentoreachoutquery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def opentoreachout(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"

        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " WHERE user_details.user_id = " + str(
                request.user.id) + " and (  (cr_status.id='8' and next_event.status_id='2')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and (  (cr_status.id='8' and next_event.status_id='2')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"

        # return HttpResponse(sql + opentoreachoutquery)
        data = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)

            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " where user_details.status='active' and user_details.user_id = " + str(
                request.user.id) + " and ( (cr_status.id='8' and next_event.status_id='2')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + " 23:59:59' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            opentoreachoutquery = " where user_details.status='active' and user_details.user_id in %s " % (tuple(
                usrs),) + " and ( (cr_status.id='8' and next_event.status_id='2')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + " 23:59:59' group by cr_event.id"
        data = models.tblcallevents.objects.raw(sql + opentoreachoutquery)
        # return HttpResponse(sql + opentoreachoutquery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def reachouttotentetive(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            reachouttotentetivequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and (  (cr_status.id='2' and next_event.status_id='3')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + " ' group by cr_event.id"


        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            reachouttotentetivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and (  (cr_status.id='2' and next_event.status_id='3')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + " ' group by cr_event.id"

        data = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            if dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        date = date.today().strftime('%Y-%m-%d')
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            reachouttotentetivequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and ( (old_status.id ='2' and cr_status.id='3') or (cr_status.id='2' and next_event.status_id='3')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            reachouttotentetivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and ( (cr_status.id ='2' and next_event.status_id='3') or (cr_status.id='2' and next_event.status_id='3')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        data = models.tblcallevents.objects.raw(sql + reachouttotentetivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:

            if dt.status_id == 1:
                open.append(dt)
            if dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:

                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def conversion_details(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        if user.type_id == 3:

            tentativetopositivequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and ( (cr_status.id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') group by cr_event.id"
        else:

            tentativetopositivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and ( (cr_status.id='3' and next_event.status_id='6')) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') group by cr_event.id"
        data = models.tblcallevents.objects.raw(reportssql + tentativetopositivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        date = date.today().strftime('%Y-%m-%d')
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        if user.type_id == 3:

            tentativetopositivequery = " WHERE user_details.user_id = " + str(
                request.user.id) + " and (  (cr_status.id='"+str(request.GET['from_status'])+"' and next_event.status_id='"+str(request.GET['to_status'])+"')) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') group by cr_event.id"
        else:

            tentativetopositivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and (  (cr_status.id='"+str(request.GET['from_status'])+"' and next_event.status_id='"+str(request.GET['to_status'])+"')) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') group by cr_event.id"
        data = models.tblcallevents.objects.raw(reportssql + tentativetopositivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "conversiondetailsreports.html",
                      {"from":request.GET["from"], "to":request.GET["to"],"con_name":request.GET['con_name'],"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def positivetoclosure(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and ( (cr_status.id='6' and next_event.status_id='7')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and ( (cr_status.id='6' and next_event.status_id='7')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        data = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        date = date.today().strftime('%Y-%m-%d')
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and (  (cr_status.id='6' and next_event.status_id='7')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and (  (cr_status.id='6' and next_event.status_id='7')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        data = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def otherconversions(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and ( (cr_status.id!='1' and next_event.status_id !='2') and (cr_status.id!='2' and next_event.status_id !='3') and (cr_status.id!='3' and next_event.status_id !='6') and (cr_status.id!='6' and next_event.status_id!='7')) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and ( (cr_status.id!='1' and next_event.status_id !='2') and (cr_status.id!='2' and next_event.status_id !='3') and (cr_status.id!='3' and next_event.status_id !='6') and (cr_status.id!='6' and next_event.status_id!='7') ) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        data = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 2:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        date = date.today().strftime('%Y-%m-%d')
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        if user.type_id == 3:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and (  (cr_status.id!='1' and next_event.status_id !='2') and (cr_status.id!='2' and next_event.status_id !='3') and (cr_status.id!='3' and next_event.status_id !='6') and (cr_status.id!='6' and next_event.status_id!='7') ) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        else:
            sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,next_status.name as nstatus,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join status next_status on next_status.id=next_event.status_id join user_details on cr_event.user_id=user_details.user_id "
            positivetoclosurequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and (  (cr_status.id!='1' and next_event.status_id !='2') and (cr_status.id!='2' and next_event.status_id !='3') and (cr_status.id!='3' and next_event.status_id !='6') and (cr_status.id!='6' and next_event.status_id!='7') ) and cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "' group by cr_event.id"
        # return HttpResponse(sql+positivetoclosurequery)
        data = models.tblcallevents.objects.raw(sql + positivetoclosurequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 2:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def manage_employees(request):
    if request.user.is_superuser:
        users = models.users.objects.filter()
        return render(request, "super-admin/manage_users.html", {"users": users})
    else:
        return HttpResponse(status=404)


@login_required(login_url='/')
def edit_user(request):
    return HttpResponse(status=404)


@login_required(login_url='/')
def delete_user(request):
    return HttpResponse(status=404)


@login_required(login_url='/')
def get_employee_report(request):
    user = request.GET['user_id']
    from datetime import date
    date = date.today()
    all_tasks = models.tblcallevents.objects.filter(appointmentdatetime__date=date).filter(
        Q(assignedto_id=user)).filter(Q(actontaken='yes') | Q(actontaken='no'))
    completed = models.tblcallevents.objects.filter(appointmentdatetime__date=date).filter(
        Q(assignedto_id=user)).filter(actontaken='yes')
    pending = models.tblcallevents.objects.filter(appointmentdatetime__date=date).filter(Q(assignedto_id=user)).filter(
        actontaken='no')
    blanktask = len(all_tasks) - (len(completed) + len(pending))
    if blanktask > 0:
        all_tasks = len(all_tasks) - blanktask
        return HttpResponse(
            '{"all":"' + str(all_tasks) + ' ","completed":"' + str(
                len(completed)) + '","pending":"' + str(len(pending)) + '"}')
    else:
        return HttpResponse(
            '{"all":"' + str(len(all_tasks)) + ' ","completed":"' + str(
                len(completed)) + '","pending":"' + str(len(pending)) + '"}')


@login_required(login_url='/')
def employee_data(request, id):
    userdetails = models.users.objects.filter(user_id=id)[:1].get()
    if request.method == "POST":
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        all_tasks = models.tblcallevents.objects.filter(appointmentdatetime__range=(from_date, to_date)).filter(
            Q(assignedto_id=id)).filter(Q(actontaken='yes') | Q(actontaken='no'))
        completed = models.tblcallevents.objects.filter(appointmentdatetime__range=(from_date, to_date)).filter(
            Q(assignedto_id=id)).filter(actontaken='yes')
        completed_with_no = models.tblcallevents.objects.filter(
            appointmentdatetime__range=(request.POST['from'], request.POST['to'] + ' 23:59:59')).filter(
            Q(assignedto_id=id)).filter(actontaken='no').exclude(nextCFID=0)
        pending = models.tblcallevents.objects.filter(
            appointmentdatetime__range=(request.POST['from'], request.POST['to'] + ' 23:59:59')).filter(
            Q(assignedto_id=id)).filter(actontaken='no').filter(nextCFID=0)
        return render(request, "employee_data.html",
                      {"completed_with_no": completed_with_no, "completed_with_no_count": len(completed_with_no),
                       "from": from_date, "to": to_date, "userdetails": userdetails, "all_tasks": len(all_tasks),
                       "completed": completed, "completedcount": len(completed), "pending": pending,
                       "pendingcount": len(pending)})
    else:
        from datetime import date
        date = date.today()
        all_tasks = models.tblcallevents.objects.filter(
            appointmentdatetime__range=(request.GET['from'], request.GET['to'] + ' 23:59:59')).filter(
            Q(assignedto_id=id)).filter(Q(actontaken='yes') | Q(actontaken='no'))
        completed = models.tblcallevents.objects.filter(
            appointmentdatetime__range=(request.GET['from'], request.GET['to'] + ' 23:59:59')).filter(
            Q(assignedto_id=id)).filter(actontaken='yes')
        completed_with_no = models.tblcallevents.objects.filter(
            appointmentdatetime__range=(request.GET['from'], request.GET['to'] + ' 23:59:59')).filter(
            Q(assignedto_id=id)).filter(actontaken='no').exclude(nextCFID=0)
        pending = models.tblcallevents.objects.filter(
            appointmentdatetime__range=(request.GET['from'], request.GET['to'] + ' 23:59:59')).filter(
            Q(assignedto_id=id)).filter(actontaken='no').filter(nextCFID=0)
        return render(request, "employee_data.html",
                      {"completed_with_no": completed_with_no, "completed_with_no_count": len(completed_with_no),
                       "from": request.GET['from'], "to": request.GET['to'], "userdetails": userdetails,
                       "all_tasks": len(all_tasks), "completed": completed, "completedcount": len(completed),
                       "pending": pending, "pendingcount": len(pending)})


@login_required(login_url='/')
def check_date_activity(request):
    from_date = request.GET['date']
    to_date = request.GET['date'] + ' 23:59:59'

    emails = models.tblcallevents.objects.filter(appointmentdatetime__date=from_date).filter(
        Q(assignedto=request.user)).filter(actiontype_id=2).filter(actontaken='no').order_by('appointmentdatetime')
    calls = models.tblcallevents.objects.filter(appointmentdatetime__date=from_date).filter(
        Q(assignedto=request.user)).filter(actiontype_id=1).filter(actontaken='no').order_by('appointmentdatetime')
    meets = models.tblcallevents.objects.filter(appointmentdatetime__date=from_date).filter(
        Q(assignedto=request.user)).filter(actiontype_id=3).filter(actontaken='no').order_by('appointmentdatetime')
    return HttpResponse("You have total " + str(len(emails)) + " emails , " + str(len(calls)) + " calls and " + str(
        len(meets)) + " meetings on " + from_date)


@login_required(login_url='/')
def add_new_contact(request, id):
    return render(request, 'add_contact.html', {"id": id})


@login_required(login_url='/')
def change_pass(request):
    if request.method == "POST":
        if request.POST['password'] != request.POST['confirmpassword']:
            msg = "Password does not match."
            return render(request, "change_password.html", {"msg": msg})
        else:
            models.users.objects.filter(user=request.user).update(password=request.POST['password'])
            user = User.objects.get(id=request.user.id)
            user.set_password(request.POST['password'])
            user.save()

            return redirect('/')

    else:
        return render(request, "change_password.html")


@login_required(login_url='/')
def pending_tasks(request):
    from datetime import datetime
    user = models.users.objects.filter(user=request.user)[:1].get()
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')

    date = datetime.today()
    usrs = []
    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        if request.POST['from'] != '' and request.POST['to'] != '':
            from_date = request.POST['from']
            to_date = request.POST['to']
            if request.POST['user'] != '':
                data = models.tblcallevents.objects.raw(
                    "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE  tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id='" +
                    request.POST['user'] + "' and tblcallevents.appointmentdatetime between '" + request.POST[
                        'from'] + " 00:00:00' and '" + request.POST[
                        'to'] + " 23:59:59' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")
            else:
                if user.type_id == 3:
                    data = models.tblcallevents.objects.raw(
                        "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id='" + str(
                            request.user.id) + "' and tblcallevents.appointmentdatetime between '" + request.POST[
                            'from'] + " 00:00:00' and '" + request.POST[
                            'to'] + " 23:59:59' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")
                    # return HttpResponse("SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` WHERE date(appointmentdatetime) < CURRENT_DATE  and id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id='"+str(request.user.id)+"' and actiontype_id !=4 ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")
                else:
                    data = models.tblcallevents.objects.raw(
                        "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id in %s" % (
                            tuple(usrs),) + " and tblcallevents.appointmentdatetime between '" + request.POST[
                            'from'] + " 00:00:00' and '" + request.POST[
                            'to'] + " 23:59:59' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")
                    # return HttpResponse("SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` WHERE date(appointmentdatetime) < CURRENT_DATE  and id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id in %s" %(tuple(usrs),)+ " and actiontype_id !=4 ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")
        else:
            from_date = ''
            to_date = ''
            if request.POST['user'] != '':
                data = models.tblcallevents.objects.raw(
                    "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id='" +
                    request.POST[
                        'user'] + "' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")
            else:
                if user.type_id == 3:
                    data = models.tblcallevents.objects.raw(
                        "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id='" + str(
                            request.user.id) + "' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")

                else:
                    data = models.tblcallevents.objects.raw(
                        "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id in %s" % (
                            tuple(usrs),) + "  and '" + request.POST[
                            'to'] + " 23:59:59' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")

    else:
        from_date = ''
        to_date = ''
        if user.type_id == 3:
            data = models.tblcallevents.objects.raw(
                "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id='" + str(
                    request.user.id) + "' and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")

        else:
            data = models.tblcallevents.objects.raw(
                "SELECT `tblcallevents`.`id`, `tblcallevents`.`cid_id`,company_master.id, `tblcallevents`.`user_id`, `tblcallevents`.`lastCFID`, `tblcallevents`.`nextCFID`, `tblcallevents`.`draft`, `tblcallevents`.`status_id`, `tblcallevents`.`event`, `tblcallevents`.`purpose_id`, `tblcallevents`.`remarks`, `tblcallevents`.`fwd_date`, `tblcallevents`.`actiontype_id`, `tblcallevents`.`actontaken`, `tblcallevents`.`assignedto_id`, `tblcallevents`.`nextaction`, `tblcallevents`.`appointmentdatetime`, `tblcallevents`.`date`, `tblcallevents`.`updateddate` FROM `tblcallevents` join init_call on tblcallevents.cid_id=init_call.id  join company_master on init_call.cmpid_id=company_master.id join company_contact_master on company_contact_master.company_id=company_master.id join partner_master on company_master.partnerType_id=partner_master.id join user_details on tblcallevents.assignedto_id=user_details.user_id WHERE date(appointmentdatetime) < CURRENT_DATE  and tblcallevents.id=(select MAX(id) from tblcallevents t1 WHERE t1.cid_id=tblcallevents.cid_id)  and assignedto_id in %s" % (
                    tuple(usrs),) + " and actiontype_id !=4 GROUP by company_master.id ORDER BY `tblcallevents`.`appointmentdatetime`  ASC")

    return render(request, 'pending-tasks.html',
                  {"data": data, "all": len(data), "users": users, "from": from_date, "to": to_date})


@login_required(login_url='/')
def forward_to_current_date(request, cmpid, last_id):
    from datetime import datetime
    data = models.tblcallevents.objects.get(id=last_id)
    now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    # return HttpResponse(data.cid)
    form4 = models.tblcallevents(cid=data.cid, user=request.user, lastCFID=last_id, nextCFID=0,
                                 draft="",
                                 status_id=data.status_id,
                                 event='', purpose_id=data.purpose_id,
                                 remarks="Task has been forwarded from " + data.appointmentdatetime.strftime(
                                     '%Y-%m-%d %H:%M:%S') + " to " + now, fwd_date=datetime.today(),
                                 appointmentdatetime=datetime.now(),
                                 actiontype_id=data.actiontype_id, actontaken='no', assignedto_id=data.assignedto_id,
                                 nextaction=data.nextaction)
    form4.save()
    models.tblcallevents.objects.filter(id=last_id).update(nextCFID=form4.id)
    return redirect('/pending-tasks')


@login_required(login_url='/')
def edit_company(request, company_id):
    details = models.company_master.objects.get(id=company_id)
    states = models.state.objects.filter()
    company = models.partner_master.objects.filter()
    return render(request, 'company_edit.html', {"data": details, "states": states, "company": company})


@login_required(login_url='/')
def edit_company_contact(request, company_id):
    details = models.company_contact_master.objects.filter(company_id=company_id)
    return render(request, 'company_contact_edit.html', {"data": details})


@login_required(login_url='/')
def update_company(request, company_id):
    compname = request.POST['compname']
    city = request.POST['city']
    draft = request.POST['draft']
    budget = request.POST['budget']
    state = request.POST['state']
    address = request.POST['address']
    country = '1'
    website = request.POST['website']
    partnerType = request.POST['partnerType']
    dt=models.company_master.objects.get(id=company_id)
    users=models.users.objects.filter(user_id=request.user.id)[:1].get()
    state_count = models.state.objects.filter(Q(id=state) | Q(state=state)).count()
    if state_count > 0:
        state_name = models.state.objects.filter(Q(id=state) | Q(state=state))[:1].get()
    else:
        state_name = []
    fm=models.notification(msg=str(dt.compname)+' has been updated by '+str(request.user.first_name),user=str(users.admin_id),company_id=str(company_id),status='pending')
    fm.save()
    models.company_master.objects.filter(id=company_id).update(compname=compname, draft=draft, budget=budget,
                                                               address=address,
                                                               country=country, website=website, state=state_name.state,
                                                               city=city, partnerType_id=partnerType)
    
    return redirect('/company/' + str(company_id))


@login_required(login_url='/')
def update_contact(request, company_id, contact_id):
    if request.method == "POST":
        emailid = request.POST['emailid']
        phoneno = request.POST['phoneno']
        draft = request.POST['draft']
        compconname = request.POST['compconname']
        designation = request.POST['designation']
        dt=models.company_master.objects.get(id=company_id)
        users=models.users.objects.filter(user_id=request.user.id)[:1].get()
        fm=models.notification(msg='Contact of '+str(dt.compname)+' has been updated by '+str(request.user.first_name),user=str(users.admin_id),company_id=str(company_id),status='pending')
        fm.save()
        models.company_contact_master.objects.filter(id=contact_id).update(contactperson=compconname, emailid=emailid,
                                                                           draft=draft, phoneno=phoneno,
                                                                           designation=designation)

        return redirect('/company/' + str(company_id))


@login_required(login_url='/')
def assigned_data(request):
    if request.method == "POST":
        from datetime import datetime
        events = request.POST.getlist('init_id')
        assigned_id = request.POST['assigned_to']
        user = User.objects.get(id=assigned_id)
        for ev in events:
            data = models.tblcallevents.objects.get(id=ev)
            now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            # return HttpResponse(now)
            form4 = models.tblcallevents(cid_id=data.cid_id, user=request.user, lastCFID=ev, nextCFID=0,
                                         draft="Task has been assigned to " + user.first_name + ' ' + user.last_name,
                                         status_id=data.status_id,
                                         event='', purpose_id=data.purpose_id,
                                         remarks="Task has been assigned to " + user.first_name + ' ' + user.last_name,
                                         fwd_date=datetime.now(),
                                         appointmentdatetime=datetime.now(),
                                         actiontype_id=data.actiontype_id, actontaken='no',
                                         assignedto_id=assigned_id,
                                         nextaction=data.nextaction)
            form4.save()
            models.tblcallevents.objects.filter(id=ev).update(nextCFID=form4.id)
        return redirect('/assigned-data')

    else:
        user = models.users.objects.get(user=request.user)
        if user.type_id == 1:
            users = models.users.objects.filter(type_id=2)
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active').filter(type_id=2)
        usrs = []
        for us in users:
            usrs.append(us.user_id)
        if user.type_id == 2:
            data = models.tblcallevents.objects.raw(
                "SELECT t1.*,company_master.*,init_call.*,user_details.name FROM tblcallevents t1 join init_call on t1.cid_id=init_call.id JOIN user_details on init_call.creator_id=user_details.user_id join company_master on company_master.id=init_call.cmpid_id where t1.id=(select MAX(id) from tblcallevents t2 where t2.cid_id=t1.cid_id) and (t1.assignedto_id=" + str(
                    request.user.id) + " and init_call.creator_id!=" + str(
                    request.user.id) + ") ORDER BY `nextCFID`  DESC")
        elif user.type_id == 1:
            data = models.tblcallevents.objects.raw(
                "SELECT t1.*,company_master.*,init_call.*,user_details.name FROM tblcallevents t1 join init_call on t1.cid_id=init_call.id JOIN user_details on init_call.creator_id=user_details.user_id join company_master on company_master.id=init_call.cmpid_id where t1.id=(select MAX(id) from tblcallevents t2 where t2.cid_id=t1.cid_id) and (t1.assignedto_id in %s" % (
                tuple(usrs),) + " and t1.assignedto_id!=init_call.creator_id) ORDER BY `nextCFID`  DESC")
            # return HttpResponse("SELECT t1.*,company_master.*,init_call.*,user_details.* FROM tblcallevents t1 join init_call on t1.cid_id=init_call.id JOIN user_details on init_call.creator_id=user_details.user_id join company_master on company_master.id=init_call.cmpid_id where t1.id=(select MAX(id) from tblcallevents t2 where t2.cid_id=t1.cid_id) and (t1.assignedto_id in %s" %(tuple(usrs),) + ") ORDER BY `nextCFID`  DESC")
        return render(request, 'assigned_data.html', {"data": data, "count": len(data), "users": users})


@login_required(login_url='/')
def funnel_report(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []
    for us in users:
        usrs.append(us.user_id)
    from datetime import date

    from_data = date.today().strftime('%Y-%m-%d') + " 00:00:00"
    to_data = date.today().strftime('%Y-%m-%d') + " 23:59:59"

    if user.type_id == 3:
        query = "SELECT  a.*, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE  t1.assignedto_id = a.user_id  and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)) as totaltaks      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id) ) as open      ,(SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id)) as open_rpem      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I2 JOIN init_call on init_call.id=I2.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I2.cid_id) ) as reachout      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I3 JOIN init_call on init_call.id=I3.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I3.cid_id) ) as tantative      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I4 JOIN init_call on init_call.id=I4.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I4.cid_id)  ) as will_do_later      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I5 JOIN init_call on init_call.id=I5.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I5.cid_id)  ) as not_interested      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as positive , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as very_positive      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I7 JOIN init_call on init_call.id=I7.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I7.cid_id)  ) as closure FROM user_details a where a.status='active' and a.user_id = (" + str(
            request.user.id) + ")"

    else:
        query = "SELECT  a.*, (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents t1 JOIN init_call on init_call.id=t1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE  t1.assignedto_id = a.user_id  and t1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=t1.cid_id)) as totaltaks      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=1 and I1.status_id=1 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id) ) as open      ,(SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I1 JOIN init_call on init_call.id=I1.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I1.assignedto_id = a.user_id and I1.status_id=8 and I1.status_id=8 and I1.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I1.cid_id)) as open_rpem      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I2 JOIN init_call on init_call.id=I2.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I2.assignedto_id = a.user_id and I2.status_id=2 and I2.status_id=2 and I2.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I2.cid_id) ) as reachout      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I3 JOIN init_call on init_call.id=I3.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I3.assignedto_id = a.user_id and I3.status_id=3  and I3.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I3.cid_id) ) as tantative      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I4 JOIN init_call on init_call.id=I4.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I4.assignedto_id = a.user_id and I4.status_id=4  and I4.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I4.cid_id)  ) as will_do_later      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I5 JOIN init_call on init_call.id=I5.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I5.assignedto_id = a.user_id and I5.status_id=5 and I5.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I5.cid_id)  ) as not_interested      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=6 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as positive , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I6 JOIN init_call on init_call.id=I6.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I6.assignedto_id = a.user_id and I6.status_id=9 and I6.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I6.cid_id) ) as very_positive      , (SELECT Count(DISTINCT init_call.cmpid_id) FROM tblcallevents I7 JOIN init_call on init_call.id=I7.cid_id join company_contact_master on company_contact_master.company_id=init_call.cmpid_id  WHERE I7.assignedto_id = a.user_id and I7.status_id=6 and I7.id=(select MAX(tt2.id) from tblcallevents tt2 where tt2.cid_id=I7.cid_id)  ) as closure FROM user_details a where a.status='active' and a.user_id in %s" % (
            tuple(usrs),)

    data = models.users.objects.raw(query)
    return render(request, "funnel_report.html",
                  {"users": data,
                   "from": '2020-09-21',
                   "to": '2020-09-21'})


@login_required(login_url='/')
def conversoin_report(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []
    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from_date = request.POST['from'] + " 00:00:00"
        to_date = request.POST['to'] + " 23:59:59"
        from_date_d = request.POST['from']
        to_date_d = request.POST['to']
    else:
        from datetime import date

        from_date = date.today().strftime('%Y-%m') + "-01 00:00:00"
        to_date = date.today().strftime('%Y-%m-%d') + " 23:59:59"
        from_date_d = date.today().strftime('%Y-%m') + "-01"
        to_date_d = date.today().strftime('%Y-%m-%d')

    if user.type_id == 3:
        query = "SELECT user_details.*,(SELECT count(distinct t1.cid_id) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as total,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=1 and t2.status_id=8 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_to_open_rpem,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_rpem_to_reachout,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=3 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as reachout_to_tentative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=6 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tentative_to_verypositive,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=9 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive_to_verypositive,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=9 and t2.status_id=7 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as verypositive_to_closure,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_to_willdolater,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_to_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as reachout_to_willdolater,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as rechout_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tentative_willdolater,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tentative_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=5 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as negativereachout,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=4 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as willdolater_reachout,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive_willdolater FROM user_details where user_details.status='active' and user_details.user_id = (" + str(
            request.user.id) + ")"

    else:
        query = "SELECT user_details.*,(SELECT count(distinct t1.cid_id) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as total,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=1 and t2.status_id=8 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_to_open_rpem,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_rpem_to_reachout,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=3 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as reachout_to_tentative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=6 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tentative_to_verypositive,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=9 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive_to_verypositive,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=9 and t2.status_id=7 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as verypositive_to_closure,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_to_willdolater,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as open_to_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as reachout_to_willdolater,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as rechout_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tentative_willdolater,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as tentative_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=5 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as negativereachout,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=4 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as willdolater_reachout,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive_negative,(SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' ) as positive_willdolater FROM user_details where user_details.status='active' and user_details.user_id in %s" % (
            tuple(usrs),)
    # return HttpResponse(query)
    data = models.users.objects.raw(query)


    return render(request, "conversion_report.html", {"users": data, "from": from_date_d, "to": to_date_d})



@login_required(login_url='/')
def task_conversoin_report(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []
    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from_date = request.POST['from'] + " 00:00:00"
        to_date = request.POST['to'] + " 23:59:59"
        from_date_d = request.POST['from']
        to_date_d = request.POST['to']
    else:
        from datetime import date

        from_date = date.today().strftime('%Y-%m') + "-01 00:00:00"
        to_date = date.today().strftime('%Y-%m-%d') + " 23:59:59"
        from_date_d = date.today().strftime('%Y-%m') + "-01"
        to_date_d = date.today().strftime('%Y-%m-%d')
    if user.type_id == 3:
        query = "SELECT user_details.*,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=1 and t2.status_id=8 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=1 ))*100 as open_to_open_rpem,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=8 ))*100 as open_rpem_to_reachout,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=3 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=2 ))*100 as reachout_to_tentative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=6 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=3 ))*100 as tentative_to_verypositive,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=9 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=6 ))*100 as positive_to_verypositive,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=9 and t2.status_id=7 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=9 ))*100 as verypositive_to_closure,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=8 ))*100 as open_to_willdolater,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=8 ))*100 as open_to_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=2 ))*100 as reachout_to_willdolater,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=2 ))*100 as rechout_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=3 ))*100 as tentative_willdolater,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=3 ))*100 as tentative_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=5 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=5 ))*100 as negativereachout,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=4 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=4 ))*100 as willdolater_reachout,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=6 ))*100 as positive_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=6 ))*100 as positive_willdolater FROM user_details where user_details.status='active' and user_details.user_id = (" + str(
            request.user.id) + ")"
    else:
        query = "SELECT user_details.*,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=1 and t2.status_id=8 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=1 ))*100 as open_to_open_rpem,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=8 ))*100 as open_rpem_to_reachout,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=3 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=2 ))*100 as reachout_to_tentative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=6 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=3 ))*100 as tentative_to_verypositive,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=9 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=6 ))*100 as positive_to_verypositive,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=9 and t2.status_id=7 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=9 ))*100 as verypositive_to_closure,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=8 ))*100 as open_to_willdolater,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=8 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=8 ))*100 as open_to_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=2 ))*100 as reachout_to_willdolater,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=2 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=2 ))*100 as rechout_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=3 ))*100 as tentative_willdolater,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=3 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=3 ))*100 as tentative_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=5 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=5 ))*100 as negativereachout,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=4 and t2.status_id=2 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=4 ))*100 as willdolater_reachout,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=5 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=6 ))*100 as positive_negative,((SELECT count(*) from tblcallevents t1 join tblcallevents t2 on t1.nextCFID=t2.id where (t1.status_id=6 and t2.status_id=4 ) and t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' )/(SELECT count(distinct t1.cid_id) from tblcallevents t1  where t1.assignedto_id=user_details.user_id and t1.appointmentdatetime between '" + from_date + "' and '" + to_date + "' and t1.status_id=6 ))*100 as positive_willdolater FROM user_details where user_details.status='active' and user_details.user_id in %s" % (
            tuple(usrs),)
    # return HttpResponse(query)
    data = models.users.objects.raw(query) 
    return render(request, "task_conversion_report.html", {"users": data, "from": from_date_d, "to": to_date_d})


@login_required(login_url='/')
def other_conversion_details(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        if user.type_id == 3:

            tentativetopositivequery = " WHERE user_details.user_id =" + str(
                request.user.id) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') and cr_event.status_id != next_event.status_id group by cr_event.id"
        else:

            tentativetopositivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') and cr_event.status_id != next_event.status_id group by cr_event.id"
        data = models.tblcallevents.objects.raw(reportssql + tentativetopositivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "reports.html",
                      {"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        date = date.today().strftime('%Y-%m-%d')
        from_date = request.GET['from']
        to_date = request.GET['to'] + " 23:59:59"
        if user.type_id == 3:

            tentativetopositivequery = " WHERE user_details.user_id = " + str(
                request.user.id) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') and cr_event.status_id != next_event.status_id group by cr_event.id"
        else:

            tentativetopositivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and not (cr_event.status_id='1' and next_event.status_id='8') and not (cr_event.status_id='8' and next_event.status_id='2') and not (cr_event.status_id='2' and next_event.status_id='3') and not (cr_event.status_id='3' and next_event.status_id='6') and not (cr_event.status_id='6' and next_event.status_id='9') and not (cr_event.status_id='6' and next_event.status_id='7') and not (cr_event.status_id='9' and next_event.status_id='7') and (cr_event.status_id !=next_event.status_id) and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') and cr_event.status_id != next_event.status_id group by cr_event.id"
        data = models.tblcallevents.objects.raw(reportssql + tentativetopositivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "conversiondetailsreports.html",
                      {"from":request.GET["from"], "to":request.GET["to"],"con_name":request.GET['con_name'],"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
                       
                       

@login_required(login_url='/')
def school_visit_reports(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    usrs = []

    for us in users:
        usrs.append(us.user_id)
    if request.method == "POST":
        from datetime import datetime, date
        date = date.today()
        from_date = request.POST['from']
        to_date = request.POST['to'] + " 23:59:59"
        if request.POST['user']!='':
            tentativetopositivequery = " WHERE user_details.user_id =" + str(request.POST['user']) + " and company_master.partnerType_id='11' and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')  group by cr_event.id"
        else:
            if user.type_id == 3:
                tentativetopositivequery = " WHERE user_details.user_id =" + str(request.user.id) + " and company_master.partnerType_id='11' and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')  group by cr_event.id"
            else:
                tentativetopositivequery = " WHERE user_details.user_id in %s " % (tuple(usrs),) + " and company_master.partnerType_id='11' and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "')  group by cr_event.id"
        data = models.tblcallevents.objects.raw(reportssql + tentativetopositivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "school_visit_reports.html",
                      {"users":users,"from":request.POST["from"],"to":request.POST["to"],"data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})
    else:
        from datetime import datetime, date
        date = date.today().strftime('%Y-%m-%d')
        from_date = date+' 00:00:00'
        to_date = date + " 23:59:59"
        if user.type_id == 3:

            tentativetopositivequery = " WHERE user_details.user_id = " + str(
                request.user.id) + " and company_master.partnerType_id='11' and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') by cr_event.id"
        else:

            tentativetopositivequery = " WHERE user_details.user_id in %s " % (tuple(
                usrs),) + " and company_master.partnerType_id='11' and (cr_event.appointmentdatetime BETWEEN '" + from_date + "' and '" + to_date + "') group by cr_event.id"
        # return HttpResponse(reportssql + tentativetopositivequery)
        data = models.tblcallevents.objects.raw(reportssql + tentativetopositivequery)
        open = []
        open_rpem = []
        reachout = []
        tentative = []
        will_do_later = []
        ni = []
        very_positive = []
        closure = []
        for dt in data:
            if dt.status_id == 1:
                open.append(dt)
            elif dt.status_id == 8:
                open_rpem.append(dt)
            elif dt.status_id == 2:
                reachout.append(dt)
            elif dt.status_id == 3:
                tentative.append(dt)
            elif dt.status_id == 4:
                will_do_later.append(dt)
            elif dt.status_id == 5:
                ni.append(dt)
            elif dt.status_id == 6:
                very_positive.append(dt)
            elif dt.status_id == 7:
                closure.append(dt)
        return render(request, "school_visit_reports.html",
                      {"users":users,"from": date, "to": date,
                       "data": data, "open": open, "open_rpem": open_rpem, "reachout": reachout, "tentative": tentative,
                       "will_do_later": will_do_later, "ni": ni, "very_positive": very_positive, "closure": closure,
                       "all_len": len(data), "open_len": len(open), "open_rpem_len": len(open_rpem),
                       "reachout_len": len(reachout),
                       "tentative_len": len(tentative), "will_do_later_len": len(will_do_later), "ni_len": len(ni),
                       "very_positive_len": len(very_positive), "closure_len": len(closure)})


@login_required(login_url='/')
def meeting_proposal(request):
    user = models.users.objects.get(user=request.user)
    # status = models.status.objects.filter()
    sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id"
    common_condition="  and init_call.proposal='yes' group by init_call.id "
    if request.method=="POST":
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        us = []
        for urs in users:
            us.append(urs.user_id)

        from_date = request.POST['from'] + ' 00:00:00'
        to_date = request.POST['to'] + ' 23:59:59'
        from_date_d = request.POST['from']
        to_date_d = request.POST['to']
        if request.POST['from'] != '' and request.POST['to'] != '':
            if request.POST['user'] != '':
                data = models.tblcalls.objects.raw(sql+
                    ' WHERE cr_event.assignedto_id =' +
                    request.POST[
                        "user"] + ' and init_call.proposaldate between "' + from_date + '" and "' + to_date + '" '+common_condition+'  order by cr_event.id desc'
                )
            else:
                if user.type_id == 3:
                    data = models.tblcalls.objects.raw(sql+
                        ' WHERE cr_event.assignedto_id =' + str(
                            request.user.id) + ' and init_call.proposaldate between "' + from_date + '" and "' + to_date + '" '+common_condition+'    order by cr_event.id desc')
                else:
                    data = models.tblcalls.objects.raw(sql+
                        ' WHERE cr_event.assignedto_id in %s' % (
                            tuple(
                                us),) + ' and init_call.proposaldate between "' + from_date + '" and "' + to_date + '" '+common_condition+'   order by cr_event.id desc')

        else:
            if request.POST['user'] != '':
                data = models.tblcalls.objects.raw(sql+
                    ' WHERE cr_event.assignedto_id =' +
                    request.POST[
                        "user"] + ' '+common_condition+'  order by cr_event.id desc')
                # return HttpResponse('select con.*,company_master.*,company_master.id as cmpny_id,user_details.name,(select status.name from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id) as totaltask,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets,(select status.id from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as status_id,(select remarks from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as last_remark from company_contact_master con join company_master on con.company_id=company_master.id JOIN init_call on init_call.cmpid_id=company_master.id join user_details on init_call.creator_id=user_details.user_id WHERE init_call.creator_id =' +request.POST["user"] + '   order by company_master.id DESC')
            else:
                if user.type_id == 3:
                    data = models.tblcalls.objects.raw(sql+
                        'WHERE cr_event.assignedto_id =' + str(
                            request.user.id) + ' '+common_condition+'  order by cr_event.id desc')
                    # return HttpResponse('select con.*,company_master.*,company_master.id as cmpny_id,init_call.creator_id,user_details.name,(select assignedto_id from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as assignedto,(select status.name from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as current_status,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id) as totaltask,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=1 and tblcallevents.actontaken="yes") as calls,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=2 and tblcallevents.actontaken="yes") as emails,(select COUNT(*) from tblcallevents WHERE tblcallevents.cid_id=init_call.id and tblcallevents.actiontype_id=3 and tblcallevents.actontaken="yes") as meets,(select status.id from tblcallevents join status on tblcallevents.status_id=status.id WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as status_id,(select remarks from tblcallevents WHERE tblcallevents.cid_id=init_call.id order by cr_event.id desc LIMIT 1) as last_remark from company_contact_master con join company_master on con.company_id=company_master.id JOIN init_call on init_call.cmpid_id=company_master.id join user_details on init_call.creator_id=user_details.user_id WHERE init_call.creator_id =' + str(
                    #         request.user.id) + '   order by company_master.id DESC')
                else:
                    data = models.tblcalls.objects.raw(sql+
                        'WHERE cr_event.assignedto_id in %s' % (
                            tuple(
                                us),) + ' '+common_condition+' order by cr_event.id desc')
    else:
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        us = []
        for urs in users:
            us.append(urs.user_id)

        from datetime import date

        from_date = date.today().strftime('%Y-%m') + "-01 00:00:00"
        to_date = date.today().strftime('%Y-%m-%d') + " 23:59:59"
        from_date_d = date.today().strftime('%Y-%m') + "-01"
        to_date_d = date.today().strftime('%Y-%m-%d')
        if user.type_id == 3:
            data = models.tblcalls.objects.raw(sql+
                ' WHERE cr_event.assignedto_id =' + str(
                    request.user.id) + ' and init_call.proposaldate between "' + from_date + '" and "' + to_date + '" '+common_condition+'    order by cr_event.id desc')
        else:
            data = models.tblcalls.objects.raw(sql+
                ' WHERE cr_event.assignedto_id in %s' % (
                    tuple(
                        us),) + ' and init_call.proposaldate between "' + from_date + '" and "' + to_date + '" '+common_condition+'   order by cr_event.id desc')
        
    
    return render(request, "meeting_proposal.html", {"data": data,"total":len(data),"users": users,"from": from_date_d, "to": to_date_d})


@login_required(login_url='/')
def meeting_dashboard(request):
    user = models.users.objects.get(user=request.user)
    # status = models.status.objects.filter()
    sql = "SELECT cr_event.*,cr_status.name as current_status,cr_action.name as current_action_type,user_details.name,last_event.appointmentdatetime as last_task_date,last_action.name as last_task_activity,last_event.remarks as last_remark,lpurpose.name as last_purpose,npurpose.name as next_purpose,lstatus.name as last_status,last_event.actontaken as last_action_taken,next_event.appointmentdatetime as next_task_date,nx_action.name as next_task_activity,next_event.remarks as next_remarks,company_master.*,partner_master.name as partner_type,init_call.*,company_contact_master.* from tblcallevents cr_event left join tblcallevents last_event on cr_event.lastCFID=last_event.id left join action cr_action on cr_action.id=cr_event.actiontype_id left join status cr_status on cr_status.id=cr_event.status_id left join tblcallevents next_event on cr_event.nextCFID=next_event.id  left join init_call on init_call.id=cr_event.cid_id left join company_master on company_master.id=init_call.cmpid_id left join action last_action on last_action.id=last_event.actiontype_id left join purpose lpurpose on lpurpose.id=last_event.purpose_id left join purpose npurpose on npurpose.id=next_event.purpose_id left join status lstatus on lstatus.id=last_event.status_id left join action nx_action on nx_action.id=next_event.actiontype_id left join company_contact_master on company_master.id=company_contact_master.company_id left join partner_master on partner_master.id=company_master.partnerType_id join user_details on cr_event.user_id=user_details.user_id"
    common_condition=" and (cr_event.meeting_type!='NA' or ( cr_event.status_id=3 and cr_event.nextCFID!='' )) group by cr_event.id "
    if request.method=="POST":
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        us = []
        for urs in users:
            us.append(urs.user_id)

        from_date = request.POST['from'] + ' 00:00:00'
        to_date = request.POST['to'] + ' 23:59:59'
        from_date_d = request.POST['from']
        to_date_d = request.POST['to']
        if request.POST['from'] != '' and request.POST['to'] != '':
            if request.POST['user'] != '':
                data = models.tblcalls.objects.raw(sql+
                    ' WHERE cr_event.assignedto_id =' +
                    request.POST[
                        "user"] + ' and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '" '+common_condition+'  order by cr_event.id desc'
                )
            else:
                if user.type_id == 3:
                    data = models.tblcalls.objects.raw(sql+
                        ' WHERE cr_event.assignedto_id =' + str(
                            request.user.id) + ' and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '" '+common_condition+'    order by cr_event.id desc')
                else:
                    data = models.tblcalls.objects.raw(sql+
                        ' WHERE cr_event.assignedto_id in %s' % (
                            tuple(
                                us),) + ' and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '" '+common_condition+'   order by cr_event.id desc')

        else:
            if request.POST['user'] != '':
                data = models.tblcalls.objects.raw(sql+
                    ' WHERE cr_event.assignedto_id =' +
                    request.POST[
                        "user"] + ' '+common_condition+' order by cr_event.id desc')
                
            else:
                if user.type_id == 3:
                    data = models.tblcalls.objects.raw(sql+
                        'WHERE cr_event.assignedto_id =' + str(
                            request.user.id) + ' '+common_condition+'  order by cr_event.id desc')
                
                
                else:
                    data = models.tblcalls.objects.raw(sql+
                        'WHERE cr_event.assignedto_id in %s' % (
                            tuple(
                                us),) + ' '+common_condition+' order by cr_event.id desc')
    else:
        if user.type_id == 1:
            users = models.users.objects.filter()
        elif user.type_id == 2:
            users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                status='active')
        else:
            users = models.users.objects.filter(user=request.user).filter(status='active')
        us = []
        for urs in users:
            us.append(urs.user_id)

        from datetime import date

        from_date = date.today().strftime('%Y-%m') + "-01 00:00:00"
        to_date = date.today().strftime('%Y-%m-%d') + " 23:59:59"
        from_date_d = date.today().strftime('%Y-%m') + "-01"
        to_date_d = date.today().strftime('%Y-%m-%d')
        if user.type_id == 3:
            data = models.tblcalls.objects.raw(sql+
                ' WHERE cr_event.assignedto_id =' + str(
                    request.user.id) + ' and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '" '+common_condition+'    order by cr_event.id desc')
        else:
            data = models.tblcalls.objects.raw(sql+
                ' WHERE cr_event.assignedto_id in %s' % (
                    tuple(
                        us),) + ' and cr_event.appointmentdatetime between "' + from_date + '" and "' + to_date + '" '+common_condition+'   order by cr_event.id desc')
        
    
    return render(request, "meeting_dashboard.html", {"data": data,"total":len(data),"users": users,"from": from_date_d, "to": to_date_d})
    
    
@login_required(login_url='/')
def action_wise_activity(request):
    user = models.users.objects.get(user=request.user)
    if user.type_id == 1:
        users = models.users.objects.filter()
    elif user.type_id == 2:
        users = models.users.objects.filter(Q(user=request.user) | Q(admin=request.user)).filter(
                status='active')
    else:
        users = models.users.objects.filter(user=request.user).filter(status='active')
    us = []
    for urs in users:
        us.append(urs.user_id)
    if user.type_id == 3:
        data = models.tblcalls.objects.raw(reportssql+' WHERE cr_event.assignedto_id =' + str(
                    request.user.id) + ' and cr_event.appointmentdatetime between "' + request.GET["from"] + ' 00:00:00" and "' + request.GET["to"] + ' 23:59:59" and cr_event.actiontype_id='+str(request.GET["action"])+'    order by cr_event.id desc')
    else:
        data = models.tblcalls.objects.raw(reportssql+' WHERE cr_event.assignedto_id in %s' % (
                    tuple(
                        us),) + ' and cr_event.appointmentdatetime between "' + request.GET["from"] + ' 00:00:00" and "' + request.GET["to"] + ' 23:59:59" and cr_event.actiontype_id='+str(request.GET["action"])+'    order by cr_event.id desc')
    return render(request,'action_wise_report.html',{"data":data,"total":len(data),"from":request.GET['from'],"to":request.GET['to'],"type":request.GET['type']})
    
