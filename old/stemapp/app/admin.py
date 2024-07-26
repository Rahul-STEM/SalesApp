from django.contrib import admin
from . import models

# Register your models here.
admin.site.site_header='STEM ADMINISTRATION'
admin.site.site_title="STEM ADMINISTRATION"

class todays_remark_data(admin.ModelAdmin):
    list_filter = ('status',)
    
class todays_purpose_data(admin.ModelAdmin):
    list_filter = ('status','action')
    



admin.site.register(models.category)
admin.site.register(models.company_contact_master)
admin.site.register(models.todays_remark,todays_remark_data)
admin.site.register(models.tblcallevents)

admin.site.register(models.actions)
admin.site.register(models.purpose,todays_purpose_data)
admin.site.register(models.state)
admin.site.register(models.status)
admin.site.register(models.tblcalls)
admin.site.register(models.company_master)
admin.site.register(models.partner_master)
admin.site.register(models.country)
admin.site.register(models.city)
admin.site.register(models.user_type)
admin.site.register(models.next_action)
admin.site.register(models.user_zone)
admin.site.register(models.users)