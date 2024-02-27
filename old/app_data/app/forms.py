from django.forms.models import ModelForm
from . import models
class add_leadForm(ModelForm):
    class Meta:
        model=models.tblcalls
        fields=['creator','draft','proposal','topspender','noofschools','proposaldate']

class add_companyForm(ModelForm):
    class Meta:
        model=models.company_master
        fields=['compname','city','draft','budget','state','address','country','website','partnerType']

class add_companycontact(ModelForm):
    class Meta:
        model=models.company_contact_master
        fields = ['contactperson','emailid','draft','phoneno','designation']