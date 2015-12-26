[Docs List](/docs/)

#Pages & API end points

##Definitions
*  **Count Event** - Describes a traffic count that is to be carried out on a particular date and time at one or more locations. 
* **Location** - Describes the physical location where counts are to be conducted. 
*   **Counting Location** - Describes a specific location, date and time where traffic is to be counted. Each location is associated with a single Count Event record and a single Location record. 

##HTML Pages
Title: Count Page

* Input: Count ID
* Output: Count ID, Traveler trip data (via Ajax), Weather value (indicates that the count is completed 
*  Errors: (inherited from api end points
*   Description: This is the client side "app" that the user interacts with to collect and transmit count data. 

Title: Organization List

*  Input: none
*  Output: Display a list of Organization records with links to allow editing of the records.
*  Errors: No Organization records found
*  Description: Disply a list of organizations for the super-admin

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

Title: Count Location Create/Edit

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

*   Input: countingLocationUID
*   Output: Data object needed to populate the client count form. 
*   Errors: ID not found, Count already completed, Count start period has expired
*   Description: Send the data required by the client app to perform the count. The data includes the street names and Traveler definitions needed to begin a count.

Title: Record trip

*    Input: Unique Trip Identifier (location_ID + datetime string), Trip data
*    Output: Status code; trip recorded, duplicate trip, count already closed, database not available (resend later)
*    Errors: none
*    Description: The client app sends data for one or more trips to server for storage. Based on the status returned the client app will delete or mark the trip(s) as recorded. Any trips that get a "database not available" response will be submitted again.  


Title: Delete Trip

* Input: Unique Trip Identifier (location_ID + datetime string)
* Output: Status code; ok, trip not found, counting location record closed, database not available (resend later)
* Errors: none
* Description: Used to "undo" a single trip by deleting the record. 


Title: End Count

*    Input: Count ID, Weather code 
*    Output: Status code; ok, database not available (resend later)
*    Errors: none
*    Description: Setting the weather field of the countingLocation table to a non-null value indicates that the count for that location is complete. Alternately a countingLocation record is considered closed 24 hours after the end of the count. Once closed, no additional changes will be recorded for that countingLocation.
