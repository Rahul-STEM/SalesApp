"""stemAPP URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.conf.urls import url
from django.contrib import admin
from django.urls import path
from app import views
from django.conf.urls.static import static
from django.conf import settings

urlpatterns = [
                  path('admin/', admin.site.urls),
                  path('', views.login_page),
                  path("login/validation", views.login_validator),
                  path('logout', views.logout_user),
                  path("homepage", views.homepage),
                #   path("test", views.test),
                  path("Admin-dashboard", views.admin_dashboard),
                  path("unique-companies",views.unique_companies),
                  path('new-lead', views.new_lead),
                  path('company/add', views.add_company_data),
                  path('get-city/<int:id>', views.get_city),
                  path('get-company-contact', views.get_company_contact),
                  path('company/contact/add', views.add_contact),
                  path('get-remark', views.get_remark),
                  path('get-purpose', views.get_purpose),
                  path('get-next_action', views.get_next_action),
                  path('add-new-lead', views.add_new_lead),
                  path('company/<int:company_id>', views.company_details),
                  path('get-event-details', views.get_event_details),
                  path('companies', views.all_companies),
                  path('reports', views.reports),
                  path('get-company-status', views.get_company_status),
                  path('synopsis', views.synopsis),
                  path('check-remark', views.check_remark, ),
                  path('add-call-log', views.add_call_log),
                  path('opentoopenrpem',views.opentoopenrpem),
                  path('opentoreachout', views.opentoreachout),
                  path('reachouttotentetive', views.reachouttotentetive),
                  # path('tentativetopositive', views.tentativetopositive),
                  path('positivetoclosure', views.positivetoclosure),
                  path('other-conversions', views.otherconversions),
                  path('manage-employees', views.manage_employees),
                  path('edit-user/<int:id>', views.edit_user),
                  path('delete-user/<int:id>', views.delete_user),
                  path('get-employee-report', views.get_employee_report),
                  path('employee-data/<int:id>', views.employee_data),
                  path('employee-data-calls/<int:id>',views.employee_data_calls),
                  path('employee-data-emails/<int:id>',views.employee_data_emails),
                  path('employee-data-meets/<int:id>',views.employee_data_meets),
                  path('set-inactive-user/<int:id>', views.set_inactive_user),
                  path('set-active-user/<int:id>', views.set_active_user),
                  path('check-date-activity', views.check_date_activity),
                  path('add-contact/<int:id>',views.add_new_contact),
                  path('change-pass',views.change_pass),
                  path('pending-tasks',views.pending_tasks),
                  path('forward-to-current-date/<int:cmpid>/<int:last_id>',views.forward_to_current_date),
                  path('edit-company/<int:company_id>',views.edit_company),
                    path('edit-company-contact/<int:company_id>',views.edit_company_contact),
                    path('company/update/<int:company_id>',views.update_company),
                    path('company/contact/update/<int:company_id>/<int:contact_id>',views.update_contact),
                    path('setasalternate/<int:company_id>/<int:contact_id>',views.setasalternate),
                    path('setasprimary/<int:company_id>/<int:contact_id>',views.setasprimary),
                    path('assigned-data',views.assigned_data),
                    path('export-assigned-data',views.export_assigned_data),
                    path('my-data',views.my_data),
                    path('funnel_report',views.funnel_report),
                    path('conversion_report',views.conversoin_report),
                    path('task_conversion_report',views.task_conversoin_report),
    path('conversion_details',views.conversion_details),
    path('other_conversion_details',views.other_conversion_details),
    path('school_visit_reports',views.school_visit_reports),
    path('meeting_proposal',views.meeting_proposal),
    path('meeting_dashboard',views.meeting_dashboard),
    path('check_notification',views.check_notification),
    path('update_notification/<int:id>',views.update_notification),
    path('notifications',views.notifications),
    path('action_wise_activity',views.action_wise_activity),

              ] + static(settings.STATIC_URL,document_root=settings.STATIC_ROOT)
