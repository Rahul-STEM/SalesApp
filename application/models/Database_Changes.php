<?php
/* 

-------------------------------------------------------------
                    Table Update  
-------------------------------------------------------------

1).  tblcallevents  
        - filter_by  - Update varchar (350)
        - approved_status	- varchar(10)
        - approved_by	- varchar(50)
        - plan_change	- tinyint			default	0
        - self_assign	- varchar(100)
        - comment_by	- int
        - comments	- varchar(500)
        - thnkscomments	- varchar(500)

2).  autotask_time
        - start_tttpft	- time	
        - end_tttpft	- time
        - userworkfrom	- int

3).  mom_data
       - proposal_of_location - varchar(255)  -  (Add After - proposal_of_budget (20))   - 20, 21
       - client_int_type_project	varchar(255)  - (Add After - client_int_school_visit)  -20, 21
       - pst_call_task	tinyint			default	0  -  (Add After  - cm_call_task )


4).  close_your_day_request    - New 

    CREATE TABLE `close_your_day_request` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `req_id` int NOT NULL,
    `req_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `why_did_you` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `req_remarks` text NOT NULL,
    `startautotasktime` time DEFAULT NULL,
    `endautotasktime` time DEFAULT NULL,
    `start_tttpft` time DEFAULT NULL,
    `end_tttpft` time DEFAULT NULL,
    `autotasktimeisset` varchar(10) NOT NULL,
    `approved_status` varchar(100) NOT NULL,
    `approved_by` int NOT NULL,
    `approved_remarks` text NOT NULL,
    `approved_date` datetime DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci



5).  special_request_for_leave    - New 
    
CREATE TABLE `special_request_for_leave` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time NOT NULL,
  `prupose` varchar(400) NOT NULL,
  `start_tommorow` varchar(255) NOT NULL,
  `approve_by` varchar(50) NOT NULL,
  `approve_status` varchar(50) NOT NULL,
  `approve_date` varchar(255) NOT NULL,
  `approve_remarks` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1



6).  reminder   - New 

CREATE TABLE `reminder` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(300) NOT NULL,
  `message` text,
  `acknowledge_by` varchar(255) NOT NULL,
  `acknowledge_message` text NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci


6).  reminder_message   - Added in Folder

7).  init_call   - Update

        ALTER TABLE init_call
        ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


8).  action   - Update

    - 17 Join Meeting 30  10  NULL bg-warning #2471A3
    - 18 MOM Check 5 10 NULL bg-succcess #2471A3


9).  auto_assign_task   - New

    CREATE TABLE `auto_assign_task` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `to_user_id` int NOT NULL,
    `ccstatus` int NOT NULL,
    `init_cmpid` int NOT NULL,
    `call_tid` int NOT NULL,
    `action_id` int NOT NULL,
    `status` int NOT NULL,
    `mom_id` int NOT NULL,
    `remarks` varchar(300) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci


10).  task_plan_for_today   - Update

    - taskcnt	int
    - would_you_want	varchar(300)	
    
ALTER TABLE task_plan_for_today
        ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;



11). session_plan_time  - New

    CREATE TABLE `session_plan_time` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `psdatetime` datetime DEFAULT NULL,
    `pstime` time DEFAULT NULL,
    `pctime` time DEFAULT NULL,
    `pcdatetime` datetime DEFAULT NULL,
    `totaltime` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`,`psdatetime`,`pstime`,`pctime`,`pcdatetime`)
    ) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1




12). barginmeeting   - Upddate

      - letmeetingsremarks	varchar(400)
      - company_as	varchar(255)
      - company_descri	varchar(255)
      - potentional_client	varchar(255)	
      - approved_status	varchar(10)
      - approved_by	varchar(40)
      - plan_change	tinyint



13). userworkfrom   - NEW  - Added in Folder



14). change_user_day_request   - NEW  


    CREATE TABLE `change_user_day_request` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `user_want_start` int NOT NULL,
    `date` datetime NOT NULL,
    `message` text NOT NULL,
    `apr_by` int DEFAULT NULL,
    `apr_status` tinyint NOT NULL DEFAULT '0',
    `amessage` text NOT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci




15). close_your_day_request   - NEW  

    CREATE TABLE `close_your_day_request` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `req_id` int NOT NULL,
    `req_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `why_did_you` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `req_remarks` text NOT NULL,
    `startautotasktime` time DEFAULT NULL,
    `endautotasktime` time DEFAULT NULL,
    `start_tttpft` time DEFAULT NULL,
    `end_tttpft` time DEFAULT NULL,
    `autotasktimeisset` varchar(10) NOT NULL,
    `approved_status` varchar(100) NOT NULL,
    `approved_by` int NOT NULL,
    `approved_remarks` text NOT NULL,
    `approved_date` datetime DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci




16). allreviewdata   - Update

      - travelcluster	varchar(40)
      - cluster_id	varchar(255)
      - reviewtype	varchar(255)


17). many_time_review   - New

CREATE TABLE `many_time_review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sdatet` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `bdid` int NOT NULL,
  `remark` text NOT NULL,
  `ntid` int NOT NULL,
  `inid` int NOT NULL,
  `how_many_task` int NOT NULL,
  `frequency_of_the_task` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type_of_task` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rp_meeting_done` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mom_done` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `social_networking_done` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `category_right` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `slct_category` int DEFAULT NULL,
  `current_status_right` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `current_status` int DEFAULT NULL,
  `many_times_barge_meeting` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `research_prospecting` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `base_or_travel_location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `partner_type_right` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `partner_type` int DEFAULT NULL,
  `suppert` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rtype` varchar(255) NOT NULL,
  `ex_status_id` int NOT NULL,
  `exdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci



18). 





















*/ 



