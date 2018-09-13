### Release History:
This file may be not accurate!

#### 2.0.0   2018-09-13
- LEPTON-CMS

#### 1.0.8   2018-09-12
- Set project up to WB 2.12.0 with som minor fixes.
- Tested with PHP 7.2.8

#### 1.0.7	2015-09-13
- Serval bugfixes and codechanges for WB 2.8.3 and deprecated functions.

#### 1.0.6	2010-08-09
- Bugifx inside view.php - missing Quote causes in validation-errors.

#### 1.0.5	2010-07-10
- Bugfix inside resizer.php for missformed values for max_height and max_width.
- Remove the http-referer test in the delete.php to avoid conflicts  
when WB trys to delete a page/section within this module.
- Modify the js-code to center the popup-window in the frontend in  
center of the main-window instead of the main-screen.
- Add error-checking in the install.php.
- Add backend.css for the interface. Removed hardcoded styles in the modify.php - backend interface.
- Removed unused php-code inside modify.php. (unnessesary queries).
- Recode the default-options ($fetch_page_content) inside modify.php;  
add missing keys to avoid warnings "key doesn't exists in array".
- Bugfix js-output inside the view.php that causes js-errors.
- Add label for the thumbnails (was hardcoded "Pictures" before).

#### 1.0.4	2010-04-13
- Remove the http-referer test in the save.php.

#### 1.0.3	2010-04-07
- Some additional code inside "delete.php" to check the HTTP_REFERER.
- Remove some typos in the comments (e.g. in uninstall.php we are  
not(!) trying to delete a directory, but we drop a [MySQL]-Table).
- Update the language-files to speed up the code.
- Add hash_id to the modify.php backend and additional tests inside  
the save.php if it match.
- Rename $file_size to $file_name; as we unlink a file, not his size.

#### 1.0.2	2010-04-07
- Some code-changes.
- Bugfix inside modify.php; missplaced '?>'.
- Remove some typos in uninstall.php.
- Bugfix in the view.php; wrong path to the ie-specific css file.

#### 1.0.1	2010-04-05
- PopUp Window now is placed in the middle of the screen, instead of left=5px and top=5px hardcoded.
- Some typography cosmetic corrections.

#### 1.0.0	2010-04-05
- Massiv recoding for the output to get the frontend XHTML transitional valide.
- Add frontend.js and frontend.css to the project.

#### 0.9.4	2010-04-04
- Add conditional IE-css to avoid css-errors outside IE.

#### 0.9.3	2010-04-04
- Bugfix inside "resizer_interface.php".
- Minor typography "cosmetic" changes.
- Bugfix for missing values for "duration" and "delay" that causes for java-script errors.
- Backend-Form xhtml transitional valid (was 83! errors). Frontend is not!

#### 0.9.2	2010-04-03
- Secure Fixes.
- Add guid.

#### 0.9.1	2009-02-05
- Bugfix in view.php

#### v0.9 Feb 15, 2007 (ToS)
- added third option for opening image directly (equals: taget="_blank")
- added Norvegian language (by oeh)
- added option to put gallery description at the bottom of page
- removed Note in modify.php

#### [0.9a]
- actualized info.php
- translated new language fields to german
#### [0.9b]
- fixed descreption is always displayed under the gallery
- fixed (hopefully) Mang-bug with undefined index

#### v0.8 Feb 15, 2007 (Matthias Gallas)
- fixed bug with popup window in IE6 (thanks to sporrencense)

#### v0.7 Jan 15, 2007 (Matthias Gallas)
- added new lines to German language file

#### v0.6(Beta) Jan 15, 2007 (ToS)
- added to css file | .jdGallery .slideInfoZone h2 | added: text-align: left;
- fixed modify.php | changed 'showCaurosel' option to correct one: 'showCarousel'
- added change-able name-desc split character
- added resizer_inteface.php to prevent future update problems of the smoothGallery itself
- added option to select wether images should be parsed tru resizer.php for normal showing
- added option to select what extensions are to be selected for showing
- fixed not loading extensions in wrong casing
- fixed use hard-coded links for thumbnails (not integrated thumb generator)
- added option: select if the links should be opened in new javascript window or in active.
- added cache dir support/handling

#### v0.5  Jan 08, 2007 (Matthias Gallas)
- added version History to info.php
- added german language file
- added language support
- a lot of code cleaning, fixing and sorting in all files
- replaced all directory variables with hardcoded pathes
- changed all copyright notices now includes 2007

#### v0.4  Jan. 07, 2007 (ToS)
- Initial Release