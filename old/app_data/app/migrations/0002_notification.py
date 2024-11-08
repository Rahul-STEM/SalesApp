# Generated by Django 3.1.1 on 2020-10-04 22:43

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0001_initial'),
    ]

    operations = [
        migrations.CreateModel(
            name='notification',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('msg', models.TextField(verbose_name='Message')),
                ('user', models.CharField(max_length=11, verbose_name='User')),
                ('company_id', models.CharField(max_length=11, verbose_name='Company _id')),
            ],
            options={
                'verbose_name': 'Notification',
                'verbose_name_plural': 'Notifications',
                'db_table': 'notifications',
                'managed': True,
            },
        ),
    ]
