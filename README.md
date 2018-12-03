https://personalprogrammer.mk/senior-php-developer-with-experience-in-zend-framework/

TOOLS:
https://github.com/prewk/xml-string-streamer
http://www.dimuthu.org/blog/2008/09/30/xpath-in-simplexml/
ERRORS:
http://php.net/manual/en/simplexml.examples-errors.php

Hi,

I'm looking for a simple XML tool to fetch data from XML-files and use it for
various other purposes.

Enclosed you'll find two XML files, each for a different project. 

The configurator test-file contains information for a composite product, and this
information has to be converted to an Exact import-format. 
1. composite product - what is composite product? I see.
2. exact import-format (json, csv, xml...) - to select output

The productindex test-file contains a very large list (in the test-file just a few, but the
real file is >1GB) of links to products, and we need to filter it on one or
more specific Catids for further processing.
1. It seems this file is like DB with data that should be fltered out by some criteria
2. Catids - Catid="587" this is catid

 

For this assignment I expect an implementation for the productindex, but built
in such a way that part of the solution can also be used for the configurator
file and possibly other xml files as well.
1. I expect an implementation for the productindex
2. can also be used for the configurator file and possibly other xml files as well - general solution


Looking at test_productindex.xml, I want to filter 'file' with an attribute
'Catid' containing '587', and show a report on screen with
- Product_ID,
- Model_Name
- path (link to detail-xml)
- HighPic
- a list of EAN_UPC Values



# Just to comment these last sections

For example, using the test-file this would produce: # test-file??? new file or...?

Product 30114
-------------
Title:      Lightweight Tripod VCT-R640
Image:      http://images.icecat.biz/img/norm/high/30114-Sony.jpg
Detail-XML: export/level4/NL/30114.xml
EANs:
- 4901780776467
- 5053460903188

This is one match, so every match the app should generate one detaul-xml file?
- No the app doesn't generate a detail file, this is taken from the xml input file. What he says is that he wants to process this file as well.
- I see. But I don't have that file. I'll ask them for this.

The real file has many thousands of file entries and many thousands of those
have Catid=587, so the report would be quite long. Actually, for the real file
we want to process the detail-xml for each match, so I want something that's
flexible in how it handles each match.
1. has many thousands of file entries and many thousands of those - that is related to detail-xml?
no
there is a very large xml file
with thousands of products
catId is probably category ID
so many different products can have the same category ID
then each product has a detail xml file
which is probably a different file for each product
2. So this is related to processing detail-xml file for every product/category?

1. for the real file we want to process the detail-xml for each match, so I want something that's
flexible in how it handles each match.??? - your answer is exactly related to this

I'm thinking about a split in a library part (reusable) and a project part
(configured for this xml-format, and set to output the formatted text).
Someone with a lot less programming skills should be able to use the library
to get to work with e.g. the configurator xml.
1. 2 parts: 
    1st part general class for dealing with large files
    2nd part - a specific class related to this project and manipulating a certain scope od data (detail-xml file, catids, ...)

Less programming skills means reading and adapting existing code, define a
simple class, and of course the basic loops and conditionals. Besides that
you can always teach and explain things when necessary :-).
1. existin code - I have no code at all, just xml file. It's confusing.

I would like to see a solution in Python, but a PHP-version is fine too.

The point is to gain insight into the way you structure your code, how you
handle reusability, and as a starting point for discussing the code you wrote.

If you have any questions or remarks, you can reach me at marc@guidance.nl or
through our main telephone number 010-2642323.

Ciao, Marc.

