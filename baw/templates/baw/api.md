_Updated Jan 16, 2016_


##Definitions
* **Count Event** - Describes a date and time when traffic is to be counted at one or more locations. 
* **Location** - Describes the physical location where counts are to be conducted. The same Location will usually be used during multiple Count Events.
* **Assignment** - Represents a single User assigned to a Location on the date of a Count Event.

##HTML Pages
Title: Count Page

* Input: Count ID
* Output: Count ID, Traveler trip data (via Ajax), Weather value (indicates that the count is completed 
*  Errors: (inherited from api end points
*   Description: This is the client side "app" that the user interacts with to collect and transmit count data. 

Title: Organization List

*  Input: None
*  Output: Display a list of Organization records with links to allow editing of the records.
*  Errors: No Organization records found
*  Description: Display a list of organizations for the super-admin

Title: Organization Create / Edit

* Input: Org ID (for editing)
* Output: Display Org List for super-admin or Count List for Org admin
* Errors: Org record not found
* Description: Allow super-admin to create and edit Organization records. Allow Org. admin to edit Organization record. 

Title: Location List

* Input: Organization ID
* Output: display a list of location records 
* Errors: Organization not found
* Description: List the Location records created for the Organization. List items are links to allow editing of location records. 

Title: Location Create / Edit

* Input: Location ID (for editing)
* Output: Display a list of Location records
* Errors: No location found
* Description: Record contains info about a pyhsical location the admin will be conducting a count. Each Location record is related to one Organization record. 


Title: Counting Event Create/Edit

*   Input: organization ID, Count Event ID (for editing)
*   Output: Display newly created event id
*   Errors: Org. not found, Event id not found
*   Description: Provide a way for admin to create Count Event record. The Event recort has a relation to one Organization record. 

Title: Assignment Create/Edit

*    Input: Count Event ID, Count location ID (for editing)
*    Output: Display newly created Count location Id
*    Errors: Count Event ID not found, Count Location id not found
*    Description: Provide a way for admin to create/edit count events and location records. Each record will have a relation to an Location Record

Title: Organization Count List

*   Input: Organization Name or ID
*   Output: List of links to counts initiated by this org.
*   Errors: Org. Not found, No counts Found
*   Description: A way for Org. Admin to access count results. 

Title: Count Results

*   Input: Id for count event (multiple locations) or counting location (single location)
*   Output: Count data
*   Errors: Count not found
*   Description: Display a summary of the data requested and provide a link to download the data in machine readable format (csv, json, etc.)  
    The output may be data for a single Count Location or for all Locations that are part of a Count Event. 

##API End Points:

Title: Start Count

*   Input: assignmentUID
*   Output: Data object needed to populate the client count form. 
*   Errors: ID not found, Count already completed, Count start period has expired
*   Description: Send the data required by the client app to perform the count. The data includes the street names and Traveler definitions needed to begin a count.

Title: Record trip

*    Input: a json formatted string: `Action:"add", tripCnt, tripDate, turnDirection, seqNo, location_ID, traveler_ID, countEvent_ID`
*    Output: a json object: {"result":"success", "total": <total trips for this assignment >} The response is always success regardless.
*    Errors: none
*    Description: The client app sends data for one or more trips to server for storage. Based on the status returned the client app will delete or mark the trip(s) as recorded. Any trips that get a "database not available" response will be submitted again.  

Title: Undo Trip

* Input: a json formatted string: `Action:"undo", Location_ID, countEvent_ID, seqNo, tripDate`
* Output: a json object: {"result":"success", "total": <total trips for this assignment >} The response is always success regardless. Also, trips may only be deleted within one minute of the trip time.
* Errors: none
* Description: Used to "undo" a single trip by deleting the record. 

Title: Total Trips

* Input: a json formatted string: `Action:"total", Location_ID, countEvent_ID`
* Output: a json object: {"result":"success", "total": <total trips for this assignment >} The response is always success regardless. Also, trips may only be deleted within one minute of the trip time.
* Errors: none
* Description: Used to get the current trip total for and assignment 
