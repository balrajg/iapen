=================
HTML FOLDER INFO:
=================

The template files in the 'html' folder are not parsed by Savant, but simply loaded into a string and echoed
to the browser via Savant. This is for easier editing of HTML.

The code between braces (ie: {name}) gets parsed when the system runs. You should be careful not to 
remove some of these as you may find that certain data does not appear correctly. Advanced users should be able to see
which vars are important. Many simply load language data, others script data.

If you edit and find something has gone wrong, re-download the script and replace these files.

IMPORTANT: Unlike the .tpl.php template files, which are directly parsed by Savant, the .tpl template files cannot
have any PHP code inserted into them directly. PHP will not work if you do this.

