------------------------------------------------
 The "Operator Panel Layout" Module for FreePBX
------------------------------------------------

This module provides layout control of the Flash Operator Panel (FOP)


Operation
---------

This module populates a 'panel' database table with layout information relating to FOP. 
Some versions of retrieve_op_conf_from_mysql.pl will detect the existence of the 'panel' database table and use the layout information to generate the FOP configuration file op_buttons_additional.cfg

Preconditions
-------------

This module requires support for the 'panel' database table in retrieve_op_conf_from_mysql.pl . Please see Ticket #2989 for details.

Open Issues
-----------

The layout preview is crude. It gives an indication of the positioning of the layout areas but it does not attempt to simulate the FOP appearance

Author
------
nick.lewis@atltelecom.com