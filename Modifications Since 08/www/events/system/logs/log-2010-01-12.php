<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

DEBUG - 2010-01-12 08:40:25 --> Config Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Hooks Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Router Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Output Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Input Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Global POST and COOKIE data sanitized
DEBUG - 2010-01-12 08:40:25 --> URI Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Language Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Loader Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Config file loaded: config/custom_config.php
DEBUG - 2010-01-12 08:40:25 --> Helpers loaded: form, html, date, http
DEBUG - 2010-01-12 08:40:25 --> Database Driver Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Session Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Encrypt Class Initialized
DEBUG - 2010-01-12 08:40:25 --> A session cookie was not found.
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Helpers loaded: url
DEBUG - 2010-01-12 08:40:25 --> User Agent Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Controller Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Model Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Pagination Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Validation Class Initialized
DEBUG - 2010-01-12 08:40:25 --> Helpers loaded: form
DEBUG - 2010-01-12 08:40:25 --> Helpers loaded: url
DEBUG - 2010-01-12 08:40:26 --> EVENT:getIDfromURL:SELECT *
FROM cn_events
WHERE event_url_name = 'motivation_weight_lose_while_training_for_a_triathlon'
DEBUG - 2010-01-12 08:40:26 --> Plugins loaded: captcha
DEBUG - 2010-01-12 08:40:26 --> EVENT:getEvent:SELECT *
FROM cn_events
WHERE event_id = '3'
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined index:  participants /home/openfloo/public_html/events/system/application/controllers/forums.php 302
DEBUG - 2010-01-12 08:40:26 --> questionQueue:SELECT 
				question_id, 
				IFNULL((SELECT 
					cast(format(sum(vote_value)/10,0) as signed) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_question_id=question_id 
				AND vote_id IN (SELECT max(vote_id) FROM cn_votes WHERE fk_question_id = question_id GROUP BY fk_user_id)	 					
				GROUP BY fk_question_id), 0) as votes,
				(SELECT count(*) FROM cn_comments WHERE fk_question_id=question_id) as comment_count,
				question_name, 
				question_desc,
				question_status,
				question_answer,
				cn_questions.timestamp as date, 
				user_name,
				user_id, 
				user_avatar,
				event_name,
				event_desc,
				event_url_name,
				location,
				flag_reason,
				flag_reason_other
			FROM 
				cn_questions, 
				cn_events, 
				cn_users
				 
			WHERE 
				cn_questions.fk_user_id=user_id 
				 AND question_status = 'current' AND event_id = 3
			AND 
				fk_event_id=event_id 
			ORDER BY 
				votes 
			DESC
DEBUG - 2010-01-12 08:40:26 --> questionQueue:SELECT 
				question_id, 
				IFNULL((SELECT 
					cast(format(sum(vote_value)/10,0) as signed) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_question_id=question_id 
				AND vote_id IN (SELECT max(vote_id) FROM cn_votes WHERE fk_question_id = question_id GROUP BY fk_user_id)	 					
				GROUP BY fk_question_id), 0) as votes,
				(SELECT count(*) FROM cn_comments WHERE fk_question_id=question_id) as comment_count,
				question_name, 
				question_desc,
				question_status,
				question_answer,
				cn_questions.timestamp as date, 
				user_name,
				user_id, 
				user_avatar,
				event_name,
				event_desc,
				event_url_name,
				location,
				flag_reason,
				flag_reason_other
			FROM 
				cn_questions, 
				cn_events, 
				cn_users
				 
			WHERE 
				cn_questions.fk_user_id=user_id 
				 AND question_status = 'current' AND event_id = 3
			AND 
				fk_event_id=event_id 
			ORDER BY 
				votes 
			DESC
DEBUG - 2010-01-12 08:40:26 --> Language file loaded: language/english/date_lang.php
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Trying to get property of non-object /home/openfloo/public_html/events/system/application/models/candidate_model.php 143
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined index:  option_delete /home/openfloo/public_html/events/system/application/views/event/widget.php 5
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined index:  option_respondent /home/openfloo/public_html/events/system/application/views/event/widget.php 6
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined variable: head_include /home/openfloo/public_html/events/system/application/views/view_layout/widget_header.php 27
ERROR - 2010-01-12 08:40:26 --> Severity: Warning  --> Invalid argument supplied for foreach() /home/openfloo/public_html/events/system/application/views/view_layout/widget_header.php 27
DEBUG - 2010-01-12 08:40:26 --> File loaded: /home/openfloo/public_html/events/system/application/views/view_layout/widget_header.php
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined variable: curtain /home/openfloo/public_html/events/system/application/views/ajax/openfloor_login.php 4
DEBUG - 2010-01-12 08:40:26 --> File loaded: /home/openfloo/public_html/events/system/application/views/ajax/openfloor_login.php
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined index:  user_name /home/openfloo/public_html/events/system/application/views/event/widget.php 60
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined index:  user_name /home/openfloo/public_html/events/system/application/views/event/widget.php 68
DEBUG - 2010-01-12 08:40:26 --> File loaded: /home/openfloo/public_html/events/system/application/views/question/_submit_question_form.php
ERROR - 2010-01-12 08:40:26 --> Severity: Notice  --> Undefined index:  user_name /home/openfloo/public_html/events/system/application/views/event/widget.php 303
DEBUG - 2010-01-12 08:40:26 --> File loaded: /home/openfloo/public_html/events/system/application/views/ajax/openfloor_login.php
DEBUG - 2010-01-12 08:40:26 --> File loaded: /home/openfloo/public_html/events/system/application/views/view_layout/widget_footer.php
DEBUG - 2010-01-12 08:40:26 --> File loaded: /home/openfloo/public_html/events/system/application/views/event/widget.php
DEBUG - 2010-01-12 08:40:26 --> Final output sent to browser
DEBUG - 2010-01-12 08:40:26 --> Total execution time: 0.8508
DEBUG - 2010-01-12 21:52:16 --> Config Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Hooks Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Router Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Output Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Input Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Global POST and COOKIE data sanitized
DEBUG - 2010-01-12 21:52:16 --> URI Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Language Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Loader Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Config file loaded: config/custom_config.php
DEBUG - 2010-01-12 21:52:16 --> Helpers loaded: form, html, date, http
DEBUG - 2010-01-12 21:52:16 --> Database Driver Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Session Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Encrypt Class Initialized
DEBUG - 2010-01-12 21:52:16 --> A session cookie was not found.
DEBUG - 2010-01-12 21:52:16 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:16 --> User Agent Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Controller Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:16 --> EVENT:getIDfromURL:SELECT *
FROM cn_events
WHERE event_url_name = 'robots.txt'
DEBUG - 2010-01-12 21:52:16 --> Config Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Hooks Class Initialized
DEBUG - 2010-01-12 21:52:16 --> No URI present. Default controller set.
DEBUG - 2010-01-12 21:52:16 --> Router Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Output Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Input Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Global POST and COOKIE data sanitized
DEBUG - 2010-01-12 21:52:16 --> URI Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Language Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Loader Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Config file loaded: config/custom_config.php
DEBUG - 2010-01-12 21:52:16 --> Helpers loaded: form, html, date, http
DEBUG - 2010-01-12 21:52:16 --> Database Driver Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Session Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Encrypt Class Initialized
DEBUG - 2010-01-12 21:52:16 --> A session cookie was not found.
DEBUG - 2010-01-12 21:52:16 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:16 --> User Agent Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Controller Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:16 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:16 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Validation Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Plugins loaded: js_calendar
DEBUG - 2010-01-12 21:52:17 --> Encrypt class already loaded. Second attempt ignored.
DEBUG - 2010-01-12 21:52:17 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:17 --> getCMS:SELECT *
FROM cms
WHERE cms_url = 'ConventionNext'
DEBUG - 2010-01-12 21:52:17 --> getCMS:SELECT *
FROM cms
WHERE cms_id = '6'
ERROR - 2010-01-12 21:52:17 --> Severity: Notice  --> Undefined offset:  3 /home/openfloo/public_html/events/system/application/libraries/tag_lib.php 23
ERROR - 2010-01-12 21:52:17 --> Severity: Notice  --> Undefined variable: head_include /home/openfloo/public_html/events/system/application/views/view_layout/view_head_setup.php 15
ERROR - 2010-01-12 21:52:17 --> Severity: Warning  --> Invalid argument supplied for foreach() /home/openfloo/public_html/events/system/application/views/view_layout/view_head_setup.php 15
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/view_layout/view_head_setup.php
ERROR - 2010-01-12 21:52:17 --> Severity: Notice  --> Undefined variable: onload /home/openfloo/public_html/events/system/application/views/themes/openfloor/header.php 1
ERROR - 2010-01-12 21:52:17 --> Severity: Notice  --> Undefined variable: curtain /home/openfloo/public_html/events/system/application/views/ajax/openfloor_login.php 4
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/ajax/openfloor_login.php
ERROR - 2010-01-12 21:52:17 --> Severity: Notice  --> Undefined index:  user_name /home/openfloo/public_html/events/system/application/views/themes/openfloor/header.php 14
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/themes/openfloor/header.php
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/view_layout/header.php
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/themes/openfloor/footer.php
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/view_layout/footer.php
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/event/view_events.php
DEBUG - 2010-01-12 21:52:17 --> Final output sent to browser
DEBUG - 2010-01-12 21:52:17 --> Total execution time: 0.2889
DEBUG - 2010-01-12 21:52:17 --> Config Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Hooks Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Router Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Output Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Input Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Global POST and COOKIE data sanitized
DEBUG - 2010-01-12 21:52:17 --> URI Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Language Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Loader Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Config file loaded: config/custom_config.php
DEBUG - 2010-01-12 21:52:17 --> Helpers loaded: form, html, date, http
DEBUG - 2010-01-12 21:52:17 --> Database Driver Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Session Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Encrypt Class Initialized
DEBUG - 2010-01-12 21:52:17 --> A session cookie was not found.
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:17 --> User Agent Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Controller Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Helpers loaded: url
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Model Class Initialized
DEBUG - 2010-01-12 21:52:17 --> Validation Class Initialized
DEBUG - 2010-01-12 21:52:17 --> GET_USER:SELECT *
FROM cn_users
WHERE user_name = 'danielwatrous'
ERROR - 2010-01-12 21:52:17 --> Severity: Notice  --> Undefined variable: error /home/openfloo/public_html/events/system/application/controllers/user.php 459
DEBUG - 2010-01-12 21:52:17 --> getEventAlert:SELECT
    									q.question_name
    								FROM
    									cn_questions as q, cn_alerts as a 
    								WHERE
    									q.question_id = a.fk_question_id 
    								AND
    									a.fk_user_id = 267 
    								AND
    									(a.alert_type = 'flag_inappropriate' 
    									 OR 
    									 a.alert_type = 'flag_duplicate')
    								AND
    									status = 0
DEBUG - 2010-01-12 21:52:17 --> File loaded: /home/openfloo/public_html/events/system/application/views/user/view_user_profile.php
DEBUG - 2010-01-12 21:52:17 --> Final output sent to browser
DEBUG - 2010-01-12 21:52:17 --> Total execution time: 0.1628
DEBUG - 2010-01-12 22:42:49 --> Config Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Hooks Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Router Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Output Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Input Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Global POST and COOKIE data sanitized
DEBUG - 2010-01-12 22:42:49 --> URI Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Language Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Loader Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Config file loaded: config/custom_config.php
DEBUG - 2010-01-12 22:42:49 --> Helpers loaded: form, html, date, http
DEBUG - 2010-01-12 22:42:49 --> Database Driver Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Session Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Encrypt Class Initialized
DEBUG - 2010-01-12 22:42:49 --> A session cookie was not found.
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Helpers loaded: url
DEBUG - 2010-01-12 22:42:49 --> User Agent Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Controller Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Helpers loaded: url
DEBUG - 2010-01-12 22:42:49 --> EVENT:getIDfromURL:SELECT *
FROM cn_events
WHERE event_url_name = 'robots.txt'
DEBUG - 2010-01-12 22:42:49 --> Config Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Hooks Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Router Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Output Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Input Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Global POST and COOKIE data sanitized
DEBUG - 2010-01-12 22:42:49 --> URI Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Language Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Loader Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Config file loaded: config/custom_config.php
DEBUG - 2010-01-12 22:42:49 --> Helpers loaded: form, html, date, http
DEBUG - 2010-01-12 22:42:49 --> Database Driver Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Session Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Encrypt Class Initialized
DEBUG - 2010-01-12 22:42:49 --> A session cookie was not found.
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Helpers loaded: url
DEBUG - 2010-01-12 22:42:49 --> User Agent Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Controller Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Helpers loaded: url
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Model Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Validation Class Initialized
DEBUG - 2010-01-12 22:42:49 --> Plugins loaded: js_calendar
DEBUG - 2010-01-12 22:42:49 --> Encrypt class already loaded. Second attempt ignored.
ERROR - 2010-01-12 22:42:49 --> 404 Page Not Found --> 
