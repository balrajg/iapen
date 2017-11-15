<?php

// Maian Survey
// Version: 1.1
// Language File

/******************************************************************************************************
 * LANGUAGE FILE - PLEASE READ                                                                        *
 * This is a language file for Maian Survey. Edit it to suit your own preferences.           *
 * DO NOT edit the actual variable names in any way and be careful NOT to remove any of the           *
 * apostrophe`s (') that contain the variable info. This will cause the software to malfunction.      *
 * USING APOSTROPHES IN MESSAGES                                                                      *
 * If you need to use an apostrophe, escape it with a backslash. ie: d\'apostrophe                    *
 * SYSTEM VARIABLES                                                                                   *
 * Variables inside braces {} are system variables and parse when the system runs.                    *
 * The system will not fail if you accidentally delete these, but some language may not display       *
 * correctly.                                                                                         *
 ******************************************************************************************************/

/*---------------------------------------------
  CHARACTER SET
  For encoding HTML characters
  Unless specified this may not need altering.
----------------------------------------------*/


$msg_charset               = 'utf-8';
$mail_charset              = 'utf-8';


/*-------------------------------
  TEMPLATES/INC/INDEX.TPL.PHP
---------------------------------*/


$msg_publicindex           = 'For spam prevention, enter the code you see on the left in the box on the right. Click captcha to refresh.';
$msg_publicindex2          = 'Invalid security code...please try again..';
$msg_publicindex3          = 'Security Code - Click to Refresh';


/*-------------------------------
  TEMPLATES/INC/RESULTS.TPL.PHP
---------------------------------*/


$public_results            = 'Survey Results';
$public_results2           = '<b>{count}</b> people have participated in this survey.';
$public_results3           = 'Print Survey';
$public_results4           = 'Other';
$public_results5           = 'View All Responses to this Question';
$public_results6           = 'There have been 0 responses to this question!';
$public_results7           = 'Viewing Other';
$public_results8           = 'Viewing Responses';
$public_results9           = 'Print Answers';
$public_results10          = 'There is no other data for this question!';


/*-------------------------------
  TEMPLATES/INC/SURVEY.TPL.PHP
---------------------------------*/


$public_survey             = 'Other Answer:';
$public_survey2            = 'Required Field! Please Complete!';
$public_survey3            = 'Please ensure all selections are different!';


/*-------------------------------
  TEMPLATES/INC/THANKS.TPL.PHP
---------------------------------*/


$public_thanks             = 'THANK YOU!';
$public_thanks2            = '<a class="view" href="results.php?survey={code}"><img src="images/results.gif" alt="View Survey Results" title="View Survey Results" /></a>';


/*-------------------------------
  TEMPLATES/INC/HEADER.TPL.PHP
---------------------------------*/


$public_header             = 'Web Survey';
$public_header2            = 'Web Survey Results';


/*--------------------------
  TEMPLATES/EMAIL_BOX.TPL.PHP
----------------------------*/


$public_email              = 'Newsletter Signup: (Optional)';
$public_email2             = 'Please enter a valid e-mail address..';
$public_email3             = 'Please enter your name..';
$public_email4             = 'Your Name';
$public_email5             = 'Your E-Mail Address';


/*--------------------------
  TEMPLATES/BUTTONS.TPL.PHP
----------------------------*/


$public_buttons            = 'Previous';
$public_buttons2           = 'Continue';
$public_buttons3           = 'This survey has <b>{count}</b> questions';
$public_buttons4           = 'Complete Survey';


/*--------------------------
  ADMIN/TEMPLATES/HOME.PHP
----------------------------*/


$msg_home                  = 'Welcome to {software}';
$msg_home2                 = 'A free PHP survey system for your website.<br /><br />
                              For details on how to get started with your survey system, please see the <a href="../docs/setup/index.html" title="Documentation" onclick="window.open(this);return false">Documentation</a>. <br /><br />
                              Note that this software doesn`t come with any support, sorry.<br /><br />Hope you enjoy this script. If you would like to send a donation, please visit the <a href="http://www.maiansurvey.com" title="Maian Survey" onclick="window.open(this);return false">Maian Survey</a> website, thank you.<br /><br />David Ian Bennett.<br /><a href="http://www.maianscriptworld.co.uk" title="Maian Script World">www.maianscriptworld.co.uk</a><br /><br />
                              (To edit or remove this message edit the "lang/english.php" file)
                              ';
$msg_home3                 = 'Overview';
$msg_home4                 = '<b>{count}</b> Surveys';
$msg_home5                 = '<b>{count}</b> Colour Schemes';
$msg_home6                 = 'Documentation';
$msg_home7                 = 'Quick Links';
$msg_home8                 = '<b>{count}</b> Questions';
$msg_home9                 = '<b>{count}</b> Contacts';


/*----------------------------
  ADMIN/TEMPLATES/CONTACTS.PHP
------------------------------*/


$msg_contacts              = 'This feature enables you to import survey contacts into a CSV file. This can be useful if you want to import this list into an auto responder or mailing list.';
$msg_contacts2             = 'All Survey Contacts';
$msg_contacts3             = 'Choose Survey(s) - Select holding down Ctrl key';
$msg_contacts4             = 'Specify Seperator';
$msg_contacts5             = 'Download CSV File';
$msg_contacts6             = 'Name';
$msg_contacts7             = 'E-Mail Address';
$msg_contacts8             = 'Clear Contacts';
$msg_contacts9             = 'Contacts Cleared';
$msg_contacts10            = 'All contact data has been cleared!';


/*----------------------------
  ADMIN/TEMPLATES/KEYWORDS.PHP
------------------------------*/


$msg_keywords              = 'Here you can see a detailed list of the keywords used in this survey. Use the filter option to filter by question or date. Click on a keyword to see all replies associated with that keyword.';
$msg_keywords2             = 'Filter by Question';
$msg_keywords3             = 'Filter by Dates (YYYY-MM-DD)';
$msg_keywords4             = 'All Questions';
$msg_keywords5             = 'Clear Keywords';
$msg_keywords6             = 'Print Keywords';
$msg_keywords7             = 'Update Filter';
$msg_keywords8             = 'Hide Filter Options';
$msg_keywords9             = 'Show Filter Options';
$msg_keywords10            = 'Keywords';
$msg_keywords11            = 'Click a keyword to see answers associated with keyword:';
$msg_keywords12            = 'No keywords found!';
$msg_keywords13            = 'Keyword';
$msg_keywords14            = 'Frequency';
$msg_keywords15            = 'Percentage';
$msg_keywords16            = 'No keyword data found for: <b>{keyword}</b>';
$msg_keywords17            = 'Keywords Cleared';
$msg_keywords18            = 'All keywords have been cleared!';


/*----------------------------
  ADMIN/TEMPLATES/SETTINGS.PHP
------------------------------*/


$msg_settings              = 'Update your settings below. You must update these settings before adding any surveys. Enable the SMTP option if your server requires it:';
$msg_settings2             = 'Website Name';
$msg_settings3             = 'Administration E-Mail';
$msg_settings4             = 'Installation URL';
$msg_settings5             = 'Update Settings';
$msg_settings6             = 'Please include a website name..';
$msg_settings7             = 'Please include a valid e-mail address..';
$msg_settings8             = 'Please enter your installation url..';
$msg_settings9             = 'Enable SMTP';
$msg_settings10            = 'SMTP Host';
$msg_settings11            = 'SMTP Username';
$msg_settings12            = 'SMTP Password';
$msg_settings13            = 'SMTP Port';
$msg_settings14            = 'Footer Link';


/*----------------------------------
  ADMIN/TEMPLATES/QUESTIONS.PHP
  ADMIN/TEMPLATES/ADD-QUESTION.PHP
  ADMIN/TEMPLATES/EDIT-QUESTION.PHP
-----------------------------------*/


$msg_question              = 'Questions';
$msg_question2             = 'Current questions for this survey are shown below. Use the buttons provided to edit or delete questions and use the drop down menu`s to order the questions. To add a new question, use the link on the right hand side.';
$msg_question3             = 'Add New Question';
$msg_question4             = 'There are currently 0 questions for this survey!';
$msg_question5             = 'View Questions';
$msg_question6             = 'To add a new question to this survey use the form below:';
$msg_question7             = 'Enter Question';
$msg_question8             = 'Choose how the participant should provide an answer to this question: (<a rel="ibox" title="Question Type Examples" href="index.php?cmd=add-question&amp;help=1">Examples</a>)';
$msg_question9             = 'If you think a participant might not understand this question, enter optional help text';
$msg_question10            = 'Select whether participant is required to provide an answer to this question';
$msg_question11            = 'If this question has multiple answers, please enter the possible answers to your survey question in the text box below, one answer per line.';
$msg_question12            = 'Single Choice Answer (Vertical)';
$msg_question13            = 'Single Choice Answer (Horizontal)';
$msg_question14            = 'Single Choice Answer with Other Option';
$msg_question15            = 'Multiple Choice Answer (Vertical)';
$msg_question16            = 'Multiple Choice Answer (Horizontal)';
$msg_question17            = 'Multiple Choice Answer with Other Option';
$msg_question18            = 'Order of Importance';
$msg_question19            = 'Text Answer (Single Line)';
$msg_question20            = 'Text Answer (Multiple Lines)';
$msg_question21            = 'New Question Added!';
$msg_question22            = 'Your new question has successfully been added. To edit this question or add another new question, click the links below. To view questions, use the link in the right menu.';
$msg_question23            = 'Update Question';
$msg_question24            = 'Add Another New Question';
$msg_question25            = 'Please enter a question..';
$msg_question26            = 'Question Updated!';
$msg_question27            = 'Question has successfully been updated. To re-edit this question or add new question, click the links below. To view questions, use the link in the right menu.';
$msg_question28            = 'Re-Edit Question';
$msg_question29            = 'Survey Name';


/*----------------------------------
  ADMIN/TEMPLATES/SURVEYS.PHP
  ADMIN/TEMPLATES/CREATE-SURVEY.PHP
  ADMIN/TEMPLATES/EDIT-SURVEY.PHP
  ADMIN/TEMPLATES/COPY-SURVEY.PHP
-----------------------------------*/


$msg_survey                = 'Your current surveys are shown below. Use the links provided to view,edit or delete current surveys, or view other options such as questions and results. Click the link in the right hand menu to create a new survey:<br /><br />
                              The web link for any survey will "index.php?survey=xxxxxx", where xxxxxx is the unique 6-digit code shown below. Click "Show Link" if you are unsure:
                              ';
$msg_survey2               = 'Create New Survey';
$msg_survey3               = 'There are currently 0 surveys in the database!';
$msg_survey4               = 'View Surveys';
$msg_survey5               = 'Fill out the options below to create a new survey. Once you have created your survey, you can then assign questions to it:';
$msg_survey6               = 'Title of Survey';
$msg_survey7               = 'Display Survey Title';
$msg_survey8               = 'Select Colour Scheme';
$msg_survey9               = 'Show Link';
$msg_survey10              = 'Request Participants E-Mail Address';
$msg_survey11              = 'If yes, please enter a message to entice the survey participant to enter their email address';
$msg_survey12              = 'Can Participants View Survey Results';
$msg_survey13              = 'Expiry Date for Survey (Leave blank for no expiry)';
$msg_survey14              = 'After Survey Completion:';
$msg_survey15              = 'If url, enter web address to direct participant to';
$msg_survey16              = 'If message, enter message that participant will see';
$msg_survey17              = 'Can Participants Complete Survey Multiple Times';
$msg_survey18              = 'Notification E-Mail For Completed Survey (Optional)';
$msg_survey19              = 'If expiry, specify expiration date';
$msg_survey20              = 'Display URL';
$msg_survey21              = 'Show Message';
$msg_survey22              = 'Activate Survey';
$msg_survey23              = 'Update Survey';
$msg_survey24              = 'Update this survey below:';
$msg_survey25              = 'Title already exists..try again..';
$msg_survey26              = 'Please enter survey title..';
$msg_survey27              = 'Add/Remove Questions';
$msg_survey28              = 'Survey Created!';
$msg_survey29              = 'Your new survey has been created. To view this survey in the surveys list, click the link in the right hand menu. Too add questions to this survey or to create another survey, click the links below:';
$msg_survey30              = 'Add Questions to this Survey';
$msg_survey31              = 'Create Another New Survey';
$msg_survey32              = 'Other Options';
$msg_survey33              = 'Survey Options';
$msg_survey34              = 'Return to Surveys';
$msg_survey35              = 'Copy Survey';
$msg_survey36              = 'View Results';
$msg_survey37              = 'Clear Results';
$msg_survey38              = 'Add/Remove Questions';
$msg_survey39              = 'Use the links in the right hand menu to add questions, copy this survey or view/clear results. To return to the main survey page, click the link above or below:';
$msg_survey40              = 'Copy Survey';
$msg_survey41              = 'This enables you to make a quick copy of a survey if you have another survey thats similar. Update the info below to copy this survey into a new survey:';
$msg_survey42              = 'Your survey has been updated. To view this survey in the surveys list, click the link in the right hand menu. Too re-edit this survey, add questions to this survey or create another survey, click the links below:';
$msg_survey43              = 'Survey Updated!';
$msg_survey44              = 'Re-Edit Survey';
$msg_survey45              = 'Survey Copied!';
$msg_survey46              = 'Your survey has been copied into a new survey. To view this survey in the surveys list, click the link in the right hand menu. Too edit this survey, add questions to this survey or create another survey, click the links below:';
$msg_survey47              = 'Code';
$msg_survey48              = 'Survey Display Type';
$msg_survey49              = 'Single Page';
$msg_survey50              = 'Multiple Pages';
$msg_survey51              = 'Export Contacts';
$msg_survey52              = 'Keyword Analysis';
$msg_survey53              = 'Enable Keyword Logging';
$msg_survey54              = 'Enable Single Page Captcha';
$msg_survey55              = 'Survey Results Cleared';
$msg_survey56              = 'All survey results have been cleared!';
$msg_survey57              = 'Participants';
$msg_survey58              = 'Contacts';


/*--------------------------
  ADMIN/TEMPLATES/LOGIN.PHP
  ADMIN/TEMPLATES/NEWPASS.PHP
----------------------------*/


$msg_login                 = 'Administration Login';
$msg_login2                = 'Log in to your account below. If you have forgot your password, use the link on the right:';
$msg_login3                = 'Username';
$msg_login4                = 'Password';
$msg_login5                = 'Login';
$msg_login6                = 'Forgot Password?';
$msg_login7                = 'Get New Password';
$msg_login8                = 'If you have forgot your password, use the form below to have it reset:';
$msg_login9                = 'Administration E-Mail Address';
$msg_login10               = 'Password Reset!';
$msg_login11               = 'Please check your inbox at <b>{email}</b> for your new password.<br /><br />Change this to something you can remember as soon as possible.<br /><br />Thank you!';
$msg_login12               = 'Invalid username..try again..';
$msg_login13               = 'Invalid password..try again..';
$msg_login14               = 'Remember Me';
$msg_login15               = 'Invalid email..try again..';
$msg_login16               = '[IMPORTANT] New Password!!';


/*--------------------------
  ADMIN/TEMPLATES/PASS.PHP
----------------------------*/


$msg_pass                  = 'If you need to update your admin login details, please use the form below. It is recommended you change these from time to time for security reasons. If you just want to update your username, enter your new password the same as your old:';
$msg_pass2                 = 'Old Password';
$msg_pass3                 = 'New Password';
$msg_pass4                 = 'Re-Type New Password';
$msg_pass5                 = 'Please enter your current password..';
$msg_pass6                 = 'Please enter a new password..';
$msg_pass7                 = 'New passwords do not match..try again..';
$msg_pass8                 = 'Password Updated!';
$msg_pass9                 = 'Your login details have successfully been updated.<br /><br />Remember to log in with the following details next time.<br /><br /><b>Username</b>: {username}<br /><b>Password</b>: {password}';
$msg_pass10                = 'Old password invalid..try again..';
$msg_pass11                = 'New Username';


/*----------------------------------------
  ADMIN/TEMPLATES/COLOURS.PHP
  ADMIN/TEMPLATES/CREATE-COLOUR-SCHEME.PHP
  ADMIN/TEMPLATES/EDIT-COLOUR-SCHEME.PHP
-----------------------------------------*/


$msg_colours               = 'Here you can add colour schemes to your system. You can have as many colour schemes as you wish and you can assign different schemes to different surveys.<br /><br />
                              To create a new scheme, use the link in the right hand menu. To edit an existing scheme, use the links next to each scheme:
                              ';
$msg_colours2              = 'Create New Scheme';
$msg_colours3              = 'To add a new colour scheme, complete the fields below. Click the pallet images to launch the color picker or type colours in manually. No # symbol before colours:';
$msg_colours4              = 'View Colour Schemes';
$msg_colours5              = 'Enter Title for Colour Scheme';
$msg_colours6              = 'Display Width for Survey (in Pixels)';
$msg_colours7              = 'Enter Font &amp; Colours for Survey Title';
$msg_colours8              = 'Enter Font &amp; Colours for Survey Question';
$msg_colours9              = 'Enter Font &amp; Colours for Survey Answer';
$msg_colours11             = 'Background Colour';
$msg_colours12             = 'Text Colour';
$msg_colours13             = 'Font Type';
$msg_colours14             = 'Font Size';
$msg_colours15             = 'Click to Choose Colour';
$msg_colours16             = 'There are currently 0 colour schemes in the database!';
$msg_colours17             = 'Title already exists..try again..';
$msg_colours18             = 'Update Colour Scheme';
$msg_colours19             = 'Update this scheme below. Click the preview link in the right menu to see what this scheme looks like after editing:';
$msg_colours20             = 'Please enter scheme title..';
$msg_colours21             = 'Preview This Theme';


/*-----------------------------------------
  ADMIN/TEMPLATES/PREVIEW-COLOUR-SCHEME.PHP
------------------------------------------*/


$msg_preview               = 'SURVEY TITLE HERE..';
$msg_preview2              = 'This is a question. Here are some possible answers:';
$msg_preview3              = 'Answer One';
$msg_preview4              = 'Answer Two';
$msg_preview5              = 'Answer Three';


/*---------------------
  ADMIN/INC/HEADER.PHP
----------------------*/


$msg_header                = 'Administration';
$msg_header2               = 'Home';
$msg_header3               = 'Logout';
$msg_header4               = 'Surveys';
$msg_header5               = 'Colour Schemes';
$msg_header6               = 'Change Login Data';
$msg_header7               = 'Login';
$msg_header8               = 'Settings';


/*-----------------
  ERROR MESSAGES
------------------*/


$msg_error                 = 'The survey with code #"<b>{code}</b>" has expired!';
$msg_error2                = 'The survey with code #"<b>{code}</b>" does not exist!';
$msg_error3                = 'The survey with code #"<b>{code}</b>" has no questions!';
$msg_error4                = 'You have already taken part in survey "<b>{code}</b>". Multiple voting isn`t allowed!';
$msg_error5                = 'This page has expired.<br /><br />This page usually appears if you use your browser back button to view an expired survey page or if you try and access an invalid survey results page. OR if you attempt to directly access the main index.php file.';
$msg_error6                = 'The results for survey #"<b>{code}</b>" are not viewable to the public!';


/*-----------------
  GENERAL VARIABLES
------------------*/


$msg_script                = 'Maian Survey';
$msg_script2               = 'v1.1';
$msg_script3               = 'Powered by';
$msg_script4               = 'Yes';
$msg_script5               = 'No';
$msg_script6               = 'All Rights Reserved';
$msg_script7               = 'First';
$msg_script8               = 'Last';
$msg_script9               = 'Edit';
$msg_script10              = 'Delete';
$msg_script11              = 'Cancel';
$msg_script12              = 'Links';
$msg_script13              = 'Preview';
$msg_script14              = 'Help &amp; Information';
$msg_script15              = 'No Thanks';
$msg_script16              = 'Yes Please';
$msg_script17              = '[Survey Notification] Survey Completed by Visitor!';
$msg_script18              = 'Keyword';
$msg_script19              = 'Print This Page';
$msg_script20              = 'Return to Previous Page';


/*--------------
  ADMIN/HELP
----------------*/


$msg_help                  = 'Question';
$msg_help2                 = 'Other, please specify';


/*----------------------
  ADMIN/INC/CAL_ARRAY.PHP
-----------------------*/


$msg_calendar              = 'January';
$msg_calendar2             = 'February';
$msg_calendar3             = 'March';
$msg_calendar4             = 'April';
$msg_calendar5             = 'May';
$msg_calendar6             = 'June';
$msg_calendar7             = 'July';
$msg_calendar8             = 'August';
$msg_calendar9             = 'September';
$msg_calendar10            = 'October';
$msg_calendar11            = 'November';
$msg_calendar12            = 'December';


/*-----------------------------------------------------------------------------------------------------
  JAVASCRIPT VARIABLES
  IMPORTANT: If you want to use apostrophes in these variables, you MUST escape them with 3 backslashes
             Failure to do this will result in the software malfunctioning on javascript code.
  EXAMPLE: d\\\'apostrophe

  Double (") quotes should be fine.
------------------------------------------------------------------------------------------------------*/


$msg_javascript            = 'Deleting....\n\nAre you sure?';
$msg_javascript2           = 'Help/Information';
$msg_javascript3           = 'This is the full url (starting http://) to your survey installation folder. WITH trailing slash. ie:<br /><br />http://www.yoursite.com/survey/';
$msg_javascript4           = 'Survey Link';
$msg_javascript5           = 'Specify whether you want visitors to see a message after completing the survey, or be directed to another page. This could be a page of special offers.<br /><br />If you want a view results link on your other page, link to "results.php?survey=xxxxxx", where xxxxxx is your 6 digit survey code.';
$msg_javascript6           = 'If you do not want participants to be able to complete a survey more than once, set this to no. A cookie is set on the participants machine to prevent further access to this survey.';
$msg_javascript7           = 'Do you want to receive e-mail notification if someone completes the survey? This can be sent to more than 1 e-mail address. Separate e-mail addresses with a comma. Leave blank for no notification.';
$msg_javascript8           = 'Some servers require SMTP authentication to send e-mails. If the e-mails are working ok, you don`t need to enable this. Contact your host if you are unsure of these settings.';
$msg_javascript9           = 'If checked and cookies are enabled, this will keep you logged in for 30 days. NOT recommended for shared computers.';
$msg_javascript10          = 'If you select "Single Page", all questions will load on one page. If you select "Multiple Pages" survey displays one question per page with status bar.';
$msg_javascript11          = 'The "admin/csv" is not writeable or does not exist. Check and try again..';
$msg_javascript12          = 'Clear Keywords\n\nAre you sure?\n\nNote that if you have selected a question as a filter, only keywords will be removed for that question. Update filter for ALL questions to clear all survey keywords.\n\n(Participant data is not affected)';
$msg_javascript13          = 'Do you wish to enable keyword logging for this survey? Can be useful if you want to analyse text used in questions. Only applies to questions with textual answers.';
$msg_javascript14          = 'Captchas can help prevent spam and bots auto submitting your form. This option is only available for single page surveys which are vulnerable to bots.';
$msg_javascript15          = 'Clear Results\n\nAre you sure?\n\nThis will clear all participant survey data for this survey!!\n\n(Keywords are not affected)';
$msg_javascript16          = 'Logout and terminate current session?';
$msg_javascript17          = 'Clear Contacts\n\nAre you sure?\n\nThis will clear all contact data for this survey!';
$msg_javascript18          = 'Enter preferred footer url for surveys.';
$msg_javascript19          = '["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]'; // Javascript calendar array..
$msg_javascript20          = '["Su","Mo","Tu","We","Th","Fr","Sa"]'; // Javascript calendar array..


?>
