# Ecore-3.0
2D Serious Game Editor and Player with moodle LTI interface

#### INSTALLATION:
- import the mysql DB using the file "ecore.sql"
- open the file /config/function.common.inc.php
  and set the database access
  
- open the file /config/config.inc.php
	in this file set:
	- $serverRoot and $serverDir
	- Database access
    - the constant "SITE_URL_LOCATION"
    - the constant "API_KEY_GOOGLE_TTS" for the text to speech synthesis

- Upload the files

- The following folders and all content, have to be WRITABLE (chmode 777): 
/data/audio/ 
/data/attachments/
/data/attachmentsTMP/
/data/gameCover/
/data/scenarios/
/data/scenariosT/
/data/avatar_prev/1/
/data/attachmentsTMP/

#### FIRST TEST:	
to test the platform you can log in as:
- Simple User:
user:user
password: user1

- Editor:
user:editor
password: editor1

- Super user
user:super
password: super1


#### USERS Hierarchy
*users, Hierarchy and privileges
in the db, table "user" the field "user_level"
is used to set Hierarchy and privileges:

0  simple user, 
1 Editor, 
2 Administrator, 
3 Super User

Note
the Access via #moodle will create itself the user in this table,
anyway you can create direct access new user using the same table

#### LANGUAGES
english, italian
the db table for languages is PLANG

##### Legal stuff
Please, find the file /informativaTEMPLATE.docx (in italian), 
customize it with your company data
and overwrite the file /informativa.pdf


--- 

Entropy Knowledge Network srl www.entropykn.net

