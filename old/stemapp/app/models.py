from django.db import models
from django.contrib.auth.models import User


def upload_user(self, filename):
    return '%s/%s/%s' % ("Users", str(self.user_id), filename)


class user_type(models.Model):
    name = models.CharField(max_length=2000, verbose_name="Name")

    def __str__(self):
        return self.name

    class Meta:
        db_table = 'user_type'
        managed = True
        verbose_name = 'User Type'
        verbose_name_plural = 'User Types'


class category(models.Model):
    name = models.CharField(max_length=1000)

    def __str__(self):
        return self.name

    class Meta:
        db_table = "category"
        verbose_name = "Category"
        managed = True
        verbose_name_plural = "Categories"


class status(models.Model):
    name = models.CharField(max_length=500, verbose_name="Status")
    color=models.CharField(max_length=100,verbose_name="Set Background Color" ,blank=True,default='gray')

    def __str__(self):
        return self.name

    class Meta:
        db_table = "status"
        managed = True
        verbose_name = "Status"
        verbose_name_plural = "Status"


class todays_remark(models.Model):
    status = models.ForeignKey(status, verbose_name="Status", on_delete=models.CASCADE)
    name = models.CharField(max_length=1000, verbose_name="Today's Remark")

    def __str__(self):
        return self.name

    class Meta:
        db_table = "todays_remark"
        managed = True
        verbose_name = "Today's Remark"
        verbose_name_plural = "Today's Remarks"


class actions(models.Model):
    name = models.CharField(max_length=1000, verbose_name="Action")

    class Meta:
        db_table = "action"
        managed = True
        verbose_name = "Action"
        verbose_name_plural = "Actions"

    def __str__(self):
        return self.name


class purpose(models.Model):
    status = models.ForeignKey(status, verbose_name="Purpose", on_delete=models.CASCADE)
    action = models.ForeignKey(actions, verbose_name="Action", on_delete=models.CASCADE)
    name = models.CharField(verbose_name="Purpose", max_length=3000)

    class Meta:
        db_table = "purpose"
        managed = True
        verbose_name = "Purpose"
        verbose_name_plural = "Purpose"

    def __str__(self):
        return self.name


class next_action(models.Model):
    purpose = models.ForeignKey(purpose, verbose_name="Purpose", on_delete=models.CASCADE)
    name = models.CharField(max_length=10000, verbose_name="Next Action")

    class Meta:
        db_table = "next_action"
        managed = True
        verbose_name = "Next Action"
        verbose_name_plural = "Next Actions"

    def __str__(self):
        return self.name


class partner_master(models.Model):
    name = models.CharField(max_length=10000, verbose_name="Name")

    def __str__(self):
        return self.name

    class Meta:
        db_table = "partner_master"
        managed = True
        verbose_name = "Partner Category Master"
        verbose_name_plural = "Partner Categories Master"


class user_zone(models.Model):
    name = models.CharField(verbose_name="Name", max_length=2000)

    def __str__(self):
        return self.name

    class Meta:
        db_table = 'user_zone'
        managed = True
        verbose_name = 'User Zone'
        verbose_name_plural = 'User Zones'


class country(models.Model):
    name = models.CharField(verbose_name="Country Name", max_length=3000)

    def __str__(self):
        return self.name

    class Meta:
        db_table = 'country_db'
        managed = True
        verbose_name = 'Country'
        verbose_name_plural = 'Countries'


class state(models.Model):
    country = models.ForeignKey(country, verbose_name="Country", on_delete=models.CASCADE)
    state = models.CharField(verbose_name="State", max_length=3000)

    def __str__(self):
        return self.state

    class Meta:
        db_table = 'states'
        managed = True
        verbose_name = 'State'
        verbose_name_plural = 'States'


class city(models.Model):
    state = models.ForeignKey(state, verbose_name="State", on_delete=models.CASCADE)
    city = models.CharField(verbose_name="City", max_length=10000)

    def __str__(self):
        return self.city

    class Meta:
        db_table = 'city'
        managed = True
        verbose_name = "City"
        verbose_name_plural = "Cities"


class users(models.Model):
    user = models.ForeignKey(User, verbose_name="User ID", on_delete=models.CASCADE)
    email = models.EmailField(verbose_name="Email", default='', blank=True)
    photo = models.ImageField(upload_to=upload_user, verbose_name="Image", default='', blank=True)
    name = models.CharField(verbose_name="Full Name", max_length=1000)
    type = models.ForeignKey(user_type, verbose_name='Department', on_delete=models.CASCADE)
    zone = models.ForeignKey(user_zone, verbose_name="Zone", on_delete=models.CASCADE)
    phoneno = models.CharField(max_length=20, verbose_name="Mobile Number", default='', blank=True)
    username = models.CharField(verbose_name="Username", max_length=200)
    password = models.CharField(verbose_name="Password", max_length=1000)
    status=models.CharField(verbose_name="Status",default='active',null=True,blank=True,max_length=20)
    admin=models.ForeignKey(User,default='',blank=True,related_name="admin_id", verbose_name="TL Name",on_delete=models.CASCADE)
    usercreateDate = models.DateField(auto_now_add=True)

    def __str__(self):
        return self.name

    class Meta:
        db_table = "user_details"
        managed = True
        verbose_name = "User Detail"
        verbose_name_plural = "User Details"


class company_master(models.Model):
    compname = models.CharField(max_length=10000,null=True, verbose_name="Company Name")
    city = models.TextField( verbose_name="City",null=True,max_length=500)
    draft = models.TextField(verbose_name="Draft",null=True)
    budget = models.CharField(verbose_name="Budget",null=True,max_length=1000)
    state = models.CharField( verbose_name="State",null=True,max_length=1000)
    address = models.TextField(verbose_name="Address",null=True)
    country = models.CharField( verbose_name="Country",null=True,max_length=1000)
    website = models.CharField(max_length=1000,null=True, verbose_name="Website")

    createddate = models.DateField(auto_now_add=True, verbose_name="Created Date")
    partnerType = models.ForeignKey(partner_master, verbose_name="Type", on_delete=models.CASCADE)

    def __str__(self):
        return self.compname

    class Meta:
        db_table = "company_master"
        managed = True
        verbose_name = "Company Master"
        verbose_name_plural = "Company Master"


class company_contact_master(models.Model):
    company=models.ForeignKey(company_master,on_delete=models.CASCADE,null=True,related_name="company_contact",verbose_name="Company" ,default="",blank=True)
    contactperson = models.CharField(verbose_name="Contact Person",null=True, max_length=2000)
    emailid = models.EmailField(verbose_name="Email",null=True)
    draft = models.TextField(verbose_name='Draft',null=True)
    phoneno = models.CharField(verbose_name="Mobile Number",null=True,max_length=20)
    designation = models.CharField(verbose_name="Designation",null=True, max_length=500)
    createddate = models.DateField(verbose_name="Created Date",auto_now_add=True)


    def __str__(self):
        return self.contactperson

    class Meta:
        db_table = "company_contact_master"
        managed = True
        verbose_name = "Company Contact Master"
        verbose_name_plural = "Company Contact Masters"


class tblcalls(models.Model):
    cmpid = models.ForeignKey(company_master, verbose_name="Company", on_delete=models.CASCADE)
    draft = models.CharField(max_length=3000, verbose_name="Draft")
    creator = models.ForeignKey(User, verbose_name="Creator", on_delete=models.CASCADE)
    proposal = models.CharField(max_length=1000, verbose_name="Preposal")
    createDate = models.DateField(auto_now_add=True, blank=True)
    topspender = models.CharField(max_length=100, verbose_name="Topsender")
    noofschools = models.CharField(max_length=1000,blank=True,default='0', verbose_name="Number of school")
    proposal_type = models.CharField(max_length=100,blank=True,default='NA', verbose_name="Proposal Type")
    proposal_amt = models.CharField(max_length=100,blank=True,default='NA', verbose_name="Proposal Amt.")
    proposaldate = models.DateField(blank=True,null=True)

    class Meta:
        db_table = "init_call"
        managed = True
        verbose_name = "Creator Info"
        verbose_name_plural = "Creators Info"
        
class notification(models.Model):
    msg=models.TextField(verbose_name="Message")
    user=models.CharField(max_length=11, verbose_name="User")
    company_id=models.CharField(max_length=11, verbose_name="Company id")
    status=models.CharField(max_length=11,default="pending", verbose_name="Status")
    date = models.DateField(blank=True,null=True)
    class Meta:
        db_table = "notification"
        managed = True
        verbose_name = "Notification"
        verbose_name_plural = "Notifications"
        



class tblcallevents(models.Model):
    cid = models.ForeignKey(tblcalls, verbose_name="Table Calls",related_name="cid" ,on_delete=models.CASCADE)
    user = models.ForeignKey(User, verbose_name="User", on_delete=models.CASCADE,related_name="user")
    lastCFID = models.CharField(verbose_name="Last Id", max_length=1000)
    nextCFID = models.CharField(verbose_name="New Id", max_length=1000)
    draft = models.CharField(verbose_name="Draft", max_length=30000)
    status = models.ForeignKey(status, verbose_name="Status", on_delete=models.CASCADE)
    event = models.CharField(verbose_name="Event",blank=True, max_length=30000)
    purpose = models.ForeignKey(purpose, verbose_name="Purpose", on_delete=models.CASCADE)
    remarks = models.TextField(verbose_name="Remark")
    fwd_date = models.DateTimeField(blank=True, verbose_name="Forwarded Date")
    actiontype = models.ForeignKey(actions, verbose_name="Action Type", on_delete=models.CASCADE)
    actontaken = models.CharField(max_length=500, verbose_name="Action Taken")
    assignedto = models.ForeignKey(User, verbose_name="Assign To", on_delete=models.CASCADE,related_name="assign_to")
    nextaction = models.TextField(verbose_name="Next Action")
    meeting_type = models.CharField(max_length=100,blank=True,default='NA', verbose_name="Meeting Type")
    live_loaction = models.TextField(verbose_name="Live Location URL",blank=True,default='NA')
    mom_received= models.TextField(verbose_name="MOM Received",blank=True,default='NA')
    appointmentdatetime = models.DateTimeField(blank=True,null=True)
    date=models.DateTimeField(auto_now=True,blank=True,null=True)
    updateddate = models.DateTimeField(auto_now_add=True, blank=True, null=True)

    def __str__(self):
        return self.event

    class Meta:
        db_table = "tblcallevents"
        managed = True
        verbose_name = "Call Event"
        verbose_name_plural = "Call Events"
