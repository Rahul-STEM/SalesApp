# from django.db import models
# from app import company_master
# from django.contrib.auth.models import User

# # Create your models here.
# class proposal_log(models.Model):
#     cmpid = models.ForeignKey(company_master, verbose_name="Company", on_delete=models.CASCADE)
#     draft = models.CharField(max_length=3000, verbose_name="Draft")
#     creator = models.ForeignKey(User, verbose_name="Creator", on_delete=models.CASCADE)
#     proposal = models.CharField(max_length=1000, verbose_name="Preposal")
#     createDate = models.DateField(auto_now_add=True, blank=True)
#     noofschools = models.CharField(max_length=1000,blank=True,default='0', verbose_name="Number of school")
#     proposal_type = models.CharField(max_length=100,blank=True,default='NA', verbose_name="Proposal Type")
#     proposaldate = models.DateField(blank=True,null=True)
    
#     class Meta:
#         db_table = "proposal_logs"
#         managed = True
#         verbose_name = "Proposal Logs"